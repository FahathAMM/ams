<div>

    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 p-1">
        <div class="chat-leftsidebar">
            <div class="px-4 pt-4 mb-3">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="mb-4">EOD Reports</h5>
                    </div>
                    <div class="flex-shrink-0">
                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom"
                            title="Add Contact">
                            <!-- Button trigger modal -->
                            <a href="{{ route('eodreport.index') }}" class="btn btn-soft-success btn-sm">
                                <i class="ri-add-line align-bottom"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="search-box">
                    <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                    <i class="ri-search-2-line search-icon"></i>
                </div>
            </div> <!-- .p-4 -->

            {{-- <div class="chat-room-list pt-3" data-simplebar style="max-height: 275px;"> --}}
            <div class="chat-room-list pt-3" id="my-date-view" style="height: calc(100vh - 301px); overflow: auto;">
                {{-- max-height: 65vh;
                overflow: auto;
                height: calc(100vh - 352px)
                --}}
                <div class="d-flex align-items-center px-4 mb-2">
                    <div class="flex-grow-1">
                        {{-- <h4 class="mb-0 fs-11 text-muted text-uppercase">EOD Report List</h4> --}}
                    </div>
                    <div class="flex-shrink-0">
                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom"
                            title="New Message">
                        </div>
                    </div>
                </div>

                <div class="chat-message-list">
                    {{-- {{ json_encode(count($eodDateListArr), JSON_PRETTY_PRINT) }} --}}

                    <ul class="list-unstyled chat-list chat-user-list" id="userList">
                        @foreach ($eodDateListArr as $key => $item)
                            <li style="cursor: pointer"
                                class="{{ $selectedDate == $item->eod_date ? 'active' : '' }} border-top">
                                <a wire:click="fetchEODBydate('{{ $item->eod_date }}', '{{ $item->subject }}')">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 chat-user-img away align-self-center me-2 ms-0">
                                            <div class="avatar-xxs">
                                                <div class="avatar-title rounded-circle bg-primary text-white fs-10">
                                                    {{ getInitials($item->subject) }}
                                                </div>
                                                {{-- <span class="user-status"> </span> --}}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-0">
                                                {{ date('Y-m-d', strtotime($item->eod_date)) }} -
                                                {{ $item->subject }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>

        <div class="user-chat w-100 overflow-hidden">

            <div class="chat-content d-lg-flex">
                <div class="w-100 overflow-hidden position-relative">
                    <div class="position-relative">
                        <div class="position-relative" id="users-chat">
                            <div class="p-3 user-chat-topbar">
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-12">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1">
                                                    <i class="ri-arrow-left-s-line align-bottom"></i></a>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate mb-0 fs-16">
                                                            <a class="text-reset username">
                                                                {{ $selectedSubject ?? 'Subject' }}
                                                            </a>
                                                        </h5>
                                                        <p class="text-truncate text-muted fs-14 mb-0 userStatus">
                                                            <small>{{ $selectedDate }}</small>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm" style=" margin-right: 25px; ">
                                                            <img src="{{ $this->employeeModel->img }}" alt="user-img"
                                                                class="img-thumbnail rounded-circle"
                                                                style="width: 53px !important;height: 53px !important;max-width: 100px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-conversatin p-3 p-lg-4 " id="chat-conversation" data-simplebar>
                                @if ($singleEodReport)
                                    <div class="row">
                                        @forelse ($singleEodReport as $key => $items)
                                            @php
                                                $companyName = $items[0]['customer']['company_name'];
                                                $subject = $items[0]['subject'];
                                            @endphp

                                            <div class="col-12 col-lg-6 col-md-6 col-xxl-4">
                                                <div class="card card-height-100">
                                                    <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">
                                                            {{ $companyName }} - {{ $subject }}
                                                        </h4>
                                                        <div class="flex-shrink-0">
                                                            <div class="dropdown card-header-dropdown">
                                                                <a class="text-reset dropdown-btn" href="#"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <span class="text-muted fs-18"><i
                                                                            class="mdi mdi-dots-vertical"></i></span>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#">Edit</a>
                                                                    <a class="dropdown-item" href="#">Remove</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body pt-2">
                                                        @foreach ($items as $item)
                                                            <ul class="list-group list-group-flush border-top mt-1">
                                                                <li class="list-group-item ps-0">
                                                                    <div class="row align-items-center g-3">
                                                                        <div class="col-auto">
                                                                            <div
                                                                                class="avatar-sm p-1 py-2 w-auto h-auto bg-light rounded-3">
                                                                                <div class="text-center">
                                                                                    {{-- <h5 class="mb-0">
                                                                                        {{ $item['task_code'] ?? '' }}
                                                                                    </h5> --}}
                                                                                    <div class="text-muted">
                                                                                        {{ $item['task_code'] ?? '' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <h5 class="text-muted mt-0 mb-1 fs-13">
                                                                                {{ $item['duration'] ?? '' }}
                                                                            </h5>
                                                                            <a href="#"
                                                                                class="text-reset fs-14 mb-0">
                                                                                {{ $item['task_description'] ?? '' }}
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-sm-auto">

                                                                            {!! eodStatus($item['status']) ?? '' !!}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            empty
                                        @endforelse
                                    </div>
                                @else
                                @endif

                                <div id="elmLoader1" wire:loading wire:target="fetchEODBydate">
                                    <div class="spinner-border text-primary avatar-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
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
            $(document).ready(function() {
                // new SimpleBar(document.getElementById('my-date-view'));
            });

            window.addEventListener('show-delete-modal', event => {

                setTimeout(() => {
                    // new SimpleBar(document.getElementById('my-date-view'));
                    console.log('qqqqq');
                }, 10);

            })
        </script>
    @endpush

</div>
