@props([
    'label' => 'Drop files here or click to upload',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
    'oldImg' => '',
])
@php
    $isEdit = $oldImg ? 'block' : 'none';
@endphp


<div class="dropzone">
    <div class="file-input-container dz-message needsclick text-center">
        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
        <h5 class="">{{ $label }}</h5>
        <input type="file" name="{{ $name }}" multiple id="selectImage">
    </div>
</div>

<ul class="list-unstyled mb-0 mt-4" id="dropzone-preview" style="display:{{ $isEdit }}">
    <li class="mt-2" id="dropzone-preview-list">
        <div class="border rounded previewImgArea">
            <div class="d-flex p-2">
                <div class="flex-shrink-0 me-3">
                    <div class="avatar-sm bg-light rounded">
                        <img data-dz-thumbnail class="img-fluid rounded d-block img-tag" id="preview"
                            src="{{ $oldImg ?? '' }}" alt="Product-Image" />
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="pt-1">
                        <h5 class="fs-14 mb-1" id="img-name">&nbsp;</h5>
                        <p class="fs-13 text-muted mb-0" id="img-size"></p>
                        {{-- <strong class="error text-danger"
                            data-dz-errormessage>hello</strong> --}}
                    </div>
                </div>
                <div class="flex-shrink-0 ms-3">
                    <button type="button" id="removeImg" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </li>
</ul>


@push('scripts')
    <script src="{{ url('/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script>
        selectImage.onchange = evt => {
            dropzonePreview = document.getElementById('dropzone-preview');
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            dropzonePreview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                const fileSizeFormatted = convertBytesToSize(file.size);
                $('#img-name').html(file.name);
                $('#img-size').html(fileSizeFormatted);
                preview.src = URL.createObjectURL(file)
                $('.previewImgArea').show();
            }
        }

        removeImg.onclick = () => {
            // const removePreviewBtn = document.getElementById('removeImg');
            // preview.style.display = 'none';
            // dropzonePreview.style.display = 'none';
            selectImage.value = '';
            $('.previewImgArea').hide();
            $('#img-name').html('');
            $('#img-size').html('');
            $('.img-tag').attr('src', '');
        };

        function convertBytesToSize(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes === 0) return '0 Byte';
            const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
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
    </script>
@endpush
