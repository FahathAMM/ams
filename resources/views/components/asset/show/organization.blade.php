@props([
    'title' => ' ',
    'employee' => $employee,
])

@php
    $reportingManager = $employee->reportingManager;
@endphp

<div class="card org">
    <div class="card-body"> {{-- <h5 class="card-title mb-3">Activities</h5> --}} <div class="sitemap-content">
            <div class="hori-sitemap">
                <ul class="list-unstyled mb-0">
                    <li class="p-0 parent-title">
                        <div href="javascript: void(0);"
                            class="fw-semibold fs-14 text-center d-flex justify-content-center">
                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                <img src="{{ $employee->img ?? '' }}" alt="user-img"
                                    class="rounded-circle avatar-lg img-thumbnail user-profile-image" />
                            </div>
                        </div>
                        <label for="">{{ $employee->full_name }}</label>
                    </li>
                    <li>

                        <ul class="list-unstyled second-list row g-0 pt-0 justify-content-center">

                            {{-- @foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $item)
                                <li class="col-sm-1 assign-empt-tree">
                                    <a href="javascript: void(0);" class="fw-semibold  d-flex justify-content-center">
                                        <div class="avatar-sm">
                                            <img src="{{ $employee->img ?? '' }}" alt="user-img"
                                                class="img-thumbnail rounded-circle" />
                                        </div>
                                    </a>
                                    <label for="">{{ $employee->full_name }}</label>
                                </li>
                            @endforeach --}}

                            @foreach ($reportingManager as $emp)
                                <li class="col-sm-1 assign-empt-tree" styles="width:10%">
                                    <a href="{{ route('eod.list', ['id' => $emp->id]) }}"
                                        class="fw-semibold  d-flex justify-content-center">
                                        <div class="avatar-sm">
                                            <img src="{{ $emp->img ?? '' }}" alt="user-img"
                                                class="img-thumbnail rounded-circle" />
                                            {{-- <label for="">{{ $emp->full_name }}</label> --}}
                                        </div>
                                    </a>
                                    <label for="">{{ $emp->full_name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


@push('styles')
    <style>
        .org .assign-empt-tree .img-thumbnail {
            width: 55px !important;
            height: 55px !important;
            max-width: 55px !important;
        }

        /* style="width:100px;height:85px;" */
        .sitemap-content {
            max-width: 100% !important;
        }
    </style>
@endpush
