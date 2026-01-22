<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $currentStep * 25 }}%"></div>
            </div>
        </div>
        <div class="flex justify-between mt-2 text-sm font-medium text-gray-500">
            <span class="{{ $currentStep >= 1 ? 'text-blue-600' : '' }}">1. ข้อมูลทั่วไป</span>
            <span class="{{ $currentStep >= 2 ? 'text-blue-600' : '' }}">2. เลือกรายวิชา</span>
            <span class="{{ $currentStep >= 3 ? 'text-blue-600' : '' }}">3. ค่าใช้จ่าย</span>
            <span class="{{ $currentStep >= 4 ? 'text-blue-600' : '' }}">4. ตรวจสอบ & บันทึก</span>
        </div>
    </div>

    @if ($currentStep == 1)
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">ปีการศึกษา (พ.ศ.)</label>
                    <input type="number" wire:model="year"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ภาคเรียน</label>
                    <select wire:model="semester"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">ฤดูร้อน</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ระดับชั้น</label>
                    <select wire:model.live="level_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- เลือกระดับชั้น --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">สาขาวิชา</label>
                    <select wire:model.live="major_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- เลือกสาขาวิชา --</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->major_name }} ({{ $major->major_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('major_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">รหัสกลุ่มเรียน (Ref.2)
                        *ถ้าต้องการกำหนดเอง</label>
                    <input type="text" wire:model="custom_ref2"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="เช่น 682020101 (ถ้าเว้นว่างจะใช้รหัสสาขา)">
                    @error('custom_ref2')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 border-t pt-4 mt-2">
                    <h3 class="text-lg font-semibold mb-3">กำหนดการชำระเงิน (สำหรับแสดงในใบแจ้งหนี้)</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">วันที่เริ่มชำระ</label>
                    <input type="date" wire:model="payment_start_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">วันสิ้นสุดการชำระ</label>
                    <input type="date" wire:model.live="payment_end_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">เริ่มปรับล่าช้า</label>
                    <input type="date" wire:model="late_payment_start_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">สิ้นสุดการปรับ</label>
                    <input type="date" wire:model="late_payment_end_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="col-span-2 border-t pt-4 mt-2">
                    <h3 class="text-lg font-semibold mb-3">ตั้งค่าค่าปรับล่าช้า</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">รูปแบบการปรับ</label>
                    <select wire:model.live="late_fee_type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="flat">ปวช. / ปวส. (เหมาจ่ายครั้งเดียว)</option>
                        <option value="daily">ป.ตรี (ปรับรายวัน)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ $late_fee_type == 'flat' ? 'จำนวนเงินที่ต้องจ่าย (บาท)' : 'คิดค่าปรับวันละ (บาท)' }}
                    </label>
                    <input type="number" wire:model.live="late_fee_amount"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="0.00">
                    @error('late_fee_amount')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @if ($late_fee_type == 'daily')
                    <div class="col-span-2 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Input: จำนวนวัน --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">จำนวนวันล่าช้าสูงสุด</label>
                                <div class="relative">
                                    <input type="number" wire:model.live="calculate_days"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="เช่น 15">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">วัน</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Input: ผลรวม (ปรับสูงสุด) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    = ปรับสูงสุดไม่เกิน (บาท) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" wire:model="late_fee_max_amount" readonly
                                        class="block w-full border-gray-300 bg-gray-50 text-gray-800 font-bold rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">บาท</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Hint Text --}}
                        @if ($calculate_days && $late_fee_amount)
                            <p class="mt-2 text-xs text-gray-400 flex justify-end italic">
                                (สูตรคำนวณ: {{ number_format((float) $late_fee_amount) }} บาท x {{ $calculate_days }}
                                วัน)
                            </p>
                        @endif

                        @error('late_fee_max_amount')
                            <p class="mt-1 text-xs text-red-500 text-right">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if ($currentStep == 2)
        <div>
            <div class="mb-4">
                <input type="text" wire:model.live.debounce.300ms="searchSubject"
                    placeholder="ค้นหารหัสวิชา หรือ ชื่อวิชา..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded border h-96 overflow-y-auto">
                    <h3 class="font-semibold mb-2 text-gray-700">ผลการค้นหา</h3>
                    @forelse($subjects as $subject)
                        <div class="flex items-center justify-between p-2 bg-white mb-2 rounded shadow-sm hover:bg-gray-100 cursor-pointer"
                            wire:click="toggleSubject({{ $subject->id }})">
                            <div>
                                <div class="font-bold">{{ $subject->subject_code }}</div>
                                <div class="text-sm text-gray-600">{{ $subject->subject_name }}</div>
                            </div>
                            <div>
                                @if (isset($selectedSubjects[$subject->id]))
                                    <span class="text-green-600 font-bold">✓ เลือกแล้ว</span>
                                @else
                                    <span class="text-gray-400">+ เพิ่ม</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 text-center mt-10">ไม่พบรายวิชา</div>
                    @endforelse
                </div>

                <div class="bg-blue-50 p-4 rounded border h-96 overflow-y-auto">
                    <h3 class="font-semibold mb-2 text-blue-800">รายวิชาที่เลือก ({{ count($selectedSubjects) }})</h3>
                    @foreach ($selectedSubjects as $id => $subj)
                        <div class="bg-white p-3 mb-2 rounded shadow-sm border-l-4 border-blue-500">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-bold text-gray-800">{{ $subj['code'] }} {{ $subj['name'] }}
                                    </div>
                                </div>
                                <button wire:click="toggleSubject({{ $id }})"
                                    class="text-red-500 hover:text-red-700">ลบ</button>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-2">
                                <div>
                                    <label class="text-xs text-gray-500">หน่วยกิต</label>
                                    <input type="number" wire:model="selectedSubjects.{{ $id }}.credit"
                                        class="w-full text-sm border-gray-300 rounded p-1">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">ชม.ทฤษฎี</label>
                                    <input type="number"
                                        wire:model="selectedSubjects.{{ $id }}.hour_theory"
                                        class="w-full text-sm border-gray-300 rounded p-1">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">ชม.ปฏิบัติ</label>
                                    <input type="number"
                                        wire:model="selectedSubjects.{{ $id }}.hour_practical"
                                        class="w-full text-sm border-gray-300 rounded p-1">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary & Rate Settings --}}
            <div class="mt-6 p-4 bg-indigo-50 border border-indigo-200 rounded-md">
                <h3 class="font-semibold text-indigo-800 mb-3">สรุปหน่วยกิตและตั้งค่าราคา (สำหรับคำนวณค่าลงทะเบียน)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Theory Section --}}
                    <div class="bg-white p-4 rounded shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">หน่วยกิตทฤษฎีรวม</span>
                            <span class="text-lg font-bold text-indigo-600">{{ $totalTheoryCredits }}</span>
                        </div>
                        <div class="flex items-center">
                            <label class="text-xs text-gray-500 mr-2">ราคา/หน่วย:</label>
                            <input type="number" wire:model.live="theoryRate" 
                                class="w-24 text-sm border-gray-300 rounded p-1 text-right" placeholder="100">
                            <span class="text-xs text-gray-500 ml-1">บาท</span>
                        </div>
                        <div class="mt-2 text-right text-sm text-gray-600">
                            รวมเงิน: <strong>{{ number_format($totalTheoryCredits * ($theoryRate ?? 0), 2) }}</strong> บาท
                        </div>
                    </div>

                    {{-- Practical Section --}}
                    <div class="bg-white p-4 rounded shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">หน่วยกิตปฏิบัติรวม</span>
                            <span class="text-lg font-bold text-indigo-600">{{ $totalPracticalCredits }}</span>
                        </div>
                        <div class="flex items-center">
                            <label class="text-xs text-gray-500 mr-2">ราคา/หน่วย:</label>
                            <input type="number" wire:model.live="practicalRate" 
                                class="w-24 text-sm border-gray-300 rounded p-1 text-right" placeholder="100">
                            <span class="text-xs text-gray-500 ml-1">บาท</span>
                        </div>
                        <div class="mt-2 text-right text-sm text-gray-600">
                            รวมเงิน: <strong>{{ number_format($totalPracticalCredits * ($practicalRate ?? 0), 2) }}</strong> บาท
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-right">
                    <span class="text-sm text-gray-500">* ยอดเงินนี้จะถูกนำไปสร้างเป็นรายการค่าใช้จ่ายในขั้นตอนถัดไป</span>
                </div>
            </div>
        </div>
    @endif

    @if ($currentStep == 3)
        <div>
            <div class="mb-4 p-4 bg-yellow-50 text-yellow-800 rounded text-sm">
                * เลือกรายการค่าใช้จ่ายจากฐานข้อมูล หรือเพิ่มรายการใหม่เองได้
            </div>

            <div class="mb-4">
                <input type="text" wire:model.live.debounce.300ms="searchFee" placeholder="ค้นหาชื่อค่าใช้จ่าย..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded border h-96 overflow-y-auto">
                    <h3 class="font-semibold mb-2 text-gray-700">รายการค่าใช้จ่ายที่มี (ภาคเรียน
                        {{ $semester }}/{{ $year }})</h3>
                    @forelse($availableFees as $fee)
                        <div class="flex items-center justify-between p-2 bg-white mb-2 rounded shadow-sm hover:bg-gray-100 cursor-pointer"
                            wire:click="selectFee({{ $fee->id }})">
                            <div>
                                <div class="font-medium">{{ $fee->fee_name }}</div>
                            </div>
                            <div class="text-green-600 font-bold">
                                {{ number_format($fee->rate_money, 2) }} ฿
                                <span class="text-xs text-gray-400 ml-1">+ เพิ่ม</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 text-center mt-10">
                            ไม่พบรายการค่าใช้จ่ายสำหรับภาคเรียนนี้<br>
                            <span class="text-xs">กรุณาเพิ่มข้อมูลในเมนู "Tuition Fees"
                                หรือเพิ่มรายการเองด้านขวา</span>
                        </div>
                    @endforelse
                </div>

                <div class="bg-blue-50 p-4 rounded border h-96 overflow-y-auto">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-blue-800">รายการที่เลือก ({{ count($fees) }})</h3>
                        <button wire:click="addCustomFee"
                            class="text-xs bg-white border border-blue-500 text-blue-500 px-2 py-1 rounded hover:bg-blue-50">
                            + เพิ่มรายการเอง
                        </button>
                    </div>

                    @foreach ($fees as $index => $fee)
                        <div class="bg-white p-3 mb-2 rounded shadow-sm border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="w-full mr-2">
                                    <input type="text" wire:model="fees.{{ $index }}.name"
                                        class="w-full font-bold text-gray-800 border-none p-0 focus:ring-0"
                                        placeholder="ชื่อรายการ...">
                                </div>
                                <button wire:click="removeFee({{ $index }})"
                                    class="text-red-500 hover:text-red-700 font-bold">X</button>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">จำนวนเงิน (บาท)</label>
                                <input type="number" wire:model="fees.{{ $index }}.amount"
                                    class="w-full text-sm border-gray-300 rounded p-1 text-right" placeholder="0.00">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if ($currentStep == 4)
        <div class="text-center py-10">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">ข้อมูลครบถ้วน</h3>
            <p class="text-gray-500 mb-6">คุณสามารถตรวจสอบตัวอย่างใบแจ้งหนี้ก่อนทำการบันทึกได้</p>

            <button type="button" onclick="document.getElementById('previewModal').classList.remove('hidden')"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="mr-2 -ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                ดูตัวอย่างใบแจ้งหนี้ (Preview)
            </button>
        </div>

        <div id="previewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    onclick="document.getElementById('previewModal').classList.add('hidden')"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center border-b">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">ตัวอย่างใบแจ้งหนี้
                        </h3>
                        <button type="button"
                            onclick="document.getElementById('previewModal').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div
                            class="border border-gray-200 rounded p-4 bg-gray-100 overflow-auto max-h-[70vh] flex justify-center">
                            @include('livewire.pdf.invoice-preview')
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                            onclick="document.getElementById('previewModal').classList.add('hidden')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            ปิดหน้าต่าง
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-8 flex justify-between border-t pt-4">
        @if ($currentStep > 1)
            <button wire:click="prevStep" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                ย้อนกลับ
            </button>
        @else
            <div></div>
        @endif

        @if ($currentStep < 4)
            <button wire:click="nextStep" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                ถัดไป >
            </button>
        @else
            <button wire:click="save"
                class="px-8 py-2 bg-green-600 text-white font-bold rounded shadow hover:bg-green-700">
                ยืนยันและสร้างใบแจ้งหนี้
            </button>
        @endif
    </div>
</div>
