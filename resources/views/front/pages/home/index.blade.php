@extends('front.app')
@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('home') }}">
    <link rel="canonical" href="{{ route('home') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('content')
    <!-- Start Banner
        ============================================= -->
    <div class="banner-area with-carousel bg-gray-responsive overflow-inherit content-double transparent-nav text-large">
        <!-- Fixed Shape -->
        <div class="fixed-shape" style="background-image: url({{ asset('front/img/shape/4.png') }});"></div>
        <!-- Fixed Shape -->
        <div class="box-table">
            <div class="box-cell">
                <div class="container">
                    <div class="double-items">
                        <div class="row align-center">
                            <div class="col-lg-6 left-info simple-video">
                                <div class="content" data-animation="animated fadeInUpBig">
                                    <h1>Platform <span>Customer Service</span> Modern</h1>
                                    <p>
                                        Chatery adalah platform customer service modern yang menghubungkan pelanggan dan bisnis melalui percakapan real-time, integrasi WhatsApp/Telegram, ticketing terintegrasi, dan dukungan otomatis berbasis AI.
                                    </p>
                                    <ul>
                                        <li>
                                            <div class="fun-fact">
                                                <div class="timer" data-to="500" data-speed="2500">500</div>
                                                <span class="medium">Bisnis Aktif</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="fun-fact">
                                                <div class="timer" data-to="99" data-speed="2500">99</div>
                                                <span class="medium">% Kepuasan</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 offset-lg-1 right-info width-big">
                                <img src="{{ asset('front/img/2440x1578.png') }}" alt="Thumb">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wavesshape">
                    <img src="{{ asset('front/img/waves-shape.svg') }}" alt="Shape">
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner -->

    <!-- Start About
        ============================================= -->
    <div id="about" class="about-area default-padding-top">
        <!-- Shape -->
        <div class="shape">
            <img src="{{ asset('front/img/shape/5.png') }}" alt="Shape">
        </div>
        <!-- End Shape -->
        <div class="container">
            <div class="row align-center">
                <div class="col-lg-6 thumb-left">
                    <img src="{{ asset('front/img/illustration/1.svg') }}" alt="Thumb">
                </div>
                <div class="col-lg-6 services-info">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <i class="flaticon-ticket"></i>
                                <h4>Ticketing Terintegrasi</h4>
                                <p>
                                    Kelola tiket support pelanggan dengan sistem yang terorganisir dan mudah dilacak
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <i class="flaticon-email"></i>
                                <h4>Integrasi Sosmed</h4>
                                <p>
                                    Hubungkan akun Sosial Media bisnis Anda untuk melayani pelanggan dengan lebih efisien
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <i class="flaticon-speech-bubble"></i>
                                <h4>Live Chat Real-time</h4>
                                <p>
                                    Berkomunikasi langsung dengan pelanggan melalui widget chat di website Anda
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <i class="flaticon-file"></i>
                                <h4>Analytics</h4>
                                <p>
                                    Dapatkan insight mendalam tentang performa tim dan kepuasan pelanggan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About -->

    <!-- Start Features
        ============================================= -->
    <div id="features" class="features-area cell-items default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2>Fitur Unggulan Chatery</h2>
                        <p>
                            Chatery menyediakan berbagai fitur canggih untuk membantu bisnis Anda memberikan layanan pelanggan terbaik. Dari percakapan real-time hingga dukungan AI otomatis.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 features-thumb">
                    <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                </div>
                <div class="col-lg-7 features-items">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <div class="icon">
                                    <i class="flaticon-scroll"></i>
                                </div>
                                <div class="info">
                                    <h4>Multi-Channel</h4>
                                    <p>
                                        Kelola WhatsApp, Telegram, dan Website Chat dalam satu dashboard terintegrasi
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <div class="icon">
                                    <i class="flaticon-intersect"></i>
                                </div>
                                <div class="info">
                                    <h4>AI Support</h4>
                                    <p>
                                        Dukungan otomatis berbasis AI untuk menjawab pertanyaan pelanggan secara cepat
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <div class="icon">
                                    <i class="flaticon-rgb"></i>
                                </div>
                                <div class="info">
                                    <h4>Custom Widget</h4>
                                    <p>
                                        Sesuaikan tampilan widget chat dengan warna dan branding bisnis Anda
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 single-item">
                            <div class="item">
                                <div class="icon">
                                    <i class="flaticon-resolution"></i>
                                </div>
                                <div class="info">
                                    <h4>Analytics</h4>
                                    <p>
                                        Pantau performa tim dan kepuasan pelanggan dengan laporan lengkap
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Features -->

    <!-- Start Overview
        ============================================= -->
    <div id="overview" class="overview-area bg-gray default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2>Tampilan Dashboard Chatery</h2>
                        <p>
                            Interface yang intuitif dan mudah digunakan. Semua percakapan pelanggan dari berbagai channel tersaji dalam satu tampilan yang rapi dan terorganisir.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 text-center overview-items">
                    <div class="overview-carousel owl-carousel owl-theme">
                        <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                        <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                        <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Overview -->

    <!-- Start Pricing Area
        ============================================= -->
    <div id="pricing" class="pricing-area default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2>Pilih Paket Anda</h2>
                        <p>
                            Mulai gratis dan upgrade kapan saja sesuai kebutuhan bisnis Anda. Tidak ada biaya tersembunyi, transparan dan fleksibel.
                        </p>
                    </div>
                </div>
            </div>
            <div class="pricing pricing-simple text-center">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-item">
                            <ul>
                                <li class="pricing-header">
                                    <h4>Starter</h4>
                                    <h2><sup>Rp</sup>0 <sub>/ Bulan</sub></h2>
                                </li>
                                <li><i class="fas fa-check"></i> 1 User</li>
                                <li><i class="fas fa-check"></i> 1 Channel</li>
                                <li><i class="fas fa-check"></i> 100 Pesan/bulan</li>
                                <li><i class="fas fa-check"></i> Basic Analytics</li>
                                <li><i class="fas fa-times"></i> AI Support</li>
                                <li><i class="fas fa-times"></i> Priority Support</li>
                                <li><i class="fas fa-check"></i> Dokumentasi</li>
                                <li class="footer">
                                    <a class="btn circle btn-theme border btn-sm" href="#">Buy This Plan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-item active">
                            <ul>
                                <li class="pricing-header">
                                    <h4>Professional</h4>
                                    <h2><sup>Rp</sup>299K <sub>/ Bulan</sub></h2>
                                </li>
                                <li><i class="fas fa-check"></i> 5 Users</li>
                                <li><i class="fas fa-check"></i> Semua Channel</li>
                                <li><i class="fas fa-check"></i> Unlimited Pesan</li>
                                <li><i class="fas fa-check"></i> Advanced Analytics</li>
                                <li><i class="fas fa-check"></i> AI Support</li>
                                <li><i class="fas fa-check"></i> Priority Support</li>
                                <li><i class="fas fa-check"></i> Dokumentasi</li>
                                <li class="footer">
                                    <a class="btn circle btn-theme effect btn-sm" href="#">Buy This Plan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-item">
                            <ul>
                                <li class="pricing-header">
                                    <h4>Enterprise</h4>
                                    <h2>Custom</h2>
                                </li>
                                <li><i class="fas fa-check"></i> Unlimited Users</li>
                                <li><i class="fas fa-check"></i> Semua Channel</li>
                                <li><i class="fas fa-check"></i> Unlimited Pesan</li>
                                <li><i class="fas fa-check"></i> Custom Integration</li>
                                <li><i class="fas fa-check"></i> Dedicated AI</li>
                                <li><i class="fas fa-check"></i> 24/7 Support</li>
                                <li><i class="fas fa-check"></i> SLA Guarantee</li>
                                <li class="footer">
                                    <a class="btn circle btn-theme border btn-sm" href="#">Buy This Plan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Pricing Area -->

    <!-- Start Blog
        ============================================= -->
    <div id="blog" class="blog-area default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2>Artikel & Tips</h2>
                        <p>
                            Dapatkan informasi terbaru seputar customer service, tips meningkatkan kepuasan pelanggan, dan update fitur terbaru Chatery.
                        </p>
                    </div>
                </div>
            </div>
            <div class="blog-items">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="single.html">
                                    <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                                    <div class="post-type">
                                        <i class="fas fa-image"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="info">
                                <h4>
                                    <a href="single.html">Believe has request not how comfort</a>
                                </h4>
                                <div class="meta">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-calendar-alt "></i> 12 Nov, 2018</a></li>
                                        <li><a href="#"><i class="fas fa-user"></i> User</a></li>
                                        <li><a href="#"><i class="fas fa-comments"></i> 23</a></li>
                                    </ul>
                                </div>
                                <p>
                                    Always polite moment on is warmth spirit it to hearts. Downs those still witty an balls
                                    so chief so. Moment an little remain
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="single.html">
                                    <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                                    <div class="post-type">
                                        <i class="fas fa-video"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="info">
                                <h4>
                                    <a href="single.html">Speaking replying mistress him numerous</a>
                                </h4>
                                <div class="meta">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-calendar-alt "></i> 09 Nov, 2018</a></li>
                                        <li><a href="#"><i class="fas fa-user"></i> User</a></li>
                                        <li><a href="#"><i class="fas fa-comments"></i> 47</a></li>
                                    </ul>
                                </div>
                                <p>
                                    Always polite moment on is warmth spirit it to hearts. Downs those still witty an balls
                                    so chief so. Moment an little remain
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="single.html">
                                    <img src="{{ asset('front/img/800x600.png') }}" alt="Thumb">
                                    <div class="post-type">
                                        <i class="fas fa-images"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="info">
                                <h4>
                                    <a href="single.html">Reasonably conviction solicitude</a>
                                </h4>
                                <div class="meta">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-calendar-alt "></i> 16 Nov, 2018</a></li>
                                        <li><a href="#"><i class="fas fa-user"></i> User</a></li>
                                        <li><a href="#"><i class="fas fa-comments"></i> 58</a></li>
                                    </ul>
                                </div>
                                <p>
                                    Always polite moment on is warmth spirit it to hearts. Downs those still witty an balls
                                    so chief so. Moment an little remain
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->

    <!-- Start Testimonials
        ============================================= -->
    <div class="testimonials-area bg-gray default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading single text-center">
                        <h2>Apa Kata Mereka?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-items text-center">
                        <div class="carousel slide" data-ride="carousel" data-interval="500000"
                            id="testimonial-carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <span class="quote"></span>
                                    <p>
                                        Sejak pakai Chatery, response time tim CS kami meningkat 300%. Pelanggan jadi lebih puas dan repeat order meningkat drastis! Sangat recommended untuk bisnis online.
                                    </p>
                                    <h4>Ahmad Rizki</h4>
                                    <span>CEO TokoBaju.id</span>
                                </div>
                                <div class="carousel-item">
                                    <span class="quote"></span>
                                    <p>
                                        Integrasi WhatsApp-nya luar biasa! Sekarang saya bisa balas chat pelanggan dari laptop tanpa pegang HP terus. Produktivitas tim naik signifikan!
                                    </p>
                                    <h4>Siti Nurhaliza</h4>
                                    <span>Founder BeautyKu</span>
                                </div>
                                <div class="carousel-item">
                                    <span class="quote"></span>
                                    <p>
                                        Fitur AI-nya sangat membantu untuk menjawab pertanyaan repetitif. Tim support kami bisa fokus ke masalah yang lebih kompleks. Efisiensi meningkat 200%!
                                    </p>
                                    <h4>Budi Wijaya</h4>
                                    <span>Manager PT Tech Indo</span>
                                </div>
                            </div>
                            <!-- End Carousel Content -->

                            <!-- Carousel Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#testimonial-carousel" data-slide-to="0" class="active">
                                    <img src="{{ asset('front/img/800x800.png') }}" alt="Thumb">
                                </li>
                                <li data-target="#testimonial-carousel" data-slide-to="1">
                                    <img src="{{ asset('front/img/800x800.png') }}" alt="Thumb">
                                </li>
                                <li data-target="#testimonial-carousel" data-slide-to="2">
                                    <img src="{{ asset('front/img/800x800.png') }}" alt="Thumb">
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->

    <!-- Start Contact Area
        ============================================= -->
    <div id="contact" class="contact-us-area default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2>Hubungi Kami</h2>
                        <p>
                            Punya pertanyaan tentang Chatery? Tim kami siap membantu Anda. Hubungi kami melalui form di bawah atau kontak langsung.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 address">
                    <div class="address-items">
                        <h4>Our Office Address</h4>
                        <ul class="info">
                            <li>
                                <i class="fas fa-map-marked-alt"></i>
                                <span>{{ $setting->address }}</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>{{ $setting->phone }}</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope-open"></i>
                                <span>{{ $setting->email }}</span>
                            </li>
                        </ul>
                        <h4>Social Address</h4>
                        <ul class="social">
                            @if($setting->facebook)
                            <li class="facebook">
                                <a href="{{ $setting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            @endif
                            @if($setting->instagram)
                            <li class="instagram">
                                <a href="{{ $setting->instagram }}"><i class="fab fa-instagram"></i></a>
                            </li>
                            @endif
                            @if($setting->tiktok)
                            <li class="tiktok">
                                <a href="{{ $setting->tiktok }}"><i class="fab fa-tiktok"></i></a>
                            </li>
                            @endif
                            @if($setting->twitter)
                            <li class="twitter">
                                <a href="{{ $setting->twitter }}"><i class="fab fa-twitter"></i></a>
                            </li>
                            @endif
                            @if($setting->youtube)
                            <li class="youtube">
                                <a href="{{ $setting->youtube }}"><i class="fab fa-youtube"></i></a>
                            </li>
                            @endif
                            @if($setting->linkedin)
                            <li class="linkedin">
                                <a href="{{ $setting->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            @endif
                        </ul>
                        <div class="google-maps">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d559.7262225754869!2d100.37070651680263!3d-0.9456240075044083!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b982c9fe455f%3A0x5061d73acccaf624!2sEmily%20Queen%20Home%20Photo%20Studio!5e0!3m2!1sid!2sid!4v1765453719413!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 contact-form">
                    <h2>Hubungi Tim Chatery</h2>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{ route('message.send') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Lengkap *"
                                        type="text" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="alert-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email *"
                                        type="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="alert-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="No. Telepon"
                                        type="text" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="alert-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subjek *"
                                        type="text" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <span class="alert-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group comments">
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" placeholder="Pesan Anda *" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="alert-error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <button type="submit" name="submit" id="submit">
                                    Kirim Pesan <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->

    <!-- Start Faq
        ============================================= -->
    <div class="faq-area bg-gray default-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h2>Pertanyaan Umum</h2>
                        <p>
                            Temukan jawaban untuk pertanyaan yang sering diajukan tentang Chatery. Jika tidak menemukan jawaban, hubungi tim support kami.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 thumb">
                    <img src="{{ asset('front/img/700x800.png') }}" alt="Thumb">
                </div>
                <div class="col-lg-6 faq-items default-padding-bottom">
                    <!-- Start Accordion -->
                    <div class="faq-content">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h4 class="mb-0" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Apa itu Chatery?
                                    </h4>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>
                                            Chatery adalah platform customer service modern yang memungkinkan bisnis mengelola semua percakapan pelanggan dari berbagai channel (WhatsApp, Telegram, Website Chat) dalam satu dashboard terintegrasi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        Apakah ada biaya untuk memulai?
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>
                                            Tidak! Anda bisa memulai dengan paket Starter yang gratis selamanya. Upgrade ke paket berbayar kapan saja sesuai kebutuhan bisnis Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Bagaimana cara mengintegrasikan WhatsApp?
                                    </h4>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>
                                            Cukup scan QR Code dari dashboard Chatery menggunakan WhatsApp di smartphone Anda. Prosesnya hanya membutuhkan waktu kurang dari 1 menit.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Apakah data percakapan aman?
                                    </h4>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>
                                            Ya, keamanan adalah prioritas kami. Semua data dienkripsi dan disimpan di server yang aman. Kami mematuhi standar keamanan industri.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Accordion -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Faq  -->
@endsection
