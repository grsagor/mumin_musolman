@extends('backend.pages.message.message-layout')
@section('css')
    <style>
        .btn-outline-primary {
            --bs-btn-color: #FF5B22;
            --bs-btn-border-color: #FF5B22;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #FF5B22;
            --bs-btn-hover-border-color: #FF5B22;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #FF5B22;
            --bs-btn-active-border-color: #FF5B22;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #FF5B22;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #FF5B22;
            --bs-gradient: none
        }

        .border-primary {
            --bs-border-opacity: 1;
            border-color: #FF5B22 !important;
        }
    </style>
@endsection
@section('message-content')
    @if ($channel_id)
        @include('backend.pages.message.messages')
    @else

    @endif
@endsection
