@extends('layout.app')
@section('content')
    @push('styles')
        <style>
            table.dataTable tr {
                border: 2px solid #dbdade;
            }

            table.dataTable {
                border-top: 1px solid #dbdade;
                border-right: 1px solid #dbdade;
                border-left: 1px solid #dbdade;
            }

            /* Style for the file input container */
            .file-input-container {
                position: relative;
                width: 200px;
                height: 100px;
                overflow: hidden;
                background-color: white;
                color: black;
                border-radius: 5px;
                cursor: pointer;
            }

            /* Style for the actual file input (opacity set to 0 to make it invisible) */
            .file-input-container input {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            /* Style for the text inside the file input container */
            .file-input-text {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
            }

            /* Style for the preview image */
            #preview {
                display: none;
                /* max-width: 100%; */
                /* height: auto; */
                border-radius: 5px;
                width: 100px;
                height: 50px;
            }

            .dropzone {
                min-height: 120px !important;
            }
        </style>
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            {{-- <x-breadcrumb title="Assets" parent="Page" /> --}}

            <form id="asset-form" method="POST" action="{{ route('asset.store') }}" autocomplete="off" class="needs-validation1"
                novalidate1 enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Asset Name" name="name"
                                                placeholder="Enter your Asset name" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Serial Number" name="serial_number"
                                                placeholder="Enter your Serial Number" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Warranty Info" name="warranty_nfo"
                                                placeholder="Enter your Warranty Info" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.select-group label="Condition" name="condition" itemText="name"
                                                itemValue="value" :items="[
                                                    ['name' => 'Good', 'value' => 'good'],
                                                    ['name' => 'Average', 'value' => 'average'],
                                                    ['name' => 'Poor', 'value' => 'poor'],
                                                ]" data-choices-search-false />
                                        </div>
                                    </div>
                                    <div>
                                        <x-input.ckeditor id="content" name="description" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        {{-- attribute  --}}
                        <div class="card">
                            <div class="card-header">
                                <p class="text-muted mb-2">
                                    <button type="button" id="newRow"
                                        class="float-end  btn fw-medium btn-soft-secondary">
                                        <i class="ri-add-fill me-1 align-bottom"></i>
                                        Add New
                                    </button>
                                <h5 class="card-title mb-0">Asset Attributes</h5>
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">

                                    <div class="table-responsivew">
                                        <table class="invoice-table table table-borderless table-nowrap mb-0">
                                            <tbody id="newlink">
                                                <tr id="1" class="product">
                                                    <td class="text-start py-0 w-50">
                                                        <div class="mb-0">
                                                            <x-input.select-group name="attribute" itemText="name"
                                                                itemValue="id" :items="$attributes" data-choices-search-true />

                                                            {{-- <select name="df" id="">
                                                                <option value="">dfsdf</option>
                                                                <option value="">dfsdf</option>
                                                                <option value="">dfsdf</option>
                                                                <option value="">dfsdf</option>
                                                                <option value="">dfsdf</option>
                                                                <option value="">dfsdf</option>
                                                            </select> --}}

                                                        </div>
                                                    </td>
                                                    <td class="py-0">
                                                        <div>
                                                            <x-input.txt-group name="value[]"
                                                                placeholder="Enter your  attribute value" />
                                                        </div>
                                                    </td>
                                                    <td class="product-removal py-0">
                                                        <a href="javascript:void(0)" class="btn btn-success">
                                                            <i class=" bx bx-plus-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- attribute  --}}

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Asset Gallery</h5>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    <x-input.img name="img" />
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"
                                            role="tab">
                                            General Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                                            Meta Data
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- end card header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="manufacturer-name-input">Manufacturer
                                                        Name</label>
                                                    <input type="text" class="form-control" id="manufacturer-name-input"
                                                        placeholder="Enter manufacturer name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="manufacturer-brand-input">Manufacturer
                                                        Brand</label>
                                                    <input type="text" class="form-control"
                                                        id="manufacturer-brand-input"
                                                        placeholder="Enter manufacturer brand">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="stocks-input">Stocks</label>
                                                    <input type="text" class="form-control" id="stocks-input"
                                                        placeholder="Stocks">
                                                    <div class="invalid-feedback">Please Enter a product stocks.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="product-price-input">Price</label>
                                                    <div class="input-group has-validation mb-3">
                                                        <span class="input-group-text" id="product-price-addon">$</span>
                                                        <input type="text" class="form-control"
                                                            id="product-price-input" placeholder="Enter price"
                                                            aria-label="Price" aria-describedby="product-price-addon">
                                                        <div class="invalid-feedback">Please Enter a product
                                                            price.</div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="product-discount-input">Discount</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"
                                                            id="product-discount-addon">%</span>
                                                        <input type="text" class="form-control"
                                                            id="product-discount-input" placeholder="Enter discount"
                                                            aria-label="discount"
                                                            aria-describedby="product-discount-addon">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="orders-input">Orders</label>
                                                    <input type="text" class="form-control" id="orders-input"
                                                        placeholder="Orders">
                                                    <div class="invalid-feedback">Please Enter a product orders.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end tab-pane -->

                                    <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="meta-title-input">Meta
                                                        title</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter meta title" id="meta-title-input">
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="meta-keywords-input">Meta
                                                        Keywords</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter meta keywords" id="meta-keywords-input">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->

                                        <div>
                                            <label class="form-label" for="meta-description-input">Meta
                                                Description</label>
                                            <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                </div>
                                <!-- end tab content -->
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="button" onclick="store()" class="btn btn-success w-sm">Submit</button>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Publish</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <x-input.select-group label="Status" name="status" itemText="name"
                                        itemValue="value" :items="[
                                            ['name' => 'Active', 'value' => '1'],
                                            ['name' => 'Deactive', 'value' => '0'],
                                        ]" data-choices-search-false />

                                </div>

                                <div>
                                    <label for="datepicker-publish-input" class="form-label">Issue Date </label>
                                    <input type="text" id="datepicker-publish-input" class="form-control"
                                        placeholder="Enter publish date" data-provider="flatpickr"
                                        data-date-format="d-m-Y">
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Assign Employee</h5>
                            </div>
                            <!-- end card body -->
                            <div class="card-body">
                                <div>
                                    <x-input.select-group label="Employees" name="user_id" itemText="full_name"
                                        itemValue="id" :items="$employees" data-choices-search-true />
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Asset Categories</h5>
                            </div>
                            <div class="card-body">
                                <x-input.select-group label="Categories" name="category" itemText="name" itemValue="id"
                                    :items="$assetCategories" data-choices-search-true />
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Asset Tags</h5>
                            </div>
                            <div class="card-body">
                                <div class="hstack gap-3 align-items-start">
                                    <div class="flex-grow-1">
                                        <input class="form-control" name="tags" data-choices
                                            data-choices-multiple-remove="true" placeholder="Enter tags" type="text"
                                            value="Cotton" />
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product Short Description</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-2">Add short description for product</p>
                                <textarea class="form-control" placeholder="Must enter minimum of a 100 characters" rows="3"></textarea>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </form>

        </div>
        <!-- container-fluid -->
    </div>

    @push('scripts')
        <script src="{{ url('/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
        {{-- <script src="{{ url('/assets/js/pages/ecommerce-product-create.init.js') }}"></script> --}}
        <!-- ckeditor -->
        <script>
            $('document').ready(function() {});

            function store() {
                var form = document.getElementById('asset-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                payload.append('img', document.getElementById('selectImage').files[0]);


                const options = {
                    // contentType: 'application/json',
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
                        console.log('Success:', response);
                        if (false) {
                            // if (response.status) {
                            // associateReset('employee-form');
                            // $("#employee-form :input").val("");
                        } else {
                            associateErrors(response.errors, 'asset-form');
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            var ckClassicEditor = document.querySelectorAll("#content")
            ckClassicEditor.forEach(function() {
                ClassicEditor
                    .create(document.querySelector('#content'))
                    .then(function(editor) {
                        editor.ui.view.editable.element.style.height = '200px';
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            });


            var rowCount = 1;

            // Function to add a new row
            function addNewRow() {

                // i++;
                // $('#dynamic_field').append('<tr id="row' + i +
                //     '" class="dynamic-added"> <
                //     td > < input type = "text"
                //     name = "name[]"
                //     placeholder = "Enter your Name"
                //     class = "form-control name_list" / > < /td> <
                //     td > < button type = "button"
                //     name = "remove"
                //     id = "' +
                //     i + '" class="btn btn-danger btn_remove">X</button></td></tr>');




                new Choices('#attribute', {
                    placeholderValue: "This is a placeholder set in the config",
                    searchPlaceholderValue: "This is a search placeholder",
                });

            }

            // Event handler for the button click
            $('#newRow').click(function() {
                console.log('ff');
                addNewRow();
            });
        </script>
    @endpush
@endsection
