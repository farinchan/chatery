@extends('back.app')

@section('content')
    <div id="kt_content_container" class="container-fluid">
        @livewire('telegram-chat-component', ['nameId' => $nameId])
    </div>
@endsection

@section('scripts')

@endsection
