@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
    'id' => null,
    'extraAttr' => '',
])

@php
    $className = 'form-control';
    $id = isset($id) ? $id : $name;
@endphp

<div class="form-group">

    @if (isset($label) && $label != '')
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger mt-1">*</span> <!-- Show the asterisk if required -->
            @endif
        </label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
        {{ $attributes->merge(['class' => $className]) }} placeholder="{{ $placeholder }}"
        @if ($required) required @endif autocomplete="off" />
    <div class="invalid-feedback d-block invalid-msg"> </div>
</div>
