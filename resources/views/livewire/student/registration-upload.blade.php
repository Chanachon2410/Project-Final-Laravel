<div>
    <!-- แนะนำให้เพิ่ม Link Font Prompt ในไฟล์ Layout หลัก (app.blade.php) -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->

    <div class="p-6 md:p-8 font-sans">
        <!-- Header Section -->
        <div
            class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 shadow-lg shadow-indigo-200 text-white p-6 sm:p-10">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-pink-500 opacity-20 blur-xl">
            </div>

            <div class="relative z-10">
                <h1 class="text-2xl md:text-3xl font-bold mb-4 flex items-center gap-3">
                    <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    อัปโหลดหลักฐานการลงทะเบียนเรียน
                </h1>

                @if ($activeSemester)
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/20 text-sm md:text-base font-medium">
                        <span class="relative flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        เปิดลงทะเบียน: ภาคเรียนที่ {{ $activeSemester->semester }}/{{ $activeSemester->year }}
                        <span class="ml-2 text-indigo-100 text-xs md:text-sm border-l border-indigo-400 pl-2">
                            (หมดเขต:
                            {{ $activeSemester->registration_end_date ? $activeSemester->registration_end_date->format('d/m/Y') : '-' }})
                        </span>
                    </div>
                @else
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 text-yellow-50 text-sm md:text-base font-medium">
                        <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        ยังไม่มีภาคเรียนที่เปิดให้ลงทะเบียนในขณะนี้
                    </div>
                @endif
            </div>
        </div>

        @if ($activeSemester)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Upload Form Column -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </span>
                                ส่งเอกสารหลักฐาน
                            </h2>
                        </div>

                        <div class="p-6 md:p-8">
                            <form wire:submit.prevent="saveRegistration" class="space-y-8">
                                <!-- 1. Registration Card Upload -->
                                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <label class="block text-sm font-bold text-gray-700 mb-3 flex justify-between">
                                        <span>1. ไฟล์ใบลงทะเบียน (PDF/Image)</span>
                                        @if ($registration_card_file)
                                            <span
                                                class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-md font-medium">เลือกไฟล์แล้ว</span>
                                        @endif
                                    </label>

                                    @if (!$registration_card_file)
                                        <label for="registration_card_file"
                                            class="group relative flex flex-col items-center justify-center w-full h-48 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-violet-50 hover:border-violet-400 transition-all duration-300 cursor-pointer">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <div
                                                    class="w-14 h-14 mb-3 rounded-full bg-white shadow-sm flex items-center justify-center group-hover:scale-110 group-hover:bg-violet-600 group-hover:text-white text-gray-400 transition-all duration-300">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p
                                                    class="mb-1 text-sm text-gray-500 group-hover:text-violet-700 font-medium">
                                                    คลิกเพื่ออัปโหลด หรือลากไฟล์มาวาง</p>
                                                <p class="text-xs text-gray-400">PNG, JPG, PDF (ไม่เกิน 5MB)</p>
                                            </div>
                                            <input id="registration_card_file" wire:model="registration_card_file"
                                                type="file" class="hidden" accept="image/*,application/pdf" />
                                        </label>
                                    @else
                                        <div
                                            class="relative flex items-center p-4 bg-violet-50 border border-violet-100 rounded-xl group hover:shadow-md transition-shadow">
                                            <div
                                                class="flex-shrink-0 h-16 w-16 mr-4 bg-white rounded-lg border border-violet-100 flex items-center justify-center overflow-hidden">
                                                @if (str_contains($registration_card_file->getMimeType(), 'image'))
                                                    <img src="{{ $registration_card_file->temporaryUrl() }}"
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <svg class="w-8 h-8 text-red-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-gray-900 truncate">
                                                    {{ $registration_card_file->getClientOriginalName() }}</p>
                                                <p class="text-xs text-violet-600">
                                                    {{ number_format($registration_card_file->getSize() / 1024, 2) }} KB
                                                </p>
                                            </div>
                                            <button type="button" wire:click="$set('registration_card_file', null)"
                                                class="ml-2 p-2 bg-white rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 shadow-sm transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif

                                    <div x-show="isUploading" class="mt-3">
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-violet-600 h-1.5 rounded-full transition-all duration-300"
                                                :style="`width: ${progress}%`"></div>
                                        </div>
                                        <p class="text-xs text-right text-violet-600 mt-1" x-text="`${progress}%`"></p>
                                    </div>
                                    @error('registration_card_file')
                                        <p class="mt-2 text-sm text-red-500 font-medium flex items-center"><svg
                                                class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 2. Slip Upload -->
                                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <label class="block text-sm font-bold text-gray-700 mb-3 flex justify-between">
                                        <span>2. ไฟล์สลิปโอนเงิน (PDF/Image)</span>
                                        @if ($slip_file_name)
                                            <span
                                                class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-md font-medium">เลือกไฟล์แล้ว</span>
                                        @endif
                                    </label>

                                    @if (!$slip_file_name)
                                        <label for="slip_file_name"
                                            class="group relative flex flex-col items-center justify-center w-full h-48 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-violet-50 hover:border-violet-400 transition-all duration-300 cursor-pointer">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <div
                                                    class="w-14 h-14 mb-3 rounded-full bg-white shadow-sm flex items-center justify-center group-hover:scale-110 group-hover:bg-violet-600 group-hover:text-white text-gray-400 transition-all duration-300">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p
                                                    class="mb-1 text-sm text-gray-500 group-hover:text-violet-700 font-medium">
                                                    คลิกเพื่ออัปโหลดสลิป</p>
                                                <p class="text-xs text-gray-400">PNG, JPG, PDF (ไม่เกิน 5MB)</p>
                                            </div>
                                            <input id="slip_file_name" wire:model="slip_file_name" type="file"
                                                class="hidden" accept="image/*,application/pdf" />
                                        </label>
                                    @else
                                        <div
                                            class="relative flex items-center p-4 bg-green-50 border border-green-100 rounded-xl group hover:shadow-md transition-shadow">
                                            <div
                                                class="flex-shrink-0 h-16 w-16 mr-4 bg-white rounded-lg border border-green-100 flex items-center justify-center overflow-hidden">
                                                @if (str_contains($slip_file_name->getMimeType(), 'image'))
                                                    <img src="{{ $slip_file_name->temporaryUrl() }}"
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <svg class="w-8 h-8 text-red-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-gray-900 truncate">
                                                    {{ $slip_file_name->getClientOriginalName() }}</p>
                                                <p class="text-xs text-green-600">พร้อมอัปโหลด</p>
                                            </div>
                                            <button type="button" wire:click="$set('slip_file_name', null)"
                                                class="ml-2 p-2 bg-white rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 shadow-sm transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif

                                    <div x-show="isUploading" class="mt-3">
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-indigo-600 h-1.5 rounded-full transition-all duration-300"
                                                :style="`width: ${progress}%`"></div>
                                        </div>
                                    </div>
                                    @error('slip_file_name')
                                        <p class="mt-2 text-sm text-red-500 font-medium flex items-center"><svg
                                                class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center py-3.5 px-6 border border-transparent shadow-lg shadow-indigo-500/30 text-base font-bold rounded-xl text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:-translate-y-0.5"
                                        wire:loading.attr="disabled" @if (!$registration_card_file || !$slip_file_name) disabled @endif>
                                        <span wire:loading.remove class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            ยืนยันการส่งข้อมูล
                                        </span>
                                        <span wire:loading class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            กำลังดำเนินการ...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- History / Status Column -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            ประวัติการส่ง
                        </h2>

                        <div class="space-y-4">
                            @forelse ($registrations as $registration)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-sm font-bold text-gray-700">ภาคเรียน
                                            {{ $registration->semester }}/{{ $registration->year }}</span>
                                        <button wire:click="viewEvidence({{ $registration->id }})"
                                            class="text-gray-400 hover:text-indigo-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex items-center justify-between mt-3">
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-lg
                                            {{ $registration->status === 'approved'
                                                ? 'bg-green-100 text-green-700'
                                                : ($registration->status === 'rejected'
                                                    ? 'bg-red-100 text-red-700'
                                                    : 'bg-yellow-100 text-yellow-700') }}">
                                            @if ($registration->status === 'approved')
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block mr-1"></span>อนุมัติแล้ว
                                            @elseif($registration->status === 'rejected')
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block mr-1"></span>ถูกปฏิเสธ
                                            @else
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-yellow-500 inline-block mr-1"></span>รอตรวจสอบ
                                            @endif
                                        </span>
                                        <span
                                            class="text-xs text-gray-400">{{ $registration->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-sm">ยังไม่มีประวัติการส่ง</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Evidence Modal (Same content but cleaner style) -->
    @if ($isViewModalOpen && $selectedRegistration)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    wire:click="closeViewModal" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-6 py-6">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                รายละเอียดหลักฐาน
                            </h3>
                            <button wire:click="closeViewModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                                <p class="text-xs text-indigo-500 font-bold uppercase mb-1">ภาคเรียน / ปีการศึกษา</p>
                                <p class="text-lg font-bold text-indigo-900">
                                    {{ $selectedRegistration->semester }}/{{ $selectedRegistration->year }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-1">วันที่ส่งข้อมูล</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $selectedRegistration->created_at->format('d/m/Y H:i') }} น.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Card 1 -->
                            <div class="space-y-2">
                                <p class="text-sm font-bold text-gray-700 ml-1">ใบลงทะเบียน</p>
                                <div
                                    class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 h-48 flex items-center justify-center relative group">
                                    @if ($selectedRegistration->registration_card_file)
                                        <a href="{{ asset('storage/' . $selectedRegistration->registration_card_file) }}"
                                            target="_blank" class="w-full h-full flex items-center justify-center">
                                            @if (str_contains($selectedRegistration->registration_card_file, '.pdf'))
                                                <div class="text-center">
                                                    <svg class="h-12 w-12 text-red-500 mx-auto" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500 mt-2 block">เปิดไฟล์ PDF</span>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/' . $selectedRegistration->registration_card_file) }}"
                                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            @endif
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all flex items-center justify-center">
                                                <span
                                                    class="bg-white px-3 py-1 rounded-full text-xs font-bold shadow opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all">คลิกเพื่อดู</span>
                                            </div>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">ไม่พบไฟล์</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="space-y-2">
                                <p class="text-sm font-bold text-gray-700 ml-1">สลิปโอนเงิน</p>
                                <div
                                    class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 h-48 flex items-center justify-center relative group">
                                    @if ($selectedRegistration->slip_file_name)
                                        <a href="{{ asset('storage/' . $selectedRegistration->slip_file_name) }}"
                                            target="_blank" class="w-full h-full flex items-center justify-center">
                                            @if (str_contains($selectedRegistration->slip_file_name, '.pdf'))
                                                <div class="text-center">
                                                    <svg class="h-12 w-12 text-red-500 mx-auto" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-sm text-gray-500 mt-2 block">เปิดไฟล์ PDF</span>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/' . $selectedRegistration->slip_file_name) }}"
                                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            @endif
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all flex items-center justify-center">
                                                <span
                                                    class="bg-white px-3 py-1 rounded-full text-xs font-bold shadow opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all">คลิกเพื่อดู</span>
                                            </div>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">ไม่พบไฟล์</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($selectedRegistration->remarks)
                            <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule=\"evenodd\" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700 font-bold">หมายเหตุจากฝ่ายทะเบียน:</p>
                                        <p class="text-sm text-red-600 mt-1">{{ $selectedRegistration->remarks }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
