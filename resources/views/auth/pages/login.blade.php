@extends('auth.app')

@section('content')
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <div class="w-lg-500px p-10">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST"
                    action="{{ route('login.action') }}">
                    @csrf
                    <div class="text-center mb-11">
                        <h1 class="text-gray-900 fw-bolder mb-3">Masuk</h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Selamat Datang di {{ $setting_web->name ?? 'Website' }}! <br>Silahkan masuk ke akun Anda.
                        </div>
                    </div>
                    <div class="row g-3 mb-9">
                        <div class="col-md-6">
                            <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Logo" src="{{ asset("back/media/svg/brand-logos/google-icon.svg") }}"
                                    class="h-15px me-3" />Masuk dengan Google</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Logo" src="{{ asset("back/media/svg/brand-logos/facebook-2.svg") }}"
                                    class="theme-light-show h-15px me-3" />
                                <img alt="Logo" src="{{ asset("back/media/svg/brand-logos/facebook-1.svg") }}"
                                    class="theme-dark-show h-15px me-3" />Masuk dengan Facebook</a>
                        </div>
                    </div>
                    <div class="separator separator-content my-14">
                        <span class="w-200px text-gray-500 fw-semibold fs-7">Atau dengan email</span>
                    </div>
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Email/Username" name="login" autocomplete="off"
                            class="form-control bg-transparent @error('login') is-invalid @enderror" value="{{ old('login') }}" />
                        @error('login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-3">
                        <input type="password" placeholder="Password" name="password" autocomplete="off"
                            class="form-control bg-transparent @error('password') is-invalid @enderror" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        <a href="authentication/layouts/corporate/reset-password.html" class="link-primary">Lupa Password
                            ?</a>
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <span class="indicator-label">Masuk</span>
                            <span class="indicator-progress">Mohon tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <div class="text-gray-500 text-center fw-semibold fs-6">Belum Punya Akun?
                        <a href="{{ route("register") }}" class="link-primary">Daftar</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
            {{-- <div class="me-10">
                <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                    <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                        src="{{ asset("back/media/flags/united-states.svg") }}" alt="" />
                    <span data-kt-element="current-lang-name" class="me-1">English</span>
                    <span class="d-flex flex-center rotate-180">
                        <i class="ki-duotone ki-down fs-5 text-muted m-0"></i>
                    </span>
                </button>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                    data-kt-menu="true" id="kt_auth_lang_menu">
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                            <span class="symbol symbol-20px me-4">
                                <img data-kt-element="lang-flag" class="rounded-1"
                                    src="{{ asset("back/media/flags/united-states.svg") }}" alt="" />
                            </span>
                            <span data-kt-element="lang-name">English</span>
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                            <span class="symbol symbol-20px me-4">
                                <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/spain.svg"
                                    alt="" />
                            </span>
                            <span data-kt-element="lang-name">Spanish</span>
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                            <span class="symbol symbol-20px me-4">
                                <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/germany.svg"
                                    alt="" />
                            </span>
                            <span data-kt-element="lang-name">German</span>
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                            <span class="symbol symbol-20px me-4">
                                <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/japan.svg"
                                    alt="" />
                            </span>
                            <span data-kt-element="lang-name">Japanese</span>
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                            <span class="symbol symbol-20px me-4">
                                <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/france.svg"
                                    alt="" />
                            </span>
                            <span data-kt-element="lang-name">French</span>
                        </a>
                    </div>
                </div>
            </div> --}}
            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                <a href="pages/team.html" target="_blank">Terms</a>
                <a href="pages/pricing/column.html" target="_blank">Plans</a>
                <a href="pages/contact.html" target="_blank">Contact Us</a>
            </div>
        </div>
    </div>
@endsection
