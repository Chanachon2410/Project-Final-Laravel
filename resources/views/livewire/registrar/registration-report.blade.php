<div>
    <div class="py-8 md:py-12 font-sans text-gray-800 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Header Section (Gradient Design) -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 shadow-lg shadow-indigo-200 text-white p-6 sm:p-8">
                <!-- Decorative Blobs -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl">
                </div>
                <div
                    class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-pink-500 opacity-20 blur-xl">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <span class="bg-white/20 p-2.5 rounded-xl backdrop-blur-sm border border-white/10">
                                <!-- Icon: Clipboard Check -->
                                <svg class="w-6 h-6 text-indigo-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </span>
                            รายงานผลการลงทะเบียน
                        </h2>
                        <p class="text-indigo-100 text-sm mt-2 opacity-90 pl-[3.75rem]">
                            ตรวจสอบสถานะการลงทะเบียนของนักเรียนรายห้อง / รายชั้นปี
                        </p>
                    </div>

                
                </div>
            </div>

            <!-- 2. Stats Overview Cards (New Addition) -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Card: Total Students -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-50 rounded-lg p-3">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">นักเรียนทั้งหมด
                                    </dt>
                                    <dd class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ $stats['total'] ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Completed -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-50 rounded-lg p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        ลงทะเบียนสมบูรณ์</dt>
                                    <dd class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ $stats['paid'] ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Pending -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-50 rounded-lg p-3">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">รอตรวจสอบ</dt>
                                    <dd class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ $stats['pending'] ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Not Registered -->
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-50 rounded-lg p-3">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">ยังไม่ลงทะเบียน
                                    </dt>
                                    <dd class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ $stats['not_registered'] ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Filters Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        ตัวกรองข้อมูลสำหรับพิมพ์รายงาน
                    </h3>

                    <div
                        class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                        <!-- Semester Filter -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5 ml-1">ภาคเรียน/ปีการศึกษา</label>
                            <select wire:model.live="semester_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                                <option value="">-- เลือกภาคเรียน --</option>
                                @foreach ($semesters as $sem)
                                    <option value="{{ $sem->id }}">
                                        {{ $sem->semester }}/{{ $sem->year }}
                                        {{ $sem->is_active ? '(ปัจจุบัน)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Level Filter -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5 ml-1">ระดับชั้น</label>
                            <select wire:model.live="level_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3 disabled:bg-gray-100 disabled:text-gray-400"
                                {{ !$semester_id ? 'disabled' : '' }}>
                                <option value="">-- ทั้งหมด --</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Class Group Filter -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5 ml-1">กลุ่มเรียน</label>
                            <select wire:model.live="class_group_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3 disabled:bg-gray-100 disabled:text-gray-400"
                                {{ !$semester_id || !$level_id ? 'disabled' : '' }}>
                                <option value="">-- ทั้งหมด --</option>
                                @foreach ($classGroups as $group)
                                    <option value="{{ $group->id }}">
                                        {{ $group->course_group_name }} ({{ $group->course_group_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Print/Preview Report Button -->
                    <div class="mt-4 flex justify-end border-t border-gray-100 pt-4">
                        @if($semester_id && $class_group_id)
                            <a href="{{ route('registrar.registration-report.preview', ['semester_id' => $semester_id, 'class_group_id' => $class_group_id]) }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200">
                                
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                
                                ดูตัวอย่างรายงาน (PDF)
                            </a>
                        @else
                            <button disabled
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-300 cursor-not-allowed text-white text-sm font-semibold rounded-xl shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                ดูตัวอย่างรายงาน (PDF)
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 4. Data Table Section (New Addition) -->
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 flex justify-between items-center">
                    <h3 class="text-base font-semibold text-gray-800">
                        รายชื่อนักเรียน
                        @if ($class_group_id)
                            @php
                                $selectedGroup = $classGroups->firstWhere('id', $class_group_id);
                            @endphp
                            @if($selectedGroup)
                                <span class="text-indigo-600">กลุ่ม {{ $selectedGroup->course_group_name }}</span>
                            @endif
                        @endif
                    </h3>

                    <!-- Search Box -->
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="block w-full pl-9 pr-3 py-1.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                            placeholder="ค้นหาชื่อ หรือ รหัสนักศึกษา...">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    รหัสนักศึกษา</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    ชื่อ-นามสกุล</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    กลุ่มเรียน</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    ระดับชั้น</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    ห้อง</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    สถานะ</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Loop Data Here --}}
                            @forelse($students ?? [] as $student)
                                @php
                                    // หาข้อมูลการลงทะเบียนของนักเรียนในเทอมที่เลือก
                                    $reg = $student->registrations->first(); 
                                @endphp
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                        {{ $student->student_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $student->classGroup->course_group_code ?? '-' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 font-medium">
                                        {{ $student->classGroup->course_group_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900 font-bold">
                                        {{ $student->level->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600">
                                        {{ $student->classGroup->class_room ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($reg)
                                            @if ($reg->status == 'approved')
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                    สมบูรณ์
                                                </span>
                                            @elseif($reg->status == 'pending')
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    รอตรวจสอบ
                                                </span>
                                            @elseif($reg->status == 'rejected')
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                    ถูกปฏิเสธ
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                                ยังไม่ลง
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <button wire:click="viewProof({{ $student->id }})" class="text-gray-400 hover:text-indigo-600 transition-colors mx-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-sm font-medium">ไม่พบข้อมูลนักเรียนตามเงื่อนไขที่เลือก</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (Optional) -->
                @if (isset($students) && method_exists($students, 'links'))
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $students->links() }}
                    </div>
                @endif
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
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            {{-- Action buttons removed for view-only report --}}
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
</div>