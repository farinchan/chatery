<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use App\Services\OnlineStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    private function getTeam($nameId)
    {
        return Team::where('name_id', $nameId)->whereHas('teamUsers', function ($query) {
            $query->where('user_id', Auth::id());
        })->firstOrFail();
    }

    private function isOwnerOrAdmin($team)
    {
        $teamUser = $team->teamUsers()->where('user_id', Auth::id())->first();
        return $teamUser && in_array($teamUser->role, ['owner', 'admin']);
    }

    public function index(Request $request, $nameId)
    {
        $team = Team::where('name_id', $nameId)->whereHas('teamUsers', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('teamUsers.user')->firstOrFail();

        // Get online status untuk semua member
        $userIds = $team->teamUsers->pluck('user_id')->toArray();
        $onlineUsers = OnlineStatusService::getOnlineUsers($userIds);
        $onlineCount = OnlineStatusService::countOnline($userIds);

        $data = [
            'title' => 'Team - ' . $team->name,
            'breadcrumbs' => [
                [
                    'name' => $team->name,
                ],
                [
                    'name' => 'My Team',
                    'link' => route('back.team.index', $team->name_id)
                ],
            ],
            'team' => $team,
            'onlineUsers' => $onlineUsers,
            'onlineCount' => $onlineCount,
        ];

        return view('back.pages.my-team', $data);
    }

    public function getOnlineStatus(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);
        $team->load('teamUsers');

        $userIds = $team->teamUsers->pluck('user_id')->toArray();
        $onlineUsers = OnlineStatusService::getOnlineUsers($userIds);
        $onlineCount = OnlineStatusService::countOnline($userIds);

        return response()->json([
            'success' => true,
            'onlineUsers' => $onlineUsers,
            'onlineCount' => $onlineCount,
        ]);
    }

    public function update(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);

        if (!$this->isOwnerOrAdmin($team)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
        ];

        if ($request->hasFile('logo')) {
            if ($team->logo && !str_starts_with($team->logo, 'http')) {
                Storage::disk('public')->delete($team->logo);
            }
            $data['logo'] = $request->file('logo')->store('teams/logos', 'public');
        }

        $team->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Team berhasil diperbarui',
            'team' => $team
        ]);
    }

    public function addMember(Request $request, $nameId)
    {
        $team = $this->getTeam($nameId);

        if (!$this->isOwnerOrAdmin($team)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:admin,member,agent',
        ]);

        $user = User::where('email', $request->email)->first();

        $existingMember = TeamUser::where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingMember) {
            return response()->json([
                'success' => false,
                'message' => 'User sudah menjadi member team ini'
            ], 422);
        }

        $teamUser = TeamUser::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => $request->role,
            'status' => 'active',
            'token' => Str::random(32),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil ditambahkan',
            'member' => $teamUser->load('user')
        ]);
    }

    public function updateMember(Request $request, $nameId, $memberId)
    {
        $team = $this->getTeam($nameId);

        if (!$this->isOwnerOrAdmin($team)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'role' => 'required|in:admin,member,agent',
            'status' => 'required|in:active,blocked,pending',
        ]);

        $teamUser = TeamUser::where('team_id', $team->id)
            ->where('id', $memberId)
            ->firstOrFail();

        if ($teamUser->role === 'owner') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengubah role owner'
            ], 422);
        }

        $teamUser->update([
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil diperbarui',
            'member' => $teamUser->load('user')
        ]);
    }

    public function deleteMember(Request $request, $nameId, $memberId)
    {
        $team = $this->getTeam($nameId);

        if (!$this->isOwnerOrAdmin($team)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $teamUser = TeamUser::where('team_id', $team->id)
            ->where('id', $memberId)
            ->firstOrFail();

        if ($teamUser->role === 'owner') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus owner'
            ], 422);
        }

        $teamUser->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil dihapus'
        ]);
    }
}
