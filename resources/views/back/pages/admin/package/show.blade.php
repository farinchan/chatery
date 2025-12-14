@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Package Header-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px">
                            <span class="symbol-label fs-2x fw-bold" style="background-color: {{ $package->badge_color }}20; color: {{ $package->badge_color }}">
                                <i class="ki-outline ki-{{ $package->icon ?? 'box' }} fs-3x"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-gray-900 fs-2 fw-bold me-1">{{ $package->name }}</span>
                                    @if($package->is_featured)
                                        <span class="badge badge-light-warning ms-2">
                                            <i class="ki-outline ki-verify fs-5 text-warning me-1"></i>Featured
                                        </span>
                                    @endif
                                    @if($package->is_active)
                                        <span class="badge badge-light-success ms-2">Active</span>
                                    @else
                                        <span class="badge badge-light-danger ms-2">Inactive</span>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <span class="badge me-3" style="background-color: {{ $package->badge_color }}; color: white;">
                                        {{ $package->slug }}
                                    </span>
                                    <span class="d-flex align-items-center text-gray-500 me-5">
                                        <i class="ki-outline ki-wallet fs-4 me-1"></i>
                                        {{ $package->formatted_price }} {{ $package->billing_cycle_label }}
                                    </span>
                                </div>
                                @if($package->description)
                                    <p class="text-gray-600 mb-0">{{ $package->description }}</p>
                                @endif
                            </div>
                            <div class="d-flex my-4">
                                <a href="{{ route('back.admin.package.index') }}" class="btn btn-sm btn-light me-2">
                                    <i class="ki-outline ki-arrow-left fs-3"></i>Kembali
                                </a>
                                <a href="{{ route('back.admin.package.edit', $package->id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="ki-outline ki-pencil fs-3"></i>Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePackageModal">
                                    <i class="ki-outline ki-trash fs-3"></i>Hapus
                                </button>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-people fs-3 text-success me-2"></i>
                                            <div class="fs-2 fw-bold">{{ $package->teams_count }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-500">Teams</div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-user fs-3 text-info me-2"></i>
                                            <div class="fs-2 fw-bold">{{ $package->getLimitDisplay('max_members') }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-500">Max Members</div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-message-text fs-3 text-primary me-2"></i>
                                            <div class="fs-2 fw-bold">{{ $package->getLimitDisplay('max_messages_per_day') }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-500">Msg/Day</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Package Header-->

        <div class="row">
            <!--begin::Limits & Features-->
            <div class="col-md-6">
                <!--begin::Limits Card-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <h3 class="card-title">Batasan (Limits)</h3>
                    </div>
                    <div class="card-body p-9">
                        <table class="table table-row-dashed table-row-gray-300 gy-4">
                            <tbody>
                                @foreach($package->limits as $label => $value)
                                    <tr>
                                        <td class="fw-semibold text-gray-600">{{ $label }}</td>
                                        <td class="text-end">
                                            <span class="badge badge-light-primary fs-6">{{ $value }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Limits Card-->
            </div>

            <div class="col-md-6">
                <!--begin::Features Card-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <h3 class="card-title">Fitur</h3>
                    </div>
                    <div class="card-body p-9">
                        <table class="table table-row-dashed table-row-gray-300 gy-4">
                            <tbody>
                                @foreach($package->features as $label => $enabled)
                                    <tr>
                                        <td class="fw-semibold text-gray-600">{{ $label }}</td>
                                        <td class="text-end">
                                            @if($enabled)
                                                <span class="badge badge-light-success">
                                                    <i class="ki-outline ki-check fs-5 text-success"></i>
                                                </span>
                                            @else
                                                <span class="badge badge-light-danger">
                                                    <i class="ki-outline ki-cross fs-5 text-danger"></i>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Features Card-->
            </div>
        </div>

        <!--begin::Teams Using Package-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header">
                <h3 class="card-title">Teams Menggunakan Package Ini ({{ $teams->total() }})</h3>
            </div>
            <div class="card-body p-9">
                @if($teams->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th class="min-w-200px">Team</th>
                                    <th class="min-w-100px">Members</th>
                                    <th class="min-w-100px">Expired</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="{{ $team->getLogo() }}" alt="{{ $team->name }}" />
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a href="{{ route('back.admin.team.show', $team->id) }}" class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $team->name }}</a>
                                                    <span class="text-muted fw-semibold d-block fs-7">{{ $team->name_id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary">{{ $team->teamUsers->count() }} members</span>
                                        </td>
                                        <td>
                                            @if($team->package_expires_at)
                                                @if($team->isPackageExpired())
                                                    <span class="badge badge-light-danger">Expired {{ $team->package_expires_at->diffForHumans() }}</span>
                                                @else
                                                    <span class="text-gray-600">{{ $team->package_expires_at->format('d M Y') }}</span>
                                                    <span class="text-muted d-block fs-7">{{ $team->getDaysUntilExpiry() }} days left</span>
                                                @endif
                                            @else
                                                <span class="badge badge-light-success">Lifetime</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($team->hasActivePackage())
                                                <span class="badge badge-light-success">Active</span>
                                            @else
                                                <span class="badge badge-light-danger">Expired</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('back.admin.team.show', $team->id) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                                View
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light-danger" data-bs-toggle="modal" data-bs-target="#removePackageModal{{ $team->id }}">
                                                Remove
                                            </button>
                                        </td>
                                    </tr>

                                    <!--begin::Remove Package Modal-->
                                    <div class="modal fade" id="removePackageModal{{ $team->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Hapus Package dari Team</h2>
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                        <i class="ki-outline ki-cross fs-1"></i>
                                                    </div>
                                                </div>
                                                <div class="modal-body text-center py-10">
                                                    <p class="fs-5">Apakah Anda yakin ingin menghapus package dari team <strong>{{ $team->name }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('back.admin.package.remove-from-team', $team->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Remove Package Modal-->
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap mt-5">
                        {{ $teams->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="ki-outline ki-people fs-3x text-gray-400 mb-5"></i>
                        <p class="text-gray-600 fs-5">Belum ada team yang menggunakan package ini</p>
                    </div>
                @endif
            </div>
        </div>
        <!--end::Teams Using Package-->
    </div>

    <!--begin::Delete Package Modal-->
    <div class="modal fade" id="deletePackageModal" tabindex="-1" aria-hidden="true">
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
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
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
                        <form action="{{ route('back.admin.package.destroy', $package->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--end::Delete Package Modal-->
@endsection
