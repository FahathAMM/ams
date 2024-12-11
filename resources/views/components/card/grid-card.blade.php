@props([
    'titleName' => '',
    'height' => '235px',
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'card ' . $class]) }}>
    <div class="card-header align-items-center d-flex border-bottom-dashed">
        <h4 class="card-title mb-0 flex-grow-1">{{ $titleName ?? '' }}</h4>
    </div>

    <div class="card-body">
        <div data-simplebar style="{{ $height }}">
            {{ $slot }}
        </div>
    </div>
</div>
