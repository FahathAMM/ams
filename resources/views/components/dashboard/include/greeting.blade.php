@php
    $currentUser = currentUser();
@endphp

<div class="d-flex align-items-lg-center flex-lg-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-16 mb-1">{{ getGreeting() }}, {{ ucwords($currentUser->full_name) ?? '' }}!</h4>
        <p class="text-muted mb-0">
            Here's what's happening with your store today.
        </p>
    </div>
</div>
