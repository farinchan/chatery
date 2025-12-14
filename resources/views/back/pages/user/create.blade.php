@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2>Tambah User Baru</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('back.user.index') }}" class="btn btn-light-primary">
                        <i class="ki-outline ki-arrow-left fs-2"></i>Kembali
                    </a>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <form action="{{ route('back.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Image input-->
                            <div class="mb-7 text-center">
                                <label class="form-label fw-bold fs-6 mb-5">Foto Profil</label>
                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                    style="background-image: url('{{ asset('back/media/avatars/blank.png') }}')">
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url('{{ asset('back/media/avatars/blank.png') }}')">
                                    </div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah foto">
                                        <i class="ki-outline ki-pencil fs-7"></i>
                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="photo_remove" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus foto">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </span>
                                </div>
                                <div class="form-text">Format: jpg, jpeg, png. Max 2MB</div>
                                @error('photo')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Image input-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-8">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Nama</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name"
                                        class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                        placeholder="Nama Lengkap" value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Email</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email"
                                        class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                        placeholder="example@domain.com" value="{{ old('email') }}" required />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Username</label>
                                <div class="col-lg-9">
                                    <input type="text" name="username"
                                        class="form-control form-control-lg form-control-solid @error('username') is-invalid @enderror"
                                        placeholder="username" value="{{ old('username') }}" required />
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-semibold fs-6">No. Telepon</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone"
                                        class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror"
                                        placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Role</label>
                                <div class="col-lg-9">
                                    <div class="d-flex flex-wrap gap-5">
                                        @foreach ($roles as $role)
                                            <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                <input class="form-check-input" type="checkbox" name="roles[]"
                                                    value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                    {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }} />
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    {{ ucfirst($role->name) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                                    @enderror
                                    @error('roles.*')
                                        <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Password</label>
                                <div class="col-lg-9">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                                        placeholder="********" required />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Konfirmasi Password</label>
                                <div class="col-lg-9">
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="********" required />
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end pt-5">
                        <a href="{{ route('back.user.index') }}" class="btn btn-light me-3">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
