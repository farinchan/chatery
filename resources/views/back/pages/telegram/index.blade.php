@extends('back.app')

@section('content')
    <div id="kt_content_container" class="container-xxl">

        <div class="card card-flush mb-5">
            <div class="card-header mt-6">
                <h2 class="mb-5">
                    <i class="fab fa-telegram text-primary fs-2x me-2"></i>
                    Telegram Bot Setting
                </h2>
            </div>

            <div class="card-body pt-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-5">
                        <div class="fv-row mb-10 px-10">
                            <label class="fw-bold fs-6 mb-2">Status Bot</label>
                            <div class="border rounded mt-3">
                                <div class="text-center">
                                    <p class="text-gray-700 fs-3 fw-bold py-7" id="status_bot">
                                        Loading...
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="fv-row mb-10 px-10">
                            <label class="fw-bold fs-6 mb-2">Status Webhook</label>
                            <div class="border rounded mt-3">
                                <div class="text-center">
                                    <p class="text-gray-700 fs-3 fw-bold py-7" id="status_webhook">
                                        Loading...
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($telegramBot)
                            <div class="d-grid mb-10 px-10">
                                <a href="{{ route('back.team.telegram.chat', $team->name_id) }}"
                                    class="btn btn-flex btn-primary px-6 justify-content-center mb-5">
                                    <i class="fas fa-comments fs-2x"></i>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-3 fw-bold">Buka Chat</span>
                                        <span class="fs-7">Lihat pesan dari pengguna</span>
                                    </span>
                                </a>
                                <form action="{{ route('back.team.telegram.refresh', $team->name_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-flex btn-warning px-6 justify-content-center mb-5 w-100">
                                        <i class="fas fa-sync fs-2x"></i>
                                        <span class="d-flex flex-column align-items-start ms-2">
                                            <span class="fs-3 fw-bold">Refresh Webhook</span>
                                            <span class="fs-7">Perbarui koneksi webhook</span>
                                        </span>
                                    </button>
                                </form>
                                <button type="button"
                                    class="btn btn-flex btn-danger px-6 justify-content-center mb-5"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash fs-2x"></i>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-3 fw-bold">Hapus Bot</span>
                                        <span class="fs-7">Putuskan koneksi bot</span>
                                    </span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="border border-hover-primary rounded mt-3 p-10">
                            @if ($telegramBot)
                                {{-- Bot Info --}}
                                <div class="text-center mb-8">
                                    <div class="symbol symbol-100px mb-5">
                                        <div
                                            class="symbol-label fs-1 fw-bold bg-light-primary text-primary rounded-circle">
                                            <i class="fab fa-telegram fs-3x text-primary"></i>
                                        </div>
                                    </div>
                                    <h2 class="fs-2x fw-bold mb-0">{{ $telegramBot->bot_name }}</h2>
                                    <p class="text-muted fs-5">@{{ $telegramBot->bot_username }}</p>
                                </div>

                                {{-- Update Form --}}
                                <form action="{{ route('back.team.telegram.update', $team->name_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="fv-row mb-7">
                                        <label class="required fw-semibold fs-6 mb-2">Bot Token</label>
                                        <input type="text" name="bot_token"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            placeholder="Masukkan token bot baru"
                                            value="{{ old('bot_token', $telegramBot->bot_token) }}" />
                                        <div class="text-muted fs-7 mt-2">
                                            Token saat ini: {{ $telegramBot->getMaskedToken() }}
                                        </div>
                                        @error('bot_token')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Update Token
                                        </button>
                                    </div>
                                </form>
                            @else
                                {{-- Setup Form --}}
                                <div class="text-center mb-8">
                                    <div class="symbol symbol-100px mb-5">
                                        <div
                                            class="symbol-label fs-1 fw-bold bg-light-secondary text-secondary rounded-circle">
                                            <i class="fab fa-telegram fs-3x"></i>
                                        </div>
                                    </div>
                                    <h2 class="fs-2x fw-bold mb-2">Hubungkan Bot Telegram</h2>
                                    <p class="text-muted fs-6">
                                        Masukkan token bot dari @BotFather untuk menghubungkan bot Telegram Anda.
                                    </p>
                                </div>

                                <form action="{{ route('back.team.telegram.store', $team->name_id) }}" method="POST">
                                    @csrf
                                    <div class="fv-row mb-7">
                                        <label class="required fw-semibold fs-6 mb-2">Bot Token</label>
                                        <input type="text" name="bot_token"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            placeholder="123456789:ABCDefGHIjklMNOpqrsTUVwxyz" />
                                        @error('bot_token')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-7">
                                        <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <div class="fw-semibold">
                                                <h4 class="text-gray-900 fw-bold">Cara mendapatkan Bot Token:</h4>
                                                <div class="fs-6 text-gray-700">
                                                    1. Buka Telegram dan cari @BotFather<br>
                                                    2. Ketik /newbot untuk membuat bot baru<br>
                                                    3. Ikuti instruksi untuk memberi nama bot<br>
                                                    4. Salin token yang diberikan dan paste di sini
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plug me-2"></i>
                                            Hubungkan Bot
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Delete Modal --}}
    @if ($telegramBot)
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Bot Telegram</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus bot <strong>{{ $telegramBot->bot_name }}</strong>?</p>
                        <p class="text-danger">Semua data chat dan pesan akan ikut terhapus!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('back.team.telegram.destroy', $team->name_id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function checkStatus() {
                $.ajax({
                    url: '{{ route('back.team.telegram.status', $team->name_id) }}',
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                    success: function(response) {
                        if (response.status === 'connected') {
                            $('#status_bot').html(
                                '<span class="text-success fs-2">Connected</span><br>' +
                                '<small class="text-muted">@' + response.bot.username + '</small>'
                            );

                            let webhookStatus = response.webhook.url ?
                                '<span class="text-success fs-2">Active</span>' :
                                '<span class="text-warning fs-2">Not Set</span>';

                            if (response.webhook.last_error_message) {
                                webhookStatus +=
                                    '<br><small class="text-danger">Error: ' +
                                    response.webhook.last_error_message + '</small>';
                            }

                            if (response.webhook.pending_update_count > 0) {
                                webhookStatus +=
                                    '<br><small class="text-info">Pending: ' +
                                    response.webhook.pending_update_count + '</small>';
                            }

                            $('#status_webhook').html(webhookStatus);
                        } else if (response.status === 'not_connected') {
                            $('#status_bot').html(
                                '<span class="text-secondary fs-2">Not Connected</span><br>' +
                                '<small class="text-muted">Silakan hubungkan bot</small>'
                            );
                            $('#status_webhook').html(
                                '<span class="text-secondary fs-2">-</span>'
                            );
                        } else {
                            $('#status_bot').html(
                                '<span class="text-danger fs-2">Error</span><br>' +
                                '<small class="text-muted">' + response.message + '</small>'
                            );
                            $('#status_webhook').html(
                                '<span class="text-danger fs-2">Error</span>'
                            );
                        }
                    },
                    error: function(xhr) {
                        $('#status_bot').html(
                            '<span class="text-danger fs-2">Connection Failed</span>'
                        );
                        $('#status_webhook').html(
                            '<span class="text-danger fs-2">-</span>'
                        );
                    }
                });
            }

            // Initial check
            checkStatus();

            // Refresh every 30 seconds
            setInterval(checkStatus, 30000);
        });
    </script>
@endsection
