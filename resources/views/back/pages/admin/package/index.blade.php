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
                        <form action="{{ route('back.admin.package.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-solid w-250px ps-13"
                                placeholder="Cari package..." value="{{ request('search') }}" />
                            @if (request('status') !== null)
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                        </form>
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end gap-3" data-kt-package-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-filter fs-2"></i>Filter
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                            </div>
                            <div class="separator border-gray-200"></div>
                            <div class="px-7 py-5">
                                <form action="{{ route('back.admin.package.index') }}" method="GET">
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Status:</label>
                                        <select class="form-select form-select-solid fw-bold" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('back.admin.package.index') }}"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6">Reset</a>
                                        <button type="submit" class="btn btn-primary fw-semibold px-6">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Filter-->
                        <!--begin::Add package-->
                        <a href="{{ route('back.admin.package.create') }}" class="btn btn-primary">
                            <i class="ki-outline ki-plus fs-2"></i>Tambah Package
                        </a>
                        <!--end::Add package-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_packages">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">No</th>
                            <th class="min-w-150px">Package</th>
                            <th class="min-w-100px">Harga</th>
                            <th class="min-w-100px">Limits</th>
                            <th class="min-w-80px">Teams</th>
                            <th class="min-w-80px">Status</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse($packages as $key => $package)
                            <tr>
                                <td>{{ $packages->firstItem() + $key }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-3">
                                            <span class="symbol-label" style="background-color: {{ $package->badge_color }}20">
                                                <i class="ki-outline ki-{{ $package->icon ?? 'box' }} fs-2" style="color: {{ $package->badge_color }}"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('back.admin.package.show', $package->id) }}"
                                                class="text-gray-800 text-hover-primary mb-1 fw-bold">
                                                {{ $package->name }}
                                                @if($package->is_featured)
                                                    <i class="ki-outline ki-verify fs-5 text-primary ms-1" data-bs-toggle="tooltip" title="Featured"></i>
                                                @endif
                                            </a>
                                            <span class="badge" style="background-color: {{ $package->badge_color }}; color: white; width: fit-content;">
                                                {{ $package->slug }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-gray-800">{{ $package->formatted_price }}</span>
                                    <span class="text-muted d-block fs-7">{{ $package->billing_cycle_label }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1 fs-7">
                                        <span><i class="ki-outline ki-people fs-7 text-gray-500 me-1"></i>{{ $package->getLimitDisplay('max_members') }} members</span>
                                        <span><i class="ki-outline ki-message-text fs-7 text-gray-500 me-1"></i>{{ $package->getLimitDisplay('max_messages_per_day') }} msg/day</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light-primary">{{ $package->teams_count }} teams</span>
                                </td>
                                <td>
                                    @if($package->is_active)
                                        <span class="badge badge-light-success">Active</span>
                                    @else
                                        <span class="badge badge-light-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-outline ki-down fs-5 ms-1"></i>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.admin.package.show', $package->id) }}" class="menu-link px-3">
                                                <i class="ki-outline ki-eye fs-5 me-2"></i>View
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.admin.package.edit', $package->id) }}" class="menu-link px-3">
                                                <i class="ki-outline ki-pencil fs-5 me-2"></i>Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <form action="{{ route('back.admin.package.toggle-status', $package->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="menu-link px-3 w-100 border-0 bg-transparent text-start">
                                                    <i class="ki-outline ki-{{ $package->is_active ? 'cross-circle' : 'check-circle' }} fs-5 me-2"></i>
                                                    {{ $package->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="separator my-2"></div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 text-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $package->id }}">
                                                <i class="ki-outline ki-trash fs-5 me-2"></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!--begin::Delete Modal-->
                            <div class="modal fade" id="deleteModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Hapus Package</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-outline ki-cross fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            @if($package->teams_count > 0)
                                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-5">
                                                    <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                                                    <div class="d-flex flex-stack flex-grow-1">
                                                        <div class="fw-semibold">
                                                            <div class="fs-6 text-gray-700">
                                                                Package ini sedang digunakan oleh <strong>{{ $package->teams_count }} team</strong>.
                                                                Anda tidak dapat menghapus package ini.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-center fs-5">
                                                    Apakah Anda yakin ingin menghapus package <strong>{{ $package->name }}</strong>?
                                                </p>
                                                <p class="text-center text-muted">
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            @if($package->teams_count == 0)
                                                <form action="{{ route('back.admin.package.destroy', $package->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Delete Modal-->
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ki-outline ki-box fs-3x text-gray-400 mb-5"></i>
                                        <span class="text-gray-600 fs-5">Tidak ada data package</span>
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
                        {{ $packages->appends(request()->query())->links() }}
                    </div>
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
