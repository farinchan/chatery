<div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
    data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">

    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
        id="#kt_aside_menu" data-kt-menu="true">

        <div class= "menu-item">
            <a class="menu-link @if (request()->routeIs('back.index')) active @endif" href="{{ route('back.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-star fs-2"></i>
                </span>
                <span class="menu-title">Overview</span>
            </a>
        </div>

        @php
            $current_team = Illuminate\Support\Facades\Cookie::get('current_team');
        @endphp

        @if ($current_team)
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Teams</span>
                </div>
            </div>

            <div class= "menu-item">
                <a class="menu-link @if (request()->routeIs('back.team.index')) active @endif"
                    href="{{ route('back.team.index', $current_team) }}">

                    <span class="menu-icon ">
                        <i class="ki-duotone ki-element-11 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i></span>
                    <span class="menu-title">My Teams</span>
                </a>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item  @if (request()->routeIs('back.team.whatsapp.*')) here show @endif menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="fa-brands fa-whatsapp fs-2"></i>
                    </span>
                    <span class="menu-title">WhatsApp</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.team.whatsapp.index', $current_team)) active @endif"
                            href="{{ route('back.team.whatsapp.index', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Device Link</span>
                        </a>
                        <a class="menu-link @if (request()->routeIs('back.team.whatsapp.chat', $current_team)) active @endif"
                            href="{{ route('back.team.whatsapp.chat', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Chat</span>
                        </a>
                        <a class="menu-link @if (request()->routeIs('back.team.whatsapp.documentation.index', $current_team)) active @endif"
                            href="{{ route('back.team.whatsapp.documentation.index', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Dokumentasi API</span>
                        </a>
                    </div>

                </div>
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion @if (request()->routeIs('back.team.telegram.*')) here show @endif">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="fa-brands fa-telegram fs-2"></i>
                    </span>
                    <span class="menu-title">Telegram</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.team.telegram.index', $current_team)) active @endif"
                            href="{{ route('back.team.telegram.index', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Bot Setting</span>
                        </a>
                        <a class="menu-link @if (request()->routeIs('back.team.telegram.chat', $current_team)) active @endif"
                            href="{{ route('back.team.telegram.chat', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Chat</span>
                        </a>
                    </div>
                </div>
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion @if (request()->routeIs('back.team.webchat.*')) here show @endif">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="fa-regular fa-comments fs-2"></i>
                    </span>
                    <span class="menu-title">Website Chat</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.team.webchat.index', $current_team)) active @endif"
                            href="{{ route('back.team.webchat.index', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Website Integration</span>
                        </a>
                        <a class="menu-link @if (request()->routeIs('back.team.webchat.chat', $current_team)) active @endif"
                            href="{{ route('back.team.webchat.chat', $current_team) }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Chat</span>
                        </a>
                    </div>
                </div>
            </div>

        @endif

        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Administrator</span>
            </div>
        </div>

        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-element-11 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i></span>
                <span class="menu-title">Dashboards</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link @if (request()->routeIs('back.dashboard.visitor')) active @endif"
                        href="{{ route('back.dashboard.visitor') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Default</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link @if (request()->routeIs('back.dashboard.news')) active @endif"
                        href="{{ route('back.dashboard.news') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Berita</span>
                    </a>
                    @role('super-admin|keuangan')
                        {{-- <a class="menu-link @if (request()->routeIs('back.dashboard.cashflow')) active @endif"
                            href="{{ route('back.dashboard.cashflow') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Cashflow</span>
                        </a> --}}
                    @endrole
                </div>
            </div>
        </div>

        @role('humas|super-admin')
            {{-- <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Post</span>
                </div>
            </div>


            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion @if (request()->routeIs('back.news.*')) here show @endif">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-document fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Berita</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.news.category')) active @endif"
                            href="{{ route('back.news.category') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Kategori</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.news.index')) active @endif"
                            href="{{ route('back.news.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">List Berita</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.news.comment')) active @endif"
                            href="{{ route('back.news.comment') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Komentar</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class= "menu-item">
                <a class="menu-link @if (request()->routeIs('back.welcomeSpeech.index')) active @endif"
                    href="{{ route('back.welcomeSpeech.index') }}">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-star fs-2"></i>
                    </span>
                    <span class="menu-title">Tentang kami</span>
                </a>
            </div>

            <div class= "menu-item">
                <a class="menu-link @if (request()->routeIs('back.menu.profil.*')) active @endif"
                    href="{{ route('back.menu.profil.index') }}">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-burger-menu-5 fs-2"></i>
                    </span>
                    <span class="menu-title">Menu Profil</span>
                </a>
            </div> --}}
        @endrole




        @role('super-admin')
            <div class="menu-item pt-5">
                <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Administrator</span>
                </div>
            </div>

            <div class="menu-item">
                <a class="menu-link @if (request()->routeIs('back.message.index')) active @endif"
                    href="{{ route('back.message.index') }}">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-sms fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Inbox</span>
                </a>
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion @if (request()->routeIs('back.master.*')) here show @endif">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-abstract-24 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Master Data</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">

                    <div class="menu-item">
                        <a class="menu-link"
                            href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengguna</span>
                        </a>
                    </div>
                </div>
            </div>

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion @if (request()->routeIs('back.setting.*')) here show @endif">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-setting-2 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <span class="menu-title">Pengaturan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link @if (request()->routeIs('back.setting.website')) active @endif"
                            href="{{ route('back.setting.website') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Website</span>
                        </a>
                    </div>
                </div>
            </div>
        @endrole

    </div>

</div>
