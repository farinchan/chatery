<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links Of CSS File -->
    <link rel="stylesheet" href="{{ asset('back/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/google-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/fullcalendar.main.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/lightpick.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/style.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('back/images/favicon.png') }}">
    <!-- Title -->
    <title>{{ $title ?? 'Page Title' }}</title>
    @livewireStyles
</head>

<body class="boxed-size">
    <!-- Start Preloader Area -->
    {{-- <div class="preloader" id="preloader">
            <div class="preloader">
                <div class="waviy position-relative">
                    <span class="d-inline-block">T</span>
                    <span class="d-inline-block">R</span>
                    <span class="d-inline-block">E</span>
                    <span class="d-inline-block">Z</span>
                    <span class="d-inline-block">O</span>
                </div>
            </div>
        </div> --}}
    <!-- End Preloader Area -->

    <!-- Start Sidebar Area -->
    @include('components.partials.sidebar')
    <!-- End Sidebar Area -->

    <!-- Start Main Content Area -->
    <div class="container-fluid">

        <div class="main-content d-flex flex-column">
            <!-- Start Header Area -->
            @include('components.partials.header')
            <!-- End Header Area -->

            <div class="main-content-container overflow-hidden">
                @include('components.partials.breadcrumb')

                {{ $slot }}
            </div>

            <div class="flex-grow-1"></div>

            <!-- Start Footer Area -->
            @include('components.partials.footer')
            <!-- End Footer Area -->
        </div>


    </div>
    <!-- Start Main Content Area -->

    <!-- Start Create From Area -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom p-4">
            <h5 class="offcanvas-title fs-18 mb-0" id="offcanvasRightLabel">Create Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-4">
            <form>
                <div class="form-group mb-4">
                    <label class="label">Task ID</label>
                    <input type="text" class="form-control text-dark" placeholder="Task ID">
                </div>
                <div class="form-group mb-4">
                    <label class="label">Task Title</label>
                    <input type="text" class="form-control text-dark" placeholder="Task Title">
                </div>
                <div class="form-group mb-4">
                    <label class="label">Assigned To</label>
                    <input type="text" class="form-control text-dark" placeholder="Assigned To">
                </div>
                <div class="form-group mb-4">
                    <label class="label">Due Date</label>
                    <input type="date" class="form-control text-dark">
                </div>
                <div class="form-group mb-4">
                    <label class="label">Priority</label>
                    <select class="form-select form-control text-dark" aria-label="Default select example">
                        <option selected>High</option>
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="label">Status</label>
                    <select class="form-select form-control text-dark" aria-label="Default select example">
                        <option selected>Finished</option>
                        <option value="1">Pending</option>
                        <option value="2">In Progress</option>
                        <option value="3">Cancelled</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="label">Action</label>
                    <select class="form-select form-control text-dark" aria-label="Default select example">
                        <option selected>Yes</option>
                        <option value="1">No</option>
                    </select>
                </div>

                <div class="form-group d-flex gap-3">
                    <button class="btn btn-primary text-white fw-semibold py-2 px-2 px-sm-3">
                        <span class="py-sm-1 d-block">
                            <i class="ri-add-line text-white"></i>
                            <span>Create Task</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Create From Area -->

    <!-- Start Theme Setting Area -->
    <div class="offcanvas offcanvas-end bg-white" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1"
        id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel"
        style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
        <div class="offcanvas-header bg-primary py-3 px-4">
            <h5 class="offcanvas-title fs-18 text-white" id="offcanvasScrollingLabel">Theme Settings</h5>
            <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"
                style="filter: invert(1); opacity: 1;"></button>
        </div>
        <div class="offcanvas-body p-4">
            <div class="mb-4 pb-2">
                <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">RTL / LTR</h4>

                <div class="d-flex align-items-center position-relative settings-box-wrap for-rtl-mode"
                    style="gap: 25px;">
                    <div class="cursor position-relative active-wrap2">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">LTR</span>
                        </div>
                    </div>
                    <div class="cursor position-relative active-wrap1">
                        <div class="settings-box for-rtl">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">RTL</span>
                        </div>
                    </div>
                    <label id="switch" class="switch-for-rtl">
                        <input type="checkbox" class="position-absolute top-0 bottom-0 start-0 end-0 opacity-0 cursor"
                            onchange="toggleTheme()" id="slider">
                        <span class="sliders round"></span>
                    </label>
                </div>
            </div>

            <!-- <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Container Style Fluid / Boxed</h4>
                    <button class="boxed-style settings-btn fluid-boxed-btn" id="boxed-style">
                        Click To <span class="fluid">Fluid</span> <span class="boxed">Boxed</span>
                    </button>
                </div> -->

            <div class="mb-4 pb-2">
                <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Sidebar Light / Dark</h4>

                <div class="d-flex align-items-center position-relative settings-box-wrap for-sidebar-dark"
                    style="gap: 25px;">
                    <div class="cursor position-relative active-wrap2">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Light</span>
                        </div>
                    </div>
                    <div class="cursor position-relative active-wrap1">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Dark</span>
                        </div>
                    </div>
                    <button class="sidebar-light-dark settings-btn" id="sidebar-light-dark"></button>
                </div>
            </div>

            <div class="mb-4 pb-2">
                <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Header Light / Dark</h4>

                <div class="d-flex align-items-center position-relative settings-box-wrap for-header-dark"
                    style="gap: 25px;">
                    <div class="cursor position-relative active-wrap2">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Light</span>
                        </div>
                    </div>
                    <div class="cursor position-relative active-wrap1">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Dark</span>
                        </div>
                    </div>
                    <button class="header-light-dark settings-btn" id="header-light-dark"></button>
                </div>
            </div>

            <div class="mb-4 pb-2">
                <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Footer Light / Dark</h4>

                <div class="d-flex align-items-center position-relative settings-box-wrap for-footer-dark"
                    style="gap: 25px;">
                    <div class="cursor position-relative active-wrap2">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Light</span>
                        </div>
                    </div>
                    <div class="cursor position-relative active-wrap1">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Dark</span>
                        </div>
                    </div>
                    <button class="footer-light-dark settings-btn" id="footer-light-dark"></button>
                </div>
            </div>

            <div class="mb-4 pb-2">
                <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style Radius / Square</h4>

                <div class="d-flex align-items-center position-relative settings-box-wrap for-card-radius"
                    style="gap: 25px;">
                    <div class="cursor position-relative active-wrap2">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Radius</span>
                        </div>
                    </div>
                    <div class="cursor position-relative active-wrap1">
                        <div class="settings-box rounded-0">
                            <span class="rounded-0"></span>
                            <span class="rounded-0"></span>
                            <span class="rounded-0"></span>
                            <span class="rounded-0"></span>
                            <span class="rounded-0"></span>
                            <span class="rounded-0"></span>
                            <span class="rounded-0"></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Square</span>
                        </div>
                    </div>
                    <button class="card-radius-square settings-btn" id="card-radius-square"></button>
                </div>
            </div>

            <div class="mb-4 pb-2">
                <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style BG White / Gray</h4>

                <div class="d-flex align-items-center position-relative settings-box-wrap for-card-bg-gray"
                    style="gap: 25px;">
                    <div class="cursor position-relative active-wrap2">
                        <div class="settings-box bg-light-40">
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="rounded-3 bg-white"></span>
                            <span class="rounded-3 bg-white"></span>
                            <span class="rounded-3 bg-white"></span>
                            <span class="rounded-3 bg-white"></span>
                            <span class="rounded-3 bg-white"></span>
                            <span class="rounded-3 bg-white"></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">White</span>
                        </div>
                    </div>
                    <div class="cursor position-relative active-wrap1">
                        <div class="settings-box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                            <span class="rounded-3"></span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 5px; margin-top: 10px;">
                            <i
                                class="ri-checkbox-circle-fill position-relative top-1 fs-18 text-primary opacity-1"></i>
                            <i
                                class="ri-checkbox-blank-circle-line position-relative fs-18 text-light-40 position-absolute start-0 bottom-0 opacity-0"></i>
                            <span class="fw-semibold">Gray</span>
                        </div>
                    </div>
                    <button class="card-bg settings-btn" id="card-bg"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Theme Setting Area -->

    <!-- Link Of JS File -->
    <script src="{{ asset('back/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('back/js/dragdrop.js') }}"></script>
    <script src="{{ asset('back/js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('back/js/quill.min.js') }}"></script>
    <script src="{{ asset('back/js/data-table.js') }}"></script>
    <script src="{{ asset('back/js/prism.js') }}"></script>
    <script src="{{ asset('back/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('back/js/feather.min.js') }}"></script>
    <script src="{{ asset('back/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('back/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('back/js/echarts.min.js') }}"></script>
    <script src="{{ asset('back/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('back/js/fullcalendar.main.js') }}"></script>
    <script src="{{ asset('back/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('back/js/world-merc.js') }}"></script>
    <script src="{{ asset('back/js/moment.min.js') }}"></script>
    <script src="{{ asset('back/js/lightpick.js') }}"></script>
    <script src="{{ asset('back/js/custom/apexcharts.js') }}"></script>
    <script src="{{ asset('back/js/custom/echarts.js') }}"></script>
    <script src="{{ asset('back/js/custom/custom.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
