<div>
    <div class="py-8 md:py-12 font-sans text-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-100 rounded-2xl">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">จัดการข้อมูลนักเรียน</h2>
                        <p class="text-gray-500 text-sm mt-1">ข้อมูลรายละเอียดและการลงทะเบียนของ {{ $student->firstname }} {{ $student->lastname }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('registrar.students.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        ย้อนกลับ
                    </a>
                    <button wire:click="deleteStudent"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        ลบข้อมูล
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Basic Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Student Summary Card -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col md:flex-row gap-8">
                                <div class="flex-shrink-0">
                                    <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                                        {{ substr($student->firstname, 0, 1) }}{{ substr($student->lastname, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-900">{{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}</h3>
                                            <p class="text-indigo-600 font-medium">รหัสนักเรียน: {{ $student->student_code }}</p>
                                        </div>
                                        <span class="px-4 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                            สถานะ: กำลังศึกษา
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                                        <div class="flex items-center gap-3 text-gray-600">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm">{{ $student->user->email ?? 'ไม่มีอีเมล' }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-gray-600">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4"></path>
                                            </svg>
                                            <span class="text-sm">เลขบัตร: {{ $student->citizen_id ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registration History -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                ประวัติการลงทะเบียน
                            </h3>
                        </div>
                        <div class="p-0">
                            @if($student->registrations && $student->registrations->count() > 0)
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            <th class="px-6 py-4">ภาคเรียน/ปี</th>
                                            <th class="px-6 py-4">วันที่</th>
                                            <th class="px-6 py-4">สถานะ</th>
                                            <th class="px-6 py-4 text-right">การจัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($student->registrations as $reg)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <span class="font-bold text-gray-800">{{ $reg->semester }}/{{ $reg->year }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $reg->created_at->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                                            'approved' => 'bg-green-100 text-green-700',
                                                            'rejected' => 'bg-red-100 text-red-700',
                                                        ];
                                                        $color = $statusColors[$reg->status] ?? 'bg-gray-100 text-gray-700';
                                                    @endphp
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                                        {{ $reg->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <button class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">ดูรายละเอียด</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-12 text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-medium">ไม่พบประวัติการลงทะเบียน</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Academic Details -->
                <div class="space-y-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="font-bold text-gray-800">ข้อมูลการเรียน</h3>
                        </div>
                        <div class="p-6">
                            @if($student->classGroup)
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase">กลุ่มเรียน / สาขาวิชา</label>
                                        <p class="text-gray-800 font-bold mt-1">{{ $student->classGroup->course_group_name }}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs font-bold text-gray-400 uppercase">ระดับชั้น</label>
                                            <p class="text-gray-800 font-bold mt-1">{{ $student->classGroup->level->name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-400 uppercase">ห้อง</label>
                                            <p class="text-gray-800 font-bold mt-1">{{ $student->classGroup->class_room }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase">ครูที่ปรึกษา</label>
                                        <div class="flex items-center gap-3 mt-2 p-3 bg-indigo-50 rounded-2xl">
                                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-indigo-600 font-bold shadow-sm">
                                                {{ substr($student->classGroup->advisor->firstname ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-indigo-900">{{ $student->classGroup->advisor->firstname ?? 'N/A' }} {{ $student->classGroup->advisor->lastname ?? '' }}</p>
                                                <p class="text-xs text-indigo-500">ที่ปรึกษาประจำห้อง</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-yellow-50 rounded-2xl border border-yellow-100 flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <p class="text-sm text-yellow-700 font-medium">ยังไม่ได้จัดห้องเรียน</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl shadow-lg p-6 text-white">
                        <h4 class="font-bold mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            ทางลัด
                        </h4>
                        <div class="space-y-3">
                            <button class="w-full py-3 px-4 bg-white/10 hover:bg-white/20 rounded-2xl text-sm font-bold transition-colors text-left flex items-center justify-between group">
                                                                                        <span>พิมพ์เอกสารลงทะเบียน</span>                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </button>
                            <button class="w-full py-3 px-4 bg-white/10 hover:bg-white/20 rounded-2xl text-sm font-bold transition-colors text-left flex items-center justify-between group">
                                <span>ดูประวัติการชำระเงิน</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>