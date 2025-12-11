<header id="home">

        <!-- Start Navigation -->
        <nav class="navbar navbar-default navbar-fixed dark no-background bootsnav">

            <div class="container">

                <!-- Start Atribute Navigation -->
                <div class="attr-nav button">
                    <ul>
                        <li>
                            <a href="{{ route("login") }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route("register") }}">Bergabung</a>
                        </li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.html">
                        <img src="{{ Storage::url($setting_web->logo) }}" class="logo logo-scrolled" alt="Logo" style="height: 50px;" />
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                        {{-- <li class="dropdown dropdown-right">
                            <a href="#home" class="dropdown-toggle smooth-menu" data-toggle="dropdown" >Home</a>
                            <ul class="dropdown-menu">
                                <li><a href="index.html">Home Version One</a></li>
                                <li><a href="index-2.html">Home Version Two</a></li>
                                <li><a href="index-3.html">Home Version Three</a></li>
                                <li><a href="index-4.html">Home Version Four</a></li>
                                <li><a href="index-5.html">Home Version Five</a></li>
                                <li><a href="index-6.html">Home Version Six</a></li>
                                <li><a href="index-7.html">Home Version Seven</a></li>
                                <li><a href="index-8.html">Home Version Eight</a></li>
                                <li><a href="index-9.html">Home Version Nine <span class="badge">Trending</span></a></li>
                                <li><a href="index-10.html">Home Version Ten <span class="badge">New</span></a></li>
                            </ul>
                        </li> --}}
                        <li>
                            <a class="smooth-menu" href="{{ route("home") }}">Home</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#about">About</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#features">Features</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#overview">Overview</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#pricing">Pricing</a>
                        </li>

                        <li>
                            <a class="smooth-menu" href="#contact">contact</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>

        </nav>
        <!-- End Navigation -->

    </header>
