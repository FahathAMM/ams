@props([
    'title' => ' ',
    'employee' => $employee,
])

@php
    $assets = $employee->assets;
@endphp

<div class="card">
    {{-- <pre>{{ json_encode($assets, JSON_PRETTY_PRINT) }}</pre> --}}

    <div class="card-body">
        <ul class="nav nav-pills nav-customs d-flex justify-content-center nav-danger mb-3" role="tablist">
            @forelse ($assets as $key => $ass)
                <li class="nav-item">
                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                        href="#asset-navs-{{ $ass['id'] }}" role="tab">
                        {{ ++$key }} - {{ $ass['name'] }}
                    </a>
                </li>
            @empty
                <x-notification.not-found msg="Sorry! No assets Found" title="assets" />
            @endforelse
        </ul>
        <div class="tab-content text-muted">
            @foreach ($assets as $key => $ass)
                <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="asset-navs-{{ $ass['id'] }}"
                    role="tabpanel">
                    <x-asset.show.asset-view :asset="$ass" />
                </div>
            @endforeach
        </div>



























        {{-- <!-- Nav tabs -->
        <ul class="nav nav-pills nav-customs nav-danger mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#border-navs-home" role="tab">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#border-navs-profile" role="tab">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#border-navs-messages" role="tab">Messages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#border-navs-settings" role="tab">Settings</a>
            </li>
        </ul><!-- Tab panes -->
        <div class="tab-content text-muted">
            <div class="tab-pane active" id="border-navs-home" role="tabpanel">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        Raw denim you probably haven't heard of them jean shorts Austin.
                        Nesciunt tofu stumptown aliqua, retro synth master cleanse.
                    </div>
                </div>
                <div class="d-flex mt-2">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        Too much or too little spacing, as in the example below, can make things
                        unpleasant for the
                        reader. The
                        goal is to make your text as comfortable to read as possible.
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="border-navs-profile" role="tabpanel">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        In some designs, you might adjust your tracking to create a certain artistic
                        effect. It can
                        also help
                        you fix fonts that are poorly spaced to begin with.
                    </div>
                </div>
                <div class="d-flex mt-2">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        A wonderful serenity has taken possession of my entire soul, like these sweet
                        mornings of
                        spring which I
                        enjoy with my whole heart.
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="border-navs-messages" role="tabpanel">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        Each design is a new, unique piece of art birthed into this world, and while you
                        have the
                        opportunity to
                        be creative and make your own style choices.
                    </div>
                </div>
                <div class="d-flex mt-2">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        For that very reason, I went on a quest and spoke to many different professional
                        graphic
                        designers and
                        asked them what graphic design tips they live.
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="border-navs-settings" role="tabpanel">
                <div class="d-flex mt-2">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        For that very reason, I went on a quest and spoke to many different professional
                        graphic
                        designers and
                        asked them what graphic design tips they live.
                    </div>
                </div>
                <div class="d-flex mt-2">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        After gathering lots of different opinions and graphic design basics, I came up
                        with a list
                        of 30
                        graphic design tips that you can start implementing.
                    </div>
                </div>
            </div>
        </div>
        <!--end row--> --}}
    </div>
    <!--end card-body-->
</div>

@push('styles')
    <style>
        .border {
            border-color: #b7b9bf !important;
        }
    </style>
@endpush
