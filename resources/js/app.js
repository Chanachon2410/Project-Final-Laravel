import './bootstrap';
import 'sweetalert2/dist/sweetalert2.min.css';


import Swal from 'sweetalert2';



window.Swal = Swal;




document.addEventListener('livewire:init', () => {
    Livewire.on('user-saved', (event) => {
        Swal.fire({
            icon: 'success',
            title: event.message,
            showConfirmButton: false,
            timer: 1500
        });
    });

    Livewire.on('delete-user-confirmation', (event) => {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete-confirmed', { userId: event.userId })
            }
        })
    });

    Livewire.on('swal:confirm', (event) => {
        Swal.fire({
            title: event.message || 'ยืนยันการทำรายการ?',
            text: event.text || "คุณต้องการดำเนินการต่อหรือไม่?",
            icon: event.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete-confirmed', { id: event.id });
            }
        });
    });

    Livewire.on('swal:success', (event) => {
        Swal.fire({
            icon: 'success',
            title: event.message || 'สำเร็จ',
            showConfirmButton: false,
            timer: 1500
        });
    });
});
