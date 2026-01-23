<div>
    <div class="py-8 md:py-12 font-sans text-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section with Gradient -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 shadow-lg shadow-indigo-200 text-white p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl">
                </div>
                <div
                    class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-pink-500 opacity-20 blur-xl">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <span class="bg-white/20 p-2 rounded-xl">
                                <svg class="w-8 h-8 text-indigo-100" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </span>
                            จัดการผู้ใช้งานระบบ
                        </h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80 pl-14">บริหารจัดการบัญชีผู้ใช้
                            สิทธิ์การเข้าถึง และข้อมูลส่วนตัว</p>
                    </div>

                    <button wire:click="create()"
                        class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold py-2.5 px-5 rounded-xl border border-white/20 shadow-sm transition-all duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                        <span
                            class="bg-white text-indigo-600 rounded-lg p-1 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                        </span>
                        <span>สร้างผู้ใช้ใหม่</span>
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <!-- Filters & Controls -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <!-- PerPage -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-600 whitespace-nowrap">แสดง:</span>
                            <select wire:model.live="perPage" id="perPage"
                                class="bg-white border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-20 py-2 shadow-sm cursor-pointer transition-all">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="w-full md:w-80 flex gap-2">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" id="search" type="text"
                                placeholder="Username, อีเมล..."
                                class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-shadow">
                        </div>
                        <button wire:click="$refresh"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl shadow-md transition-colors flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modern Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Username</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    อีเมล</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    บทบาท</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($users as $user)
                                <tr class="hover:bg-violet-50/30 transition duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3 font-bold shadow-sm border border-indigo-200">
                                                {{ strtoupper(substr($user->username, 0, 1)) }}
                                            </div>
                                            <div class="text-sm font-bold text-gray-900">{{ $user->username }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border
                                            {{ $user->hasRole('admin')
                                                ? 'bg-red-100 text-red-800 border-red-200'
                                                : ($user->hasRole('teacher')
                                                    ? 'bg-green-100 text-green-800 border-green-200'
                                                    : ($user->hasRole('student')
                                                        ? 'bg-blue-100 text-blue-800 border-blue-200'
                                                        : ($user->hasRole('registrar')
                                                            ? 'bg-purple-100 text-purple-800 border-purple-200'
                                                            : 'bg-gray-100 text-gray-800 border-gray-200'))) }}">
                                            {{ $user->roles->first()->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button wire:click="view({{ $user->id }})"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="ดูข้อมูล">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button wire:click="edit({{ $user->id }})"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="แก้ไข">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $user->id }})"
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="ลบ">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-10 w-10 text-gray-300 mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                            <p>ไม่พบข้อมูลผู้ใช้งาน</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if ($isOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    wire:click="closeModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form>
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-violet-600 to-indigo-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="bg-white/20 p-1.5 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </span>
                                {{ $userId ? 'แก้ไขข้อมูลผู้ใช้' : 'สร้างผู้ใช้ใหม่' }}
                            </h3>
                        </div>

                        <div class="bg-white px-6 py-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="username"
                                        class="block text-gray-700 text-sm font-bold mb-1">Username</label>
                                    <input type="text" wire:model="username" id="username"
                                        class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="เช่น user01">
                                    @error('username')
                                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email"
                                        class="block text-gray-700 text-sm font-bold mb-1">อีเมล</label>
                                    <input type="email" wire:model="email" id="email"
                                        class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="example@email.com">
                                    @error('email')
                                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="selectedRole" class="block text-gray-700 text-sm font-bold mb-1">บทบาท
                                        (Role)</label>
                                    <select wire:model="selectedRole" id="selectedRole"
                                        class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        <option value="">เลือกบทบาท</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedRole')
                                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 mt-2">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">รหัสผ่าน
                                        {{ $userId ? '(ระบุเฉพาะถ้าต้องการเปลี่ยน)' : '' }}</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="password" wire:model="password" id="password"
                                                class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                placeholder="รหัสผ่าน">
                                            @error('password')
                                                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input type="password" wire:model="password_confirmation"
                                                id="password_confirmation"
                                                class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                placeholder="ยืนยันรหัสผ่าน">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2 rounded-b-2xl">
                            <button wire:click.prevent="store()" type="button"
                                class="inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-base font-bold text-white hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 sm:text-sm">
                                บันทึก
                            </button>
                            <button wire:click="closeModal()" type="button"
                                class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors sm:text-sm">
                                ยกเลิก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Profile Modal -->
    @if ($isViewOpen && $viewingUser)
        <div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    wire:click="closeViewModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 py-6">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-16 w-16 rounded-full bg-gradient-to-tr from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-2xl shadow-md">
                                    {{ strtoupper(substr($viewingUser->username, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $viewingUser->username }}</h3>
                                    <p class="text-sm text-gray-500">{{ $viewingUser->email }}</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-lg 
                            {{ $viewingUser->hasRole('admin')
                                ? 'bg-red-100 text-red-700'
                                : ($viewingUser->hasRole('teacher')
                                    ? 'bg-green-100 text-green-700'
                                    : ($viewingUser->hasRole('student')
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'bg-gray-100 text-gray-700')) }}">
                                {{ $viewingUser->roles->first()->name ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            @if ($viewingUser->student)
                                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 shadow-sm">
                                    <h4
                                        class="text-sm font-bold text-blue-800 mb-3 border-b border-blue-200 pb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                            </path>
                                        </svg>
                                        ข้อมูลนักเรียน
                                    </h4>
                                    <div class="grid grid-cols-1 gap-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-blue-600 font-medium">รหัสประจำตัว:</span>
                                            <span
                                                class="font-bold text-gray-800">{{ $viewingUser->student->student_code }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-600 font-medium">ชื่อ-นามสกุล:</span>
                                            <span
                                                class="font-bold text-gray-800">{{ $viewingUser->student->title }}{{ $viewingUser->student->firstname }}
                                                {{ $viewingUser->student->lastname }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-600 font-medium">กลุ่มเรียน:</span>
                                            <span
                                                class="font-bold text-gray-800">{{ $viewingUser->student->classGroup->course_group_name ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-600 font-medium">ระดับชั้น:</span>
                                            <span
                                                class="font-bold text-gray-800">{{ $viewingUser->student->classGroup->level->name ?? '-' }}
                                                (ปีที่
                                                {{ $viewingUser->student->classGroup->level_year ?? '-' }})</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif($viewingUser->teacher)
                                <div class="p-4 bg-green-50 rounded-xl border border-green-100 shadow-sm">
                                    <h4
                                        class="text-sm font-bold text-green-800 mb-3 border-b border-green-200 pb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        ข้อมูลอาจารย์
                                    </h4>
                                    <div class="grid grid-cols-1 gap-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-green-600 font-medium">ชื่อ-นามสกุล:</span>
                                            <span
                                                class="font-bold text-gray-800">{{ $viewingUser->teacher->title }}{{ $viewingUser->teacher->firstname }}
                                                {{ $viewingUser->teacher->lastname }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-green-600 font-medium">รหัสอาจารย์:</span>
                                            <span
                                                class="font-bold text-gray-800">{{ $viewingUser->teacher->teacher_code ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-center text-gray-500 italic text-sm">
                                    ไม่มีข้อมูลเพิ่มเติม (นักเรียน/อาจารย์)
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                        <button wire:click="closeViewModal()" type="button"
                            class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
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
                        text: Array.isArray(event) ? event[0].message : event.message,
                        icon: 'success',
                        confirmButtonColor: '#4f46e5',
                    });
                });

                Livewire.on('swal:error', (event) => {
                    Swal.fire({
                        title: 'ผิดพลาด!',
                        text: Array.isArray(event) ? event[0].message : event.message,
                        icon: 'error',
                    });
                });

                Livewire.on('swal:confirm', (event) => {
                    const data = Array.isArray(event) ? event[0] : event;
                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: (data.message || 'คุณต้องการลบข้อมูลนี้หรือไม่?') +
                            ' (ข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!)',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: 'ใช่, ลบเลย!',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete-confirmed', {
                                id: data.id
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
</div>
