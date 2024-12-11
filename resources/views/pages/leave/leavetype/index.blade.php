@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="row" id="leave-type-card-area">
                @foreach ($leaveTypes as $type)
                    <div class="col-xxl-3 col-md-4">
                        <x-card.card-leave-type :name="$type->name" color="warning" :id="$type->id" :item="$type"
                            btnTarget="LeaveTypeModal" funName="LeaveTypeModal" per="" />
                    </div>
                @endforeach
                <div class="col-xxl-3 col-md-4">
                    <x-card.card-add-leave-type color="success" btnTarget="LeaveTypeModal" />
                </div>
            </div>

            {{-- add LeaveType  modal --}}
            <x-modal.common titleName="Add Leave Type" idName="LeaveTypeModal" size="modal-lg">
                <form action="{{ route('leave-type.store') }}" method="POST" id="leavetype-form" class="tablelist-form"
                    autocomplete="off">
                    @csrf
                    <input type="hidden" name="is_edit" id="is_edit">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Name" name="name" placeholder="Enter your Name" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Days" name="number_of_days"
                                    placeholder="Enter Number of Days" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <x-input.txtarea-group label="Description" name="description"
                                    placeholder="Enter your description" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-success sbtBtn" onclick="submitBtn()" id="submit-btn">
                                Submit
                            </button>
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

            let formName = 'leavetype-form'

            function LeaveTypeModal(isEdit, data = null) {
                const form = $(`#${formName}`);
                const submitButton = $('#submit-btn');

                // Helper function to set the form action and method
                const setFormActionAndMethod = (actionUrl, method) => {
                    form.attr('action', actionUrl);
                    if (method) {
                        form.append(`<input type="hidden" name="_method" value="${method}">`);
                    } else {
                        form.find('input[name="_method"]').remove();
                    }
                };

                // Helper function to update button text
                const updateSubmitButtonText = (text) => {
                    submitButton.text(text);
                };

                // Update the form fields
                const updateFormFields = (data) => {
                    setValueByName('is_edit', isEdit ? 1 : 0);
                    setValueByName('name', data?.name || '');
                    setValueByName('description', data?.description || '');
                    setValueByName('number_of_days', data?.number_of_days || '');
                };

                if (isEdit && data) {
                    setFormActionAndMethod(`{{ url('leave/leave-type') }}/${data.id}`, 'PUT');
                    updateSubmitButtonText('Update Leave Type');
                    updateFormFields(data);
                } else {
                    setFormActionAndMethod('{{ route('leave-type.store') }}');
                    updateSubmitButtonText('Add Leave Type');
                    clearForm(formName); // Clear form fields for a fresh entry
                }

                // Show the modal
                $('#LeaveTypeModal').modal('show');
            }

            function submitBtn() {
                if (getValue('is_edit')) {
                    update();
                } else {
                    store();
                }
            }

            function store() {
                sLoading('sbtBtn')
                var form = document.getElementById(formName);
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                const options = {
                    contentType: 'multipart/form-data',
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
                        if (response.status) {
                            $(`#${formName} :input`).val("");
                            eLoading('sbtBtn')
                            refreshContent('{{ url('leave/leave-type') }}', 'leave-type-card-area');
                            closeModal('LeaveTypeModal');
                            alertNotify(response.message, 'success')
                        } else {
                            associateErrors(response.errors, formName);
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
                var form = document.getElementById(formName);
                var url = form.getAttribute('action');
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
                            refreshContent('{{ url('leave/leave-type') }}', 'leave-type-card-area');
                            closeModal('LeaveTypeModal');
                            alertNotify(response.message, 'success')
                            eLoading('sbtBtn')
                        } else {
                            associateErrors(response.errors, formName);
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
