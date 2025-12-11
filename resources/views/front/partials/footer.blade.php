<footer class="default-padding bg-light" style="padding-top: 60px; padding-bottom: 20px;">
        <div class="container">
            <div class="f-items">
                <div class="row">
                    <div class="col-lg-3 col-md-6 item">
                        <div class="f-item">
                            <img src="{{ Storage::url($setting_web->logo) }}" alt="Logo" style="width: 180px; margin-bottom: 20px;" />
                            <p>
                                {{ Str::limit(strip_tags($setting_web->about), 150) }}
                            </p>
                            <a href="#" class="btn circle btn-theme effect btn-sm">Get Started</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 item">
                        <div class="f-item link">
                            <h4>Quick LInk</h4>
                            <ul>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> Home</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> About us</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> Features</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> News</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 item">
                        <div class="f-item link">
                            <h4>Company</h4>
                            <ul>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> Torkata</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> Torkata Tech</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> Torkata Travel</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> Services</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-angle-right"></i> History</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 item">
                        <div class="f-item twitter-widget">
                            <h4>Kontak kami</h4>
                            <p>
                                Kami siap membantu Anda. Hubungi kami melalui detail di bawah ini.
                            </p>
                            <div class="address">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="info">
                                            <h5>Website:</h5>
                                            <span>{{ $setting_web->website }}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="info">
                                            <h5>Email:</h5>
                                            <span>{{ $setting_web->email }}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="info">
                                            <h5>Phone:</h5>
                                            <span>{{ $setting_web->phone }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Footer Bottom -->
            <div class="footer-bottom">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <p>&copy; Copyright {{ date('Y') }}. All Rights Reserved by <a href="https://torkatatech.com">Torkata Tech Solution</a></p>
                        </div>
                        <div class="col-lg-6 text-right link">
                            <ul>
                                <li>
                                    <a href="#">Terms of user</a>
                                </li>
                                <li>
                                    <a href="#">License</a>
                                </li>
                                <li>
                                    <a href="#">Support</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Bottom -->
        </div>
    </footer>
