@extends('layout.app')
@section('content')
    @push('styles')
        <style>
            table.dataTable tr {
                border: 2px solid #dbdade;
            }

            table.dataTable {
                border-top: 1px solid #dbdade;
                border-right: 1px solid #dbdade;
                border-left: 1px solid #dbdade;
            }
        </style>
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Users</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Team</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="search-box">
                                <input type="text" class="form-control" id="searchMemberList"
                                    placeholder="Search for name or designation...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">
                                <button type="button" id="grid-view-button"
                                    class="btn btn-soft-info nav-link btn-icon fs-14 active filter-button"><i
                                        class="ri-grid-fill"></i></button>
                                <button type="button" id="list-view-button"
                                    class="btn btn-soft-info nav-link  btn-icon fs-14 filter-button"><i
                                        class="ri-list-unordered"></i></button>
                                <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                    aria-expanded="false" class="btn btn-soft-info btn-icon fs-14"><i
                                        class="ri-more-2-fill"></i></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                    <li><a class="dropdown-item" href="#">All</a></li>
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                                </ul>
                                <a href="{{ route('employee.create') }}" class="btn btn-success">
                                    <i class="ri-add-fill me-1 align-bottom"></i>
                                    Add Members
                                </a>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div>

                        <div id="teamlist" style="display: block;">
                            <div class="team-list row grid-view-filter" id="team-member-list">

                                @forelse ($users as $user)
                                    <div class="col">
                                        <x-card.employee-view :data="$user" />
                                    </div>
                                @empty
                                @endforelse

                            </div>
                            <div class="text-center mb-3">
                                <a href="javascript:void(0);" class="text-success"><i
                                        class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load More
                                </a>
                            </div>
                        </div>
                        <div class="py-4 mt-4 text-center" id="noresult" style="display: none;">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px">
                            </lord-icon>
                            <h5 class="mt-4">Sorry! No Result Found</h5>
                        </div>

                    </div>
                </div><!-- end col -->
            </div>
            <!--end row-->
        </div><!-- container-fluid -->
    </div><!-- End Page-content -->

    @push('scripts')
        {{-- <script src="{{ asset('/assets/js/pages/team.init.js') }}"></script> --}}

        <script>
            $(function() {



            });
        </script>
    @endpush
@endsection
