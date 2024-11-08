@props([
    'name' => '',
    'id',
    'label' => '',
    'class' => '',
    'value' => '',
    'required' => false,
    'items' => [],
    'itemText' => '',
    'itemValue' => '',
    'textJoin' => '',
])

@php
    $className = 'form-control select2 w-50 ' . $class;
    $idName = $id ?? $name;
    $isRequired = $required ? 'required' : '';
@endphp

<label>{{ $label }}</label>
{{-- <div id="ckeditor-classic">
    <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton.
        Material composition is 100% organic cotton. This is one of the
        world’s leading designer lifestyle brands and is internationally
        recognized for celebrating the essence of classic American cool
        style, featuring preppy with a twist designs.</p>
    <ul>
        <li>Full Sleeve</li>
        <li>Cotton</li>
        <li>All Sizes available</li>
        <li>4 Different Color</li>
    </ul>
</div> --}}

{{-- <textarea class="form-control mt-4" id="{{ $idName }}" rows="5" name="{{ $name }}">{{ $value }}</textarea> --}}
<textarea class="form-control mt-4" id="{{ $idName }}" rows="5" name="{{ $name }}">{!! $value !!}</textarea>
