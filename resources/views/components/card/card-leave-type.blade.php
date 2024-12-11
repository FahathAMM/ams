@props([
    'id' => '',
    'name' => 'Administrator',
    'numberOfUsers' => '4',
    'color' => 'warning',
    'btnTarget' => '',
    'funName' => '',
    'per' => '',
    'item' => '[]',
])

@php
@endphp
<div class="card  my-1 profile-project-card shadow-none profile-project-{{ $color ?? '' }}">
    <div class="card-body p-4">
        <div class="d-flex">
            <div class="flex-grow-1 text-muted overflow-hidden">
                <h5 class="fs-14 text-truncate">
                    <a href="#" class="text-body">{{ $name ?? '' }}</a>
                </h5>
                <p class="text-muted text-truncate mb-0">Total {{ $item->number_of_days ?? '' }} day(s) </p>
            </div>
            <div class="flex-shrink-0 ms-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#{{ $btnTarget }}" type="button"
                    onclick="{{ $funName }}('{{ $id }}', {{ Js::from($item) }})" class="me-2">
                    <i class="ri-pencil-line"></i>
                </a>

                <a href="#" delete-url="{{ url('leave/leave-type') }}" delete-item="{{ $name }}"
                    class="delete link-danger" id="{{ $id }}" title="Delete">
                    <i class="ri-delete-bin-5-line"></i>
                </a>

            </div>
        </div>

        <div class="d-flex mt-2">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 justify-content-end">
                    <div>
                    </div>
                    <div class="avatar-group text-end">
                        <div class="avatar-group-item">
                        </div>
                        <div class="avatar-group-item">
                            <div class="avatar-xs">
                                <div class="avatar-title rounded-circle bg-light text-primary">
                                    <i class="ri-folder-user-line"
                                        style=" font-size: 60px; opacity: 0.6; color: #9595aa; "></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end card body -->
</div>
