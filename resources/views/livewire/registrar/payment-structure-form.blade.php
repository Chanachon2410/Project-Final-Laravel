<div class="p-6 bg-white rounded-lg shadow-lg">
    <!-- Progress Bar -->
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

    <!-- Step 1: Basic Info -->
    @if ($currentStep == 1)
        <div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">ปีการศึกษา (พ.ศ.)</label>
                    <input type="number" wire:model="year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ภาคเรียน</label>
                    <select wire:model="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">ฤดูร้อน</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ระดับชั้น</label>
                    <select wire:model.live="level_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- เลือกระดับชั้น --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">สาขาวิชา</label>
                    <select wire:model.live="major_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- เลือกสาขาวิชา --</option>
                        @foreach($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->major_name }} ({{ $major->major_code }})</option>
                        @endforeach
                    </select>
                    @error('major_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">รหัสกลุ่มเรียน (Ref.2) *ถ้าต้องการกำหนดเอง</label>
                    <input type="text" wire:model="custom_ref2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="เช่น 682020101 (ถ้าเว้นว่างจะใช้รหัสสาขา)">
                    @error('custom_ref2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="col-span-2 border-t pt-4 mt-2">
                    <h3 class="text-lg font-semibold mb-3">กำหนดการชำระเงิน (สำหรับแสดงในใบแจ้งหนี้)</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">วันที่เริ่มชำระ</label>
                    <input type="date" wire:model="payment_start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">วันสิ้นสุดการชำระ</label>
                    <input type="date" wire:model.live="payment_end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">เริ่มปรับล่าช้า</label>
                    <input type="date" wire:model="late_payment_start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">สิ้นสุดการปรับ</label>
                    <input type="date" wire:model="late_payment_end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>
    @endif

    <!-- Step 2: Subjects -->
    @if ($currentStep == 2)
        <div>

            
            <!-- Search -->
            <div class="mb-4">
                <input type="text" wire:model.live.debounce.300ms="searchSubject" placeholder="ค้นหารหัสวิชา หรือ ชื่อวิชา..." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Search Results -->
                <div class="bg-gray-50 p-4 rounded border h-96 overflow-y-auto">
                    <h3 class="font-semibold mb-2 text-gray-700">ผลการค้นหา</h3>
                    @forelse($subjects as $subject)
                        <div class="flex items-center justify-between p-2 bg-white mb-2 rounded shadow-sm hover:bg-gray-100 cursor-pointer" wire:click="toggleSubject({{ $subject->id }})">
                            <div>
                                <div class="font-bold">{{ $subject->subject_code }}</div>
                                <div class="text-sm text-gray-600">{{ $subject->subject_name }}</div>
                            </div>
                            <div>
                                @if(isset($selectedSubjects[$subject->id]))
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

                <!-- Selected List -->
                <div class="bg-blue-50 p-4 rounded border h-96 overflow-y-auto">
                    <h3 class="font-semibold mb-2 text-blue-800">รายวิชาที่เลือก ({{ count($selectedSubjects) }})</h3>
                    @foreach($selectedSubjects as $id => $subj)
                        <div class="bg-white p-3 mb-2 rounded shadow-sm border-l-4 border-blue-500">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-bold text-gray-800">{{ $subj['code'] }} {{ $subj['name'] }}</div>
                                </div>
                                <button wire:click="toggleSubject({{ $id }})" class="text-red-500 hover:text-red-700">ลบ</button>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-2">
                                <div>
                                    <label class="text-xs text-gray-500">หน่วยกิต</label>
                                    <input type="number" wire:model="selectedSubjects.{{ $id }}.credit" class="w-full text-sm border-gray-300 rounded p-1">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">ชม.ทฤษฎี</label>
                                    <input type="number" wire:model="selectedSubjects.{{ $id }}.hour_theory" class="w-full text-sm border-gray-300 rounded p-1">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">ชม.ปฏิบัติ</label>
                                    <input type="number" wire:model="selectedSubjects.{{ $id }}.hour_practical" class="w-full text-sm border-gray-300 rounded p-1">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Step 3: Fees -->
    @if ($currentStep == 3)
        <div>

            <div class="mb-4 p-4 bg-yellow-50 text-yellow-800 rounded text-sm">
                * เลือกรายการค่าใช้จ่ายจากฐานข้อมูล หรือเพิ่มรายการใหม่เองได้
            </div>

            <!-- Search -->
            <div class="mb-4">
                <input type="text" wire:model.live.debounce.300ms="searchFee" placeholder="ค้นหาชื่อค่าใช้จ่าย..." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Available Fees List -->
                <div class="bg-gray-50 p-4 rounded border h-96 overflow-y-auto">
                    <h3 class="font-semibold mb-2 text-gray-700">รายการค่าใช้จ่ายที่มี (ภาคเรียน {{ $semester }}/{{ $year }})</h3>
                    @forelse($availableFees as $fee)
                        <div class="flex items-center justify-between p-2 bg-white mb-2 rounded shadow-sm hover:bg-gray-100 cursor-pointer" wire:click="selectFee({{ $fee->id }})">
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
                            <span class="text-xs">กรุณาเพิ่มข้อมูลในเมนู "Tuition Fees" หรือเพิ่มรายการเองด้านขวา</span>
                        </div>
                    @endforelse
                </div>

                <!-- Selected Fees List -->
                <div class="bg-blue-50 p-4 rounded border h-96 overflow-y-auto">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-blue-800">รายการที่เลือก ({{ count($fees) }})</h3>
                        <button wire:click="addCustomFee" class="text-xs bg-white border border-blue-500 text-blue-500 px-2 py-1 rounded hover:bg-blue-50">
                            + เพิ่มรายการเอง
                        </button>
                    </div>

                    @foreach($fees as $index => $fee)
                        <div class="bg-white p-3 mb-2 rounded shadow-sm border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="w-full mr-2">
                                    <input type="text" wire:model="fees.{{ $index }}.name" class="w-full font-bold text-gray-800 border-none p-0 focus:ring-0" placeholder="ชื่อรายการ...">
                                </div>
                                <button wire:click="removeFee({{ $index }})" class="text-red-500 hover:text-red-700 font-bold">X</button>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">จำนวนเงิน (บาท)</label>
                                <input type="number" wire:model="fees.{{ $index }}.amount" class="w-full text-sm border-gray-300 rounded p-1 text-right" placeholder="0.00">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Step 4: Review -->
    @if ($currentStep == 4)
        @include('livewire.pdf.invoice-preview')
    @endif

    <!-- Navigation Buttons -->
    <div class="mt-8 flex justify-between border-t pt-4">
        @if ($currentStep > 1)
            <button wire:click="prevStep" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                ย้อนกลับ
            </button>
        @else
            <div></div> <!-- Spacer -->
        @endif

        @if ($currentStep < 4)
            <button wire:click="nextStep" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                ถัดไป >
            </button>
        @else
            <button wire:click="save" class="px-8 py-2 bg-green-600 text-white font-bold rounded shadow hover:bg-green-700">
                ยืนยันและสร้างใบแจ้งหนี้
            </button>
        @endif
    </div>
</div>