@props(['isAdd' => false, 'routeName', 'title'])

@php
    $className =
        'btn btn-primary buttons-excel buttons-html5 bg-primary text-white border-primary add-btn waves-effect waves-light';
    $style = session('lang') == 'ar' ? '' : 'margin: 0 2.9px 0px 4px;';

@endphp
@if ($isAdd)
    <a {{ $attributes->merge(['class' => $className]) }} style="{{ $style }}" href="{{ route($routeName) }}"
        title="Add {{ $title }}">
        <i class="fas fa-plus-circle fa-lg" style="font-size: 12px;"></i>
    </a>
@endif



{{-- <button class="btn btn-success" id="custom-search-btn">
    <i class="fas fa-plus-circle"></i>
</button> --}}
