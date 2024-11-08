@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
    'value' => '',
])


@php
    $value = $value ?? date('Y-m-d');
@endphp

@if (isset($label) && $label != '')
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
@endif

<input type="text" class="form-control" name="{{ $name }}" {{ $attributes->merge() }}>
