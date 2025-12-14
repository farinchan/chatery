@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2>Edit Team</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('back.admin.team.index') }}" class="btn btn-light-primary">
                        <i class="ki-outline ki-arrow-left fs-2"></i>Kembali
                    </a>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <form action="{{ route('back.admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <!--begin::Image input-->
                            <div class="mb-7 text-center">
                                <label class="form-label fw-bold fs-6 mb-5">Logo Team</label>
                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                    style="background-image: url('{{ asset('back/media/avatars/blank.png') }}')">
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url('{{ $team->getLogo() }}')">
                                    </div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah logo">
                                        <i class="ki-outline ki-pencil fs-7"></i>
                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="logo_remove" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus logo">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </span>
                                </div>
                                <div class="form-text">Format: jpg, jpeg, png. Max 2MB</div>
                                @error('logo')
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
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Nama Team</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name"
                                        class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                        placeholder="Nama Team" value="{{ old('name', $team->name) }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-semibold fs-6">Name ID</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name_id"
                                        class="form-control form-control-lg form-control-solid @error('name_id') is-invalid @enderror"
                                        placeholder="unique-team-id" value="{{ old('name_id', $team->name_id) }}" required />
                                    <div class="form-text">ID unik untuk team (hanya huruf, angka, dash dan underscore)</div>
                                    @error('name_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-semibold fs-6">Email</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email"
                                        class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                        placeholder="team@example.com" value="{{ old('email', $team->email) }}" />
                                    @error('email')
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
                                        placeholder="08xxxxxxxxxx" value="{{ old('phone', $team->phone) }}" />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-semibold fs-6">Website</label>
                                <div class="col-lg-9">
                                    <input type="url" name="website"
                                        class="form-control form-control-lg form-control-solid @error('website') is-invalid @enderror"
                                        placeholder="https://example.com" value="{{ old('website', $team->website) }}" />
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end pt-5">
                        <a href="{{ route('back.admin.team.index') }}" class="btn btn-light me-3">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Update</span>
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
