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

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <span class="bg-white/20 p-2 rounded-xl">
                                @if($editingDocument)
                                    <svg class="w-8 h-8 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </span>
                            {{ $editingDocument ? 'แก้ไขเอกสารลงทะเบียน' : 'สร้างเอกสารลงทะเบียนใหม่' }}
                        </h2>
                        <p class="text-indigo-100 text-sm mt-2 pl-14 opacity-80">
                            {{ $editingDocument ? 'แก้ไขข้อมูลโครงสร้างค่าเทอม รายวิชา และค่าใช้จ่ายต่างๆ' : 'กำหนดโครงสร้างค่าเทอม รายวิชา และค่าใช้จ่ายต่างๆ ตามขั้นตอน' }}
                        </p>
                    </div>

                    <a href="{{ route('registrar.registration-documents.index') }}" 
                        class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold py-2.5 px-5 rounded-xl border border-white/20 shadow-sm transition-all duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>ย้อนกลับ</span>
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <!-- Stepper -->
                <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                    <div class="relative">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                            <div style="width: {{ $currentStep * 25 }}%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-violet-500 to-indigo-500 transition-all duration-500 ease-in-out">
                            </div>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm font-bold text-gray-500">
                            <div
                                class="{{ $currentStep >= 1 ? 'text-indigo-600' : '' }} flex flex-col items-center gap-1">
                                <span
                                    class="w-6 h-6 rounded-full flex items-center justify-center border-2 {{ $currentStep >= 1 ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300' }}">1</span>
                                ข้อมูลทั่วไป
                            </div>
                            <div
                                class="{{ $currentStep >= 2 ? 'text-indigo-600' : '' }} flex flex-col items-center gap-1">
                                <span
                                    class="w-6 h-6 rounded-full flex items-center justify-center border-2 {{ $currentStep >= 2 ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300' }}">2</span>
                                เลือกรายวิชา
                            </div>
                            <div
                                class="{{ $currentStep >= 3 ? 'text-indigo-600' : '' }} flex flex-col items-center gap-1">
                                <span
                                    class="w-6 h-6 rounded-full flex items-center justify-center border-2 {{ $currentStep >= 3 ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300' }}">3</span>
                                ค่าใช้จ่าย
                            </div>
                            <div
                                class="{{ $currentStep >= 4 ? 'text-indigo-600' : '' }} flex flex-col items-center gap-1">
                                <span
                                    class="w-6 h-6 rounded-full flex items-center justify-center border-2 {{ $currentStep >= 4 ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300' }}">4</span>
                                ยืนยัน
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    @if ($currentStep == 1)
                        <div class="space-y-6">
                            <!-- Section 1: Target Group -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    กลุ่มเป้าหมายและภาคเรียน
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="col-span-2">
                                        <label
                                            class="block text-sm font-bold text-gray-700 mb-1">เลือกภาคเรียนที่เปิดลงทะเบียน</label>
                                        <select wire:model.live="semester_id"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white py-2.5">
                                            <option value="">-- เลือกภาคเรียน / ปีการศึกษา --</option>
                                            @foreach ($semesters as $sem)
                                                <option value="{{ $sem->id }}">
                                                    ภาคเรียนที่ {{ $sem->semester }}/{{ $sem->year }}
                                                    @if ($sem->is_active)
                                                        (ปัจจุบัน)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('semester_id')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">ระดับชั้น</label>
                                        <select wire:model.live="level_id"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white py-2.5">
                                            <option value="">-- เลือกระดับชั้น --</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('level_id')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">สาขาวิชา</label>
                                        <select wire:model.live="major_id"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white py-2.5">
                                            <option value="">-- เลือกสาขาวิชา --</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}">{{ $major->major_name }}
                                                    ({{ $major->major_code }})</option>
                                            @endforeach
                                        </select>
                                        @error('major_id')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-bold text-gray-700 mb-1">รหัสกลุ่มเรียน (Ref.2)
                                            <span
                                                class="text-gray-400 font-normal text-xs">*เว้นว่างเพื่อใช้ค่าเริ่มต้น</span></label>
                                        <input type="text" wire:model.live="custom_ref2"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
                                            placeholder="เช่น 682020101">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Dates -->
                            <div class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100">
                                <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    กำหนดการลงทะเบียน (ดึงจากภาคเรียน)
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-600 mb-1 uppercase">เริ่มลงทะเบียนปกติ</label>
                                        <input type="date" wire:model="payment_start_date"
                                            class="w-full border-gray-300 rounded-xl shadow-sm bg-white py-2.5">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-600 mb-1 uppercase">สิ้นสุดลงทะเบียนปกติ</label>
                                        <input type="date" wire:model.live="payment_end_date"
                                            class="w-full border-gray-300 rounded-xl shadow-sm bg-white py-2.5">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-orange-600 mb-1 uppercase">เริ่มปรับล่าช้า</label>
                                        <input type="date" wire:model="late_payment_start_date"
                                            class="w-full border-orange-200 rounded-xl shadow-sm bg-orange-50 focus:ring-orange-500 py-2.5">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-orange-600 mb-1 uppercase">สิ้นสุดการปรับ</label>
                                        <input type="date" wire:model="late_payment_end_date"
                                            class="w-full border-orange-200 rounded-xl shadow-sm bg-orange-50 focus:ring-orange-500 py-2.5">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Fine Settings -->
                            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-bold text-gray-800 mb-4">ตั้งค่าค่าปรับล่าช้า</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">รูปแบบการปรับ</label>
                                        <select wire:model.live="late_fee_type"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                                            <option value="flat">ปวช. / ปวส. (เหมาจ่ายครั้งเดียว)</option>
                                            <option value="daily">ป.ตรี (ปรับรายวัน)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">
                                            {{ $late_fee_type == 'flat' ? 'จำนวนเงินที่ต้องจ่าย (บาท)' : 'คิดค่าปรับวันละ (บาท)' }}
                                        </label>
                                        <input type="number" wire:model.live="late_fee_amount"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
                                            placeholder="0.00">
                                    </div>
                                    @if ($late_fee_type == 'daily')
                                        <div>
                                            <label
                                                class="block text-sm font-bold text-gray-700 mb-1">จำนวนวันล่าช้าสูงสุด</label>
                                            <input type="number" wire:model.live="calculate_days"
                                                class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
                                                placeholder="เช่น 15">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">ปรับสูงสุดไม่เกิน
                                                (บาท)</label>
                                            <input type="number" wire:model="late_fee_max_amount" readonly
                                                class="w-full border-gray-300 rounded-xl shadow-sm bg-gray-100 font-bold text-gray-600 py-2.5">
                                            @if ($calculate_days && $late_fee_amount)
                                                <p class="text-xs text-indigo-500 mt-1 text-right">คำนวณ:
                                                    {{ number_format((float) $late_fee_amount) }} x
                                                    {{ $calculate_days }} วัน</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($currentStep == 2)
                        <div class="space-y-6">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="searchSubject"
                                    placeholder="ค้นหารหัสวิชา หรือ ชื่อวิชา..."
                                    class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-[500px]">
                                <!-- Left: Search Results -->
                                <div
                                    class="flex flex-col bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> ผลการค้นหา
                                        </h3>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-1 space-y-2">
                                        @forelse($subjects as $subject)
                                            <div wire:click="toggleSubject({{ $subject->id }})"
                                                class="group flex items-center justify-between p-3 bg-white border border-gray-100 rounded-xl hover:border-indigo-400 hover:shadow-md cursor-pointer transition-all duration-200">
                                                <div>
                                                    <div class="font-bold text-gray-800 group-hover:text-indigo-600">
                                                        {{ $subject->subject_code }}</div>
                                                    <div class="text-xs text-gray-500">{{ $subject->subject_name }}
                                                    </div>
                                                </div>
                                                <div>
                                                    @if (isset($selectedSubjects[$subject->id]))
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg> เลือกแล้ว
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-600">
                                                            + เพิ่ม
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-10 text-gray-400">
                                                <svg class="mx-auto h-10 w-10 text-gray-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <p class="mt-2 text-sm">ไม่พบรายวิชา</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Right: Selected Subjects -->
                                <div
                                    class="flex flex-col bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm overflow-hidden">
                                    <div
                                        class="bg-indigo-100/50 px-4 py-3 border-b border-indigo-200 flex justify-between items-center">
                                        <h3 class="font-bold text-indigo-800 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span> รายวิชาที่เลือก
                                            ({{ count($selectedSubjects) }})
                                        </h3>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-1 space-y-3">
                                        @foreach ($selectedSubjects as $id => $subj)
                                            <div
                                                class="bg-white p-4 rounded-xl shadow-sm border border-indigo-100 relative">
                                                <button wire:click="toggleSubject({{ $id }})"
                                                    class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                                <div class="font-bold text-gray-800 mb-1 pr-6">{{ $subj['code'] }}
                                                    {{ $subj['name'] }}</div>
                                                <div class="grid grid-cols-3 gap-3 mt-3">
                                                    <div>
                                                        <label
                                                            class="text-[10px] text-gray-500 uppercase font-bold">หน่วยกิต</label>
                                                        <input type="number"
                                                            wire:model="selectedSubjects.{{ $id }}.credit"
                                                            class="w-full text-sm border-gray-200 rounded-lg p-1.5 bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 text-center font-bold">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="text-[10px] text-gray-500 uppercase font-bold">ทฤษฎี</label>
                                                        <input type="number"
                                                            wire:model="selectedSubjects.{{ $id }}.hour_theory"
                                                            class="w-full text-sm border-gray-200 rounded-lg p-1.5 bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 text-center">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="text-[10px] text-gray-500 uppercase font-bold">ปฏิบัติ</label>
                                                        <input type="number"
                                                            wire:model="selectedSubjects.{{ $id }}.hour_practical"
                                                            class="w-full text-sm border-gray-200 rounded-lg p-1.5 bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 text-center">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Summary & Rate -->
                            @php
                                $selectedLevel = $levels->firstWhere('id', $level_id);
                                $hideCalculation = $selectedLevel && str_contains($selectedLevel->name, 'ปวช');
                            @endphp

                            @if (!$hideCalculation)
                                <div
                                    class="bg-gradient-to-r from-gray-50 to-indigo-50 border border-indigo-100 rounded-2xl p-6">
                                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        คำนวณค่าหน่วยกิต
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-sm font-medium text-gray-600">ทฤษฎีรวม</span>
                                                <span
                                                    class="text-xl font-bold text-indigo-600">{{ $totalTheoryCredits }}
                                                    <span class="text-xs font-normal text-gray-400">นก.</span></span>
                                            </div>
                                            <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg">
                                                <label
                                                    class="text-xs text-gray-500 whitespace-nowrap">ราคา/หน่วย:</label>
                                                <input type="number" wire:model.live="theoryRate"
                                                    class="w-full text-sm border-none bg-transparent font-bold text-right focus:ring-0 p-0"
                                                    placeholder="0">
                                                <span class="text-xs text-gray-500">฿</span>
                                            </div>
                                        </div>
                                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-sm font-medium text-gray-600">ปฏิบัติรวม</span>
                                                <span
                                                    class="text-xl font-bold text-indigo-600">{{ $totalPracticalCredits }}
                                                    <span class="text-xs font-normal text-gray-400">นก.</span></span>
                                            </div>
                                            <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg">
                                                <label
                                                    class="text-xs text-gray-500 whitespace-nowrap">ราคา/หน่วย:</label>
                                                <input type="number" wire:model.live="practicalRate"
                                                    class="w-full text-sm border-none bg-transparent font-bold text-right focus:ring-0 p-0"
                                                    placeholder="0">
                                                <span class="text-xs text-gray-500">฿</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-right">
                                        <p class="text-sm text-gray-600">รวมค่าหน่วยกิตทั้งหมด: <span
                                                class="text-lg font-bold text-indigo-700">{{ number_format($totalTheoryCredits * ($theoryRate ?? 0) + $totalPracticalCredits * ($practicalRate ?? 0), 2) }}</span>
                                            บาท</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($currentStep == 3)
                        <div class="space-y-6">
                            <div
                                class="bg-yellow-50 text-yellow-800 p-4 rounded-xl border border-yellow-100 text-sm flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>คุณสามารถเลือกรายการค่าใช้จ่ายจากฐานข้อมูล หรือเพิ่มรายการใหม่เองได้
                                    (ระบบจะรวมยอดเงินจากขั้นตอนที่แล้วมาให้โดยอัตโนมัติหากมี)</span>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="searchFee"
                                    placeholder="ค้นหาชื่อค่าใช้จ่าย..."
                                    class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-[500px]">
                                <!-- Left: Available Fees -->
                                <div
                                    class="flex flex-col bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                        <h3 class="font-bold text-gray-700">รายการค่าใช้จ่าย
                                            ({{ $semester }}/{{ $year }})</h3>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-1 space-y-2">
                                        @forelse($availableFees as $fee)
                                            <div wire:click="selectFee({{ $fee->id }})"
                                                class="group flex items-center justify-between p-3 bg-white border border-gray-100 rounded-xl hover:border-green-400 hover:shadow-md cursor-pointer transition-all duration-200">
                                                <div class="font-medium text-gray-700">{{ $fee->fee_name }}</div>
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="font-bold text-gray-900">{{ number_format($fee->rate_money, 2) }}</span>
                                                    <span class="text-xs text-gray-400 group-hover:text-green-600">+
                                                        เพิ่ม</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-10 text-gray-400">
                                                <p>ไม่พบรายการค่าใช้จ่าย</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Right: Selected Fees -->
                                <div
                                    class="flex flex-col bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm overflow-hidden">
                                    <div
                                        class="bg-indigo-100/50 px-4 py-3 border-b border-indigo-200 flex justify-between items-center">
                                        <h3 class="font-bold text-indigo-800">รายการที่เลือก ({{ count($fees) }})
                                        </h3>
                                        <button wire:click="addCustomFee"
                                            class="text-xs bg-white border border-indigo-300 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-50 hover:shadow-sm transition-all font-bold">
                                            + เพิ่มรายการเอง
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-1 space-y-3">
                                        @foreach ($fees as $index => $fee)
                                            <div
                                                class="bg-white p-3 rounded-xl shadow-sm border border-indigo-100 flex items-center justify-between gap-3">
                                                <div class="flex-grow">
                                                    <input type="text" wire:model="fees.{{ $index }}.name"
                                                        class="w-full text-sm font-bold text-gray-800 border-none p-0 focus:ring-0 placeholder-gray-400"
                                                        placeholder="ชื่อรายการ...">
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <input type="number"
                                                        wire:model="fees.{{ $index }}.amount"
                                                        class="w-24 text-sm font-bold text-right border-gray-200 rounded-lg p-1 bg-gray-50 focus:ring-indigo-500"
                                                        placeholder="0.00">
                                                    <button wire:click="removeFee({{ $index }})"
                                                        class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="bg-indigo-100 px-4 py-3 border-t border-indigo-200 text-right">
                                        <span class="text-sm text-indigo-800">รวมทั้งหมด: <span
                                                class="text-lg font-bold">{{ number_format(collect($fees)->sum('amount'), 2) }}</span>
                                            บาท</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($currentStep == 4)
                        <div class="text-center py-16">
                            <div class="mb-6 relative">
                                <div
                                    class="w-24 h-24 bg-green-100 rounded-full mx-auto flex items-center justify-center animate-pulse">
                                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">ข้อมูลครบถ้วน พร้อมบันทึก</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">ระบบได้เตรียมข้อมูลเอกสารลงทะเบียนเรียบร้อยแล้ว
                                กรุณาตรวจสอบตัวอย่างก่อนกดยืนยันการสร้าง</p>

                            <button type="button"
                                onclick="document.getElementById('previewModal').classList.remove('hidden')"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-indigo-300 hover:text-indigo-600 transition-all transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                ดูตัวอย่างเอกสารลงทะเบียน (Preview)
                            </button>
                        </div>

                        <!-- Preview Modal -->
                        <div id="previewModal" class="fixed inset-0 z-50 hidden overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div
                                class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                                    onclick="document.getElementById('previewModal').classList.add('hidden')"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                    aria-hidden="true">&#8203;</span>
                                <div
                                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
                                    <div
                                        class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-100">
                                        <h3 class="text-lg font-bold text-gray-900">ตัวอย่างเอกสารลงทะเบียน</h3>
                                        <button type="button"
                                            onclick="document.getElementById('previewModal').classList.add('hidden')"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div
                                        class="bg-white p-6 max-h-[70vh] overflow-auto bg-gray-100/50 flex justify-center">
                                        <div class="shadow-lg">
                                            @include('livewire.pdf.registration-document.preview')
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                                        <button type="button"
                                            onclick="document.getElementById('previewModal').classList.add('hidden')"
                                            class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 sm:ml-3 sm:w-auto sm:text-sm">
                                            ปิดหน้าต่าง
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer Navigation -->
                <div
                    class="bg-gray-50 px-6 py-4 border-t border-gray-100 rounded-b-2xl flex justify-between items-center">
                    <div>
                        @if ($currentStep > 1)
                            <button wire:click="prevStep"
                                class="inline-flex items-center px-6 py-2.5 border border-gray-300 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                                ย้อนกลับ
                            </button>
                        @endif
                    </div>
                    <div>
                        @if ($currentStep < 4)
                            <button wire:click="nextStep"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent shadow-md text-sm font-bold rounded-xl text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                                ถัดไป
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @else
                            <button wire:click="save"
                                class="inline-flex items-center px-8 py-2.5 border border-transparent shadow-lg shadow-green-500/30 text-sm font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $editingDocument ? 'บันทึกการแก้ไขเอกสารลงทะเบียน' : 'ยืนยันและสร้างเอกสารลงทะเบียน' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
