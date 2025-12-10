<?php

namespace Database\Seeders;

use App\Models\SettingBanner;
use App\Models\SettingWebsite;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'support']);
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'user']);

        User::factory()->create([
            'name' => 'Fajri - Developer',
            'email' => 'fajri@gariskode.com',
            'password' => bcrypt('password'),
        ])->assignRole('super-admin');

        SettingWebsite::create([
            'name' => 'Chatery',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'email' => 'chatery@torkatatech.com',
            'phone' => '089613390766',
            'address' => 'West Sumatra - Indonesia.',
            'latitude' => '-0.32177371869479526',
            'longitude' => '100.39795359131934',
            'about' => '<p><strong>Chatery</strong> adalah platform layanan chatbot AI yang dirancang untuk membantu bisnis dan individu dalam meningkatkan interaksi dengan pelanggan mereka melalui teknologi kecerdasan buatan terkini. Dengan Chatery, pengguna dapat membuat, mengelola, dan mengoptimalkan chatbot yang mampu memberikan respons cepat dan relevan terhadap pertanyaan serta kebutuhan pelanggan.</p><p>Platform ini menawarkan berbagai fitur canggih seperti integrasi multisaluran, analitik kinerja chatbot, serta kemampuan personalisasi yang memungkinkan chatbot untuk menyesuaikan interaksi berdasarkan preferensi pengguna. Chatery bertujuan untuk memberikan solusi komunikasi yang efisien dan efektif, sehingga membantu bisnis dalam meningkatkan kepuasan pelanggan dan mendorong pertumbuhan bisnis secara keseluruhan.</p>',
        ]);

        SettingBanner::create([
            'title' => 'Chatery - AI Chatbot Platform',
            'subtitle' => 'Enhancing Customer Interaction with Advanced AI Technology',
            'image' => 'setting/banner/vC5qyP6SqARhMTDtFaUm.png',
            'url' => 'https://torkataresearch.org',
        ]);

        Team::create([
            'name' => 'Development Team',
            'name_id' => 'development_team',
            'email' => 'development@chatery.com',
        ]);

        TeamUser::create([
            'team_id' => 1,
            'user_id' => 1,
            'role' => 'owner',
            'token' => bin2hex(random_bytes(16)),
        ]);
    }
}
