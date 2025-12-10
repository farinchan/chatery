@extends('back.app')
@section('styles')
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ $team->getLogo() }}" alt="image" />
                            {{-- <div
                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                            </div> --}}
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                        {{ $team->name }}
                                    </a>
                                    <a href="#">
                                        <i class="ki-duotone ki-verify fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 me-2pe-2">
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                        <i class="ki-duotone ki-sms fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>{{ $team->email ?? '-' }}</a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6  pe-2">
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                        <i class="ki-duotone ki-phone fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>{{ $team->phone ?? '-' }}</a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6  pe-2">
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-geolocation-home fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>{{ $team->website ?? '-' }}</a>
                                </div>
                            </div>
                            <div class="d-flex my-4">
                                <div class="me-0">
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Manage</div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal_edit_team">Ubah Team</a>
                                        </div>

                                        <div class="menu-item px-3 my-1">
                                            <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal" data-bs-target="#modal_delete_team">Hapus Team</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row g-5 g-xxl-9">
            <div class="col-xxl-8">
                <div class="card card-xxl-stretch mb-5 mb-xxl-10">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h3 class="fw-bold m-0">
                                <i class="ki-duotone ki-chart-simple fs-2 me-2 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                                Statistik Team
                            </h3>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="d-flex flex-wrap gap-4">
                                {{-- Member Count Card --}}
                                <div class="bg-light-primary rounded-3 p-6 position-relative overflow-hidden" style="min-width: 160px;">
                                    <div class="position-absolute top-0 end-0 opacity-10">
                                        <i class="ki-duotone ki-people fs-5tx text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fs-3x fw-bold text-primary lh-1 mb-2" data-kt-countup="true" data-kt-countup-value="{{ $team->teamUsers->count() }}">0</span>
                                        <span class="fs-6 fw-semibold text-gray-600">Total Member</span>
                                    </div>
                                </div>

                                {{-- Online Count Card --}}
                                <div class="bg-light-success rounded-3 p-6 position-relative overflow-hidden" style="min-width: 160px;">
                                    <div class="position-absolute top-0 end-0 opacity-10">
                                        <i class="ki-duotone ki-wifi fs-5tx text-success">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            <span id="online-count" class="fs-3x fw-bold text-success lh-1 mb-2" data-kt-countup="true" data-kt-countup-value="{{ $onlineCount }}">0</span>
                                            <span class="bullet bullet-dot bg-success h-10px w-10px ms-2 mb-2 animate__animated animate__flash animate__infinite"></span>
                                        </div>
                                        <span class="fs-6 fw-semibold text-gray-600">Online Sekarang</span>
                                    </div>
                                </div>

                                {{-- Offline Count Card --}}
                                <div class="bg-light-secondary rounded-3 p-6 position-relative overflow-hidden" style="min-width: 160px;">
                                    <div class="position-absolute top-0 end-0 opacity-10">
                                        <i class="ki-duotone ki-wifi-off fs-5tx text-gray-500">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fs-3x fw-bold text-gray-600 lh-1 mb-2" data-kt-countup="true" data-kt-countup-value="{{ $team->teamUsers->count() - $onlineCount }}">0</span>
                                        <span class="fs-6 fw-semibold text-gray-600">Offline</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#modal_add_member">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                    Invite Member
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="card card-xxl-stretch mb-5 mb-xxl-10 bg-light-warning">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-5">
                            <div class="symbol symbol-50px me-4">
                                <span class="symbol-label bg-warning">
                                    <i class="ki-duotone ki-crown fs-2x text-inverse-warning">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div>
                                <h3 class="fw-bold text-gray-800 mb-1">Lisensi Aktif</h3>
                                <span class="fs-7 text-gray-600">Paket langganan Anda</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-light-dark fs-4 fw-bold px-4 py-2">Free Tier</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge badge-light-success">
                                    <i class="ki-duotone ki-check fs-7 text-success me-1"></i>
                                    5 Member
                                </span>
                                <span class="badge badge-light-success">
                                    <i class="ki-duotone ki-check fs-7 text-success me-1"></i>
                                    1000 Pesan/bulan
                                </span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-warning btn-sm mt-5">
                            <i class="ki-duotone ki-rocket fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Upgrade Paket
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title">
                    <h3 class="m-0 text-gray-800">Member</h3>
                </div>
                <div class="card-toolbar m-0">
                    <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs border-transparent" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a id="kt_referrals_year_tab" class="nav-link text-active-gray-800 active" data-bs-toggle="tab"
                                role="tab" href="#kt_referrals_1">Member Aktif</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="kt_referred_users_tab_content" class="tab-content">
                <div id="kt_referrals_1" class="card-body p-0 tab-pane fade show active" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9" id="kt_table_users">
                            <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                                <tr>
                                    <th class="min-w-175px ps-9">Member</th>
                                    <th class="min-w-150px px-0">Role</th>
                                    <th class="min-w-350px">Token</th>
                                    <th class="min-w-125px">Online</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="min-w-125px text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6 fw-semibold text-gray-600">
                                @foreach ($team->teamUsers as $teamUser)
                                    <tr>
                                        <td class="d-flex align-items-center">

                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="#">
                                                    <div class="symbol-label">
                                                        <img src="{{ $teamUser->user->getPhoto() }}" alt="{{ $teamUser->user->name }}"
                                                            class="w-100" />
                                                    </div>
                                                </a>
                                            </div>


                                            <div class="d-flex flex-column">
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary mb-1">{{ $teamUser->user->name }}</a>
                                                <span>{{ $teamUser->user->email }}</span>
                                            </div>

                                        </td>
                                        <td>{{ $teamUser->role }}</td>
                                        <td>
                                            <div class="badge badge-light fw-bold">{{ $teamUser->token }}</div>
                                        </td>
                                        <td>
                                            <span class="online-status-indicator" data-user-id="{{ $teamUser->user_id }}">
                                                @if (isset($onlineUsers[$teamUser->user_id]) && $onlineUsers[$teamUser->user_id])
                                                    <span class="badge badge-light-success">
                                                        <i class="ki-duotone ki-abstract-26 text-success fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                                        Online
                                                    </span>
                                                @else
                                                    <span class="badge badge-light-secondary">
                                                        <i class="ki-duotone ki-abstract-26 text-secondary fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                                        Offline
                                                    </span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if ($teamUser->status == "active")
                                                <span class="badge badge-light-success">Active</span>
                                            @elseif ($teamUser->status == "pending")
                                                <span class="badge badge-light-warning">Pending</span>
                                            @elseif ($teamUser->status == "blocked")
                                                <span class="badge badge-light-danger">Blocked</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="#"
                                                class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">

                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3 btn-edit-member"
                                                        data-id="{{ $teamUser->id }}"
                                                        data-name="{{ $teamUser->user->name }}"
                                                        data-role="{{ $teamUser->role }}"
                                                        data-status="{{ $teamUser->status }}">Edit</a>
                                                </div>


                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3 btn-delete-member"
                                                        data-id="{{ $teamUser->id }}"
                                                        data-name="{{ $teamUser->user->name }}">Delete</a>
                                                </div>

                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Team --}}
    <div class="modal fade" id="modal_edit_team" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Ubah Team</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form id="form_edit_team" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body scroll-y m-5">
                        <div class="fv-row mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Logo</label>
                            <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ $team->getLogo() }}')"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah logo">
                                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                    <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="logo_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus logo">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                            <div class="form-text">Format yang diperbolehkan: png, jpg, jpeg.</div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama Team</label>
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Team" value="{{ $team->name }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email" value="{{ $team->email }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone" value="{{ $team->phone }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Website</label>
                            <input type="url" name="website" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="https://example.com" value="{{ $team->website }}" />
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Menyimpan... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Add Member --}}
    <div class="modal fade" id="modal_add_member" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Member</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form id="form_add_member">
                    @csrf
                    <div class="modal-body scroll-y m-5">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Email User</label>
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="user@example.com" />
                            <div class="form-text">Masukkan email user yang sudah terdaftar.</div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Role</label>
                            <select name="role" class="form-select form-select-solid">
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                                <option value="agent">Agent</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Tambah</span>
                            <span class="indicator-progress">Menambahkan... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Member --}}
    <div class="modal fade" id="modal_edit_member" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Edit Member</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form id="form_edit_member">
                    @csrf
                    <input type="hidden" name="member_id" id="edit_member_id" />
                    <div class="modal-body scroll-y m-5">
                        <div class="d-flex flex-column mb-7">
                            <label class="fs-6 fw-semibold mb-2">Member</label>
                            <div class="fs-4 fw-bold" id="edit_member_name"></div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Role</label>
                            <select name="role" id="edit_member_role" class="form-select form-select-solid">
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                                <option value="agent">Agent</option>
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Status</label>
                            <select name="status" id="edit_member_status" class="form-select form-select-solid">
                                <option value="active">Active</option>
                                <option value="blocked">Blocked</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Menyimpan... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete Member --}}
    <div class="modal fade" id="modal_delete_member" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Hapus Member</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form id="form_delete_member">
                    @csrf
                    <input type="hidden" name="member_id" id="delete_member_id" />
                    <div class="modal-body scroll-y m-5">
                        <div class="text-center">
                            <i class="ki-duotone ki-information-5 fs-5tx text-danger mb-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="fs-3 fw-bold">Apakah Anda yakin ingin menghapus member <span id="delete_member_name" class="text-danger"></span>?</div>
                            <div class="text-muted fs-6">Tindakan ini tidak dapat dibatalkan.</div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <span class="indicator-label">Hapus</span>
                            <span class="indicator-progress">Menghapus... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    const teamNameId = "{{ $team->name_id }}";

    // DataTable
    $("#kt_table_users").DataTable({
        "responsive": true,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
    });

    // Function untuk update online status
    function updateOnlineStatus() {
        $.ajax({
            url: `/back/team/${teamNameId}/online-status`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update online count
                    $('#online-count').text(response.onlineCount);

                    // Update each user's online status
                    $('.online-status-indicator').each(function() {
                        const userId = $(this).data('user-id');
                        const isOnline = response.onlineUsers[userId] || false;

                        if (isOnline) {
                            $(this).html(`
                                <span class="badge badge-light-success">
                                    <i class="ki-duotone ki-abstract-26 text-success fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                    Online
                                </span>
                            `);
                        } else {
                            $(this).html(`
                                <span class="badge badge-light-secondary">
                                    <i class="ki-duotone ki-abstract-26 text-secondary fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                    Offline
                                </span>
                            `);
                        }
                    });
                }
            },
            error: function(xhr) {
                console.error('Failed to fetch online status');
            }
        });
    }

    // Auto refresh online status setiap 30 detik
    setInterval(updateOnlineStatus, 30000);

    // Edit Team Form
    $('#form_edit_team').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');

        submitBtn.attr('data-kt-indicator', 'on');
        submitBtn.prop('disabled', true);

        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: "{{ route('back.team.update', $team->name_id) }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    text: message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            },
            complete: function() {
                submitBtn.removeAttr('data-kt-indicator');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Add Member Form
    $('#form_add_member').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');

        submitBtn.attr('data-kt-indicator', 'on');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: "{{ route('back.team.member.add', $team->name_id) }}",
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire({
                    html: message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            },
            complete: function() {
                submitBtn.removeAttr('data-kt-indicator');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Edit Member - Open Modal
    $(document).on('click', '.btn-edit-member', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const name = $(this).data('name');
        const role = $(this).data('role');
        const status = $(this).data('status');

        $('#edit_member_id').val(id);
        $('#edit_member_name').text(name);
        $('#edit_member_role').val(role);
        $('#edit_member_status').val(status);

        $('#modal_edit_member').modal('show');
    });

    // Edit Member Form
    $('#form_edit_member').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const memberId = $('#edit_member_id').val();

        submitBtn.attr('data-kt-indicator', 'on');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: `/back/team/${teamNameId}/member/${memberId}/update`,
            method: 'PUT',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    text: message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            },
            complete: function() {
                submitBtn.removeAttr('data-kt-indicator');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Delete Member - Open Modal
    $(document).on('click', '.btn-delete-member', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#delete_member_id').val(id);
        $('#delete_member_name').text(name);

        $('#modal_delete_member').modal('show');
    });

    // Delete Member Form
    $('#form_delete_member').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const memberId = $('#delete_member_id').val();

        submitBtn.attr('data-kt-indicator', 'on');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: `/back/team/${teamNameId}/member/${memberId}/delete`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    text: message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            },
            complete: function() {
                submitBtn.removeAttr('data-kt-indicator');
                submitBtn.prop('disabled', false);
            }
        });
    });
</script>
@endsection
