<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Package::withCount('teams');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $data = [
            'title' => 'Manajemen Package',
            'menu' => 'Master Data',
            'submenu' => 'Package',
            'packages' => $query->ordered()->paginate(10),
        ];

        return view('back.pages.admin.package.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Package',
            'menu' => 'Master Data',
            'submenu' => 'Package',
        ];

        return view('back.pages.admin.package.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:packages,slug|alpha_dash',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'badge_color' => 'required|string|max:20',
            'icon' => 'nullable|string|max:100',
            'max_members' => 'required|integer|min:-1',
            'max_whatsapp_sessions' => 'required|integer|min:-1',
            'max_telegram_bots' => 'required|integer|min:-1',
            'max_webchat_widgets' => 'required|integer|min:-1',
            'max_messages_per_day' => 'required|integer|min:-1',
            'message_history_days' => 'required|integer|min:-1',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Package::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'badge_color' => $request->badge_color,
            'icon' => $request->icon,
            'max_members' => $request->max_members,
            'max_whatsapp_sessions' => $request->max_whatsapp_sessions,
            'max_telegram_bots' => $request->max_telegram_bots,
            'max_webchat_widgets' => $request->max_webchat_widgets,
            'max_messages_per_day' => $request->max_messages_per_day,
            'message_history_days' => $request->message_history_days,
            'has_api_access' => $request->boolean('has_api_access'),
            'has_webhook' => $request->boolean('has_webhook'),
            'has_bulk_message' => $request->boolean('has_bulk_message'),
            'has_auto_reply' => $request->boolean('has_auto_reply'),
            'has_analytics' => $request->boolean('has_analytics'),
            'has_export' => $request->boolean('has_export'),
            'has_priority_support' => $request->boolean('has_priority_support'),
            'has_custom_branding' => $request->boolean('has_custom_branding'),
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        Alert::success('Berhasil', 'Package berhasil ditambahkan');
        return redirect()->route('back.admin.package.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $package = Package::withCount('teams')->findOrFail($id);

        $data = [
            'title' => 'Detail Package',
            'menu' => 'Master Data',
            'submenu' => 'Package',
            'package' => $package,
            'teams' => $package->teams()->with('teamUsers')->latest()->paginate(10),
        ];

        return view('back.pages.admin.package.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $package = Package::findOrFail($id);

        $data = [
            'title' => 'Edit Package',
            'menu' => 'Master Data',
            'submenu' => 'Package',
            'package' => $package,
        ];

        return view('back.pages.admin.package.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('packages', 'slug')->ignore($package->id)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'badge_color' => 'required|string|max:20',
            'icon' => 'nullable|string|max:100',
            'max_members' => 'required|integer|min:-1',
            'max_whatsapp_sessions' => 'required|integer|min:-1',
            'max_telegram_bots' => 'required|integer|min:-1',
            'max_webchat_widgets' => 'required|integer|min:-1',
            'max_messages_per_day' => 'required|integer|min:-1',
            'message_history_days' => 'required|integer|min:-1',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $package->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'badge_color' => $request->badge_color,
            'icon' => $request->icon,
            'max_members' => $request->max_members,
            'max_whatsapp_sessions' => $request->max_whatsapp_sessions,
            'max_telegram_bots' => $request->max_telegram_bots,
            'max_webchat_widgets' => $request->max_webchat_widgets,
            'max_messages_per_day' => $request->max_messages_per_day,
            'message_history_days' => $request->message_history_days,
            'has_api_access' => $request->boolean('has_api_access'),
            'has_webhook' => $request->boolean('has_webhook'),
            'has_bulk_message' => $request->boolean('has_bulk_message'),
            'has_auto_reply' => $request->boolean('has_auto_reply'),
            'has_analytics' => $request->boolean('has_analytics'),
            'has_export' => $request->boolean('has_export'),
            'has_priority_support' => $request->boolean('has_priority_support'),
            'has_custom_branding' => $request->boolean('has_custom_branding'),
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        Alert::success('Berhasil', 'Package berhasil diperbarui');
        return redirect()->route('back.admin.package.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::withCount('teams')->findOrFail($id);

        // Check if package is used by teams
        if ($package->teams_count > 0) {
            Alert::error('Gagal', 'Package tidak dapat dihapus karena masih digunakan oleh ' . $package->teams_count . ' team');
            return redirect()->back();
        }

        $package->delete();

        Alert::success('Berhasil', 'Package berhasil dihapus');
        return redirect()->route('back.admin.package.index');
    }

    /**
     * Toggle package active status
     */
    public function toggleStatus(string $id)
    {
        $package = Package::findOrFail($id);
        $package->update(['is_active' => !$package->is_active]);

        Alert::success('Berhasil', 'Status package berhasil diubah');
        return redirect()->back();
    }

    /**
     * Assign package to team
     */
    public function assignToTeam(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'package_id' => 'required|exists:packages,id',
            'duration' => 'required|in:1,3,6,12,lifetime',
        ]);

        $team = Team::findOrFail($request->team_id);
        $package = Package::findOrFail($request->package_id);

        $expiresAt = null;
        if ($request->duration !== 'lifetime' && $package->billing_cycle !== 'lifetime') {
            $months = (int) $request->duration;
            $expiresAt = now()->addMonths($months);
        }

        $team->update([
            'package_id' => $package->id,
            'package_expires_at' => $expiresAt,
        ]);

        Alert::success('Berhasil', 'Package berhasil di-assign ke team ' . $team->name);
        return redirect()->back();
    }

    /**
     * Remove package from team
     */
    public function removeFromTeam(string $teamId)
    {
        $team = Team::findOrFail($teamId);

        $team->update([
            'package_id' => null,
            'package_expires_at' => null,
        ]);

        Alert::success('Berhasil', 'Package berhasil dihapus dari team ' . $team->name);
        return redirect()->back();
    }
}
