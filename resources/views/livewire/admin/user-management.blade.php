<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">จัดการผู้ใช้งานระบบ</h2>
                <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 ease-in-out flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    สร้างผู้ใช้ใหม่
                </button>
            </div>

            <!-- Filters and Search (Registrar Style) -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex items-center space-x-4 w-full md:w-auto">
                    <div class="flex items-center">
                        <label for="perPage" class="text-sm text-gray-600 mr-2">แสดง:</label>
                        <select wire:model.live="perPage" id="perPage" class="text-sm rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center w-full md:w-auto">
                    <label for="search" class="text-sm text-gray-600 mr-2 hidden md:block">ค้นหา:</label>
                    <div class="relative w-full md:w-64">
                        <input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="Username, อีเมล..." class="w-full text-sm rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table (Registrar Style) -->
            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">อีเมล</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">บทบาท</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                        {{ $user->username }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->hasRole('admin') ? 'bg-red-100 text-red-800' : 
                                           ($user->hasRole('teacher') ? 'bg-green-100 text-green-800' : 
                                           ($user->hasRole('student') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ $user->roles->first()->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                    <button wire:click="view({{ $user->id }})" class="inline-flex items-center px-3 py-1 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white transition duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </button>
                                    <button wire:click="edit({{ $user->id }})" class="inline-flex items-center px-3 py-1 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $user->id }})" class="inline-flex items-center px-3 py-1 border border-red-600 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" wire:click="closeModal">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true">
                <form>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">
                            {{ $userId ? 'แก้ไขข้อมูลผู้ใช้' : 'สร้างผู้ใช้ใหม่' }}
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="username" class="block text-gray-700 text-sm font-bold mb-1">Username:</label>
                                <input type="text" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500" id="username" placeholder="Enter Username" wire:model="username">
                                @error('username') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-1">อีเมล:</label>
                                <input type="email" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500" id="email" placeholder="กรอกอีเมล" wire:model="email">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-1">รหัสผ่าน:</label>
                                <input type="password" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500" id="password" placeholder="{{ $userId ? 'เว้นว่างไว้หากไม่ต้องการเปลี่ยน' : 'รหัสผ่าน' }}" wire:model="password">
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-1">ยืนยันรหัสผ่าน:</label>
                                <input type="password" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500" id="password_confirmation" placeholder="ยืนยันรหัสผ่าน" wire:model="password_confirmation">
                            </div>
                            <div>
                                <label for="selectedRole" class="block text-gray-700 text-sm font-bold mb-1">บทบาท:</label>
                                <select wire:model="selectedRole" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500" id="selectedRole">
                                    <option value="">เลือกบทบาท</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedRole') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click.prevent="store()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
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

    <!-- View Profile Modal -->
    @if($isViewOpen && $viewingUser)
    <div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" wire:click="closeViewModal">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4 border-b pb-2 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">รายละเอียดโปรไฟล์ผู้ใช้</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $viewingUser->roles->first()->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-sm font-semibold text-gray-500 uppercase">Username:</div>
                            <div class="text-sm text-gray-900 col-span-2 font-mono font-bold">{{ $viewingUser->username }}</div>
                            
                            <div class="text-sm font-semibold text-gray-500 uppercase">อีเมล:</div>
                            <div class="text-sm text-gray-900 col-span-2">{{ $viewingUser->email }}</div>
                        </div>

                        @if($viewingUser->student)
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <h4 class="text-sm font-bold text-blue-700 mb-2 border-b border-blue-200 pb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                    ข้อมูลนักเรียน
                                </h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="text-xs font-bold text-gray-500">รหัสประจำตัว:</div>
                                    <div class="text-sm text-gray-900 col-span-2 font-bold">{{ $viewingUser->student->student_code }}</div>
                                    
                                    <div class="text-xs font-bold text-gray-500">ชื่อ-นามสกุล:</div>
                                    <div class="text-sm text-gray-900 col-span-2">
                                        {{ $viewingUser->student->title }}{{ $viewingUser->student->firstname }} {{ $viewingUser->student->lastname }}
                                    </div>

                                    <div class="text-xs font-bold text-gray-500">กลุ่มเรียน:</div>
                                    <div class="text-sm text-gray-900 col-span-2 font-semibold">
                                        {{ $viewingUser->student->classGroup->course_group_name ?? '-' }}
                                    </div>

                                    <div class="text-xs font-bold text-gray-500">ระดับชั้น:</div>
                                    <div class="text-sm text-gray-900 col-span-2">
                                        {{ $viewingUser->student->classGroup->level->name ?? '-' }} (ปีที่ {{ $viewingUser->student->classGroup->level_year ?? '-' }})
                                    </div>
                                </div>
                            </div>
                        @elseif($viewingUser->teacher)
                            <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-100">
                                <h4 class="text-sm font-bold text-green-700 mb-2 border-b border-green-200 pb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    ข้อมูลอาจารย์
                                </h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="text-xs font-bold text-gray-500">ชื่อ-นามสกุล:</div>
                                    <div class="text-sm text-gray-900 col-span-2 font-bold">
                                        {{ $viewingUser->teacher->title }}{{ $viewingUser->teacher->firstname }} {{ $viewingUser->teacher->lastname }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="closeViewModal()" type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                        ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: event.message,
                    icon: 'success',
                });
            });

            Livewire.on('swal:confirm', (event) => {
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: event.message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
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