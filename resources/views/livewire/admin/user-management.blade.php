<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            <button wire:click="create()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 transition duration-150 ease-in-out">สร้างผู้ใช้ใหม่</button>

    <!-- Create/Edit Modal -->
    @if($isOpen)
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mb-4">
                                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" placeholder="Enter Username" wire:model="username">
                                @error('username') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">อีเมล:</label>
                                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" placeholder="กรอกอีเมล" wire:model="email">
                                @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">รหัสผ่าน:</label>
                                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" placeholder="เว้นว่างไว้หากไม่ต้องการเปลี่ยนรหัสผ่าน" wire:model="password">
                                @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">ยืนยันรหัสผ่านใหม่:</label>
                                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" placeholder="ยืนยันรหัสผ่านใหม่" wire:model="password_confirmation">
                            </div>
                            <div class="mb-4">
                                <label for="selectedRole" class="block text-gray-700 text-sm font-bold mb-2">บทบาท:</label>
                                <select wire:model="selectedRole" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="selectedRole">
                                    <option value="">เลือกบทบาท</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedRole') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click.prevent="store()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            บันทึก
                        </button>
                        <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Users Table -->
    <div class="mt-8 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">อีเมล</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">บทบาท</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->username }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->roles->first()->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 hover:bg-indigo-100 border border-indigo-600 rounded px-3 py-1 transition duration-150 ease-in-out">Edit</button>
                            <button wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-900 hover:bg-red-100 ml-4 border border-red-600 rounded px-3 py-1 transition duration-150 ease-in-out">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    @push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    title: 'Success!',
                    text: event.message,
                    icon: 'success',
                });
            });

            Livewire.on('swal:confirm', (event) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: event.message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-confirmed', { userId: event.id })
                    }
                });
            });
        });
    </script>
    @endpush
</div>
        </div>
    </div>
</div>