<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsViewer;
use App\Models\Visitor;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.index')
                ],
            ],
            'user' => Auth::user(),
            'whatsapp_sessions' => WhatsappSessionUser::where('user_id', Auth::id())->with('whatsapp_session')->get(),
            'prefix_addwhatsappsesssion' => (Auth::user()->username
                ? Str::limit(Auth::user()->username, 4, '')
                : bin2hex(random_bytes(4))) . str_pad((WhatsappSession::count() + 1), 4, '0', STR_PAD_LEFT) . "_"
        ];
        return view('back.pages.dashboard.index', $data);
    }

    public function addWhatsappSession(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'session_name' => 'required|string|max:255|unique:whatsapp_sessions,session_name|regex:/^\S+$/',
            
            'session_webhook_url' => 'nullable|url',
        ], [
            'session_name.required' => 'Nama sesi tidak boleh kosong',
            'session_name.max' => 'Nama sesi maksimal 255 karakter',
        ]);

        if ($validation->fails()) {
            Alert::error('Error', $validation->errors()->all());
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {

            $session_name = (Auth::user()->username
                ? Str::limit(Auth::user()->username, 4, '')
                : bin2hex(random_bytes(4))) . str_pad((WhatsappSession::count() + 1), 4, '0', STR_PAD_LEFT) . "_" . $request->session_name;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-Api-Key' => env('WAHA_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post(env('WAHA_API_URL') . '/api/sessions/', [
                "name" => $session_name,
                "config" => [
                    "webhooks" => $request->session_webhook_url ? [
                        [
                            "url" => $request->session_webhook_url,
                            "events" => ["message"]
                        ]
                    ] : [],
                    "metadata" => [
                        "owner_id" => (string) Auth::id(),
                        "owner_email" => (string) Auth::user()->email,
                        "created_at" => (string) now()->toDateTimeString()
                    ]
                ]
            ]);

            if ($response->successful()) {
                $whatsappSession = WhatsappSession::create([
                    'session_name' => $session_name,
                    'session_webhook_url' => $request->session_webhook_url,
                    'is_active' => true,
                ]);

                WhatsappSessionUser::create([
                    'whatsapp_session_id' => $whatsappSession->id,
                    'user_id' => Auth::id(),
                    'role' => 'owner',
                    'session_token' => bin2hex(random_bytes(16)),
                    'status' => 'active',
                ]);

                Alert::success('Success', 'WhatsApp session created successfully');
                return redirect()->back();
            } else {
                Alert::error('Error', 'Failed to create WhatsApp session: ' . $response->body());
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'An error occurred: ' . $th->getMessage());
            return redirect()->back()->withInput();
        }



        Alert::success('Success', 'Whatsapp session added successfully');
        return redirect()->back();
    }


    public function visitor()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.index')
                ],

                [
                    'name' => 'Visitor',
                    'link' => route('back.dashboard.visitor')
                ],
            ],
        ];
        return view('back.pages.dashboard.visitor', $data);
    }

    public function visistorStat()
    {


        $data = cache()->remember('visitor_stats', 60, function () {
            return [
                'visitor_monthly' => Visitor::select(DB::raw('Date(created_at) as date'), DB::raw('count(*) as total'))
                    ->orderBy('date', 'desc')
                    ->limit(30)
                    ->groupBy('date')
                    ->get(),
                'visitor_platfrom' => Visitor::select('platform', DB::raw('count(*) as total'))
                    ->groupBy('platform')
                    ->get(),
                'visitor_browser' => Visitor::select('browser', DB::raw('count(*) as total'))
                    ->groupBy('browser')
                    ->get(),
                'visitor_country' => Visitor::select('country', DB::raw('count(*) as total'))
                    ->whereNotNull('country')
                    ->groupBy('country')
                    ->orderBy('total', 'desc')
                    ->get()
                    ->map(function ($item) {
                        $countryName = $item->country;

                        $hash = substr(md5($countryName), 0, 6);
                        $item->color = "#{$hash}";
                        return $item;
                    }),
            ];
        });
        return response()->json($data);
    }

    public function news()
    {
        $data = [
            'title' => 'Dashboard Berita',
            'menu' => 'dashboard',
            'sub_menu' => '',
            'berita_count' => News::count(),
            'news_popular' => News::with('comments')->withCount('viewers')->orderBy('viewers_count', 'desc')->limit(5)->get(),
            'news_new' => News::with(['comments', 'viewers'])->latest()->limit(5)->get(),
            'news_writer' => news::select(
                DB::raw('count(*) as total'),
                'news.user_id',
            )
                ->groupBy('news.user_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
        ];
        return view('back.pages.dashboard.news', $data);
    }

    public function stat()
    {


        $data = [
            'news_viewer_monthly' => NewsViewer::select(DB::raw('Date(created_at) as date'), DB::raw('count(*) as total'))
                ->limit(30)
                ->groupBy('date')
                ->get(),
            'news_viewer_platfrom' => NewsViewer::select('platform', DB::raw('count(*) as total'))
                ->groupBy('platform')
                ->get(),
            'news_viewer_browser' => NewsViewer::select('browser', DB::raw('count(*) as total'))
                ->groupBy('browser')
                ->get(),

        ];
        return response()->json($data);
    }
}
