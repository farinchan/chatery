<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\WhatsappSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class WhatsappController extends Controller
{
    private function getTeam($nameId)
    {
        return Team::where('name_id', $nameId)->whereHas('teamUsers', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('teamUsers.user')->firstOrFail();
    }

    public function index(Request $request, $nameId)
    {

        $team = $this->getTeam($nameId);

        $data = [
            'title' => 'Dashboard whatsapp',
            'breadcrumb' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'whatsApp',
                    'link' => route('back.team.whatsapp.index', $team->name_id)
                ],
            ],
            'token' => $team->teamUsers()->where('user_id', Auth::id())->first()->token,
        ];
        return view('back.pages.whatsapp.index', $data);
    }
    public function chat(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);

        $data = [
            'title' => 'Chat whatsapp',
            'breadcrumb' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'whatsApp',
                    'link' => route('back.team.whatsapp.index', $team->name_id)
                ],
                [
                    'name' => 'Chat',
                    'link' => route('back.whatsapp.chat', $team->name_id)
                ],
            ],
            'nameId' => $nameId,
        ];
        return view('back.pages.whatsapp.chat', $data);
    }
}
