@props([
    'roleName' => 'Administrator',
    'numberOfUsers' => '4',
    'color' => 'warning',
    'users' => [
        ['name' => 'fahath', 'img' => 'assets/images/users/avatar-1.jpg'],
        ['name' => 'fahath', 'img' => 'assets/images/users/avatar-2.jpg'],
        ['name' => 'fahath', 'img' => 'assets/images/users/avatar-3.jpg'],
        ['name' => 'fahath', 'img' => 'assets/images/users/avatar-4.jpg'],
    ],
])


<div class="modal fade zoomIn" id="addRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('role.store') }}" method="POST" class="tablelist-form" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="tasksId" />
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="projectName-field" class="form-label">Role Name</label>
                            <input type="text" name="name" id="projectName-field" class="form-control"
                                placeholder="Role Name" />
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label class="form-label">Assigned To</label>
                            <div data-simplebar style="height: 95px;">
                                <ul class="list-unstyled vstack gap-2 mb-0">
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-2.jpg" id="james-forbes">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="james-forbes">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">James Forbes</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-3.jpg" id="john-robles">
                                            <label class="form-check-label d-flex align-items-center" for="john-robles">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">John Robles</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-4.jpg" id="mary-gant">
                                            <label class="form-check-label d-flex align-items-center" for="mary-gant">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-4.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Mary Gant</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-1.jpg" id="curtis-saenz">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="curtis-saenz">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-1.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Curtis Saenz</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-5.jpg" id="virgie-price">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="virgie-price">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-5.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Virgie Price</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-10.jpg" id="anthony-mills">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="anthony-mills">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-10.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Anthony Mills</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-6.jpg" id="marian-angel">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="marian-angel">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-6.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Marian Angel</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-10.jpg" id="johnnie-walton">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="johnnie-walton">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-7.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Johnnie Walton</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-8.jpg" id="donna-weston">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="donna-weston">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-8.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Donna Weston</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                value="avatar-9.jpg" id="diego-norris">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="diego-norris">
                                                <span class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-9.jpg" alt=""
                                                        class="avatar-xxs rounded-circle">
                                                </span>
                                                <span class="flex-grow-1 ms-2">Diego Norris</span>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" id="close-modal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Add Role</button>
                        {{-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
