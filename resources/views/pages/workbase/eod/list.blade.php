@extends('layout.app')
@section('title', $title)
@section('content')


    <div class="page-content">
        <div class="container-fluid">

            {{-- {{ $empId }} --}}
            <livewire:pages.e-o-d.eod-livewire :dynamicempId="$empId">

        </div>
    </div>

    @push('scripts')
        <script>
            // document.querySelectorAll("#userList li").forEach(function(n) {
            //     n.addEventListener("click", function() {
            //         console.log('dddd');

            //         // Remove the 'active' class from all list items
            //         document.querySelectorAll("#userList li").forEach(function(item) {
            //             item.classList.remove("active");
            //         });

            //         // Add the 'active' class to the clicked item
            //         n.classList.add("active");
            //     });
            // });
        </script>
    @endpush


    @push('styles')
        <style>
            #elmLoader1 {
                text-align: center;
                width: 100%;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                position: absolute;
                left: 0;
                top: 165px;
                bottom: 0
            }

            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-button {
                display: none;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 60px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            ::-webkit-scrollbar-track {
                background: #fefefe19;
                border-radius: 6px;
            }

            * {
                /* scrollbar-width: thin; */
                /* scrollbar-color: #888 #ffffff00; */
            }
        </style>
    @endpush
@endsection
