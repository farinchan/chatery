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
                            <img src="{{ $team->getLogo() }}" alt="{{ $team->name }}" />
                        </div>
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::Team-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-gray-900 fs-2 fw-bold me-1">{{ $team->name }}</span>
                                    <span class="badge badge-light-info ms-2">{{ $team->name_id }}</span>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    @if($team->email)
                                        <a href="mailto:{{ $team->email }}"
                                            class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-outline ki-sms fs-4 me-1"></i>{{ $team->email }}
                                        </a>
                                    @endif
                                    @if($team->phone)
                                        <span class="d-flex align-items-center text-gray-500 me-5 mb-2">
                                            <i class="ki-outline ki-phone fs-4 me-1"></i>{{ $team->phone }}
                                        </span>
                                    @endif
                                    @if($team->website)
                                        <a href="{{ $team->website }}" target="_blank"
                                            class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                            <i class="ki-outline ki-globe fs-4 me-1"></i>{{ $team->website }}
                                        </a>
                                    @endif
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Team-->
                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <a href="{{ route('back.admin.team.index') }}" class="btn btn-sm btn-light me-2">
                                    <i class="ki-outline ki-arrow-left fs-3"></i>Kembali
                                </a>
                                <a href="{{ route('back.admin.team.edit', $team->id) }}"
                                    class="btn btn-sm btn-primary me-2">
                                    <i class="ki-outline ki-pencil fs-3"></i>Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteTeamModal">
                                    <i class="ki-outline ki-trash fs-3"></i>Hapus
                                </button>
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
                                            <div class="fs-2 fw-bold">{{ $team->teamUsers->count() }}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Total Members</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-calendar fs-3 text-info me-2"></i>
                                            <div class="fs-2 fw-bold">{{ $team->created_at->diffForHumans() }}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Dibuat</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Package Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-box fs-3 text-primary me-2"></i>
                                            @if($team->package)
                                                <span class="badge" style="background-color: {{ $team->package->badge_color }}; color: white;">
                                                    {{ $team->package->name }}
                                                </span>
                                            @else
                                                <span class="badge badge-light-secondary">No Package</span>
                                            @endif
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-500">Package</div>
                                    </div>
                                    <!--end::Package Stat-->
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

        <!--begin::Package Card-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Package Subscription</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#assignPackageModal">
                        <i class="ki-outline ki-plus fs-3"></i>{{ $team->package ? 'Change Package' : 'Assign Package' }}
                    </button>
                </div>
            </div>
            <div class="card-body p-9">
                @if($team->package)
                    <div class="d-flex flex-wrap">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <span class="symbol symbol-50px me-4">
                                    <span class="symbol-label" style="background-color: {{ $team->package->badge_color }}20;">
                                        <i class="ki-outline ki-{{ $team->package->icon ?? 'box' }} fs-2x" style="color: {{ $team->package->badge_color }}"></i>
                                    </span>
                                </span>
                                <div>
                                    <span class="fs-4 fw-bold text-gray-900">{{ $team->package->name }}</span>
                                    <span class="badge badge-light-{{ $team->hasActivePackage() ? 'success' : 'danger' }} ms-2">
                                        {{ $team->hasActivePackage() ? 'Active' : 'Expired' }}
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><span class="text-gray-500">Harga:</span> <span class="fw-bold">{{ $team->package->formatted_price }}</span> {{ $team->package->billing_cycle_label }}</p>
                                    @if($team->package_expires_at)
                                        <p class="mb-2">
                                            <span class="text-gray-500">Expired:</span>
                                            <span class="fw-bold {{ $team->isPackageExpired() ? 'text-danger' : '' }}">
                                                {{ $team->package_expires_at->format('d M Y H:i') }}
                                            </span>
                                            @if(!$team->isPackageExpired())
                                                <small class="text-muted">({{ $team->getDaysUntilExpiry() }} hari lagi)</small>
                                            @endif
                                        </p>
                                    @else
                                        <p class="mb-2"><span class="text-gray-500">Expired:</span> <span class="badge badge-light-success">Lifetime</span></p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><span class="text-gray-500">Max Members:</span> <span class="fw-bold">{{ $team->package->getLimitDisplay('max_members') }}</span></p>
                                    <p class="mb-2"><span class="text-gray-500">Max Messages/Day:</span> <span class="fw-bold">{{ $team->package->getLimitDisplay('max_messages_per_day') }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <form action="{{ route('back.admin.package.remove-from-team', $team->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus package dari team ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light-danger">
                                    <i class="ki-outline ki-trash fs-3"></i>Remove Package
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="ki-outline ki-box fs-3x text-gray-400 mb-5"></i>
                        <p class="text-gray-600 fs-5">Team belum memiliki package</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignPackageModal">
                            <i class="ki-outline ki-plus fs-3"></i>Assign Package
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <!--end::Package Card-->

        <!--begin::Members Card-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Team Members ({{ $team->teamUsers->count() }})</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addMemberModal">
                        <i class="ki-outline ki-plus fs-3"></i>Tambah Member
                    </button>
                </div>
            </div>
            <div class="card-body p-9">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th class="min-w-200px">Member</th>
                                <th class="min-w-100px">Role</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px">Joined</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($team->teamUsers as $member)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px me-5">
                                                <img src="{{ $member->user->getPhoto() }}" alt="{{ $member->user->name }}" />
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="text-gray-900 fw-bold fs-6">{{ $member->user->name }}</span>
                                                <span class="text-muted fw-semibold d-block fs-7">{{ $member->user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $roleColors = [
                                                'owner' => 'danger',
                                                'admin' => 'warning',
                                                'member' => 'primary',
                                                'agent' => 'info',
                                            ];
                                        @endphp
                                        <span class="badge badge-light-{{ $roleColors[$member->role] ?? 'secondary' }}">
                                            {{ ucfirst($member->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-{{ $member->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($member->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-gray-600">{{ $member->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-light btn-active-light-primary"
                                            data-bs-toggle="modal" data-bs-target="#editMemberModal{{ $member->id }}">
                                            <i class="ki-outline ki-pencil fs-5"></i>
                                        </button>
                                        @if($member->role !== 'owner')
                                            <button type="button" class="btn btn-sm btn-light-danger"
                                                data-bs-toggle="modal" data-bs-target="#removeMemberModal{{ $member->id }}">
                                                <i class="ki-outline ki-trash fs-5"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!--begin::Edit Member Modal-->
                                <div class="modal fade" id="editMemberModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered mw-500px">
                                        <div class="modal-content">
                                            <form action="{{ route('back.admin.team.member.update', [$team->id, $member->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Edit Role Member</h2>
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                        <i class="ki-outline ki-cross fs-1"></i>
                                                    </div>
                                                </div>
                                                <div class="modal-body py-10 px-lg-17">
                                                    <div class="d-flex align-items-center mb-7">
                                                        <div class="symbol symbol-50px me-5">
                                                            <img src="{{ $member->user->getPhoto() }}" alt="{{ $member->user->name }}" />
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-gray-900 fw-bold fs-6">{{ $member->user->name }}</span>
                                                            <span class="text-muted fs-7">{{ $member->user->email }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="fv-row">
                                                        <label class="form-label required">Role</label>
                                                        <select name="role" class="form-select form-select-solid" required>
                                                            <option value="owner" {{ $member->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                                            <option value="admin" {{ $member->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                            <option value="member" {{ $member->role === 'member' ? 'selected' : '' }}>Member</option>
                                                            <option value="agent" {{ $member->role === 'agent' ? 'selected' : '' }}>Agent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Edit Member Modal-->

                                <!--begin::Remove Member Modal-->
                                @if($member->role !== 'owner')
                                    <div class="modal fade" id="removeMemberModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-500px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Hapus Member</h2>
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                        <i class="ki-outline ki-cross fs-1"></i>
                                                    </div>
                                                </div>
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <p class="text-center fs-5">
                                                        Apakah Anda yakin ingin menghapus <strong>{{ $member->user->name }}</strong> dari team ini?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('back.admin.team.member.remove', [$team->id, $member->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!--end::Remove Member Modal-->
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ki-outline ki-people fs-3x text-gray-400 mb-5"></i>
                                            <span class="text-gray-600 fs-5">Tidak ada member</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Members Card-->

        <!--begin::Team Details-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Detail Team</h3>
                </div>
            </div>
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Nama Team</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $team->name }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Name ID</label>
                    <div class="col-lg-8">
                        <span class="badge badge-light-info fs-6">{{ $team->name_id }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $team->email ?? '-' }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">No. Telepon</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $team->phone ?? '-' }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Website</label>
                    <div class="col-lg-8">
                        @if($team->website)
                            <a href="{{ $team->website }}" target="_blank" class="fw-bold fs-6 text-primary">{{ $team->website }}</a>
                        @else
                            <span class="fw-bold fs-6 text-gray-800">-</span>
                        @endif
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Tanggal Dibuat</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $team->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Terakhir Diperbarui</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $team->updated_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
                <!--end::Row-->
            </div>
        </div>
        <!--end::Team Details-->
    </div>

    <!--begin::Add Member Modal-->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form action="{{ route('back.admin.team.member.add', $team->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="fw-bold">Tambah Member</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="fv-row mb-7">
                            <label class="form-label required">User</label>
                            <select name="user_id" class="form-select form-select-solid" data-control="select2"
                                data-placeholder="Pilih User" data-dropdown-parent="#addMemberModal" required>
                                <option value="">Pilih User</option>
                                @foreach ($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label class="form-label required">Role</label>
                            <select name="role" class="form-select form-select-solid" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="member">Member</option>
                                <option value="agent">Agent</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Add Member Modal-->

    <!--begin::Delete Team Modal-->
    <div class="modal fade" id="deleteTeamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Hapus Team</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <p class="text-center fs-5">
                        Apakah Anda yakin ingin menghapus team <strong>{{ $team->name }}</strong>?
                    </p>
                    <p class="text-center text-muted">
                        Semua member akan dihapus dari team ini. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('back.admin.team.destroy', $team->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Delete Team Modal-->

    <!--begin::Assign Package Modal-->
    <div class="modal fade" id="assignPackageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form action="{{ route('back.admin.package.assign-to-team', $team->package_id ?? 0) }}" method="POST" id="assignPackageForm">
                    @csrf
                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ $team->package ? 'Ubah Package' : 'Assign Package' }}</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="fv-row mb-7">
                            <label class="form-label required">Package</label>
                            <select name="package_id" id="packageSelect" class="form-select form-select-solid" data-control="select2"
                                data-placeholder="Pilih Package" data-dropdown-parent="#assignPackageModal" required>
                                <option value="">Pilih Package</option>
                                @foreach ($packages ?? [] as $package)
                                    <option value="{{ $package->id }}" {{ $team->package_id == $package->id ? 'selected' : '' }}>
                                        {{ $package->name }} - {{ $package->formatted_price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row">
                            <label class="form-label">Tanggal Expired</label>
                            <input type="datetime-local" name="expires_at" class="form-control form-control-solid"
                                value="{{ $team->package_expires_at?->format('Y-m-d\TH:i') }}" placeholder="Kosongkan untuk lifetime">
                            <div class="form-text">Kosongkan untuk subscription lifetime</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Assign Package Modal-->

    @push('scripts')
    <script>
        document.getElementById('packageSelect').addEventListener('change', function() {
            var packageId = this.value;
            var form = document.getElementById('assignPackageForm');
            form.action = "{{ url('back/admin/package') }}/" + packageId + "/assign-to-team";
        });
    </script>
    @endpush
@endsection
