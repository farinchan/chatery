@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <form action="{{ route('back.admin.team.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-solid w-250px ps-13"
                                placeholder="Cari team..." value="{{ request('search') }}" />
                        </form>
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-team-table-toolbar="base">
                        <!--begin::Add team-->
                        <a href="{{ route('back.admin.team.create') }}" class="btn btn-primary">
                            <i class="ki-outline ki-plus fs-2"></i>Tambah Team
                        </a>
                        <!--end::Add team-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_teams">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">No</th>
                            <th class="min-w-150px">Team</th>
                            <th class="min-w-125px">Name ID</th>
                            <th class="min-w-125px">Contact</th>
                            <th class="min-w-100px">Members</th>
                            <th class="min-w-100px">Created</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse($teams as $key => $team)
                            <tr>
                                <td>{{ $teams->firstItem() + $key }}</td>
                                <td class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="{{ route('back.admin.team.show', $team->id) }}">
                                            <div class="symbol-label">
                                                <img src="{{ $team->getLogo() }}" alt="{{ $team->name }}"
                                                    class="w-100" />
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Team details-->
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('back.admin.team.show', $team->id) }}"
                                            class="text-gray-800 text-hover-primary mb-1">{{ $team->name }}</a>
                                        @if($team->website)
                                            <a href="{{ $team->website }}" target="_blank" class="text-muted fs-7">
                                                <i class="ki-outline ki-globe fs-7 me-1"></i>{{ parse_url($team->website, PHP_URL_HOST) }}
                                            </a>
                                        @endif
                                    </div>
                                    <!--end::Team details-->
                                </td>
                                <td>
                                    <span class="badge badge-light-info">{{ $team->name_id }}</span>
                                </td>
                                <td>
                                    @if($team->email)
                                        <span class="d-block text-gray-800">{{ $team->email }}</span>
                                    @endif
                                    @if($team->phone)
                                        <span class="text-muted fs-7">{{ $team->phone }}</span>
                                    @endif
                                    @if(!$team->email && !$team->phone)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-light-primary me-2">{{ $team->teamUsers->count() }}</span>
                                        <div class="symbol-group symbol-hover flex-nowrap">
                                            @foreach($team->teamUsers->take(3) as $member)
                                                <div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip"
                                                    title="{{ $member->user->name }} ({{ ucfirst($member->role) }})">
                                                    <img src="{{ $member->user->getPhoto() }}" alt="{{ $member->user->name }}" />
                                                </div>
                                            @endforeach
                                            @if($team->teamUsers->count() > 3)
                                                <div class="symbol symbol-25px symbol-circle">
                                                    <span class="symbol-label bg-light-primary text-primary fs-8 fw-bold">
                                                        +{{ $team->teamUsers->count() - 3 }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $team->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-outline ki-down fs-5 ms-1"></i>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.admin.team.show', $team->id) }}" class="menu-link px-3">
                                                View
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.admin.team.edit', $team->id) }}" class="menu-link px-3">
                                                Edit
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $team->id }}">
                                                Delete
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>

                            <!--begin::Delete Modal-->
                            <div class="modal fade" id="deleteModal{{ $team->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Hapus Team</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-bs-dismiss="modal">
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
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('back.admin.team.destroy', $team->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Delete Modal-->
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ki-outline ki-people fs-3x text-gray-400 mb-5"></i>
                                        <span class="text-gray-600 fs-5">Tidak ada data team</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!--end::Table-->

                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex flex-wrap py-2 mr-3">
                        {{ $teams->appends(request()->query())->links() }}
                    </div>
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
