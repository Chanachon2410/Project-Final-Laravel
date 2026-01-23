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
                            <span class="bg-white/20 p-2 rounded-xl">
                                <svg class="w-8 h-8 text-indigo-100" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </span>
                            จัดการค่าธรรมเนียม
                        </h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80 pl-14">ตั้งค่ารายการค่าเทอมและค่าใช้จ่ายอื่นๆ
                        </p>
                    </div>

                    <button wire:click="create()"
                        class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold py-2.5 px-5 rounded-xl border border-white/20 shadow-sm transition-all duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                        <span
                            class="bg-white text-indigo-600 rounded-lg p-1 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </span>
                        <span>เพิ่มค่าธรรมเนียมใหม่</span>
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
                                placeholder="ค้นหาชื่อค่าธรรมเนียม..."
                                class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>
                        <button wire:click="$refresh"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-md transition-colors flex items-center font-medium">
                            ค้นหา
                        </button>
                    </div>
                </div>

                <!-- Modern Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ชื่อค่าธรรมเนียม</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ภาคเรียน/ปีการศึกษา</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    จำนวนเงิน (บาท)</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($tuitionFees as $fee)
                                <tr class="hover:bg-violet-50/30 transition duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">{{ $fee->fee_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-600 border border-gray-200">
                                            {{ $fee->semester }}/{{ $fee->year }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span
                                            class="text-sm font-bold text-emerald-600">{{ number_format($fee->rate_money, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button wire:click="edit({{ $fee->id }})"
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
                                            <button wire:click="delete({{ $fee->id }})"
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
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="h-6 w-6 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium">ไม่พบข้อมูลค่าธรรมเนียม</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $tuitionFees->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if ($isOpen)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    wire:click="closeModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form>
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-violet-600 to-indigo-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="bg-white/20 p-1.5 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </span>
                                {{ $tuitionFeeId ? 'แก้ไขข้อมูลค่าธรรมเนียม' : 'เพิ่มค่าธรรมเนียมใหม่' }}
                            </h3>
                        </div>

                        <div class="bg-white px-6 py-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="fee_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">ชื่อค่าธรรมเนียม</label>
                                    <input type="text" wire:model="fee_name" id="fee_name"
                                        class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="เช่น ค่าบำรุงการศึกษา, ค่าหน่วยกิต">
                                    @error('fee_name')
                                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="semester"
                                            class="block text-gray-700 text-sm font-bold mb-2">ภาคเรียน</label>
                                        <select wire:model="semester" id="semester"
                                            class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            <option value="">เลือกภาคเรียน</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3 (ฤดูร้อน)</option>
                                        </select>
                                        @error('semester')
                                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="year"
                                            class="block text-gray-700 text-sm font-bold mb-2">ปีการศึกษา
                                            (พ.ศ.)</label>
                                        <input type="number" wire:model="year" id="year"
                                            class="shadow-sm border-gray-300 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                            placeholder="{{ date('Y') + 543 }}">
                                        @error('year')
                                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                                    <label for="rate_money"
                                        class="block text-emerald-800 text-sm font-bold mb-2">จำนวนเงิน (บาท)</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bold">฿</span>
                                        </div>
                                        <input type="number" step="0.01" wire:model="rate_money" id="rate_money"
                                            class="pl-8 shadow-sm border-emerald-200 rounded-xl w-full focus:ring-emerald-500 focus:border-emerald-500 text-lg font-bold text-emerald-700 placeholder-emerald-300"
                                            placeholder="0.00">
                                    </div>
                                    @error('rate_money')
                                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2 rounded-b-2xl">
                            <button wire:click.prevent="store()"
                                class="inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-base font-bold text-white hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 sm:text-sm">
                                บันทึก
                            </button>
                            <button wire:click="closeModal()"
                                class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors sm:text-sm">
                                ยกเลิก
                            </button>
                        </div>
                    </form>
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
                        text: (data.message || 'ต้องการลบข้อมูลนี้ใช่หรือไม่?') +
                            ' (ไม่สามารถกู้คืนได้)',
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
 