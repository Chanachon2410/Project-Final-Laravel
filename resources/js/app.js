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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete-confirmed', { userId: event.userId })
            }
        })
    });

    Livewire.on('swal:confirm', (event) => {
        Swal.fire({
            title: event.message || 'Are you sure?',
            text: event.text || "You won't be able to revert this!",
            icon: event.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete-confirmed', { id: event.id });
            }
        });
    });

    Livewire.on('swal:success', (event) => {
        Swal.fire({
            icon: 'success',
            title: event.message,
            showConfirmButton: false,
            timer: 1500
        });
    });
});
