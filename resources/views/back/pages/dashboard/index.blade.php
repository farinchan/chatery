@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-body">
                        <div class="d-flex flex-center flex-column py-5">
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ $user->getPhoto() }}" alt="image" />
                            </div>
                            <a href="#"
                                class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->name }}</a>
                            <div class="mb-9">
                                @foreach ($user->getRoleNames() as $role)
                                    <div class="badge badge-lg badge-light-primary d-inline">{{ $role }}</div>
                                @endforeach
                            </div>

                        </div>
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details"
                                role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                                <span class="ms-2 rotate-180">
                                    <i class="ki-duotone ki-down fs-3"></i>
                                </span>
                            </div>
                            <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit customer details">
                                <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_details">Edit</a>
                            </span>
                        </div>
                        <div class="separator"></div>
                        <div id="kt_user_view_details" class="collapse show">
                            <div class="pb-5 fs-6">
                                <div class="fw-bold mt-5">Email</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                                </div>

                                <div class="fw-bold mt-5">Username</div>
                                <div class="text-gray-600">{{ $user->username }}</div>

                                <div class="fw-bold mt-5">No Telp/Whatsapp</div>
                                <div class="text-gray-600">{{ $user->phone ?? '-' }}</div>

                                <div class="fw-bold mt-5">Terakhir Masuk</div>
                                <div class="text-gray-600">-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <h3 class="fw-bold m-0">Sambungkan Akun</h3>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <i class="ki-duotone ki-design-1 fs-2tx text-primary me-4"></i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">Dengan menghubungkan akun, Anda menyetujui
                                        <a href="#" class="me-1">kebijakan privasi</a>dan
                                        <a href="#">syarat dan ketentuan</a> kami.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="d-flex flex-stack">
                                <div class="d-flex">
                                    <img src="{{ asset('back/media/svg/brand-logos/google-icon.svg') }}" class="w-30px me-6"
                                        alt="" />
                                    <div class="d-flex flex-column">
                                        <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Google</a>
                                        <div class="fs-6 fw-semibold text-muted">Plan properly your workflow</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" name="google" type="checkbox" value="1"
                                            id="kt_modal_connected_accounts_google" readonly />
                                        <span class="form-check-label fw-semibold text-muted"
                                            for="kt_modal_connected_accounts_google"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="d-flex flex-stack">
                                <div class="d-flex">
                                    <img src="{{ asset('back/media/svg/brand-logos/github-1.svg') }}" class="w-30px me-6"
                                        alt="" />
                                    <div class="d-flex flex-column">
                                        <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">Github</a>
                                        <div class="fs-6 fw-semibold text-muted">Keep eye on on your Repositories</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" name="github" type="checkbox" value="1"
                                            id="kt_modal_connected_accounts_github" readonly />
                                        <span class="form-check-label fw-semibold text-muted"
                                            for="kt_modal_connected_accounts_github"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="d-flex flex-stack">
                                <div class="d-flex">
                                    <img src="{{ asset('back/media/svg/brand-logos/facebook-4.svg') }}" class="w-30px me-6"
                                        alt="" />
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                            class="fs-5 text-gray-900 text-hover-primary fw-bold">Facebook</a>
                                        <div class="fs-6 fw-semibold text-muted">Integrate Projects Discussions</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <label
                                        class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" name="slack" type="checkbox" value="1"
                                            id="kt_modal_connected_accounts_slack" readonly />
                                        <span class="form-check-label fw-semibold text-muted"
                                            for="kt_modal_connected_accounts_slack"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer border-0 d-flex justify-content-center pt-0">
                        <button class="btn btn-sm btn-light-primary">Save Changes</button>
                    </div> --}}
                </div>
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                            href="#kt_user_view_overview_tab">Overview</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                            href="#kt_user_view_overview_events_and_logs_tab">Events & Logs</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                        <div class="card card-flush mb-6 mb-xl-9">
                            <div class="card-header mt-6">
                                <div class="card-title flex-column">
                                    <h2 class="mb-1">
                                        <i class="ki-duotone ki-people fs-2 me-2 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        Team Saya
                                    </h2>
                                    <div class="fs-6 fw-semibold text-muted">{{ $teams->count() }} Team terdaftar</div>
                                </div>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal_add_team">
                                        <i class="ki-duotone ki-plus fs-3"></i>
                                        Buat Team Baru
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-9 pt-4">
                                @if ($teams->count() > 0)
                                    <div class="row g-6">
                                        @foreach ($teams as $teamUser)
                                            <div class="col-md-6 ">
                                                <div class="card border border-gray-300 border-hover shadow-sm h-100">
                                                    <div class="card-body d-flex flex-column p-6">
                                                        {{-- Header dengan Logo dan Info --}}
                                                        <div class="d-flex align-items-center mb-5">
                                                            <div class="symbol symbol-60px symbol-circle me-4">
                                                                <img src="{{ $teamUser->team->getLogo() }}"
                                                                    alt="{{ $teamUser->team->name }}" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <a href="{{ route('back.team.index', $teamUser->team->name_id) }}"
                                                                    class="text-gray-800 text-hover-primary fs-4 fw-bold mb-1 d-block">
                                                                    {{ $teamUser->team->name }}
                                                                </a>
                                                                <span
                                                                    class="badge badge-light-{{ $teamUser->role == 'owner' ? 'danger' : ($teamUser->role == 'admin' ? 'warning' : 'primary') }}">
                                                                    {{ ucfirst($teamUser->role) }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        {{-- Info Team --}}
                                                        <div class="mb-5">
                                                            @if ($teamUser->team->email)
                                                                <div class="d-flex align-items-center text-gray-600 mb-2">
                                                                    <i class="ki-duotone ki-sms fs-5 me-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <span
                                                                        class="fs-7">{{ $teamUser->team->email }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($teamUser->team->phone)
                                                                <div class="d-flex align-items-center text-gray-600 mb-2">
                                                                    <i class="ki-duotone ki-phone fs-5 me-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <span
                                                                        class="fs-7">{{ $teamUser->team->phone }}</span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Stats --}}
                                                        <div class="d-flex justify-content-between mb-5">
                                                            <div class="text-center">
                                                                <span
                                                                    class="fs-2 fw-bold text-gray-800">{{ $teamUser->team->teamUsers->count() }}</span>
                                                                <span
                                                                    class="fs-7 fw-semibold text-gray-500 d-block">Member</span>
                                                            </div>
                                                            <div class="border-start"></div>
                                                            <div class="text-center">
                                                                <span class="fs-2 fw-bold text-success">-</span>
                                                                <span
                                                                    class="fs-7 fw-semibold text-gray-500 d-block">Online</span>
                                                            </div>
                                                            <div class="border-start"></div>
                                                            <div class="text-center">
                                                                <span
                                                                    class="badge badge-light-{{ $teamUser->status == 'active' ? 'success' : 'danger' }} fs-7">
                                                                    {{ ucfirst($teamUser->status) }}
                                                                </span>
                                                                <span
                                                                    class="fs-7 fw-semibold text-gray-500 d-block">Status</span>
                                                            </div>
                                                        </div>


                                                        {{-- Action Button --}}
                                                        <div class="mt-auto">
                                                            @if ($teamUser->status == 'active')
                                                                <a href="{{ route('back.team.index', $teamUser->team->name_id) }}"
                                                                    class="btn btn-primary btn-sm w-100">
                                                                    <i class="ki-duotone ki-setting-2 fs-4 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    Kelola Team
                                                                </a>
                                                            @else
                                                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                                                    <i class="ki-duotone ki-lock fs-4 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    Akses Diblokir
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10">
                                        <i class="ki-duotone ki-people fs-5tx text-gray-300 mb-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        <div class="fs-4 fw-bold text-gray-600 mb-2">Belum ada Team</div>
                                        <div class="fs-6 text-gray-500 mb-5">Buat team pertama Anda untuk mulai mengelola
                                            WhatsApp</div>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_add_team">
                                            <i class="ki-duotone ki-plus fs-3"></i>
                                            Buat Team Baru
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Login Sessions</h2>
                                </div>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-flex btn-light-primary"
                                        id="kt_modal_sign_out_sesions">
                                        <i class="ki-duotone ki-entrance-right fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Sign out all sessions</button>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-5">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed gy-5"
                                        id="kt_table_users_login_session">
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">Location</th>
                                                <th>Device</th>
                                                <th>IP Address</th>
                                                <th class="min-w-125px">Time</th>
                                                <th class="min-w-70px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-6 fw-semibold text-gray-600">
                                            <tr>
                                                <td>Australia</td>
                                                <td>Chome - Windows</td>
                                                <td>207.42.26.47</td>
                                                <td>23 seconds ago</td>
                                                <td>Current session</td>
                                            </tr>
                                            <tr>
                                                <td>Australia</td>
                                                <td>Safari - iOS</td>
                                                <td>207.47.11.340</td>
                                                <td>3 days ago</td>
                                                <td>
                                                    <a href="#" data-kt-users-sign-out="single_user">Sign out</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Australia</td>
                                                <td>Chrome - Windows</td>
                                                <td>207.40.20.197</td>
                                                <td>last week</td>
                                                <td>Expired</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Logs</h2>
                                </div>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-light-primary">
                                        <i class="ki-duotone ki-cloud-download fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Download Report</button>
                                </div>
                            </div>
                            <div class="card-body py-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                                        id="kt_table_users_logs">
                                        <tbody>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-danger">500 ERR</div>
                                                </td>
                                                <td>POST /v1/invoice/in_8895_8775/invalid</td>
                                                <td class="pe-0 text-end min-w-200px">19 Aug 2024, 8:43 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-danger">500 ERR</div>
                                                </td>
                                                <td>POST /v1/invoice/in_8895_8775/invalid</td>
                                                <td class="pe-0 text-end min-w-200px">15 Apr 2024, 6:05 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-success">200 OK</div>
                                                </td>
                                                <td>POST /v1/invoices/in_4465_7219/payment</td>
                                                <td class="pe-0 text-end min-w-200px">25 Oct 2024, 11:05 am</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-warning">404 WRN</div>
                                                </td>
                                                <td>POST /v1/customer/c_65a10a443a18f/not_found</td>
                                                <td class="pe-0 text-end min-w-200px">22 Sep 2024, 2:40 pm</td>
                                            </tr>
                                            <tr>
                                                <td class="min-w-70px">
                                                    <div class="badge badge-light-warning">404 WRN</div>
                                                </td>
                                                <td>POST /v1/customer/c_65a10a443a18f/not_found</td>
                                                <td class="pe-0 text-end min-w-200px">10 Mar 2024, 11:05 am</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create Team --}}
    <div class="modal fade" tabindex="-1" id="modal_add_team">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('back.dashboard.add-team') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <i class="ki-duotone ki-people fs-2 me-2 text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            Buat Team Baru
                        </h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>

                    <div class="modal-body">
                        {{-- Logo Upload --}}
                        <div class="mb-7">
                            <label class="form-label">Logo Team</label>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-100px symbol-circle me-5">
                                    <img id="logo_preview"
                                        src="https://ui-avatars.com/api/?name=T&background=3699FF&color=fff&size=100"
                                        alt="Logo Preview" />
                                </div>
                                <div>
                                    <label for="logo_input" class="btn btn-sm btn-light-primary me-2">
                                        <i class="ki-duotone ki-picture fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Pilih Logo
                                    </label>
                                    <input type="file" id="logo_input" name="logo" class="d-none"
                                        accept="image/*" onchange="previewLogo(this)" />
                                    <div class="form-text mt-2">Format: JPG, PNG, GIF (Max 2MB)</div>
                                </div>
                            </div>
                        </div>

                        {{-- Team Name --}}
                        <div class="mb-5">
                            <label for="team_name" class="required form-label">Nama Team</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="team_name"
                                name="name" placeholder="Contoh: Marketing Team" value="{{ old('name') }}"
                                required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="team_email" class="form-label">Email Team <span
                                    class="text-muted">(Opsional)</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="team_email" name="email" placeholder="team@example.com"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-5">
                            <label for="team_phone" class="form-label">Nomor Telepon <span
                                    class="text-muted">(Opsional)</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="team_phone" name="phone" placeholder="08xxxxxxxxxx"
                                value="{{ old('phone') }}" />
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-5">
                            <label for="team_address" class="form-label">Alamat <span
                                    class="text-muted">(Opsional)</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="team_address" name="address"
                                rows="2" placeholder="Alamat lengkap team">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                            <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">
                                        Anda akan menjadi owner dari team ini dan dapat mengundang member lain untuk
                                        bergabung.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-duotone ki-check fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Buat Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logo_preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
