@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="row" id="room-card-area">
                @foreach ($rooms as $room)
                    <div class="col-xxl-3 col-md-4">
                        <x-card.card-room :RoomName="$room->room_number" color="warning" :RoomId="$room->id" :item="$room"
                            per="administration-role-edit" />
                    </div>
                @endforeach
                <div class="col-xxl-3 col-md-4">
                    <x-card.card-add-room color="success" btnTarget="RoomModal" />
                </div>
            </div>

            {{-- add Room  modal --}}
            <x-modal.common titleName="Add Room" idName="RoomModal" size="modal-lg">
                <form action="{{ route('room.store') }}" method="POST" id="room-form" class="tablelist-form"
                    autocomplete="off">
                    @csrf
                    <input type="hidden" name="is_edit" id="is_edit">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Room Number" name="room_number"
                                    placeholder="Enter your Room Name" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.select-group-js name="apartment_id" label="Apartment" itemText="name"
                                    itemValue="id" :items="$apartments" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.txt-group label="Room Floor" name="floor" placeholder="Enter your Room Floor" />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <x-input.select-group-js name="type" id="room_type" label="Type" itemText="name"
                                    itemValue="value" :items="[
                                        ['name' => 'Family', 'value' => 'Family'],
                                        ['name' => 'Bachelor', 'value' => 'Bachelor'],
                                    ]" />
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
        <script>
            $(function() {
                const element = document.querySelector('.dataTables_length label select');
                if (element) {
                    const choices = new Choices(element, {
                        searchEnabled: false
                    });
                }
            });

            let formName = 'room-form';

            function RoomModal(isEdit, data = null) {
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
                    setValueByName('room_number', data?.room_number || '');
                    setValueByName('floor', data?.floor || '');
                    setValueByName('description', data?.description || '');
                    // https://chatgpt.com/share/675346c3-967c-8001-a8da-b5fcd699b7c1

                    updateSelectedValue('apartment_id', data.apartment_id)
                    updateSelectedValue('room_type', data.type)

                };

                if (isEdit && data) {
                    setFormActionAndMethod(`{{ url('roomease/room') }}/${data.id}`, 'PUT');
                    updateSubmitButtonText('Update Apartment');
                    updateFormFields(data);
                } else {
                    setFormActionAndMethod('{{ route('room.store') }}');
                    updateSubmitButtonText('Add Room');
                    clearForm(formName);
                }

                // Show the modal
                $('#RoomModal').modal('show');
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
                            $(`#${formName } :input`).val("");
                            // $("#apartment-form :input").val("");
                            eLoading('sbtBtn')
                            refreshContent('{{ url('roomease/room') }}', 'room-card-area');
                            closeModal('RoomModal');
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
                            refreshContent('{{ url('roomease/room') }}', 'room-card-area');
                            closeModal('RoomModal');
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>

        <script>
            Push.create('Hello World!', {
                timeout: 2000000,
                requireInteraction: true,
                body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, expedita.',
                // onClick() {
                //     location.href = "/";
                // }
            }).catch(e => {
                // alert('please enable notification')
                console.log(e);
            })
        </script>
    @endpush
@endsection
