@props([
    'ApartmentNamr' => 'Administrator',
    'numberOfUsers' => '4',
    'btnTarget' => 'LeaveTypeModal',
    'funName' => 'LeaveTypeModal',
    'color' => 'warning',
])


<div class="card profile-project-card shadow-none profile-project-{{ $color ?? '' }}">
    <div class="card-body p-4">
        <div class="d-flex">
            <div class="flex-grow-1 text-muted overflow-hidden">
                <h5 class="fs-14 text-truncate"><a href="#" class="text-body">Whats yours next Leave Type!</a>
                </h5>
                <p class="text-muted text-truncate mb-0">Add Leave Type, if it doesn't exist. </p>
            </div>
        </div>

        <div class="d-flex mt-2">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 justify-content-end">
                    <div class="avatar-group text-end">
                        <div class="flex-shrink-0 ms-2">
                            <button class="btn btn-primary add-btn"
                                onclick="{{ $funName }}({{ false }})"><i
                                    class="ri-add-line align-bottom me-1"></i>
                                Add Leave Type
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
