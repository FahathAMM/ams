@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
    'row' => '3',
    'id' => null,
    'value' => '',
])

@php
    $id = $id == null ? $name : $id;
    // $id = isset($id) || $id != 'dd' ? $id : $name;
@endphp

<div class="form-group">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}"
        @if ($required) required @endif rows="{{ $row }}">{{ $value }}</textarea>
</div>
