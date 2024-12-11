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
    <label for="{{ $name }}" id="lbl-{{ $name }}" class="form-label">
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
        (function() {
            const idName = '{{ $idName }}'; // Unique ID for this instance
            const searchEnabled = {{ $search ? 'true' : 'false' }}; // Convert PHP boolean to JS boolean

            // Initialize Choices instance for this select
            const selectElement = document.getElementById(idName);
            const choicesInstance = new Choices(selectElement, {
                searchEnabled: searchEnabled
            });

            // Optionally, expose a function to update selected value
            window[`updateSelectedValue_${idName}`] = function(value) {
                choicesInstance.setChoiceByValue(value.toString());
            };
        })();
    </script>
@endpush
