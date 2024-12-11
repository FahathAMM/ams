@extends('layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        {{-- <div class="col-lg-6">
                                <x-auth.banner />
                            </div> --}}

                        <div class="col-lg-12">
                            <div class="p-lg-5 p-4">
                                <div>
                                    <h5 class="text-primary">Other Logged Devices</h5>
                                    <p class="text-muted">Manage and logout your active login status on ther devices!
                                    </p>
                                </div>
                                <div class="user-thumb text-center">
                                    <img src="{{ $user->img ?? '' }}" class="rounded-circle img-thumbnail avatar-lg"
                                        alt="thumbnail">
                                    <h5 class="mt-3">{{ $user->username ?? '' }}</h5>
                                </div>

                                <div class="mt-4 mb-3 border-bottom pb-2">
                                    <div class="float-end">
                                        {{-- <a href="javascript:void(0);" class="link-primary">All Logout</a> --}}
                                    </div>
                                    <h5 class="card-title">Login History</h5>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light text-primary rounded-3" style="font-size:30px">
                                            <i class="{{ getDeviceIcon($logedDevice->device ?? '') }}"></i>
                                        </div>
                                    </div>
                                    @if (!empty($logedDevice))
                                        <div class="flex-grow-1 ms-3">
                                            <h6>{{ $logedDevice->device }}</h6>
                                            <p class="text-muted mb-0">
                                                User logged in successfully using
                                                <b>{{ $logedDevice->browser ?? '' }}</b>
                                                on a running
                                                <b>{{ $logedDevice->os }}</b>
                                                <b>
                                                    {{ date('F j \a\t g:i A', strtotime($logedDevice->login_time)) }}
                                                </b>
                                                from
                                                the IP address <b>{{ $logedDevice->ip_address }}</b>
                                            </p>
                                        </div>
                                        <div>
                                            <a href="#" class="text-danger"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form"
                                                action="{{ url('reset-login-session', ['username' => $user->username]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                        </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    No users are currently logged in.
                                </div>
                                @endif
                                <div class="mt-5 text-center">
                                    <p class="mb-0">Not you ? return <a href="{{ url('login') }}"
                                            class="fw-semibold text-primary text-decoration-underline"> Signin</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            function submitResetSession() {
                let username = document.getElementById('username').value;
                if (username == '') {
                    alert('Please enter username');
                    return;
                }
                window.location.href = '{{ url('reset-login-session') }}';
            }
        </script>
    @endpush

    <style>
        @media (min-width: 1200px) {
            :is(.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl) {
                max-width: 800px;
            }
        }
    </style>
@endsection
