<script src="https://cdn.lordicon.com/lordicon.js"></script>

@props([
    'title' => 'data',
    'msg' => 'Sorry! No Result Found',
])

<div class="noresult" style="display: block;">
    <div class="text-center">
        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a"
            style="width:75px;height:75px"></lord-icon>
        <h5 class="mt-2">{{ $msg }}</h5>
        <p class="text-muted mb-0">We couldn’t find any {{ $title }} for this order. .</p>
    </div>
</div>
