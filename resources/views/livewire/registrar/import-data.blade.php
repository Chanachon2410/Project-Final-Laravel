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

                <div class="relative z-10 flex items-center gap-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold">นำเข้าข้อมูลห้องเรียน (Import Class Data)</h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80">อัปโหลดไฟล์ Excel
                            เพื่อเพิ่มข้อมูลนักเรียนและจัดกลุ่มเรียนใหม่อัตโนมัติ</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6 md:p-8">

                <!-- Alerts -->
                @if (session()->has('message'))
                    <div
                        class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-green-800">สำเร็จ!</h3>
                            <p class="text-sm text-green-700 mt-1">{{ session('message') }}</p>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div
                        class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-red-800">เกิดข้อผิดพลาด</h3>
                            <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column: Upload Form -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                            เลือกไฟล์ข้อมูล
                        </h3>

                        <form wire:submit.prevent="import" class="space-y-6">
                            <div class="space-y-2">
                                <label for="file" class="block text-sm font-medium text-gray-700">ไฟล์ Excel
                                    (.xlsx)</label>

                                @if ($file)
                                    <div class="border-2 border-solid border-indigo-100 bg-white rounded-2xl p-6 flex flex-col items-center justify-center relative overflow-hidden">
                                        <div class="absolute top-0 right-0 p-2">
                                            <button type="button" wire:click="cancel"
                                                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-gray-100"
                                                title="ยกเลิกไฟล์นี้">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 truncate max-w-full px-4"
                                            title="{{ $file->getClientOriginalName() }}">
                                            {{ $file->getClientOriginalName() }}
                                        </p>
                                        <p class="text-xs text-green-600 mt-1 font-medium">พร้อมสำหรับการนำเข้า</p>
                                    </div>
                                @else
                                    <div class="relative group" x-data="{ isDragging: false }">
                                        <input type="file" wire:model="file" id="file"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                            @dragover="isDragging = true" @dragleave="isDragging = false"
                                            @drop="isDragging = false">

                                        <div class="border-2 border-dashed rounded-2xl p-8 text-center transition-all duration-200 flex flex-col items-center justify-center bg-gray-50 group-hover:bg-indigo-50 group-hover:border-indigo-400"
                                            :class="{ 'border-indigo-500 bg-indigo-50': isDragging, 'border-gray-300': !isDragging }">
                                            <div
                                                class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium text-gray-700">คลิกเพื่อเลือกไฟล์
                                                หรือลากไฟล์มาวางที่นี่</p>
                                            <p class="text-xs text-gray-400 mt-1">รองรับไฟล์ .xlsx เท่านั้น</p>
                                        </div>
                                    </div>
                                @endif
                                @error('file')
                                    <span class="text-red-500 text-xs font-medium flex items-center mt-1"><svg
                                            class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                    {{ !$file ? 'disabled' : '' }} wire:loading.attr="disabled"
                                    wire:target="file, import">
                                    <div wire:loading.remove wire:target="import" class="flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                            </path>
                                        </svg>
                                        <span class="text-base">นำเข้าข้อมูล (Import)</span>
                                    </div>
                                    <div wire:loading wire:target="import" class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-6 w-6 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span class="text-base">กำลังประมวลผล...</span>
                                    </div>
                                </button>
                            </div>

                            <!-- Loading State for File Upload -->
                            <div wire:loading wire:target="file" class="w-full">
                                <div class="flex items-center justify-center space-x-2 text-sm text-indigo-600">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span>กำลังอัปโหลดไฟล์...</span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column: Instructions -->
                    <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            คำแนะนำการใช้งาน
                        </h3>
                        <div class="prose prose-sm text-gray-600">
                            <ul class="space-y-2 list-none pl-0">
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                    <span>กรุณาอัปโหลดไฟล์นามสกุล <strong>.xlsx</strong> เท่านั้น</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                    <span>ระบบจะอ่านข้อมูลจาก <strong>Sheet แรก</strong> ของไฟล์ Excel</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                    <span>ระบบจะทำการค้นหาหรือสร้างข้อมูล ครู, นักเรียน,
                                        และกลุ่มเรียนใหม่อัตโนมัติ</span>
                                </li>
                            </ul>

                            <div class="mt-4 bg-white rounded-xl p-4 border border-indigo-100 shadow-sm">
                                <p class="text-xs font-bold text-indigo-800 uppercase mb-2">ตำแหน่งข้อมูลที่จำเป็น
                                    (Cell Reference)</p>
                                <ul class="space-y-1.5 text-xs">
                                    <li class="flex justify-between border-b border-gray-100 pb-1">
                                        <span>รหัสกลุ่มเรียน</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">C7</code>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-100 pb-1">
                                        <span>ชื่อกลุ่มเรียน (สาขา)</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">E7</code>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-100 pb-1">
                                        <span>ชื่อครูที่ปรึกษา</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">E8</code>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-100 pb-1">
                                        <span>ระดับชั้น/ห้อง</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">C8</code>
                                    </li>
                                    <li
                                        class="flex justify-between border-b border-gray-100 pb-1 pt-1 font-bold text-gray-800 bg-gray-50 -mx-4 px-4 mt-1">
                                        <span>ตารางรายชื่อนักเรียน (เริ่มแถวที่ 11)</span>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-100 pb-1">
                                        <span>เลขบัตรประชาชน</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">Column
                                            B</code>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-100 pb-1">
                                        <span>รหัสนักเรียน</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">Column
                                            C</code>
                                    </li>
                                    <li class="flex justify-between">
                                        <span>ชื่อ-นามสกุล</span>
                                        <code
                                            class="bg-gray-100 px-1.5 py-0.5 rounded text-indigo-600 font-bold">Column
                                            D</code>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
