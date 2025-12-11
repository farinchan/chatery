@extends('back.app')

@section('content')
    <div id="kt_content_container" class="container-fluid ">

        @livewire('website-chat-component', ['nameId' => $nameId])
    </div>
@endsection

@section('scripts')

@endsection
