@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">
            <x-asset.show.banner :employee="$employee" />
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <x-asset.show.tab-menu :employee="$employee" />
                        <!-- Tab panes -->
                        <div class="tab-content pt-4 text-muted">
                            <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                <x-asset.show.overview :employee="$employee" />
                                <!--end row-->
                            </div>
                            <div class="tab-pane fade" id="activities" role="tabpanel">
                                <x-asset.show.activity :employee="$employee" :eodLog="$empEodLogs" />
                                <!--end card-->
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane fade" id="employee-assets" role="tabpanel">
                                <x-asset.show.asset :employee="$employee" />
                                <!--end card-->
                            </div>
                            <div class="tab-pane fade" id="org-report" role="tabpanel">
                                <x-asset.show.organization :employee="$employee" />
                                <!--end card-->
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane fade" id="documents" role="tabpanel">
                                {{-- <x-asset.show.organization :employee="$employee" /> --}}
                            </div>
                            <!--end tab-pane-->
                        </div>
                        <!--end tab-content-->
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div><!-- container-fluid -->
    </div>

    @push('scripts')
    @endpush

    @push('styles')
        <style>
            .org .assign-empt-tree .img-thumbnail {
                width: 55px !important;
                height: 55px !important;
                max-width: 55px !important;
            }
        </style>
    @endpush
@endsection
