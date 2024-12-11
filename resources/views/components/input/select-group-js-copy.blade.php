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

    $selectElement = $idName;

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
        // const selectElement = document.querySelector('#{{ $idName }}');
        // const choicesInstance = new Choices(selectElement, {
        //     searchEnabled: '{{ $search }}'
        // });

        // function updateSelectedValue(value) {
        //     choicesInstance.setChoiceByValue(value.toString());
        // }

        let idName = '{{ $idName }}';

        const selectElement = document.querySelector(`#${idName}`);
        const choicesInstance = new Choices(selectElement, {
            searchEnabled: '{{ $search }}'
        });

        function updateSelectedValue(value) {
            choicesInstance.setChoiceByValue(value.toString());
        }


        const selectElement1 = document.querySelector(`#${idName}`);
        const choicesInstance1 = new Choices(selectElement1, {
            searchEnabled: '{{ $search }}'
        });

        function updateSelectedValue(value) {
            choicesInstance1.setChoiceByValue(value.toString());
        }




        // let idName = '{{ $idName }}'; // e.g., "exampleId"
        // let selectElement = '{{ $selectElement }}'; // e.g., "dropdown"
        // let searchEnabled = '{{ $search }}' === 'true'; // Convert to boolean

        // // Create a container for dynamic variables
        // const dynamicVariables = {};

        // // Dynamically create and store the select element
        // dynamicVariables[`${selectElement}${idName}`] = document.querySelector(`#${idName}`);

        // // Dynamically create and store the Choices instance
        // dynamicVariables[`${selectElement}${idName}ChoicesInstance`] = new Choices(dynamicVariables[
        //     `${selectElement}${idName}`], {
        //     searchEnabled: searchEnabled
        // });

        // // Dynamically access the Choices instance to update selected value
        // function updateSelectedValue(value) {
        //     dynamicVariables[`${selectElement}${idName}ChoicesInstance`].setChoiceByValue(value.toString());
        // }
    </script>
@endpush
