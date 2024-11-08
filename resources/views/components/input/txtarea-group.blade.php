@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
    'row' => '3',
    'id' => '',
    'value' => '',
])

@php
    $id = isset($id) ? $id : $name;
@endphp

<div class="form-group">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}"
        @if ($required) required @endif rows="{{ $row }}">{{ $value }}</textarea>
</div>
