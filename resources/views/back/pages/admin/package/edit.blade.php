@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2>Edit Package</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('back.admin.package.index') }}" class="btn btn-light-primary">
                        <i class="ki-outline ki-arrow-left fs-2"></i>Kembali
                    </a>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <form action="{{ route('back.admin.package.update', $package->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!--begin::Basic Info-->
                    <div class="card card-bordered mb-7">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Dasar</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Nama Package</label>
                                        <input type="text" name="name"
                                            class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                            placeholder="Contoh: Free Tier, Platinum, Diamond" value="{{ old('name', $package->name) }}" required />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Slug</label>
                                        <input type="text" name="slug"
                                            class="form-control form-control-lg form-control-solid @error('slug') is-invalid @enderror"
                                            placeholder="free-tier" value="{{ old('slug', $package->slug) }}" required />
                                        <div class="form-text">ID unik untuk package (hanya huruf, angka, dash)</div>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-6">
                                        <label class="form-label fw-semibold fs-6">Deskripsi</label>
                                        <textarea name="description" rows="3"
                                            class="form-control form-control-lg form-control-solid @error('description') is-invalid @enderror"
                                            placeholder="Deskripsi package...">{{ old('description', $package->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Harga</label>
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="price"
                                                class="form-control form-control-lg form-control-solid @error('price') is-invalid @enderror"
                                                placeholder="0" value="{{ old('price', $package->price) }}" min="0" required />
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Billing Cycle</label>
                                        <select name="billing_cycle"
                                            class="form-select form-select-solid form-select-lg @error('billing_cycle') is-invalid @enderror" required>
                                            <option value="monthly" {{ old('billing_cycle', $package->billing_cycle) == 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                                            <option value="yearly" {{ old('billing_cycle', $package->billing_cycle) == 'yearly' ? 'selected' : '' }}>Per Tahun</option>
                                            <option value="lifetime" {{ old('billing_cycle', $package->billing_cycle) == 'lifetime' ? 'selected' : '' }}>Selamanya</option>
                                        </select>
                                        @error('billing_cycle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Sort Order</label>
                                        <input type="number" name="sort_order"
                                            class="form-control form-control-lg form-control-solid @error('sort_order') is-invalid @enderror"
                                            placeholder="0" value="{{ old('sort_order', $package->sort_order) }}" min="0" />
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Badge Color</label>
                                        <input type="color" name="badge_color"
                                            class="form-control form-control-lg form-control-solid @error('badge_color') is-invalid @enderror"
                                            value="{{ old('badge_color', $package->badge_color) }}" required />
                                        @error('badge_color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-6">
                                        <label class="form-label fw-semibold fs-6">Icon (Keenicons)</label>
                                        <input type="text" name="icon"
                                            class="form-control form-control-lg form-control-solid @error('icon') is-invalid @enderror"
                                            placeholder="box, diamond, crown, rocket" value="{{ old('icon', $package->icon) }}" />
                                        <div class="form-text">Contoh: box, diamond, crown, rocket, star</div>
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Basic Info-->

                    <!--begin::Limits-->
                    <div class="card card-bordered mb-7">
                        <div class="card-header">
                            <h3 class="card-title">Batasan (Limits)</h3>
                            <div class="card-toolbar">
                                <span class="badge badge-light-info">Isi -1 untuk unlimited</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Max Members</label>
                                        <input type="number" name="max_members"
                                            class="form-control form-control-lg form-control-solid @error('max_members') is-invalid @enderror"
                                            value="{{ old('max_members', $package->max_members) }}" min="-1" required />
                                        @error('max_members')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Max WhatsApp Sessions</label>
                                        <input type="number" name="max_whatsapp_sessions"
                                            class="form-control form-control-lg form-control-solid @error('max_whatsapp_sessions') is-invalid @enderror"
                                            value="{{ old('max_whatsapp_sessions', $package->max_whatsapp_sessions) }}" min="-1" required />
                                        @error('max_whatsapp_sessions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Max Telegram Bots</label>
                                        <input type="number" name="max_telegram_bots"
                                            class="form-control form-control-lg form-control-solid @error('max_telegram_bots') is-invalid @enderror"
                                            value="{{ old('max_telegram_bots', $package->max_telegram_bots) }}" min="-1" required />
                                        @error('max_telegram_bots')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Max Webchat Widgets</label>
                                        <input type="number" name="max_webchat_widgets"
                                            class="form-control form-control-lg form-control-solid @error('max_webchat_widgets') is-invalid @enderror"
                                            value="{{ old('max_webchat_widgets', $package->max_webchat_widgets) }}" min="-1" required />
                                        @error('max_webchat_widgets')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Max Messages/Day</label>
                                        <input type="number" name="max_messages_per_day"
                                            class="form-control form-control-lg form-control-solid @error('max_messages_per_day') is-invalid @enderror"
                                            value="{{ old('max_messages_per_day', $package->max_messages_per_day) }}" min="-1" required />
                                        @error('max_messages_per_day')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-6">
                                        <label class="form-label required fw-semibold fs-6">Message History (Days)</label>
                                        <input type="number" name="message_history_days"
                                            class="form-control form-control-lg form-control-solid @error('message_history_days') is-invalid @enderror"
                                            value="{{ old('message_history_days', $package->message_history_days) }}" min="-1" required />
                                        @error('message_history_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Limits-->

                    <!--begin::Features-->
                    <div class="card card-bordered mb-7">
                        <div class="card-header">
                            <h3 class="card-title">Fitur</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_api_access" value="1"
                                            id="has_api_access" {{ old('has_api_access', $package->has_api_access) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_api_access">API Access</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_webhook" value="1"
                                            id="has_webhook" {{ old('has_webhook', $package->has_webhook) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_webhook">Webhook</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_bulk_message" value="1"
                                            id="has_bulk_message" {{ old('has_bulk_message', $package->has_bulk_message) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_bulk_message">Bulk Message</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_auto_reply" value="1"
                                            id="has_auto_reply" {{ old('has_auto_reply', $package->has_auto_reply) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_auto_reply">Auto Reply</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_analytics" value="1"
                                            id="has_analytics" {{ old('has_analytics', $package->has_analytics) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_analytics">Analytics</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_export" value="1"
                                            id="has_export" {{ old('has_export', $package->has_export) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_export">Export Data</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_priority_support" value="1"
                                            id="has_priority_support" {{ old('has_priority_support', $package->has_priority_support) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_priority_support">Priority Support</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="has_custom_branding" value="1"
                                            id="has_custom_branding" {{ old('has_custom_branding', $package->has_custom_branding) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="has_custom_branding">Custom Branding</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Features-->

                    <!--begin::Status-->
                    <div class="card card-bordered mb-7">
                        <div class="card-header">
                            <h3 class="card-title">Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                            id="is_active" {{ old('is_active', $package->is_active) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="is_active">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                        <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                            id="is_featured" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }} />
                                        <label class="form-check-label fw-semibold" for="is_featured">Featured (Recommended)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Status-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('back.admin.package.index') }}" class="btn btn-light me-3">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Update</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
