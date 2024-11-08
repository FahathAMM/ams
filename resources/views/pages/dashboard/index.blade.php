@extends('layout.app')
@section('title', $title)
@section('content')

    {{-- <x-dashboard.dashboard :userLogs="$userLogs" /> --}}


    <x-dashboard.user-dash :userLogs="$userLogs" />


    {{-- @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>


        <script>
            Push.create('Hello World!', {
                    timeout: 2000,
                    requireInteraction: true,
                    body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, expedita.',
                    onClick() {
                        location.href = "/";
                    }
                })
                .catch(e => {
                    alert('please enable notification')
                    console.log(e);
                })
        </script>
    @endpush --}}
@endsection
