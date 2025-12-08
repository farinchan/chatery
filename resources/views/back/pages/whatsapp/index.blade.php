@extends('back.app')

@section('content')
    <div id="kt_content_container" class=" container-xxl ">

        <div class="card card-flush">

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
                            <button class="btn btn-flex btn-primary px-6 justify-content-center mb-5" id="start_button" onclick="SessionStart()">
                                <i class="fa-solid fa-play fs-2x"></i>
                                <span class="d-flex flex-column align-items-start ms-2">
                                    <span class="fs-3 fw-bold">Start</span>
                                    <span class="fs-7">Hubungkan Ke whatsapp</span>
                                </span>
                            </button>
                            <button class="btn btn-flex btn-danger px-6 justify-content-center mb-5" id="stop_button" onclick="SessionStop()">
                                <i class="fa-solid fa-stop fs-2x"></i>
                                <span class="d-flex flex-column align-items-start ms-2">
                                    <span class="fs-3 fw-bold">Stop</span>
                                    <span class="fs-7">Matikan koneksi whatsapp</span>
                                </span>
                            </button>
                            <button class="btn btn-flex btn-warning px-6 justify-content-center mb-5" id="reset_button" onclick="SessionRestart()">
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
                                    Silahkan scan QR Code untuk menghubungkan ke Whatsapp API <br>
                                    Qr Code akan berubah setiap 30 detik
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
    $(document).ready(function() {
        let SessionState = '';

        // Fungsi untuk cek status server
        function checkServerStatus() {
            $.ajax({
                url: '{{ route('api.v1.observability.serverStatus') }}',
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

                        $('#status_server').html(' <span class="text-success fs-2">Connected</span><br><small class="text-muted">Uptime: ' + uptimeText.trim() + '</small>');
                    } else {
                        $('#status_server').html('<span class="text-danger fs-2">Server Error</span>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking server status:', error);
                    $('#status_server').html('<span class="text-danger fs-2">Connection Failed</span>');
                }
            });
        }

        function CheckSessionInformation() {
            $.ajax({
                url: '{{ route('api.v1.session.information', $session ) }}',
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'session_token': '{{ request()->header('session_token') }}',
                },
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        SessionState = response.data.status;
                        $('#status_whatsapp').html(' <span class="text-success fs-2">Session Found</span><br><small class="text-muted">Status: ' + response.data.status + '</small>' +
                            '<br><small class="text-muted">Me: ' + response.data.me + '</small>');
                    } else {
                        $('#status_whatsapp').html('<span class="text-danger fs-2">Session Error</span>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking session information:', xhr.responseText);
                    $('#status_whatsapp').html('<span class="text-danger fs-2">Connection Failed</span>');
                }
            });
        }

        function SessionStart() {
            $.ajax({
                url: '{{ route('api.v1.session.start', $session ) }}',
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'session_token': '{{ request()->header('session_token') }}',
                },
                success: function(response) {
                    alert('Session started successfully!');
                    CheckSessionInformation();
                },
                error: function(xhr, status, error) {
                    console.error('Error starting session:', xhr.responseText);
                    alert('Failed to start session.');
                }
            });
        }

        function SessionStop() {
            $.ajax({
                url: '{{ route('api.v1.session.stop', $session ) }}',
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'session_token': '{{ request()->header('session_token') }}',
                },
                success: function(response) {
                    alert('Session stopped successfully!');
                    CheckSessionInformation();
                },
                error: function(xhr, status, error) {
                    console.error('Error stopping session:', xhr.responseText);
                    alert('Failed to stop session.');
                }
            });
        }

        function SessionRestart() {
            $.ajax({
                url: '{{ route('api.v1.session.restart', $session ) }}',
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'session_token': '{{ request()->header('session_token') }}',
                },
                success: function(response) {
                    alert('Session restarted successfully!');
                    CheckSessionInformation();
                },
                error: function(xhr, status, error) {
                    console.error('Error restarting session:', xhr.responseText);
                    alert('Failed to restart session.');
                }
            });
        }

        function FetchQRCode() {
            $.ajax({
                url: '{{ route('api.v1.session.authQrCode', $session ) }}',
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'session_token': '{{ request()->header('session_token') }}',
                },
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        $('#qr_code').attr('src', 'data:image/png;base64,' + response.data.qr_code);
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
        setInterval(CheckSessionInformation, 10000);
    });
</script>
@endsection
