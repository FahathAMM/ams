@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
    'value' => '',
])

{{-- <div class="form-group">
    <label for="tasksTitle-field" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control"
        placeholder="{{ $placeholder }}" @if ($required) required @endif />
    <div class="invalid-feedback d-block invalid-msg"> </div>
</div> --}}

@php
    $value = $value ?? date('Y-m-d');
@endphp

<label for="JoiningdatInput" class="form-label">{{ $label }}</label>
<input type="text" class="form-control" value="{{ $value }}" data-provider="flatpickr" id="{{ $name }}"
    data-date-format="Y-m-d" name="{{ $name }}" data-deafult-date="{{ $value }}"
    placeholder="{{ $placeholder }}" @if ($required) required @endif />
