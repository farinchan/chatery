<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\WhatsappSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WhatsappController extends Controller
{
    public function index(Request $request, $session)
    {
        $sessionToken = $request->headers->get('session_token');
        if (!$sessionToken) {
            abort(404);
        }

        $data = [
            'title' => 'Dashboard whatsapp',
            'breadcrumb' => [
                [
                    'name' => 'whatsapp Dashboard',
                    'link' => route('back.whatsapp.index', $session)
                ],
            ],
            'session' => $session,
            'session_token' => $sessionToken,
        ];
        return view('back.pages.whatsapp.index', $data);
    }
    public function chat(Request $request, $session)
    {
        $sessionToken = $request->headers->get('session_token');
        if (!$sessionToken) {
            abort(404);
        }

        $data = [
            'title' => 'Chat whatsapp',
            'breadcrumb' => [
                [
                    'name' => 'whatsapp Dashboard',
                    'link' => route('back.whatsapp.index', $session)
                ],
                [
                    'name' => 'Chat',
                    'link' => route('back.whatsapp.chat', $session)
                ],
            ],
        ];
        return view('back.pages.whatsapp.chat', $data);
    }
}
