<script>
    // SweetAlert2 Toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
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
