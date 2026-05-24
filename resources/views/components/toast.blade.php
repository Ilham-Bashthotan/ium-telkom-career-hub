<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Position toast below the fixed header */
    .swal2-container.swal2-top-end {
        top: 85px !important;
        right: 20px !important;
    }
</style>
<script>
    // SweetAlert2 Toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Show flash messages
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        });
    @endif

    @if(session('info'))
        Toast.fire({
            icon: 'info',
            title: '{{ session('info') }}'
        });
    @endif

    @if(session('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session('warning') }}'
        });
    @endif

    @if($errors->any())
        Toast.fire({
            icon: 'error',
            title: '{{ $errors->first() }}'
        });
    @endif
</script>
