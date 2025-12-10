@extends('back.app')

@section('content')
    <div id="kt_content_container" class=" container-xxl ">

        <div class="card card-flush mb-5">

            <div class="card-header mt-6">
                <h2 class="mb-5">
                    Whatsapp API Setting
                </h2>
            </div>

            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-md-5">
                        <div class="fv-row mb-10 px-10">
                            <label class="fw-bold fs-6 mb-2">Status Server</label>
                            <div class="border  rounded mt-3">
                                <div class="text-center ">
                                    <p class="text-gray-700 fs-3 fw-bold py-7" id="status_server">
                                        Loading...
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="fv-row mb-10 px-10">
                            <label class="fw-bold fs-6 mb-2">Session Whatsapp</label>
                            <div class="border  rounded mt-3">
                                <div class="text-center ">
                                    <p class="text-gray-700 fs-3 fw-bold py-7" id="status_whatsapp">
                                        Loading...
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mb-10 px-10">
                            <button class="btn btn-flex btn-primary px-6 justify-content-center mb-5" id="start_button">
                                <i class="fa-solid fa-play fs-2x"></i>
                                <span class="d-flex flex-column align-items-start ms-2">
                                    <span class="fs-3 fw-bold">Start</span>
                                    <span class="fs-7">Hubungkan Ke whatsapp</span>
                                </span>
                            </button>
                            <button class="btn btn-flex btn-danger px-6 justify-content-center mb-5" id="stop_button">
                                <i class="fa-solid fa-stop fs-2x"></i>
                                <span class="d-flex flex-column align-items-start ms-2">
                                    <span class="fs-3 fw-bold">Stop</span>
                                    <span class="fs-7">Matikan koneksi whatsapp</span>
                                </span>
                            </button>
                            <button class="btn btn-flex btn-warning px-6 justify-content-center mb-5" id="reset_button">
                                <i class="fa-solid fa-repeat fs-2x"></i>
                                <span class="d-flex flex-column align-items-start ms-2">
                                    <span class="fs-3 fw-bold">Restart</span>
                                    <span class="fs-7">hubungkan kembali ke whatsapp</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="border border-hover-primary rounded mt-3">
                            <div class="text-center pt-15 pb-15">
                                <h2 class="fs-2x fw-bold mb-0">Whatsapp QR Code</h2>
                                <p class="text-gray-500 fs-4 fw-semibold py-7" id="info">
                                    Sedang Memuat... <br>
                                    Silahkan tunggu beberapa saat
                                </p>
                                <img class="p-10" style="width: 100%" alt="" id="qr_code">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $('#start_button').hide();
        $('#stop_button').hide();
        $('#reset_button').hide();

        $(document).ready(function() {
            let SessionState = '';

            // Fungsi untuk cek status server
            function checkServerStatus() {
                $.ajax({
                    url: '{{ route('api.v1.whatsapp.observability.serverStatus') }}',
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            let uptime = parseInt(response.data.uptime);

                            // Convert uptime (milliseconds to seconds first, then to readable format)
                            let totalSeconds = Math.floor(uptime / 1000);
                            let days = Math.floor(totalSeconds / 86400);
                            let hours = Math.floor((totalSeconds % 86400) / 3600);
                            let minutes = Math.floor((totalSeconds % 3600) / 60);
                            let seconds = totalSeconds % 60;

                            let uptimeText = '';
                            if (days > 0) uptimeText += days + ' hari ';
                            if (hours > 0) uptimeText += hours + ' jam ';
                            if (minutes > 0) uptimeText += minutes + ' menit ';
                            if (seconds > 0 || uptimeText === '') uptimeText += seconds + ' detik';

                            $('#status_server').html(
                                ' <span class="text-success fs-2">Connected</span><br><small class="text-muted">Uptime: ' +
                                uptimeText.trim() + '</small>');
                        } else {
                            $('#status_server').html(
                                '<span class="text-danger fs-2">Server Error</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking server status:', error);
                        $('#status_server').html(
                            '<span class="text-danger fs-2">Connection Failed</span>');
                    }
                });
            }

            function CheckSessionInformation() {
                $.ajax({
                    url: '{{ route('api.v1.whatsapp.session.information') }}',
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Auth-Token': '{{ $token }}',
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            SessionState = response.data.status;
                            $('#status_whatsapp').html(
                                ' <span class="text-success fs-2">Session Found</span><br><small class="text-muted">Status: ' +
                                response.data.status + '</small>' +
                                '<br><small class="text-muted">Name: ' + response.data.me.pushName + '</small>'
                            );
                        } else {
                            $('#status_whatsapp').html(
                                '<span class="text-danger fs-2">Session Error</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking session information:', xhr.responseText);
                        $('#status_whatsapp').html(
                            '<span class="text-danger fs-2">Connection Failed</span>');
                    }
                });
            }

            function SessionStart() {
                $.ajax({
                    url: '{{ route('api.v1.whatsapp.session.start') }}',
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Auth-Token': '{{ $token }}',
                    },
                    success: function(response) {
                        Swal.fire(
                            'Session Started!',
                            'Session whatsapp berhasil dimulai. Tunggu beberapa saat hingga QR Code muncul.',
                            'success'
                        );
                        CheckSessionInformation();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error starting session:', xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Gagal memulai session whatsapp.',
                            'error'
                        );
                    }
                });
            }

            function SessionStop() {
                $.ajax({
                    url: '{{ route('api.v1.whatsapp.session.stop') }}',
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Auth-Token': '{{ $token }}',
                    },
                    success: function(response) {
                        Swal.fire(
                            'Session Stopped!',
                            'Session whatsapp berhasil dihentikan.',
                            'success'
                        );
                        CheckSessionInformation();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error stopping session:', xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Gagal menghentikan session whatsapp.',
                            'error'
                        );
                    }
                });
            }

            function SessionRestart() {
                $.ajax({
                    url: '{{ route('api.v1.whatsapp.session.restart') }}',
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Auth-Token': '{{ $token }}',
                    },
                    success: function(response) {
                        Swal.fire(
                            'Session Restarted!',
                            'Session whatsapp berhasil di-restart.',
                            'success'
                        );
                        CheckSessionInformation();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error restarting session:', xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Gagal me-restart session whatsapp.',
                            'error'
                        );
                    }
                });
            }

            function FetchQRCode() {
                console.log('Fetching QR Code...');
                $.ajax({
                    url: '{{ route('api.v1.whatsapp.session.authQrCode') }}',
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Auth-Token': '{{ $token }}',
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            $('#qr_code').attr('src', 'data:image/png;base64,' + response.data.qr_code
                                .data);
                        } else {
                            $('#qr_code').attr('alt', 'Failed to load QR Code');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching QR Code:', xhr.responseText);
                        $('#qr_code').attr('alt', 'Connection Failed');
                    }
                });
            }

            checkServerStatus();
            CheckSessionInformation();

            // Refresh status setiap 10 detik
            setInterval(checkServerStatus, 10000);

            setInterval(() => {
                CheckSessionInformation();
                if (SessionState == 'SCAN_QR_CODE') {
                    $('#info').html(
                        'Silahkan scan QR Code untuk menghubungkan ke Whatsapp API <br> Qr Code akan berubah setiap 30 detik.'
                    );
                    $('#qr_code').attr('alt', 'Scan QR Code');
                    $('#qr_code').css('width', '100%');
                    $('#stop_button').show();
                    $('#start_button').hide();
                    $('#reset_button').hide();
                    FetchQRCode();
                } else if (SessionState == 'STOPPED') {
                    $('#info').html(
                        'Anda belum terhubung ke whatsapp API. Silahkan klik tombol start untuk memulai session.'
                    );
                    $('#qr_code').attr('alt', 'Session Stopped');
                    $('#qr_code').attr('src', '{{ asset('wa_status/disconnected.png') }}');
                    $('#qr_code').css('width', '50%');
                    $('#stop_button').hide();
                    $('#start_button').show();
                    $('#reset_button').hide();
                } else if (SessionState == 'STARTING') {
                    $('#info').html(
                        'Anda telah memulai session, silahkan tunggu beberapa saat hingga QR Code muncul.'
                    );
                    $('#qr_code').attr('alt', 'Session Starting');
                    $('#qr_code').attr('src', '{{ asset('wa_status/pending.png') }}');
                    $('#qr_code').css('width', '50%');
                    $('#stop_button').hide();
                    $('#start_button').hide();
                    $('#reset_button').show();
                } else if (SessionState == 'WORKING') {
                    $('#info').html('Anda telah terhubung ke whatsapp API.');
                    $('#qr_code').attr('alt', 'Session Working');
                    $('#qr_code').attr('src', '{{ asset('wa_status/connected.png') }}');
                    $('#qr_code').css('width', '50%');
                    $('#stop_button').show();
                    $('#start_button').hide();
                    $('#reset_button').hide();
                } else {
                    $('#info').html('Gagal mendapatkan status session. Silahkan coba lagi.');
                    $('#qr_code').attr('alt', 'Unknown State');
                    $('#qr_code').attr('src', '{{ asset('wa_status/disconnected.png') }}');
                    $('#qr_code').css('width', '50%');
                    $('#stop_button').hide();
                    $('#start_button').show();
                    $('#reset_button').hide();
                }
            }, 5000);

            $('#start_button').click(function() {
                SessionStart();
            });
            $('#stop_button').click(function() {
                SessionStop();
            });
            $('#reset_button').click(function() {
                SessionRestart();
            });

        });
    </script>
@endsection
