<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Team::with('teamUsers.user');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('name_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $data = [
            'title' => 'Manajemen Team',
            'menu' => 'Master Data',
            'submenu' => 'Team',
            'teams' => $query->latest()->paginate(10),
        ];

        return view('back.pages.admin.team.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Team',
            'menu' => 'Master Data',
            'submenu' => 'Team',
            'users' => User::all(),
        ];

        return view('back.pages.admin.team.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_id' => 'required|string|max:255|unique:teams,name_id|alpha_dash',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_id' => 'required|exists:users,id',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('teams/logos', 'public');
        }

        $team = Team::create([
            'name' => $request->name,
            'name_id' => Str::slug($request->name_id),
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'logo' => $logoPath,
        ]);

        // Add owner as team member
        TeamUser::create([
            'team_id' => $team->id,
            'user_id' => $request->owner_id,
            'role' => 'owner',
            'status' => 'active',
            'token' => Str::random(32),
        ]);

        Alert::success('Berhasil', 'Team berhasil ditambahkan');
        return redirect()->route('back.admin.team.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = Team::with(['teamUsers.user'])->findOrFail($id);

        $data = [
            'title' => 'Detail Team',
            'menu' => 'Master Data',
            'submenu' => 'Team',
            'team' => $team,
            'availableUsers' => User::whereNotIn('id', $team->teamUsers->pluck('user_id'))->get(),
        ];

        return view('back.pages.admin.team.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = Team::with('teamUsers')->findOrFail($id);

        $data = [
            'title' => 'Edit Team',
            'menu' => 'Master Data',
            'submenu' => 'Team',
            'team' => $team,
            'users' => User::all(),
        ];

        return view('back.pages.admin.team.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'name_id' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('teams', 'name_id')->ignore($team->id)],
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $team->logo;
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($team->logo && Storage::disk('public')->exists($team->logo)) {
                Storage::disk('public')->delete($team->logo);
            }
            $logoPath = $request->file('logo')->store('teams/logos', 'public');
        }

        $team->update([
            'name' => $request->name,
            'name_id' => Str::slug($request->name_id),
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'logo' => $logoPath,
        ]);

        Alert::success('Berhasil', 'Team berhasil diperbarui');
        return redirect()->route('back.admin.team.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);

        // Delete logo if exists
        if ($team->logo && Storage::disk('public')->exists($team->logo)) {
            Storage::disk('public')->delete($team->logo);
        }

        // Delete all team members
        $team->teamUsers()->delete();

        $team->delete();

        Alert::success('Berhasil', 'Team berhasil dihapus');
        return redirect()->route('back.admin.team.index');
    }

    /**
     * Add member to team
     */
    public function addMember(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,member,agent',
        ]);

        $existingMember = TeamUser::where('team_id', $team->id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingMember) {
            Alert::error('Gagal', 'User sudah menjadi member team ini');
            return redirect()->back();
        }

        TeamUser::create([
            'team_id' => $team->id,
            'user_id' => $request->user_id,
            'role' => $request->role,
            'status' => 'active',
            'token' => Str::random(32),
        ]);

        Alert::success('Berhasil', 'Member berhasil ditambahkan');
        return redirect()->back();
    }

    /**
     * Update member role
     */
    public function updateMember(Request $request, string $id, string $memberId)
    {
        $teamUser = TeamUser::where('team_id', $id)->where('id', $memberId)->firstOrFail();

        $request->validate([
            'role' => 'required|in:owner,admin,member,agent',
        ]);

        $teamUser->update([
            'role' => $request->role,
        ]);

        Alert::success('Berhasil', 'Role member berhasil diperbarui');
        return redirect()->back();
    }

    /**
     * Remove member from team
     */
    public function removeMember(string $id, string $memberId)
    {
        $teamUser = TeamUser::where('team_id', $id)->where('id', $memberId)->firstOrFail();

        // Prevent removing the owner
        if ($teamUser->role === 'owner') {
            Alert::error('Gagal', 'Tidak dapat menghapus owner dari team');
            return redirect()->back();
        }

        $teamUser->delete();

        Alert::success('Berhasil', 'Member berhasil dihapus dari team');
        return redirect()->back();
    }
}
