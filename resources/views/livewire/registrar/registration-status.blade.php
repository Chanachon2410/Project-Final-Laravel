<div>
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">ตรวจสอบสถานะการลงทะเบียน</h1>

        <!-- Filters and Search -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <label for="perPage" class="text-sm text-gray-600 mr-2">แสดง:</label>
                    <select wire:model.live="perPage" id="perPage" class="text-sm rounded-md border-gray-300">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <label for="statusFilter" class="text-sm text-gray-600 mr-2">สถานะ:</label>
                    <select wire:model.live="statusFilter" id="statusFilter" class="text-sm rounded-md border-gray-300">
                        <option value="">ทั้งหมด</option>
                        <option value="pending">รอตรวจสอบ</option>
                        <option value="approved">อนุมัติแล้ว</option>
                        <option value="rejected">ถูกปฏิเสธ</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center">
                <label for="search" class="text-sm text-gray-600 mr-2">ค้นหา:</label>
                <input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="ชื่อ, รหัสนักเรียน..." class="text-sm rounded-md border-gray-300">
            </div>
        </div>

        <!-- Registrations Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสนักเรียน</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อ-สกุล</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">กลุ่มเรียน</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่ส่ง</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($registrations as $registration)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->student->student_code ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $registration->student->title ?? '' }}{{ $registration->student->firstname ?? '' }} {{ $registration->student->lastname ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->student->classGroup->course_group_name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <select wire:change="updateStatus({{ $registration->id }}, $event.target.value)"
                                    class="text-xs rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-1 pl-2 pr-8
                                    @if($registration->status == 'approved') text-green-800 bg-green-100 border-green-200
                                    @elseif($registration->status == 'rejected') text-red-800 bg-red-100 border-red-200
                                    @else text-yellow-800 bg-yellow-100 border-yellow-200 @endif">
                                    <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>รอตรวจสอบ</option>
                                    <option value="approved" {{ $registration->status == 'approved' ? 'selected' : '' }}>อนุมัติแล้ว</option>
                                    <option value="rejected" {{ $registration->status == 'rejected' ? 'selected' : '' }}>ถูกปฏิเสธ</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <button wire:click="viewProof({{ $registration->id }})" 
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
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                ไม่พบข้อมูลการลงทะเบียน
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $registrations->links() }}
        </div>
    </div>

    <!-- Proof Modal -->
    @if($isShowProofModalOpen && $selectedRegistration)
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
                                <p class="text-sm"><strong>นักเรียน:</strong> {{ $selectedStudent->title ?? '' }}{{ $selectedStudent->firstname ?? '' }} {{ $selectedStudent->lastname ?? '' }}</p>
                                <p class="text-sm"><strong>รหัส:</strong> {{ $selectedStudent->student_code ?? '' }}</p>
                                <p class="text-sm"><strong>วันที่ส่ง:</strong> {{ $selectedRegistration->created_at->format('d/m/Y H:i') }} น.</p>
                            </div>

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

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="approveRegistration({{ $selectedRegistration->id }})" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        อนุมัติ
                    </button>
                    <button type="button" wire:click="rejectRegistration({{ $selectedRegistration->id }})" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        ปฏิเสธ
                    </button>
                    <button type="button" wire:click="closeProofModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>