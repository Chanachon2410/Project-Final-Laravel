<div>
    <div class="py-8 md:py-12 font-sans text-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section with Gradient -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 shadow-lg shadow-indigo-200 text-white p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-pink-500 opacity-20 blur-xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <span class="bg-white/20 p-2 rounded-xl">
                                <svg class="w-8 h-8 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </span>
                            ข้อมูลบุคลากรครู
                        </h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80 pl-14">ตรวจสอบข้อมูลครูและภาระงานที่ปรึกษา</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <!-- Filters & Controls -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <!-- PerPage (Fixed Style) -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-700">แสดง:</span>
                            <select wire:model.live="perPage"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-20 p-2.5 shadow-sm">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <span class="text-sm text-gray-500">รายการ</span>
                        </div>
                    </div>
                    
                    <!-- Search Box with Button -->
                    <div class="w-full md:w-auto flex gap-2 justify-end items-center flex-grow">
                        <div class="relative w-full md:w-64 lg:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ค้นหาชื่อครู..." class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>
                        <button wire:click="$refresh" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl shadow-md transition-colors flex items-center font-medium whitespace-nowrap">
                            <svg class="w-5 h-5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="hidden md:inline">ค้นหา</span>
                        </button>
                        <button wire:click="openCreateModal" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl shadow-md transition-colors flex items-center font-medium whitespace-nowrap">
                            <svg class="w-5 h-5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="hidden md:inline">เพิ่มครู</span>
                        </button>
                    </div>
                </div>

                <!-- Modern Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ข้อมูลครู</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ที่ปรึกษาประจำชั้น</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ข้อมูลติดต่อ</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($teachers as $teacher)
                            <tr class="hover:bg-violet-50/30 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $teacher->title }} {{ $teacher->firstname }} {{ $teacher->lastname }}
                                        </div>
                                        <div class="text-xs text-gray-500 bg-gray-100 rounded px-1.5 py-0.5 inline-block mt-1 self-start">
                                            รหัส: {{ $teacher->teacher_code ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($teacher->advisedClassGroups->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($teacher->advisedClassGroups as $group)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                                    {{ $group->course_group_name }} 
                                                    @if($group->class_room) (ห้อง {{ $group->class_room }}) @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        {{ $teacher->user->email ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="viewTeacher({{ $teacher->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="ดูรายละเอียด">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button wire:click="openEditModal({{ $teacher->id }})" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="แก้ไข">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button onclick="confirmDeleteTeacher({{ $teacher->id }}, '{{ $teacher->title }}{{ $teacher->firstname }} {{ $teacher->lastname }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="ลบ">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p>ไม่พบข้อมูลครู</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $teachers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Details Modal -->
    @if($isViewModalOpen && $selectedTeacher)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeViewModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-6 py-6">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl">
                            {{ mb_substr($selectedTeacher->firstname, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $selectedTeacher->title }} {{ $selectedTeacher->firstname }} {{ $selectedTeacher->lastname }}
                            </h3>
                            <p class="text-sm text-gray-500">รหัสครู: {{ $selectedTeacher->teacher_code ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if($selectedTeacher->user)
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">อีเมล</p>
                                <p class="font-medium text-gray-900">{{ $selectedTeacher->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">ชื่อผู้ใช้</p>
                                <p class="font-medium text-gray-900">{{ $selectedTeacher->user->username }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div>
                            <p class="text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                กลุ่มเรียนที่ปรึกษา
                            </p>
                            @if($selectedTeacher->advisedClassGroups->count() > 0)
                                <div class="space-y-2">
                                    @foreach($selectedTeacher->advisedClassGroups as $group)
                                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl hover:border-indigo-300 transition-colors shadow-sm">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ $group->course_group_name }} 
                                                @if($group->class_room) <span class="text-xs text-gray-400 ml-1">(ห้อง {{ $group->class_room }})</span> @endif
                                            </span>
                                            <button wire:click="openStudentListModal({{ $group->id }})" class="px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                                ดูรายชื่อนักเรียน
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400 text-sm italic bg-gray-50 p-3 rounded-lg text-center">ไม่มีกลุ่มเรียนที่ปรึกษา</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <button wire:click="closeViewModal()" type="button" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List Modal (Nested) -->
    @if($isStudentListModalOpen)
    <div class="fixed z-[60] inset-0 overflow-y-auto" aria-labelledby="student-modal-headline" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity backdrop-blur-sm" wire:click="closeStudentListModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 py-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2" id="student-modal-headline">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        รายชื่อนักเรียนในกลุ่ม
                    </h3>
                    <div class="overflow-y-auto max-h-80 border border-gray-200 rounded-xl">
                        @if(count($studentsInGroup) > 0)
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">รหัส</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ชื่อ-นามสกุล</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($studentsInGroup as $student)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm font-mono text-indigo-600 font-bold">{{ $student->student_code }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-700">{{ $student->firstname }} {{ $student->lastname }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-8 text-center text-gray-500 italic">ไม่พบนักเรียนในกลุ่มนี้</div>
                        @endif
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <button wire:click="closeStudentListModal()" type="button" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

    <!-- Manage Teacher Modal -->
    @if($isManageModalOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeManageModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 py-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        {{ $teacherId ? 'แก้ไขข้อมูลครู' : 'เพิ่มข้อมูลครู' }}
                    </h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">คำนำหน้า</label>
                                <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">รหัสครู</label>
                                <input type="text" wire:model="teacher_code" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('teacher_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ชื่อจริง</label>
                                <input type="text" wire:model="firstname" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('firstname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">นามสกุล</label>
                                <input type="text" wire:model="lastname" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('lastname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-4 mt-2">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">บัญชีผู้ใช้</h4>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">อีเมล</label>
                                <input type="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
                                    <input type="text" wire:model="username" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">รหัสผ่าน {{ $teacherId ? '(เว้นว่างหากไม่เปลี่ยน)' : '' }}</label>
                                    <input type="password" wire:model="password" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="saveTeacher" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        บันทึก
                    </button>
                    <button wire:click="closeManageModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        ยกเลิก
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        function confirmDeleteTeacher(id, name) {
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: `คุณต้องการลบข้อมูลของ "${name}" ใช่หรือไม่?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ลบข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deleteTeacher(id);
                }
            });
        }
    </script>
</div>