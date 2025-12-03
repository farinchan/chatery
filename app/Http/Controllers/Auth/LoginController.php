<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Login | ' . $setting_web->name,
            'meta' => [
                'title' => 'Login | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', Login, Authentication, User Access',
                'favicon' => $setting_web->favicon
            ],
            'breadcrumbs' =>  [
                [
                    'name' => "Home",
                    'link' => route('home')
                ],
                [
                    'name' => "Login",
                    'link' => route('login')
                ]
            ],
            'setting_web' => SettingWebsite::first()
        ];
        return view('auth.pages.login', $data);
    }

    public function loginAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required|min:6'
        ], [
            'login.required' => 'Email atau username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $request->input('login'), 'password' => $request->input('password')])) {

            Alert::success('Success', 'Login berhasil');
            return redirect()->intended(route('back.dashboard'));
        }

        Alert::error('Error', 'Email atau username dan password salah');
        return redirect()->back()->withInput();
    }

    public function logoutAction(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Success', 'Logout berhasil');
        return redirect()->route('home');
    }
}
