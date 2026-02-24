<div>
    <div class="py-8 md:py-12 font-sans text-gray-800">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">

            <!-- Header Section with Gradient -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 shadow-lg shadow-indigo-200 text-white p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl">
                </div>
                <div
                    class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-pink-500 opacity-20 blur-xl">
                </div>

                <div class="relative z-10 flex items-center gap-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold">ตรวจสอบสถานะการลงทะเบียน</h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80">อนุมัติ ตรวจสอบหลักฐาน
                            และจัดการสถานะการลงทะเบียนของนักเรียน</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <!-- Filters & Controls -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <!-- PerPage -->
                        <div class="flex items-center bg-white border border-gray-200 rounded-xl px-3 py-1.5 shadow-sm">
                            <span class="text-sm text-gray-500 mr-2 whitespace-nowrap">แสดง:</span>
                            <select wire:model.live="perPage"
                                class="border-none focus:ring-0 text-sm font-bold text-gray-700 bg-transparent p-0 w-12 cursor-pointer">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <button wire:click="$set('isShowFilterModalOpen', true)" class="inline-flex items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all ml-2">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            ตัวกรอง
                            @if($filterLevelId || $filterClassGroupId || $statusFilter) 
                                <span class="ml-2 flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                </span>
                            @endif
                        </button>
                    </div>

                    <!-- Search Box -->
                    <div class="w-full md:w-96 flex gap-2">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="ชื่อ, รหัสนักเรียน..."
                                class="block w-full pl-9 pr-4 py-2.5 border-gray-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>
                        <button wire:click="$refresh"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white p-2.5 rounded-2xl shadow-md shadow-indigo-200 transition-all flex items-center justify-center">
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
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    รหัสนักศึกษา</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ชื่อ-นามสกุล</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    กลุ่มเรียน</th>
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ชั้นปี</th>
                                <th
                                    class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ห้อง</th>
                                <th
                                    class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    สถานะ</th>
                                <th
                                    class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($students as $student)
                                @php
                                    $registration = $student->registrations->first();
                                @endphp
                                <tr class="hover:bg-violet-50/30 transition duration-150 ease-in-out group">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 group-hover:bg-indigo-100 transition-colors font-mono">
                                            {{ $student->student_code }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal break-words max-w-xs">
                                        <div class="text-sm font-bold text-gray-700">
                                            {{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal break-words max-w-[150px] text-sm text-gray-600">
                                        {{ $student->classGroup->course_group_name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $student->level->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                        {{ $student->classGroup->class_room ?? '-' }}
                                    </td>
                                                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                                                                                                    @if ($registration)
                                                                                                                        <div class="relative inline-block text-left"
                                                                                                                            x-data="{
                                                                                                                                open: false,
                                                                                                                                top: 0,
                                                                                                                                left: 0,
                                                                                                                                updatePosition() {
                                                                                                                                    const rect = $refs.button.getBoundingClientRect();
                                                                                                                                    this.top = rect.bottom;
                                                                                                                                    this.left = rect.right - 176; // w-44 = 176px
                                                                                                                                }
                                                                                                                            }"
                                                                                                                            @scroll.window="open = false"
                                                                                                                            @resize.window="open = false">
                                                                                                                            <button x-ref="button" @click="updatePosition(); open = !open" type="button"
                                                                                                                                class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-bold border transition-all duration-200
                                                                                                                                {{ $registration->status === 'approved'
                                                                                                                                    ? 'bg-green-100 text-green-700 border-green-200 hover:bg-green-200'
                                                                                                                                    : ($registration->status === 'rejected'
                                                                                                                                        ? 'bg-red-100 text-red-700 border-red-200 hover:bg-red-200'
                                                                                                                                        : 'bg-yellow-100 text-yellow-800 border-yellow-200 hover:bg-yellow-200') }}">
                                                                                                                                <span
                                                                                                                                    class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $registration->status === 'approved' ? 'bg-green-500' : ($registration->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
                                                                                                                                {{ match ($registration->status) {
                                                                                                                                    'pending' => 'รอตรวจสอบ',
                                                                                                                                    'approved' => 'อนุมัติแล้ว',
                                                                                                                                    'rejected' => 'ถูกปฏิเสธ',
                                                                                                                                    default => $registration->status,
                                                                                                                                } }}
                                                                                                                                <svg class="ml-1 -mr-0.5 h-3 w-3" fill="none"
                                                                                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                                                                                </svg>
                                                                                                                            </button>
                                                                            
                                                                                                                            <!-- Dropdown Menu -->
                                                                                                                            <div x-show="open" @click.away="open = false"
                                                                                                                                class="fixed z-[9999] w-44 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
                                                                                                                                :style="`top: ${top}px; left: ${left}px`"
                                                                                                                                style="display: none;">
                                                                                                                                <div class="py-1">
                                                                                                                                    <button
                                                                                                                                        wire:click="openRemarksModal({{ $registration->id }}, 'pending')"
                                                                                                                                        @click="open = false"
                                                                                                                                        class="flex items-center w-full px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50">
                                                                                                                                        <span
                                                                                                                                            class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                                                                                                                        รอตรวจสอบ
                                                                                                                                    </button>
                                                                                                                                    <button
                                                                                                                                        wire:click="openRemarksModal({{ $registration->id }}, 'approved')"
                                                                                                                                        @click="open = false"
                                                                                                                                        class="flex items-center w-full px-4 py-2 text-sm text-green-700 hover:bg-green-50">
                                                                                                                                        <span
                                                                                                                                            class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                                                                                                                        อนุมัติ (Approve)
                                                                                                                                    </button>
                                                                                                                                    <button
                                                                                                                                        wire:click="openRemarksModal({{ $registration->id }}, 'rejected')"
                                                                                                                                        @click="open = false"
                                                                                                                                        class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                                                                                                                        <span
                                                                                                                                            class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                                                                                                                        ปฏิเสธ (Reject)
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>                                                                                @if ($registration->status === 'approved' && $registration->approved_by)
                                                                                    <div class="text-[10px] text-gray-400 mt-1">โดย:
                                                                                        {{ $registration->approved_by }}</div>
                                                                                @endif
                                                                                                                    @else
                                                                                                                        <div class="relative inline-block text-left"
                                                                                                                            x-data="{
                                                                                                                                open: false,
                                                                                                                                top: 0,
                                                                                                                                left: 0,
                                                                                                                                updatePosition() {
                                                                                                                                    const rect = $refs.button.getBoundingClientRect();
                                                                                                                                    this.top = rect.bottom;
                                                                                                                                    this.left = rect.right - 192; // w-48 = 192px
                                                                                                                                }
                                                                                                                            }"
                                                                                                                            @scroll.window="open = false"
                                                                                                                            @resize.window="open = false">
                                                                                                                            <button x-ref="button" @click="updatePosition(); open = !open" type="button"
                                                                                                                                class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200 transition-all duration-200">
                                                                                                                                ยังไม่ลงทะเบียน
                                                                                                                                <svg class="ml-1 -mr-0.5 h-3 w-3" fill="none"
                                                                                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                                                                                </svg>
                                                                                                                            </button>
                                                                            
                                                                                                                            <!-- Dropdown Menu for New Registration -->
                                                                                                                            <div x-show="open" @click.away="open = false"
                                                                                                                                class="fixed z-[9999] w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
                                                                                                                                :style="`top: ${top}px; left: ${left}px`"
                                                                                                                                style="display: none;">
                                                                                                                                <div class="py-1">
                                                                                                                                    <div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">สร้างรายการใหม่</div>
                                                                                                                                    <button
                                                                                                                                        wire:click="openRemarksModal(null, 'approved', {{ $student->id }})"
                                                                                                                                        @click="open = false"
                                                                                                                                        class="flex items-center w-full px-4 py-2 text-sm text-green-700 hover:bg-green-50">
                                                                                                                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                                                                                                                        อนุมัติทันที (Approve)
                                                                                                                                    </button>
                                                                                                                                    <button
                                                                                                                                        wire:click="openRemarksModal(null, 'pending', {{ $student->id }})"
                                                                                                                                        @click="open = false"
                                                                                                                                        class="flex items-center w-full px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50">
                                                                                                                                        <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                                                                                                                        รอตรวจสอบ (Pending)
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    @endif                                                                        </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <button wire:click="viewProof({{ $student->id }})"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-lg text-indigo-600 bg-indigo-50 hover:bg-indigo-100 hover:text-indigo-700 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            ดูหลักฐาน
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500 italic">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-10 w-10 text-gray-300 mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                            <p>ไม่พบข้อมูลนักเรียน</p>
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

    <!-- Modal: View Proof -->
    @if ($isShowProofModalOpen && $selectedStudent)
        <div class="fixed z-[99] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    wire:click="closeProofModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">

                    <!-- Modal Header -->
                    <div
                        class="bg-gradient-to-r from-violet-600 to-indigo-600 px-4 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            หลักฐานการลงทะเบียน
                        </h3>
                        <button wire:click="closeProofModal" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white px-4 py-6">
                        <!-- Student Info Card -->
                        <div
                            class="bg-indigo-50 rounded-xl p-4 border border-indigo-100 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-lg font-bold text-indigo-900">
                                        {{ $selectedStudent->title }}{{ $selectedStudent->firstname }}
                                        {{ $selectedStudent->lastname }}</h4>
                                    <span
                                        class="bg-indigo-200 text-indigo-800 text-xs font-bold px-2 py-0.5 rounded-full font-mono">{{ $selectedStudent->student_code }}</span>
                                </div>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                                    <p class="text-sm text-indigo-700">
                                        <span class="font-bold">กลุ่มเรียน:</span> {{ $selectedStudent->classGroup->course_group_name ?? '-' }}
                                    </p>
                                    <p class="text-sm text-indigo-700">
                                        <span class="font-bold">ระดับชั้น:</span> {{ $selectedStudent->level->name ?? '-' }}
                                    </p>
                                    <p class="text-sm text-indigo-700">
                                        <span class="font-bold">ห้อง:</span> {{ $selectedStudent->classGroup->class_room ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if ($selectedRegistration)
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">วันที่ส่งข้อมูล</p>
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ $selectedRegistration->created_at->format('d/m/Y H:i') }} น.</p>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        ยังไม่ส่งหลักฐาน
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if ($selectedRegistration)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Slip -->
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm font-bold text-gray-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            สลิปโอนเงิน (Slip)
                                        </p>
                                        @if ($selectedRegistration->slip_file_name)
                                            <a href="{{ asset('storage/' . $selectedRegistration->slip_file_name) }}"
                                                target="_blank"
                                                class="text-xs text-indigo-600 hover:underline flex items-center gap-1">
                                                เปิดแท็บใหม่ <svg class="w-3 h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>

                                    <div
                                        class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 h-64 flex items-center justify-center relative group">
                                        @if ($selectedRegistration->slip_file_name)
                                            <img src="{{ asset('storage/' . $selectedRegistration->slip_file_name) }}"
                                                class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="text-center text-gray-400">
                                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs">ไม่พบไฟล์</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Registration Card -->
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm font-bold text-gray-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                                </path>
                                            </svg>
                                            บัตรลงทะเบียน
                                        </p>
                                        @if ($selectedRegistration->registration_card_file)
                                            <a href="{{ asset('storage/' . $selectedRegistration->registration_card_file) }}"
                                                target="_blank"
                                                class="text-xs text-indigo-600 hover:underline flex items-center gap-1">
                                                เปิดแท็บใหม่ <svg class="w-3 h-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>

                                    <div
                                        class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 h-64 flex items-center justify-center relative group">
                                        @if ($selectedRegistration->registration_card_file)
                                            <img src="{{ asset('storage/' . $selectedRegistration->registration_card_file) }}"
                                                class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="text-center text-gray-400">
                                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs">ไม่พบไฟล์</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($selectedRegistration->remarks)
                                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-xl">
                                    <p class="text-sm text-red-800 font-bold">หมายเหตุ (จากทะเบียน):</p>
                                    <p class="text-sm text-red-600 mt-1">{{ $selectedRegistration->remarks }}</p>
                                </div>
                            @endif
                        @else
                            <div
                                class="py-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <p class="mt-2 text-gray-500 font-medium">ไม่พบหลักฐานการลงทะเบียน</p>
                                <p class="text-xs text-gray-400">นักเรียนยังไม่ได้ดำเนินการอัปโหลดเอกสาร</p>
                            </div>
                        @endif
                    </div>

                    <div
                        class="bg-gray-50 px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-3 rounded-b-2xl">

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            @if ($selectedRegistration && $selectedRegistration->status === 'pending')
                                <button type="button"
                                    wire:click="openRemarksModal({{ $selectedRegistration->id }}, 'approved')"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg shadow-green-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    อนุมัติ (Approve)
                                </button>

                                <button type="button" 
                                    wire:click="openRemarksModal({{ $selectedRegistration->id }}, 'rejected')"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 bg-white border border-red-300 rounded-xl font-bold text-xs text-red-700 uppercase tracking-widest hover:bg-red-50 focus:outline-none focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    ปฏิเสธ
                                </button>
                            @endif
                        </div>

                        <button type="button" wire:click="closeProofModal"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            ปิดหน้าต่าง
                        </button>
                    </div>
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
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">สถานะการลงทะเบียน</label>
                                <select wire:model.live="statusFilter" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                                    <option value="">ทั้งหมด</option>
                                    <option value="pending">รอตรวจสอบ</option>
                                    <option value="approved">อนุมัติแล้ว</option>
                                    <option value="rejected">ถูกปฏิเสธ</option>
                                    <option value="unregistered">ยังไม่ลงทะเบียน</option>
                                </select>
                            </div>

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
                        <button type="button" wire:click="$set('filterLevelId', ''); $set('filterClassGroupId', ''); $set('statusFilter', '');" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            ล้างค่า
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Remarks Modal -->
    @if ($isShowRemarksModalOpen)
        <div class="fixed z-[100] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeRemarksModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 py-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                ยืนยันการเปลี่ยนสถานะ
                            </h3>
                            <button wire:click="closeRemarksModal" class="text-gray-400 hover:text-gray-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <p class="text-sm text-gray-600">สถานะใหม่: 
                                    <span class="font-bold {{ $tempStatus === 'approved' ? 'text-green-600' : ($tempStatus === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                        {{ match ($tempStatus) {
                                            'pending' => 'รอตรวจสอบ',
                                            'approved' => 'อนุมัติแล้ว',
                                            'rejected' => 'ถูกปฏิเสธ',
                                            default => $tempStatus,
                                        } }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">หมายเหตุ (ระบุเหตุผล หรือข้อมูลเพิ่มเติม)</label>
                                <textarea wire:model="remarks" rows="4" 
                                    placeholder="เช่น ส่งหลักฐานที่อาจารย์แล้ว, สลิปไม่ชัดเจน..."
                                    class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse rounded-b-2xl gap-2">
                        <button type="button" wire:click="submitStatusWithRemarks" 
                            class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm transition-all">
                            ยืนยัน
                        </button>
                        <button type="button" wire:click="closeRemarksModal" 
                            class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm transition-all">
                            ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>      
