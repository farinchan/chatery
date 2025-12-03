@extends('auth.app')
@section('content')
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <div class="w-lg-500px p-10">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST"
                    action="{{ route('register.action') }}">
                    @csrf
                    <div class="text-center mb-11">
                        <h1 class="text-gray-900 fw-bolder mb-3">Daftar</h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Selamat Datang di {{ $setting_web->name ?? 'Website' }}! <br>Buat akun baru Anda.
                        </div>
                    </div>
                    <div class="row g-3 mb-9">
                        <div class="col-md-6">
                            <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Logo" src="{{ asset('back/media/svg/brand-logos/google-icon.svg') }}"
                                    class="h-15px me-3" />Masuk dengan Google</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Logo" src="{{ asset('back/media/svg/brand-logos/facebook-2.svg') }}"
                                    class="theme-light-show h-15px me-3" />
                                <img alt="Logo" src="{{ asset('back/media/svg/brand-logos/facebook-1.svg') }}"
                                    class="theme-dark-show h-15px me-3" />Masuk dengan Facebook</a>
                        </div>
                    </div>
                    <div class="separator separator-content my-14">
                        <span class="w-200px text-gray-500 fw-semibold fs-7">Atau dengan email</span>
                    </div>
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Nama Lengkap" name="name" autocomplete="off"
                            class="form-control bg-transparent @error('name') is-invalid @enderror" value="{{ old('name') }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Email" name="email" autocomplete="off"
                            class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Nomor Telepon" name="phone" autocomplete="off"
                            class="form-control bg-transparent @error('phone') is-invalid @enderror" value="{{ old('phone') }}" />
                        <small class="text-muted">Pastikan nomor telepon terhubung dengan WhatsApp, contoh: +6281234567890</small>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-8" data-kt-password-meter="true">
                        <div class="mb-1">
                            <div class="position-relative mb-3">
                                <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="Password"
                                    name="password" autocomplete="off" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-2"></i>
                                    <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                        </div>
                        <div class="text-muted">Gunakan minimal 8 karakter dengan kombinasi huruf, angka & simbol.</div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-8">
                        <input placeholder="Ulangi Password" name="password_confirmation" type="password" autocomplete="off"
                            class="form-control bg-transparent" />
                    </div>
                    <div class="fv-row mb-8">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input @error('toc') is-invalid @enderror" type="checkbox" name="toc" value="1" {{ old('toc') ? 'checked' : '' }} />
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Saya menyetujui
                                <a href="#" class="ms-1 link-primary">Syarat dan Ketentuan</a></span>
                        </label>
                        @error('toc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <span class="indicator-label">Daftar</span>
                            <span class="indicator-progress">Mohon tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <div class="text-gray-500 text-center fw-semibold fs-6">Sudah punya akun?
                        <a href="{{ route('login') }}" class="link-primary fw-semibold">Masuk</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                <a href="pages/team.html" target="_blank">Terms</a>
                <a href="pages/pricing/column.html" target="_blank">Plans</a>
                <a href="pages/contact.html" target="_blank">Contact Us</a>
            </div>
        </div>
    </div>
@endsection
