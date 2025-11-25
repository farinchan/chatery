<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
     public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard')
                ],
            ],
        ];
        return view('back.pages.whatsapp.chat', $data);
    }
}
