@extends('back.app')

@section('content')
    <div id="kt_content_container" class="container-xxl">

        <div class="card card-flush mb-5">
            <div class="card-header mt-6">
                <h2 class="mb-5">
                    <i class="fa fa-comments text-primary fs-2x me-2"></i>
                    Website Chat Integration
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
                            <label class="fw-bold fs-6 mb-2">Status Widget</label>
                            <div class="border rounded mt-3">
                                <div class="text-center">
                                    <p class="text-gray-700 fs-3 fw-bold py-7" id="status_widget">
                                        @if ($widget && $widget->is_active)
                                            <span class="text-success">Aktif</span>
                                        @elseif($widget)
                                            <span class="text-warning">Nonaktif</span>
                                        @else
                                            <span class="text-secondary">Belum Setup</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="fv-row mb-10 px-10">
                            <label class="fw-bold fs-6 mb-2">Statistik</label>
                            <div class="border rounded mt-3 p-5">
                                @if ($widget)
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Total Visitor</span>
                                        <span class="fw-bold">{{ $widget->visitors()->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Online Sekarang</span>
                                        <span class="fw-bold text-success">{{ $widget->getOnlineVisitorsCount() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Pesan Belum Dibaca</span>
                                        <span class="fw-bold text-danger">{{ $widget->getUnreadMessagesCount() }}</span>
                                    </div>
                                @else
                                    <p class="text-muted text-center mb-0">Setup widget terlebih dahulu</p>
                                @endif
                            </div>
                        </div>

                        @if ($widget)
                            <div class="d-grid mb-10 px-10">
                                <a href="{{ route('back.team.webchat.chat', $team->name_id) }}"
                                    class="btn btn-flex btn-primary px-6 justify-content-center mb-5">
                                    <i class="fas fa-comments fs-2x"></i>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-3 fw-bold">Buka Chat</span>
                                        <span class="fs-7">Lihat pesan dari visitor</span>
                                    </span>
                                </a>
                                <button type="button"
                                    class="btn btn-flex btn-danger px-6 justify-content-center mb-5"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash fs-2x"></i>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-3 fw-bold">Hapus Widget</span>
                                        <span class="fs-7">Hapus konfigurasi widget</span>
                                    </span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="border border-hover-primary rounded mt-3 p-10">
                            @if ($widget)
                                {{-- Widget Info --}}
                                <div class="text-center mb-8">
                                    <div class="symbol symbol-100px mb-5">
                                        <div class="symbol-label fs-1 fw-bold rounded-circle"
                                            style="background-color: {{ $widget->primary_color }}20;">
                                            <i class="fa fa-comments fs-3x" style="color: {{ $widget->primary_color }};"></i>
                                        </div>
                                    </div>
                                    <h2 class="fs-2x fw-bold mb-0">{{ $widget->widget_name }}</h2>
                                    <p class="text-muted fs-5">{{ $widget->widget_title }}</p>
                                </div>

                                {{-- Embed Code --}}
                                <div class="mb-8">
                                    <label class="fw-bold fs-6 mb-2">Kode Embed</label>
                                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fs-7 text-muted">Salin dan paste kode ini ke website Anda</span>
                                                <button type="button" class="btn btn-sm btn-light-primary" onclick="copyEmbedCode()">
                                                    <i class="fas fa-copy me-1"></i> Salin
                                                </button>
                                            </div>
                                            <code id="embedCode" class="d-block bg-dark text-white p-3 rounded fs-7" style="word-break: break-all;">
                                                {{ $widget->getEmbedCode() }}
                                            </code>
                                        </div>
                                    </div>
                                </div>

                                {{-- Update Form --}}
                                <form action="{{ route('back.team.webchat.update', $team->name_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-5">
                                                <label class="required fw-semibold fs-6 mb-2">Nama Widget</label>
                                                <input type="text" name="widget_name"
                                                    class="form-control form-control-solid"
                                                    value="{{ old('widget_name', $widget->widget_name) }}" />
                                                @error('widget_name')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-5">
                                                <label class="required fw-semibold fs-6 mb-2">Judul Chat</label>
                                                <input type="text" name="widget_title"
                                                    class="form-control form-control-solid"
                                                    value="{{ old('widget_title', $widget->widget_title) }}" />
                                                @error('widget_title')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-5">
                                        <label class="fw-semibold fs-6 mb-2">Subjudul</label>
                                        <input type="text" name="widget_subtitle"
                                            class="form-control form-control-solid"
                                            value="{{ old('widget_subtitle', $widget->widget_subtitle) }}" />
                                    </div>

                                    <div class="fv-row mb-5">
                                        <label class="fw-semibold fs-6 mb-2">Pesan Selamat Datang</label>
                                        <textarea name="welcome_message" class="form-control form-control-solid" rows="3">{{ old('welcome_message', $widget->welcome_message) }}</textarea>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-4">
                                            <div class="fv-row mb-5">
                                                <label class="fw-semibold fs-6 mb-2">Warna Primer</label>
                                                <input type="color" name="primary_color"
                                                    class="form-control form-control-color w-100"
                                                    value="{{ old('primary_color', $widget->primary_color) }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fv-row mb-5">
                                                <label class="fw-semibold fs-6 mb-2">Warna Sekunder</label>
                                                <input type="color" name="secondary_color"
                                                    class="form-control form-control-color w-100"
                                                    value="{{ old('secondary_color', $widget->secondary_color) }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fv-row mb-5">
                                                <label class="fw-semibold fs-6 mb-2">Posisi</label>
                                                <select name="position" class="form-select form-select-solid">
                                                    <option value="right" {{ $widget->position == 'right' ? 'selected' : '' }}>Kanan</option>
                                                    <option value="left" {{ $widget->position == 'left' ? 'selected' : '' }}>Kiri</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-4">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="require_name" value="1"
                                                    {{ $widget->require_name ? 'checked' : '' }} />
                                                <label class="form-check-label fw-semibold">Wajib Isi Nama</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="require_email" value="1"
                                                    {{ $widget->require_email ? 'checked' : '' }} />
                                                <label class="form-check-label fw-semibold">Wajib Isi Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                                    {{ $widget->is_active ? 'checked' : '' }} />
                                                <label class="form-check-label fw-semibold">Aktif</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-8">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            @else
                                {{-- Setup Form --}}
                                <div class="text-center mb-8">
                                    <div class="symbol symbol-100px mb-5">
                                        <div class="symbol-label fs-1 fw-bold bg-light-secondary text-secondary rounded-circle">
                                            <i class="fa fa-comments fs-3x"></i>
                                        </div>
                                    </div>
                                    <h2 class="fs-2x fw-bold mb-2">Buat Widget Chat</h2>
                                    <p class="text-muted fs-6">
                                        Buat widget chat untuk ditambahkan ke website Anda.
                                    </p>
                                </div>

                                <form action="{{ route('back.team.webchat.store', $team->name_id) }}" method="POST">
                                    @csrf

                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-5">
                                                <label class="required fw-semibold fs-6 mb-2">Nama Widget</label>
                                                <input type="text" name="widget_name"
                                                    class="form-control form-control-solid"
                                                    placeholder="Support Chat"
                                                    value="{{ old('widget_name', 'Support Chat') }}" />
                                                @error('widget_name')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-5">
                                                <label class="required fw-semibold fs-6 mb-2">Judul Chat</label>
                                                <input type="text" name="widget_title"
                                                    class="form-control form-control-solid"
                                                    placeholder="Chat Support"
                                                    value="{{ old('widget_title', 'Chat Support') }}" />
                                                @error('widget_title')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-5">
                                        <label class="fw-semibold fs-6 mb-2">Subjudul</label>
                                        <input type="text" name="widget_subtitle"
                                            class="form-control form-control-solid"
                                            placeholder="Kami siap membantu Anda"
                                            value="{{ old('widget_subtitle', 'Kami siap membantu Anda') }}" />
                                    </div>

                                    <div class="fv-row mb-5">
                                        <label class="fw-semibold fs-6 mb-2">Pesan Selamat Datang</label>
                                        <textarea name="welcome_message" class="form-control form-control-solid" rows="3"
                                            placeholder="Halo! Ada yang bisa kami bantu?">{{ old('welcome_message', 'Halo! 👋 Ada yang bisa kami bantu?') }}</textarea>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-4">
                                            <div class="fv-row mb-5">
                                                <label class="fw-semibold fs-6 mb-2">Warna Primer</label>
                                                <input type="color" name="primary_color"
                                                    class="form-control form-control-color w-100"
                                                    value="{{ old('primary_color', '#0f4aa2') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fv-row mb-5">
                                                <label class="fw-semibold fs-6 mb-2">Warna Sekunder</label>
                                                <input type="color" name="secondary_color"
                                                    class="form-control form-control-color w-100"
                                                    value="{{ old('secondary_color', '#0fa36b') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fv-row mb-5">
                                                <label class="fw-semibold fs-6 mb-2">Posisi</label>
                                                <select name="position" class="form-select form-select-solid">
                                                    <option value="right">Kanan</option>
                                                    <option value="left">Kiri</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-8">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>
                                            Buat Widget
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
    @if ($widget)
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Widget Chat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus widget <strong>{{ $widget->widget_name }}</strong>?</p>
                        <p class="text-danger">Semua data visitor dan pesan akan ikut terhapus!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('back.team.webchat.destroy', $team->name_id) }}" method="POST"
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
        function copyEmbedCode() {
            var embedCode = document.getElementById('embedCode').innerText;
            navigator.clipboard.writeText(embedCode).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Kode embed berhasil disalin',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        }
    </script>
@endsection
