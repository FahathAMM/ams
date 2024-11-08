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
    'search' => false,
])

@php
    $className = 'form-control select2 w-50 ' . $class;
    $idName = $id ?? $name;
    $isRequired = $required ? 'required' : '';

@endphp

@if (isset($label) && $label != '')
    <label for="{{ $name }}" id='{{ "lbl-$name" }}' for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>
@endif
<select id="{{ $idName }}" name="{{ $name }}" data-choices-search-false {{ $attributes }}>
    <option value="">-- {{ $placeholder }} --</option>
    @foreach ($items as $item)
        <option value="{{ $item[$itemValue] }}">
            {{ $item[$itemText] }}
        </option>
    @endforeach
</select>

@push('scripts')
    <script>
        const selectElement = document.querySelector('#{{ $idName }}');
        const choicesInstance = new Choices(selectElement, {
            searchEnabled: '{{ $search }}'
        });

        function updateSelectedValue(value) {
            choicesInstance.setChoiceByValue(value.toString());
        }
    </script>
@endpush
