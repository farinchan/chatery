<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SettingWebsite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Register | ' . $setting_web->name,
            'meta' => [
                'title' => 'Register | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', Register, Sign Up, Create Account',
                'favicon' => $setting_web->favicon
            ],
            'breadcrumbs' =>  [
                [
                    'name' => "Home",
                    'link' => route('home')
                ],
                [
                    'name' => "Register",
                    'link' => route('register')
                ]
            ],
            'setting_web' => SettingWebsite::first()
        ];
        return view('auth.pages.register', $data);
    }

    public function registerAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:8|confirmed',
            'toc' => 'required|accepted'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon tidak boleh kosong',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'toc.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'toc.accepted' => 'Anda harus menyetujui syarat dan ketentuan'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Generate username dari nama
            $username = Str::slug($request->name) . '-' . substr(uniqid(), -5);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $username,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Auto login setelah register
            Auth::login($user);

            Alert::success('Success', 'Registrasi berhasil! Selamat datang ' . $user->name);
            return redirect()->intended(route('back.dashboard'));

        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
