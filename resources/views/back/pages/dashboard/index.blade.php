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
                                    <h2 class="mb-1">Whatsapp Session</h2>
                                    <div class="fs-6 fw-semibold text-muted">{{ $whatsapp_sessions->count() }} Session
                                        aktif</div>
                                </div>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#add_whatsappsession">
                                        <i class="ki-duotone ki-abstract-10 fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Tambah Session</button>
                                </div>
                            </div>
                            <div class="card-body p-9 pt-4">
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800">
                                                    <th>Whatsapp Session</th>
                                                    <th>Role</th>
                                                    <th>token</th>
                                                    <th class="text-end">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($whatsapp_sessions as $session)
                                                    <tr>
                                                        <td class="d-flex align-items-center">
                                                            @if ($session->whatsapp_session->is_active)
                                                                <div
                                                                    class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                                    <a href="#">
                                                                        <div id="tooltip_{{ $session->whatsapp_session->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="left" title="Mohon Tunggu..."
                                                                            class="symbol-label">
                                                                            <img id="img_{{ $session->whatsapp_session->id }}"
                                                                                src="{{ asset('wa_status/pending.png') }}"
                                                                                alt="..." class="w-100">
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <script>
                                                                    fetch('{{ route('api.v1.session.show', $session->whatsapp_session->session_name) }}', {
                                                                            headers: {
                                                                                'Accept': 'application/json',
                                                                                'session_token': '{{ $session->session_token }}'
                                                                            }
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            console.log(data);
                                                                            const imgElement = document.getElementById('img_{{ $session->whatsapp_session->id }}');
                                                                            const tooltipElement = document.getElementById('tooltip_{{ $session->whatsapp_session->id }}');

                                                                            if (data.data.status === 'WORKING') {
                                                                                imgElement.src = '{{ asset('wa_status/connected.png') }}';
                                                                                tooltipElement.setAttribute('title', 'Session is connected');
                                                                            } else if (data.data.status === 'STOPPED') {
                                                                                imgElement.src = '{{ asset('wa_status/disconnected.png') }}';
                                                                                tooltipElement.setAttribute('title', 'Session is disconnected');
                                                                            } else if (data.data.status === 'STARTING') { 
                                                                                imgElement.src = '{{ asset('wa_status/pending.png') }}';
                                                                                tooltipElement.setAttribute('title', 'Session is pending');
                                                                            } else{
                                                                                imgElement.src = '{{ asset('wa_status/disconnected.png') }}';
                                                                                tooltipElement.setAttribute('title', 'Session status is unknown');
                                                                            }
                                                                        })
                                                                        .catch(error => {
                                                                            console.error('Error fetching session status:', error);
                                                                        });
                                                                </script>
                                                            @else
                                                                <div
                                                                    class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                                    <a href="#">
                                                                        <div data-bs-toggle="tooltip"
                                                                            data-bs-placement="left"
                                                                            title="Session anda di blokir"
                                                                            class="symbol-label">
                                                                            <img src="
                                                                            {{ asset('wa_status/blocked.png') }}
                                                                        "
                                                                                alt="..." class="w-100">
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <div class="d-flex flex-column">
                                                                <a href=""
                                                                    class="text-gray-800 text-bold text-hover-primary mb-1">{{ $session->whatsapp_session->session_name }}</a>
                                                                <span>-</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $session->role }}</td>
                                                        <td>{{ $session->session_token }}</td>
                                                        <td class="text-end">
                                                            @if ($session->whatsapp_session->is_active)
                                                                <a href=""
                                                                    class="btn btn-sm btn-light-primary">Manage</a>
                                                            @else
                                                                <a href="" class="text-danger">Block</a>
                                                            @endif

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

    <div class="modal fade" tabindex="-1" id="add_whatsappsession">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="{{ route('back.dashboard.add-whatsapp-session') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">Buat WhatsApp Session</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>

                    <div class="modal-body">

                        <div class="mb-5">
                            <label for="session_name" class="required form-label">Nama Session</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">{{ $prefix_addwhatsappsesssion }}</span>
                                <input type="text" class="form-control  @error('session_name') is-invalid @enderror"
                                    id="session_name" name="session_name" placeholder="Contoh: session_utama"
                                    value="{{ old('session_name') }}" required />
                            </div>

                            @error('session_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Berikan nama yang mudah diingat untuk session WhatsApp Anda, tanpa
                                spasi</div>
                        </div>

                        <div class="mb-5">
                            <label for="session_webhook_url" class="form-label">Webhook URL <span
                                    class="text-muted">(Opsional)</span></label>
                            <input type="url" class="form-control @error('session_webhook_url') is-invalid @enderror"
                                id="session_webhook_url" name="session_webhook_url"
                                placeholder="https://example.com/webhook" value="{{ old('session_webhook_url') }}" />
                            @error('session_webhook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL untuk menerima notifikasi pesan masuk</div>
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
                                        Session akan dibuat dalam status non-aktif. Anda perlu melakukan scan QR code untuk
                                        mengaktifkan session.
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
                            Buat Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
