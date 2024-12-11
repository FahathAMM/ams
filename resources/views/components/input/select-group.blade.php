@props([
    'name',
    'id',
    'label' => '',
    'class' => '',
    'value' => '',
    'required' => false,
    'items' => [],
    'itemText' => '',
    'itemValue' => '',
    'textJoin' => '',
    'placeholder' => 'Select',
    'groupStyle' => '',
])

@php
    $className = 'form-control select2 w-50 ' . $class;
    $idName = $id ?? $name;
    $isRequired = $required ? 'required' : '';

    $placeholder = $placeholder ? '-- ' . $placeholder . ' --' : $placeholder;

@endphp
<div class="form-group" style="{{ $groupStyle }}">
    @if (isset($label) && $label != '')
        <label for="{{ $name }}" id='{{ "lbl-$name" }}' for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($isRequired)
                <span class="text-danger mt-1">*</span> <!-- Show the asterisk if required -->
            @endif
        </label>
    @endif

    <select class="form-select" id="{{ $idName }}" name="{{ $name }}" {{ $className }} data-choices
        {{ $attributes }}>
        {{-- <option value="">-- {{ $placeholder }} --</option> --}}
        <option value=""> {{ $placeholder }}</option>
        @foreach ($items as $item)
            <option value="{{ $item[$itemValue] }}" @if ($item[$itemValue] == $value) selected @endif>
                @if (isset($item[$textJoin]))
                    {{ $item[$textJoin] }} -
                @endif
                {{ $item[$itemText] }}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback d-block invalid-msg"> </div>
</div>


<style>
    .choices {
        margin-bottom: 0px !important;
    }
</style>
