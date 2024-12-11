@props([
    'roomId' => '',
    'roomName' => '',
    'btnTarget' => 'RoomModal',
    'funName' => 'RoomModal',
    'per' => 'editRoleModal',
    'item' => '[]',
])

@php
    // $totalUsers = count($item->users) ?? 0;
    // $moreUsers = $totalUsers > 4 ? $totalUsers - 4 : 0;
@endphp
<div class="card  my-1 profile-project-card shadow-none profile-project-{{ $color ?? '' }}">
    <div class="card-body p-4">
        <div class="d-flex">
            <div class="flex-grow-1 text-muted overflow-hidden">
                <h5 class="fs-14 text-truncate">
                    <a href="#" class="text-body">{{ $roomName ?? '' }}</a>
                </h5>
                <p class="text-muted text-truncate mb-0">Total {{ $totalUsers ?? '' }} room(s) </p>
            </div>
            <div class="flex-shrink-0 ms-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#{{ $btnTarget }}" type="button"
                    onclick="{{ $funName }}('{{ $roomId }}', {{ Js::from($item) }})" class="me-2">
                    <i class="ri-pencil-line"></i>
                </a>

                <a href="#" delete-url="{{ url('roomease/room') }}" delete-item="{{ $roomName }}"
                    class="delete link-danger" id="{{ $roomId }}" title="Delete">
                    <i class="ri-delete-bin-5-line"></i>
                </a>
            </div>
        </div>

        <div class="d-flex mt-2">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 justify-content-end">
                    <div>
                        {{-- <h5 class="fs-12 text-muted mb-0">
                            Members :</h5> --}}
                    </div>
                    <div class="avatar-group text-end">
                        <div class="avatar-group-item">
                        </div>
                        <div class="avatar-group-item">
                            <div class="avatar-xs">
                                <div class="avatar-title rounded-circle bg-light text-primary">
                                    <i class="ri-building-line"
                                        style=" font-size: 60px; opacity: 0.9; color: #9595aa; "></i>
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
