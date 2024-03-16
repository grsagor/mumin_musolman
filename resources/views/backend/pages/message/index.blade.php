@extends('backend.pages.message.message-layout')

@section('message-content')
    @if ($channel_id)
        @include('backend.pages.message.messages')
    @else

    @endif
@endsection
