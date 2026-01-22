<div>
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">ตรวจสอบสถานะการลงทะเบียน</h1>

        <!-- Filters and Search -->
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
                <div class="flex items-center">
                    <label for="statusFilter" class="text-sm text-gray-600 mr-2">สถานะ:</label>
                    <select wire:model.live="statusFilter" id="statusFilter" class="text-sm rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">ทั้งหมด</option>
                        <option value="pending">รอตรวจสอบ</option>
                        <option value="approved">อนุมัติแล้ว</option>
                        <option value="rejected">ถูกปฏิเสธ</option>
                        <option value="unregistered">ยังไม่ลงทะเบียน</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center w-full md:w-auto">
                <label for="search" class="text-sm text-gray-600 mr-2 hidden md:block">ค้นหา:</label>
                <input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="ชื่อ, รหัสนักเรียน..." class="w-full md:w-64 text-sm rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Students Table (Adapted from Teacher View) -->
        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสนักศึกษา</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อ-นามสกุล</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">กลุ่มเรียน</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชั้นปี</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะการลงทะเบียน</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">หลักฐาน</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                        @php
                            $registration = $student->registrations->first();
                        @endphp
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $student->student_code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->classGroup->course_group_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->level->name ?? '-' }} ปีที่ {{ $student->classGroup->level_year ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($registration)
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-full border shadow-sm px-3 py-1 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                                            {{ $registration->status === 'approved' ? 'border-green-200 text-green-800 bg-green-50' : 
                                               ($registration->status === 'rejected' ? 'border-red-200 text-red-800 bg-red-50' : 'border-yellow-200 text-yellow-800 bg-yellow-50') }}" 
                                            aria-haspopup="true">
                                            {{ match($registration->status) {
                                                'pending' => 'รอตรวจสอบ',
                                                'approved' => 'อนุมัติแล้ว',
                                                'rejected' => 'ถูกปฏิเสธ',
                                                default => $registration->status
                                            } }}
                                            <svg class="-mr-1 ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
                                            <div class="py-1">
                                                <button wire:click="updateStatus({{ $registration->id }}, 'pending')" @click="open = false" class="text-yellow-700 block w-full text-left px-4 py-2 text-sm hover:bg-yellow-50">
                                                    รอตรวจสอบ
                                                </button>
                                                <button wire:click="updateStatus({{ $registration->id }}, 'approved')" @click="open = false" class="text-green-700 block w-full text-left px-4 py-2 text-sm hover:bg-green-50">
                                                    อนุมัติ (Approve)
                                                </button>
                                                <button wire:click="updateStatus({{ $registration->id }}, 'rejected')" @click="open = false" class="text-red-700 block w-full text-left px-4 py-2 text-sm hover:bg-red-50">
                                                    ปฏิเสธ (Reject)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($registration->status === 'approved' && $registration->approved_by)
                                        <div class="text-xs text-gray-500 mt-1">โดย: {{ $registration->approved_by }}</div>
                                    @endif
                                @else
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-full border border-gray-200 shadow-sm px-3 py-1 bg-gray-50 text-xs font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            ยังไม่ลงทะเบียน
                                            <svg class="-mr-1 ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
                                            <div class="py-1">
                                                <div class="px-4 py-2 text-xs text-gray-400 border-b">สร้างรายการใหม่:</div>
                                                <button wire:click="updateStatus(null, 'approved', {{ $student->id }})" @click="open = false" class="text-green-700 block w-full text-left px-4 py-2 text-sm hover:bg-green-50">
                                                    อนุมัติทันที (Approve)
                                                </button>
                                                <button wire:click="updateStatus(null, 'pending', {{ $student->id }})" @click="open = false" class="text-yellow-700 block w-full text-left px-4 py-2 text-sm hover:bg-yellow-50">
                                                    รอตรวจสอบ (Pending)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button wire:click="viewProof({{ $student->id }})" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    ดูหลักฐาน
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center italic">
                                ไม่พบข้อมูลนักเรียน
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

    <!-- Proof Modal -->
    @if($isShowProofModalOpen && $selectedStudent)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 wire:click="closeProofModal" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                หลักฐานการลงทะเบียน
                            </h3>
                            
                            <!-- Student Info -->
                            <div class="col-span-1 md:col-span-2 bg-gray-50 p-3 rounded mb-4 border border-gray-100">
                                <p class="text-sm"><strong>นักเรียน:</strong> {{ $selectedStudent->title }}{{ $selectedStudent->firstname }} {{ $selectedStudent->lastname }}</p>
                                <p class="text-sm"><strong>รหัส:</strong> {{ $selectedStudent->student_code }}</p>
                                <p class="text-sm"><strong>กลุ่มเรียน:</strong> {{ $selectedStudent->classGroup->course_group_name ?? '-' }}</p>
                                @if($selectedRegistration)
                                    <p class="text-sm"><strong>วันที่ส่ง:</strong> {{ $selectedRegistration->created_at->format('d/m/Y H:i') }} น.</p>
                                @else
                                    <p class="text-sm text-red-500 font-bold">สถานะ: ยังไม่มีการส่งหลักฐานในภาคเรียนนี้</p>
                                @endif
                            </div>

                            @if($selectedRegistration)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Slip File -->
                                    <div class="border rounded p-2">
                                        <p class="text-sm font-bold mb-2 text-gray-700">สลิปการโอนเงิน (Slip)</p>
                                        @if($selectedRegistration->slip_file_name)
                                            <div class="relative group">
                                                <a href="{{ asset('storage/' . $selectedRegistration->slip_file_name) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $selectedRegistration->slip_file_name) }}" 
                                                         alt="Slip" 
                                                         class="w-full h-auto rounded shadow-sm hover:opacity-90 transition-opacity cursor-pointer border">
                                                </a>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center h-32 bg-gray-100 text-gray-400 rounded italic text-xs">
                                                ไม่พบไฟล์สลิป
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Registration Card File -->
                                    <div class="border rounded p-2">
                                        <p class="text-sm font-bold mb-2 text-gray-700">บัตรลงทะเบียน (Registration Card)</p>
                                        @if($selectedRegistration->registration_card_file)
                                            <div class="relative group">
                                                <a href="{{ asset('storage/' . $selectedRegistration->registration_card_file) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $selectedRegistration->registration_card_file) }}" 
                                                         alt="Card" 
                                                         class="w-full h-auto rounded shadow-sm hover:opacity-90 transition-opacity cursor-pointer border">
                                                </a>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center h-32 bg-gray-100 text-gray-400 rounded italic text-xs">
                                                ไม่พบไฟล์บัตรลงทะเบียน
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($selectedRegistration->remarks)
                                    <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded text-red-700 text-sm">
                                        <strong>หมายเหตุ (จากทะเบียน):</strong> {{ $selectedRegistration->remarks }}
                                    </div>
                                @endif
                            @else
                                <div class="py-10 text-center bg-gray-50 rounded border border-dashed border-gray-300">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500 font-medium">ไม่พบหลักฐานการลงทะเบียน</p>
                                    <p class="text-xs text-gray-400">นักเรียนยังไม่ได้ดำเนินการอัพโหลดสลิปหรือบัตรลงทะเบียนในระบบ</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between">
                    <div class="flex flex-row-reverse">
                        <button type="button" wire:click="closeProofModal" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            ปิดหน้าต่าง
                        </button>
                        
                        @if($selectedRegistration && $selectedRegistration->status === 'pending')
                            <button type="button" 
                                wire:click="approveRegistration({{ $selectedRegistration->id }})" 
                                wire:confirm="ยืนยันการอนุมัติการลงทะเบียนของ {{ $selectedStudent->firstname }} ใช่หรือไม่?"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                อนุมัติการลงทะเบียน
                            </button>
                        @endif
                    </div>
                    
                    @if($selectedRegistration && $selectedRegistration->status === 'approved' && $selectedRegistration->approved_by)
                        <div class="flex items-center text-sm text-green-600 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            อนุมัติแล้วโดย: {{ $selectedRegistration->approved_by }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>