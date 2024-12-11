@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
        {{-- <link rel="stylesheet" href="https://dev1.routepro.cloud/bo/assets/css/dual-listbox.css"> --}}
        <link href="https://cdn.jsdelivr.net/npm/dual-listbox@1.0.9/dist/dual-listbox.css" rel="stylesheet" />
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="card" id="contactList">
                <div class="card-header py-2">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">{{ $title ?? '' }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="asset-assign-form" action="">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input.select-group label="Employee" name="employee_id" itemText="full_name"
                                    itemValue="id" :items="$employees" data-choices-search-true groupStyle="width:91.5%;"
                                    onchange="getAssetsByEmployee(this.value)" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <select id="aseetsBox" class="select1">
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <button type="button" onclick="store()" class="btn btn-success w-sm">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/dual-listbox@1.0.9/dist/dual-listbox.min.js"></script>
    @push('scripts')
        <script>
            $('document').ready(function() {
                genereteMultiSelection();
            });

            const selectedAssetsArr = [];
            let assignAssets = [];

            function genereteMultiSelection(assets = []) {

                let notAssignCoun = assets.filter((e) => {
                    return e.selected == 0
                })

                assignAssets = assets.filter((e) => {
                    return e.selected == 1
                })
                let count = assets.length > 0 ? assets.length : '';

                new DualListbox(".select1", {
                    availableTitle: "Asset List " + count,
                    selectedTitle: "Selected Asset",
                    addButtonText: '<i class="fa fa-angle-right ms-fs"></i>',
                    removeButtonText: '<i class="fa fa-angle-left ms-fs"></i>',
                    addAllButtonText: '<i class="fa fa-angle-double-right ms-fs"></i>',
                    removeAllButtonText: '<i class="fa fa-angle-double-left ms-fs"></i>',
                    sortable: true,
                    upButtonText: "ᐱ",
                    downButtonText: "ᐯ",
                    draggable: true,
                    options: assets,
                    addEvent: function(value) {
                        selectedAssetsArr.push(value);
                    },
                    removeEvent: function(value) {
                        console.log('removeEvent', value);
                        console.log(assignAssets);

                        const index = assignAssets.findIndex(asset => asset.value === Number(value));

                        console.log('index', index);

                        if (index !== -1) {
                            assignAssets.splice(index, 1);
                        }
                        console.log('Updated assignEodEmployees:', assignAssets);
                    },
                });
            }


            function store() {

                let assignAssetsIds = assignAssets.map(e => e.value)
                console.log('assignAssetsIds:', assignAssetsIds);

                let selectedAssetsArrAll = [
                    ...assignAssetsIds,
                    ...selectedAssetsArr,
                ];

                if (selectedAssetsArrAll.length == 0) {
                    alertNotify('Please select asset', 'error')
                    return;
                }

                // sLoading('sbtBtn')
                var url = '{{ url('assets/store-asset-assign') }}';
                var payload = {
                    selectedAssetsArr: selectedAssetsArrAll,
                    employee_id: getValue('employee_id')
                };
                const options = {
                    contentType: 'application/json',
                    method: 'POST',
                    headers: {
                        'dataType': "json",
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        if (response.status) {
                            console.log(response);
                            associateErrors('', 'asset-assign-form');
                            alertNotify(response.message, 'success')
                        } else {
                            // eLoading('sbtBtn')
                            associateErrors(response.errors, 'asset-assign-form');
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            function getAssetsByEmployee(employeeId) {
                let url = "{{ url('assets/asset-assign-by-employee') }}";
                var payload = {
                    employeeId: employeeId,
                };
                let res = ajaxRequest(url, payload, 'GET');

                let assets = res.record.assets
                console.log(assets);
                $(".dual-listbox.aseetsBox").remove();
                genereteMultiSelection(assets);

            }

            function appendToSelect(arr, id, text, val, extra = "") {
                var selectElement = $(`#${id}`);
                selectElement.find('option').not(':first').remove();
                $.each(arr, function(index, item) {
                    selectedAssetsArr.push(item);
                    var option = $('<option></option>').val(item[val]).text(item[text]);
                    if (extra) {
                        option.text(item[val]).text(item[extra] + ' - ' + item[text]);
                        // option.text(option.text() + ' - ' + item[extra]);
                    }
                    selectElement.append(option);
                });
            }
        </script>
    @endpush

    <style>
        .dual-listbox .dual-listbox__search {
            max-width: 45% !important
        }

        .dual-listbox__container>div:first-child,
        .dual-listbox__container>div:last-child {
            width: 45% !important;
        }

        .dual-listbox__container>div:nth-child(2) {
            width: 8%;
        }

        .dual-listbox__available,
        .dual-listbox__selected {
            width: 100% !important;
        }

        .dual-listbox .dual-listbox__button:hover {
            /* background-color: #ddd; */
            color: black;
            background-color: #9fa2a7 !important;
            border-color: #9fa2a7;
        }

        .dual-listbox .dual-listbox__button {
            background-color: #e1e1e3 !important;
            color: #fff;
            display: inline-block;
            font-weight: 400;
            /* width: 143px; */
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            border: 1px solid #f5f6f8;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            margin: 10px 0px;
            padding: 10px 0;
            font-size: 15px;
        }
    </style>
@endsection
