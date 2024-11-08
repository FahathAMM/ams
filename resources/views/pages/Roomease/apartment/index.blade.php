@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="row" id="role-card-area">
                @foreach ($apartments as $apt)
                    <div class="col-xxl-3 col-md-4">
                        <x-card.card-apartment :apartmentName="$apt->name" color="warning" :apartmentId="$apt->id" :item="$apt"
                            per="administration-role-edit" />
                    </div>
                @endforeach
                <div class="col-xxl-3 col-md-4">
                    <x-card.card-add-apartment color="success" btnTarget="ApartmentModal" />
                </div>
            </div>

            {{-- add Apartment  modal --}}
            <x-modal.common titleName="Add Apartment" idName="ApartmentModal" size="modal-lg">
                <form action="{{ route('apartment.store') }}" method="POST" id="apartment-form" class="tablelist-form"
                    autocomplete="off">
                    @csrf
                    <input type="hidden" name="is_edit" id="is_edit">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Apartment Name" name="name"
                                    placeholder="Enter your Apartment Name" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Apartment Aaddress" name="address"
                                    placeholder="Enter your Apartment Aaddress" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Apartment Floor" name="floors"
                                    placeholder="Enter your Apartment Floor" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.select-group-js name="has_parking" label="Parking" itemText="name"
                                    itemValue="value" :items="[['name' => 'Yes', 'value' => '1'], ['name' => 'No', 'value' => '0']]" />
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

            // function ApartmentModal(isEdit, data = null) {

            //     if (isEdit && data) {
            //         $('#apartment-form').attr('action', '{{ url('roomease/apartment') }}/' + data.id);
            //         $('#apartment-form').append('<input type="hidden" name="_method" value="PUT">');
            //         $('#submit-btn').text('Update Apartment');

            //         setValueByName('is_edit', isEdit)
            //         setValueByName('name', data.name)
            //         setValueByName('address', data.address)
            //         setValueByName('floors', data.floors)
            //         setValueByName('description', data.description)
            //         updateSelectedValue(data.has_parking);

            //     } else {
            //         setValueByName('is_edit', 0)
            //         $('#apartment-form').attr('action', '{{ route('apartment.store') }}');
            //         $('#apartment-form').find('input[name="_method"]').remove();
            //         $('#submit-btn').text('Add Apartment');

            //         // Clear form fields for a fresh entry
            //         updateSelectedValue(1);
            //         clearForm('apartment-form')
            //     }
            //     $('#ApartmentModal').modal('show');
            // }

            function ApartmentModal(isEdit, data = null) {
                const form = $('#apartment-form');
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
                    setValueByName('address', data?.address || '');
                    setValueByName('floors', data?.floors || '');
                    setValueByName('description', data?.description || '');
                    updateSelectedValue(data?.has_parking);
                };

                if (isEdit && data) {
                    setFormActionAndMethod(`{{ url('roomease/apartment') }}/${data.id}`, 'PUT');
                    updateSubmitButtonText('Update Apartment');
                    updateFormFields(data);
                } else {
                    setFormActionAndMethod('{{ route('apartment.store') }}');
                    updateSubmitButtonText('Add Apartment');
                    clearForm('apartment-form'); // Clear form fields for a fresh entry
                    updateSelectedValue(1);
                }

                // Show the modal
                $('#ApartmentModal').modal('show');
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
                var form = document.getElementById('apartment-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);
                console.log(payload);

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
                        console.log('Success:', response.status);
                        if (response.status) {
                            $("#apartment-form :input").val("");
                            eLoading('sbtBtn')
                            // refreshContent('{{ url('administration/role') }}', 'role-card-area');
                            // closeModal('addRoleModal');
                            alertNotify(response.message, 'success')
                        } else {
                            associateErrors(response.errors, 'apartment-form');
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
                var form = document.getElementById('apartment-form');
                // var url = '{{ url('role') }}/' + roleId + '/edit';
                // var url = '{{ url('administration/role') }}/' + roleId;
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>


        <script>
            Push.create('Hello World!', {
                    timeout: 2000000,
                    requireInteraction: true,
                    body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, expedita.',
                    // onClick() {
                    //     location.href = "/";
                    // }
                })
                .catch(e => {
                    // alert('please enable notification')
                    console.log(e);
                })
        </script>
    @endpush
@endsection
