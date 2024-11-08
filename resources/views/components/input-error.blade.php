@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <small class="text-danger">{{ $message }}</small>
    @endforeach
@endif
