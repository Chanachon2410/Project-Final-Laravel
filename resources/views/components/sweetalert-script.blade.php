<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:success', ({ message }) => {
            Swal.fire({
                title: 'สำเร็จ!',
                text: message,
                icon: 'success',
                confirmButtonText: 'ตกลง'
            });
        });

        Livewire.on('swal:error', ({ message }) => {
            Swal.fire({
                title: 'เกิดข้อผิดพลาด!',
                text: message,
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
        });
    });
</script>
