@props([
    'label' => '',
    'name' => 'is_active',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'size' => '',
])

<div>
    <label for="tasksTitle-field" class="form-label">{{ $label }}</label>
    <select class="form-control" data-choices name="{{ $name }}" id="{{ $name }}">
        <option value="">choose...</option>
        <option value="1" selected>Active</option>
        <option value="0">Deactivate</option>
    </select>
</div>
