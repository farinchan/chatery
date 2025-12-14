@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin::Avatar-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ $user->getPhoto() }}" alt="{{ $user->name }}" />
                            <div
                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                            </div>
                        </div>
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-gray-900 fs-2 fw-bold me-1">{{ $user->name }}</span>
                                    @if($user->email_verified_at)
                                        <i class="ki-outline ki-verify fs-1 text-primary"></i>
                                    @endif
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="d-flex align-items-center text-gray-500 me-5 mb-2">
                                            <i class="ki-outline ki-profile-circle fs-4 me-1"></i>{{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                    <a href="mailto:{{ $user->email }}"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-outline ki-sms fs-4 me-1"></i>{{ $user->email }}
                                    </a>
                                    @if($user->phone)
                                        <span class="d-flex align-items-center text-gray-500 mb-2">
                                            <i class="ki-outline ki-phone fs-4 me-1"></i>{{ $user->phone }}
                                        </span>
                                    @endif
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <a href="{{ route('back.user.index') }}" class="btn btn-sm btn-light me-2">
                                    <i class="ki-outline ki-arrow-left fs-3"></i>Kembali
                                </a>
                                <a href="{{ route('back.user.edit', $user->id) }}"
                                    class="btn btn-sm btn-primary me-2">
                                    <i class="ki-outline ki-pencil fs-3"></i>Edit
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        <i class="ki-outline ki-trash fs-3"></i>Hapus
                                    </button>
                                @endif
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Title-->
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-people fs-3 text-success me-2"></i>
                                            <div class="fs-2 fw-bold">{{ $user->teams->count() }}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Teams</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-calendar fs-3 text-info me-2"></i>
                                            <div class="fs-2 fw-bold">{{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Bergabung</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
            </div>
        </div>
        <!--end::Navbar-->

        <!--begin::Details-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Detail User</h3>
                </div>
            </div>
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Username</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->username ?? '-' }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                    <div class="col-lg-8 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->email }}</span>
                        @if($user->email_verified_at)
                            <span class="badge badge-success">Verified</span>
                        @else
                            <span class="badge badge-warning">Not Verified</span>
                        @endif
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">No. Telepon</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->phone ?? '-' }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Role</label>
                    <div class="col-lg-8">
                        @foreach ($user->roles as $role)
                            <span class="badge badge-light-primary fs-7 m-1">{{ ucfirst($role->name) }}</span>
                        @endforeach
                        @if($user->roles->isEmpty())
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Tanggal Bergabung</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Terakhir Diperbarui</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->updated_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
                <!--end::Row-->
            </div>
        </div>
        <!--end::Details-->

        <!--begin::Teams-->
        @if($user->teams->count() > 0)
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Teams ({{ $user->teams->count() }})</h3>
                    </div>
                </div>
                <div class="card-body p-9">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th class="min-w-150px">Team Name</th>
                                    <th class="min-w-100px">Role in Team</th>
                                    <th class="min-w-100px">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->teams as $team)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold fs-6">{{ $team->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ ucfirst($team->pivot->role ?? 'member') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-600">{{ $team->pivot->created_at ? $team->pivot->created_at->format('d M Y') : '-' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <!--end::Teams-->
    </div>

    <!--begin::Delete Modal-->
    @if(auth()->id() !== $user->id)
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Hapus User</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <p class="text-center fs-5">
                            Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>?
                        </p>
                        <p class="text-center text-muted">
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('back.user.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!--end::Delete Modal-->
@endsection
