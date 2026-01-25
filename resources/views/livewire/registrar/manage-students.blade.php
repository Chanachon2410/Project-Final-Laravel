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
                            <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            จัดการข้อมูลนักเรียน
                        </h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80">
                            ระบบบริหารจัดการรายชื่อและข้อมูลนักเรียนทั้งหมด</p>
                    </div>

                    <button wire:click="create()"
                        class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold py-2.5 px-5 rounded-xl border border-white/20 shadow-sm transition-all duration-200 flex items-center gap-2 transform hover:-translate-y-0.5 text-sm">
                        <span
                            class="bg-white text-indigo-600 rounded-lg p-1 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </span>
                        <span>เพิ่มนักเรียนใหม่</span>
                    </button>
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

                        <!-- Filter Button -->
                        <button wire:click="$set('isShowFilterModalOpen', true)" class="inline-flex items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all ml-2">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            ตัวกรอง
                            @if($filterLevelId || $filterClassGroupId) 
                                <span class="ml-2 flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                </span>
                            @endif
                        </button>
                    </div>

                    <!-- Search Box with Button -->
                    <div class="w-full md:w-96 flex gap-2">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="ค้นหาชื่อ, รหัส..."
                                class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>
                        <button wire:click="$refresh"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-md transition-colors flex items-center font-medium">
                            ค้นหา
                        </button>
                    </div>
                </div>

                <!-- Modern Table (Removed Column Selector Logic) -->
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    เลขบัตรประชาชน</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    รหัสนักเรียน</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ชื่อ-นามสกุล</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ระดับชั้น</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ห้อง</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    กลุ่มเรียน</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($students as $student)
                                <tr class="hover:bg-violet-50/30 transition duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                        {{ $student->citizen_id ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 group-hover:bg-indigo-100 transition-colors">
                                            {{ $student->student_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span
                                                class="text-sm font-bold text-gray-700">{{ $student->title ? $student->title . ' ' : '' }}{{ $student->firstname }}
                                                {{ $student->lastname }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $student->level->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if ($student->classGroup->class_room)
                                            <span class="flex items-center gap-1">
                                                {{ $student->classGroup->class_room }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $student->classGroup->course_group_name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button wire:click="edit({{ $student->id }})"
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
                                            <button wire:click="delete({{ $student->id }})"
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
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="h-6 w-6 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium">ไม่พบข้อมูลนักเรียน</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal with Glassmorphism Touch -->
    @if ($isModalOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    wire:click="closeModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
                    <form wire:submit.prevent="{{ $student_id ? 'update' : 'store' }}">
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-violet-600 to-indigo-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="bg-white/20 p-1.5 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </span>
                                {{ $student_id ? 'แก้ไขข้อมูลนักเรียน' : 'เพิ่มนักเรียนใหม่' }}
                            </h3>
                        </div>

                        <div class="bg-white px-6 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Column 1 -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="student_code"
                                            class="block text-gray-700 text-sm font-bold mb-2">รหัสนักเรียน
                                            (Username)</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" wire:model="student_code" id="student_code"
                                                class="pl-10 py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                placeholder="เช่น 662020101">
                                        </div>
                                        @error('student_code')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">ชื่อ-นามสกุล</label>
                                        <div class="grid grid-cols-12 gap-2">
                                            <div class="col-span-4">
                                                <select wire:model="title"
                                                    class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm px-2">
                                                    <option value="">คำนำ</option>
                                                    <option value="นาย">นาย</option>
                                                    <option value="นาง">นาง</option>
                                                    <option value="นางสาว">น.ส.</option>
                                                </select>
                                            </div>
                                            <div class="col-span-8">
                                                <input type="text" wire:model="firstname" placeholder="ชื่อจริง"
                                                    class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            </div>
                                            <div class="col-span-12 mt-1">
                                                <input type="text" wire:model="lastname" placeholder="นามสกุล"
                                                    class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            </div>
                                        </div>
                                        @error('firstname')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="citizen_id"
                                            class="block text-gray-700 text-sm font-bold mb-2">เลขบัตรประชาชน</label>
                                        <input type="text" wire:model="citizen_id" id="citizen_id"
                                            class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                            maxlength="13">
                                        @error('citizen_id')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">ข้อมูลการศึกษา</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label
                                                    class="block text-gray-700 text-sm font-bold mb-2">ระดับชั้น</label>
                                                <select wire:model="level_id"
                                                    class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                    <option value="">เลือกระดับชั้น...</option>
                                                    @foreach ($levels as $level)
                                                        <option value="{{ $level->id }}">{{ $level->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('level_id')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-gray-700 text-sm font-bold mb-2">กลุ่มเรียน</label>
                                                <select wire:model="class_group_id"
                                                    class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                    <option value="">เลือกกลุ่มเรียน...</option>
                                                    @foreach ($classGroups as $group)
                                                        <option value="{{ $group->id }}">
                                                            [{{ $group->level->name ?? '-' }}] {{ $group->course_group_code }} - {{ $group->course_group_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('class_group_id')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">ข้อมูลบัญชีผู้ใช้</h4>
                                        <div class="space-y-3">
                                            <input type="email" wire:model="email" placeholder="อีเมล (ถ้ามี)"
                                                class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            <input type="password" wire:model="password"
                                                placeholder="รหัสผ่าน {{ $student_id ? '(เว้นว่างหากไม่เปลี่ยน)' : '' }}"
                                                class="py-2 shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2 rounded-b-2xl">
                            <button type="submit"
                                class="inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-base font-bold text-white hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 sm:text-sm">
                                {{ $student_id ? 'บันทึกการแก้ไข' : 'บันทึกข้อมูล' }}
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

    <!-- Filter Modal -->
    @if ($isShowFilterModalOpen)
        <div class="fixed z-[99] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="$set('isShowFilterModalOpen', false)" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 py-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                ตัวกรองข้อมูล
                            </h3>
                            <button wire:click="$set('isShowFilterModalOpen', false)" class="text-gray-400 hover:text-gray-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Level Filter -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">ระดับชั้น</label>
                                <select wire:model.live="filterLevelId" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                                    <option value="">ทั้งหมด</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Class Group Filter -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">กลุ่มเรียน</label>
                                <select wire:model.live="filterClassGroupId" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                                    <option value="">ทั้งหมด</option>
                                    @foreach($classGroups as $group)
                                        <option value="{{ $group->id }}">{{ $group->course_group_name }} ({{ $group->level->name ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse rounded-b-2xl">
                        <button type="button" wire:click="$set('isShowFilterModalOpen', false)" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            ตกลง
                        </button>
                        <button type="button" wire:click="$set('filterLevelId', ''); $set('filterClassGroupId', '');" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            ล้างค่า
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
