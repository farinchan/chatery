<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function sendMessage(Request $request)
    {
        $data = [
            'title' => 'Dokumentasi API - Kirim Pesan',
            'breadcrumbs' => [
                [
                    'name' => 'Overview',
                    'link' => route('back.index')
                ],
                [
                    'name' => 'Whatsapp',
                    'link' => route('back.whatsapp.index', $request->route('session'))
                ],
                [
                    'name' => 'Documentation',
                ],
                [
                    'name' => 'Send Message',
                    'link' => route('back.whatsapp.documentation.sendMessage', $request->route('session'))
                ],
            ],
        ];

        return view('back.pages.documentation.send-message', $data);
    }

    public function sendImage(Request $request)
    {
        $data = [
            'title' => 'Dokumentasi API - Kirim Gambar',
            'breadcrumbs' => [
                [
                    'name' => 'Overview',
                    'link' => route('back.index')
                ],
                [
                    'name' => 'Whatsapp',
                    'link' => route('back.whatsapp.index', $request->route('session'))
                ],
                [
                    'name' => 'Documentation',
                ],
                [
                    'name' => 'Send Image',
                    'link' => route('back.whatsapp.documentation.sendImage', $request->route('session'))
                ],
            ],
        ];

        return view('back.pages.documentation.send-image', $data);
    }

    public function sendDocument(Request $request)
    {
        $data = [
            'title' => 'Dokumentasi API - Kirim Dokumen',
            'breadcrumbs' => [
                [
                    'name' => 'Overview',
                    'link' => route('back.index')
                ],
                [
                    'name' => 'Whatsapp',
                    'link' => route('back.whatsapp.index', $request->route('session'))
                ],
                [
                    'name' => 'Documentation',
                ],
                [
                    'name' => 'Send Document',
                    'link' => route('back.whatsapp.documentation.sendDocument', $request->route('session'))
                ],
            ],
        ];

        return view('back.pages.documentation.send-document', $data);
    }
    public function sendBulkMessage(Request $request)
    {
        $data = [
            'title' => 'Dokumentasi API - Kirim Pesan Massal',
            'breadcrumbs' => [
                [
                    'name' => 'Overview',
                    'link' => route('back.index')
                ],
                [
                    'name' => 'Whatsapp',
                    'link' => route('back.whatsapp.index', $request->route('session'))
                ],
                [
                    'name' => 'Documentation',
                ],
                [
                    'name' => 'Send Bulk Message',
                    'link' => route('back.whatsapp.documentation.sendBulkMessage', $request->route('session'))
                ],
            ],
        ];

        return view('back.pages.documentation.send-bulk-message', $data);
    }
}
