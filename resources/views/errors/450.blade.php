@extends('layout.app')
@section('title', __('Unauthorized'))
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="auth-page-wrapper py-0 d-flex justify-content-center align-items-center"
                style="min-height: 70vh !important;">

                <!-- auth-page content -->
                <div class="auth-page-content overflow-hidden p-0">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-7 col-lg-8">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/error400-cover.png') }}" alt="error img"
                                        class="img-fluid">
                                    <div class="mt-3">
                                        <h3 class="text-uppercase1 text-danger">Employment Verification Required: Action
                                            Needed to Access Your Account</h3>
                                        <p class="text-muted mb-4">Unable to verify your employment status or locate your
                                            employee details. Please review the information and try again. If you don't have
                                            access, consider creating a new employee account and logging in as an employee.
                                        </p>
                                        <a href="{{ url('dashboard') }}" class="btn btn-success"><i
                                                class="mdi mdi-home me-1"></i>Back
                                            to home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
