<!--begin::User-->
<div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
    <!--begin::Symbol-->
    <div class="symbol symbol-50px">
        <img src="{{ auth()?->user()?->getPhoto() ?? '' }}" alt="" />
    </div>
    <!--end::Symbol-->
    <!--begin::Wrapper-->
    <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
        <!--begin::Section-->
        <div class="d-flex">
            <!--begin::Info-->
            <div class="flex-grow-1 me-2">
                <!--begin::Username-->
                <a href="#" class="text-white text-hover-primary fs-6 fw-bold">{{ Auth::user()?->name ?? '-' }}</a>
                <!--end::Username-->
                <!--begin::Description-->
                <span
                    class="text-gray-600 fw-semibold d-block fs-8 mb-1">{{ auth()?->user()?->roles?->pluck('name')->join(', ') ?? '' }}</span>
                <!--end::Description-->
                <!--begin::Label-->
                <div class="d-flex align-items-center text-success fs-9">
                    <span class="bullet bullet-dot bg-success me-1"></span>online
                </div>
                <!--end::Label-->
            </div>
            <!--end::Info-->
            <!--begin::User menu-->
            <div class="me-n2">
                <!--begin::Action-->
                <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2"
                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                    <i class="ki-duotone ki-setting-2 text-muted fs-1"><span class="path1"></span><span
                            class="path2"></span></i>
                </a>
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                <img alt="Logo" src="{{ auth()?->user()?->getPhoto() ?? '' }}" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">
                                    {{ Auth::user()?->name ?? '-' }}
                                </div>
                                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                    {{ auth()?->user()?->roles?->pluck('name')->join(', ') ?? '' }} </a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="#" class="menu-link px-5">
                            Profil Saya
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="?page=apps/projects/list" class="menu-link px-5">
                            <span class="menu-text">My Session</span>
                            <span class="menu-badge">
                                <span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" data-kt-menu-offset="-15px, 0">
                        <a href="#" class="menu-link px-5">
                            <span class="menu-title position-relative">
                                Bahasa
                                <span
                                    class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                    Indonesia <img class="w-15px h-15px rounded-1 ms-2"
                                        src="{{ asset('back/media/flags/indonesia.svg') }}" alt="" />
                                </span>
                            </span>
                        </a>
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="?page=account/settings" class="menu-link d-flex px-5 active">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1" src="{{ asset('back/media/flags/indonesia.svg') }}"
                                            alt="" />
                                    </span>
                                    Indonesia
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('logout') }}" class="menu-link px-5">
                            Keluar
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->

                <!--end::Action-->
            </div>
            <!--end::User menu-->
        </div>
        <!--end::Section-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::User-->
<!--begin::Aside search-->
@php
    $teams = auth()->user()->teams;
    $current_team = Illuminate\Support\Facades\Cookie::get('current_team');
@endphp
<div class="aside-search py-5">
    <div class="border rounded">
        <select data-control="select2" class="form-select form-select-sm form-select-solid" data-placeholder="Pilih Team"
            onchange="window.location.href = this.value" data-hide-search="true">
            <option></option>
            @foreach ($teams as $team)
                <option value="{{ route('back.switch-team', $team->name_id) }}"
                    @if ($current_team == $team->name_id) selected @endif>
                    {{ $team->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<!--end::Aside search-->
