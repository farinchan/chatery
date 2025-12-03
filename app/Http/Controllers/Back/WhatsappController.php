<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WhatsappController extends Controller
{
    public function index($session)
    {
        $data = [
            'title' => 'Dashboard whatsapp',
            'breadcrumb' => [
                [
                    'name' => 'whatsapp Dashboard',
                    'link' => route('back.whatsapp.index', $session)
                ],
            ],
        ];
        Cookie::queue('whatsapp_session', $session, 60 * 24 * 30);
        return view('back.pages.whatsapp.index', $data);
    }
    public function chat($session)
    {
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
