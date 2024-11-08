@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="row" id="role-card-area">
                @foreach ($roles as $role)
                    <div class="col-xxl-3 col-md-4">
                        <x-card.card-role :roleName="$role->name" color="warning" :roleId="$role->id" :item="$role"
                            per="administration-role-edit" />
                    </div>
                @endforeach
                <div class="col-xxl-3 col-md-4">
                    @canOrRole('administration-role-create', 'create')
                    <x-card.card-add-role color="success" />
                    @endcanOrRole
                </div>
            </div>

            {{-- add role  modal --}}
            <x-modal.common titleName="Add Role" idName="addRoleModal" size="modal-lg">
                <form action="{{ route('role.store') }}" method="POST" id="role-form" class="tablelist-form"
                    autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <x-input.txt-group label="Role Name" name="name" placeholder="Enter your Role Name" />
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Assigned To</label>
                                <div data-simplebar style="height: 400px;">
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($users->chunk(ceil($users->count() / 4)) as $userChunk)
                                                <div class="col-lg-3 col-md-6">
                                                    <ul class="list-unstyled vstack gap-2 mb-0">
                                                        @foreach ($userChunk as $user)
                                                            <li>
                                                                <div class="form-check d-flex align-items-center">
                                                                    <input class="form-check-input me-3" type="checkbox"
                                                                        name="assignedTo[]" value="{{ $user->id }}"
                                                                        id="{{ $user->id }}">
                                                                    <label
                                                                        class="form-check-label d-flex align-items-center"
                                                                        for="{{ $user->id }}">
                                                                        <span class="flex-shrink-0">
                                                                            <img src="{{ $user->img }}" alt=""
                                                                                class="avatar-xxs rounded-circle">
                                                                        </span>
                                                                        <span
                                                                            class="flex-grow-1 ms-2">{{ $user->first_name }}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success sbtBtn" onclick="store()"
                                id="add-btn">Submit</button>
                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
                        </div>
                    </div>
                </form>
            </x-modal.common>

            {{-- edit role  modal --}}
            <x-modal.common titleName="Edit Role" idName="editRoleModal" size="modal-lg">
                <form action="#" method="POST" id="role-edit-form" class="tablelist-form" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <x-input.hidden id="edit-role-id" />
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <x-input.txt-group label="Role Name" name="name" id="edit-name"
                                    placeholder="Enter your Role Name" />
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">Assigned To</label>
                                <div data-simplebar style="height: 400px;">
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($users->chunk(ceil($users->count() / 4)) as $userChunk)
                                                <div class="col-lg-3 col-md-6">
                                                    <ul class="list-unstyled vstack gap-2 mb-0">
                                                        @foreach ($userChunk as $user)
                                                            <li>
                                                                <div class="form-check d-flex align-items-center">
                                                                    <input class="form-check-input me-3" type="checkbox"
                                                                        name="assignedTo[]" value="{{ $user->id }}"
                                                                        id="edit-{{ $user->id }}">
                                                                    <label
                                                                        class="form-check-label d-flex align-items-center"
                                                                        for="edit-{{ $user->id }}">
                                                                        <span class="flex-shrink-0">
                                                                            <img src="{{ $user->img }}" alt=""
                                                                                class="avatar-xxs rounded-circle">
                                                                        </span>
                                                                        <span
                                                                            class="flex-grow-1 ms-2">{{ $user->first_name }}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success sbtBtn" onclick="update()"
                                id="add-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </x-modal.common>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(function() {
                const element = document.querySelector('.dataTables_length label select');
                if (element) {
                    const choices = new Choices(element, {
                        searchEnabled: false
                    });
                }
            });

            function editRoleModal(roleId, item) {

                $(`#editRoleModal input:checkbox`).prop('checked', false);
                item.users.forEach(e => {
                    $(`#edit-${e.id}`).prop('checked', true);
                });
                setValue('edit-name', item.name);
                setValue('edit-role-id', roleId);
            }

            function store() {
                sLoading('sbtBtn')
                console.log('dfd');
                var form = document.getElementById('role-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);
                console.log(payload);

                const options = {
                    // contentType: 'application/json',
                    contentType: 'multipart/form-data',
                    // 'Content-Type': 'multipart/form-data',
                    method: method || 'POST',
                    headers: {
                        dataType: "json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        console.log('Success:', response.status);
                        if (response.status) {
                            $("#role-form :input").val("");
                            // redirectTo('{{ route('user.index') }}');
                            // refreshContent('administration/role', 'role-card-area')
                            eLoading('sbtBtn')
                            refreshContent('{{ url('administration/role') }}', 'role-card-area');
                            closeModal('addRoleModal');
                            alertNotify(response.message, 'success')
                        } else {
                            associateErrors(response.errors, 'role-form');
                            eLoading('sbtBtn')
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            function update() {
                sLoading('sbtBtn')
                let roleId = getValue('edit-role-id');
                var form = document.getElementById('role-edit-form');
                // var url = '{{ url('role') }}/' + roleId + '/edit';
                var url = '{{ url('administration/role') }}/' + roleId;
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                const options = {
                    contentType: 'multipart/form-data',
                    method: 'POST',
                    headers: {
                        dataType: "json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        if (response.status) {
                            refreshContent('{{ url('administration/role') }}', 'role-card-area');
                            closeModal('editRoleModal');
                            alertNotify(response.message, 'success')
                            eLoading('sbtBtn')
                        } else {
                            associateErrors(response.errors, 'role-edit-form');
                            eLoading('sbtBtn')
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            function closeModal(modalId) {
                $(`#${modalId}`).modal('hide');
            }

            // ========form submit============
        </script>
    @endpush
@endsection
