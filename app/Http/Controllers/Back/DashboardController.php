<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsViewer;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Visitor;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $teams = TeamUser::where('user_id', Auth::id())
            ->with('team.teamUsers')
            ->get();

        $data = [
            'title' => 'Dashboard',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.index')
                ],
            ],
            'user' => Auth::user(),
            'teams' => $teams,
        ];
        return view('back.pages.dashboard.index', $data);
    }

    public function addTeam(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama team tidak boleh kosong',
            'name.max' => 'Nama team maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'address.max' => 'Alamat maksimal 500 karakter',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau gif',
            'logo.max' => 'Ukuran logo maksimal 2MB',
        ]);

        if ($validation->fails()) {
            Alert::error('Error', $validation->errors()->first());
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            // Generate unique name_id
            $nameId = Str::slug($request->name) . '-' . Str::random(6);

            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('teams/logos', 'public');
            }

            // Create team
            $team = Team::create([
                'name' => $request->name,
                'name_id' => $nameId,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'logo' => $logoPath,
            ]);

            // Create team user as owner
            TeamUser::create([
                'team_id' => $team->id,
                'user_id' => Auth::id(),
                'role' => 'owner',
                'status' => 'active',
                'session_token' => bin2hex(random_bytes(16)),
            ]);

            Alert::success('Success', 'Team berhasil dibuat');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function switchTeam($team)
    {
        // Validasi apakah user memiliki akses ke team ini
        $teamUser = TeamUser::whereHas('team', function ($query) use ($team) {
            $query->where('name_id', $team);
        })->where('user_id', Auth::id())->first();

        if (!$teamUser) {
            Alert::error('Error', 'Team tidak ditemukan atau Anda tidak memiliki akses');
            return redirect()->route('back.index');
        }

        // Set cookie dan redirect
        return redirect()
            ->route('back.team.index', $team)
            ->cookie('current_team', $team, 60 * 24 * 30);
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
