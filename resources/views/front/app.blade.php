<!DOCTYPE html>
<html lang="en">

<head>

    @php
        $setting_web = \App\Models\SettingWebsite::first();
    @endphp

    <title>
        @isset($title)
            {{ $title }} |
        @endisset
        {{ $setting_web->name }}
    </title>
    @yield('seo')
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ Storage::url($setting_web->favicon) }}">

    <!-- ========== Start Stylesheet ========== -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/elegant-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/flaticon-set.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/magnific-popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/bootsnav.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5/html5shiv.min.js"></script>
      <script src="assets/js/html5/respond.min.js"></script>
    <![endif]-->

    <!-- ========== Google Fonts ========== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">

</head>

<body>

    <!-- Preloader Start -->
    <div class="se-pre-con"></div>
    <!-- Preloader Ends -->

    <!-- Header
    ============================================= -->
    @include('front.partials.header')
    <!-- End Header -->

    @yield('content')

    <!-- Start Footer
    ============================================= -->
    @include('front.partials.footer')
    <!-- End Footer -->

    <!-- jQuery Frameworks
    ============================================= -->
    <script src="{{ asset('front/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/popper.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('front/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/js/modernizr.custom.13711.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/wow.min.js') }}"></script>
    <script src="{{ asset('front/js/count-to.js') }}"></script>
    <script src="{{ asset('front/js/bootsnav.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>
    <script src="http://127.0.0.1:8000/api/webchat/widget/f9784bc2-e39d-4b3d-b13a-5ab1e3c285ad/script.js" async></script>


</body>

</html>
