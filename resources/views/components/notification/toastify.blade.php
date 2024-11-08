<div>
    @if (session()->has('success'))
        <script>
            alertNotify('{{ session('success') }}', 'success')
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            alertNotify('{{ session('success') }}', 'error')
        </script>
    @endif

    @if (session()->has('debug'))
        <script>
            alertNotify('Please scroll down for console', 'error')
        </script>
    @endif

    @if ($message = Session::get('debug'))
        <div id="successalert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="uil uil-check me-2"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif
</div>


<script>
    // function alertNotify(msg, status) {
    //     const arr = {
    //         success: 'success',
    //         error: 'danger',
    //         warning: 'info',
    //     }

    //     Toastify({
    //         text: msg || '',
    //         duration: 3000,
    //         newWindow: true,
    //         close: true,
    //         gravity: "top", // `top` or `bottom`
    //         position: "center", // `left`, `center` or `right`
    //         stopOnFocus: true, // Prevents dismissing of toast on hover
    //         className: arr[status],
    //         // style: {
    //         //     background: "linear-gradient(to right, #00b09b, #96c93d)",
    //         // },
    //         onClick: function() {} // Callback after click
    //     }).showToast();
    // }
</script>
