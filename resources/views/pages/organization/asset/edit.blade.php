@extends('layout.app')
@section('title', $title)
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
                display: block;
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
            {{-- @dd($asset) --}}

            <form id="asset-form" method="POST" action="{{ route('asset.update', ['asset' => $asset->id]) }}"
                autocomplete="off" class="needs-validation1" novalidate1 enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Asset Name" name="name"
                                                placeholder="Enter your Asset name" value="{{ $asset->name ?? '' }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Serial Number" name="serial_number"
                                                placeholder="Enter your Serial Number"
                                                value="{{ $asset->serial_number ?? '' }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Warranty Info" name="warranty_nfo"
                                                placeholder="Enter your Warranty Info"
                                                value="{{ $asset->warranty_nfo ?? '' }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-input.select-group label="Condition" name="condition" itemText="name"
                                                itemValue="value" :items="[
                                                    ['name' => 'Good', 'value' => 'good'],
                                                    ['name' => 'Average', 'value' => 'average'],
                                                    ['name' => 'Poor', 'value' => 'poor'],
                                                ]" data-choices-search-false
                                                value="{{ $asset->condition ?? '' }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <x-input.ckeditor id="new-content" name="description"
                                            value="{{ $asset->description ?? '' }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <p class="text-muted mb-2">
                                    <button type="button" id="newRow"
                                        class="float-end add-row btn fw-medium btn-soft-secondary">
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
                                                @foreach ($asset->attributes as $attr)
                                                    <tr id="1" class="product">
                                                        <td class="text-start py-0 w-50">
                                                            <div class="mb-0">
                                                                <x-input.select-group name="attribute[]" itemText="name"
                                                                    itemValue="id" :items="$attributes" :value="$attr->id" />
                                                            </div>
                                                        </td>
                                                        <td class="py-0">
                                                            <div>
                                                                <x-input.txt-group name="value[]"
                                                                    placeholder="Enter your  attribute value"
                                                                    :value="$attr->pivot->value" />
                                                            </div>
                                                        </td>
                                                        <td class="product-removal py-0">
                                                            <a href="javascript:void(0)" class="btn btn-danger remove-row">
                                                                <i class="ri-delete-bin-5-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Asset Gallery</h5>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    {{-- {{ $asset->img }} --}}
                                    <x-input.img name="img" oldImg="{{ $asset->img ?? '' }}" />
                                </div>
                            </div>
                        </div>

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
                                    <x-input.select-group label="Status" name="is_active" itemText="name" itemValue="value"
                                        :items="[
                                            ['name' => 'Active', 'value' => '1'],
                                            ['name' => 'Deactive', 'value' => '0'],
                                        ]" data-choices-search-false value="1"
                                        value="{{ $asset->is_active ?? '' }}" />
                                </div>
                                <div>
                                    <label for="datepicker-publish-input" class="form-label">Issue Date </label>
                                    <input name="issue_date" type="text" id="datepicker-publish-input"
                                        class="form-control" placeholder="Enter publish date" data-provider="flatpickr"
                                        data-date-format="Y-m-d" value="{{ $asset->issue_date ?? '' }}">
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card d-none">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Assign Employee</h5>
                            </div>
                            <!-- end card body -->
                            <div class="card-body">
                                <div>
                                    <x-input.select-group label="Employees" name="employee_id" itemText="full_name"
                                        itemValue="id" :items="$employees" data-choices-search-true
                                        value="{{ $asset->employee_id ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Asset Categories</h5>
                            </div>
                            <div class="card-body">
                                <x-input.select-group label="Categories" name="category_id" itemText="name"
                                    itemValue="id" :items="$assetCategories" data-choices-search-true
                                    value="{{ $asset->category_id ?? '' }}" />
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
                                        <input class="form-control" name="tags[]" data-choices
                                            data-choices-multiple-remove="true" placeholder="Enter tags" type="text"
                                            value="{{ $asset->tags[0] ?? '' }}" />
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
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


        <!-- ckeditor -->
        <script>
            $('document').ready(function() {

                let i = 1;

                $(document).on('click', '.add-row', function() {
                    let name = `attribute${i}`;
                    var newRow = `
                    <tr class="product">
                        <td class="text-start py-0 w-50">
                            <div class="mb-0">
                                <x-input.select-group name="attribute[]" id="${name}" itemText="name"
                                    itemValue="id" :items="$attributes" />
                            </div>
                        </td>
                        <td class="py-0">
                            <div>
                                <x-input.txt-group name="value[]"
                                    placeholder="Enter your attribute value" />
                            </div>
                        </td>
                        <td class="product-removal py-0">
                            <a href="javascript:void(0)" class="btn btn-danger remove-row">
                                <i class="ri-delete-bin-5-line"></i>
                            </a>
                        </td>
                    </tr>`;

                    $('#newlink').append(newRow);

                    setTimeout(() => {
                        const element = document.querySelector(`#${name}`);
                        const choices = new Choices(element);
                    }, 100);
                    i++;
                });

                $(document).on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                });

                var ckClassicEditor = document.querySelectorAll("#new-content")
                ckClassicEditor.forEach(function() {
                    ClassicEditor
                        .create(document.querySelector('#new-content'))
                        .then(function(editor) {
                            editor.ui.view.editable.element.style.height = '200px';
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                });

            });

            function store() {
                $('#new-content').html($('.ck-content').html());
                var form = document.getElementById('asset-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                // payload.append('img', document.getElementById('selectImage').files[0]);

                var profileImgInput = document.getElementById('selectImage');

                if (profileImgInput.files.length > 0) {
                    payload.append('img', profileImgInput.files[0]);
                }

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
                        if (response.status) {
                            alertNotify(response.message, 'success')
                        } else {
                            associateErrors(response.errors, 'asset-form');
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }
        </script>
    @endpush
@endsection
