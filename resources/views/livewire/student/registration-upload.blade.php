<div>
    <div class="p-6">


        @if($activeSemester)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            เปิดลงทะเบียน: ภาคเรียนที่ {{ $activeSemester->semester }}/{{ $activeSemester->year }}
                            (หมดเขต: {{ $activeSemester->registration_end_date ? $activeSemester->registration_end_date->format('d/m/Y') : '-' }})
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h2 class="text-lg font-medium mb-4">อัปโหลดเอกสารหลักฐาน</h2>
                <form wire:submit.prevent="saveRegistration">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label class="block text-sm font-medium text-gray-700 mb-2">ไฟล์ใบลงทะเบียน (PDF/Image)</label>
                            
                            <!-- File Input Area -->
                            <label for="registration_card_file" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 cursor-pointer transition duration-150 ease-in-out">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <div class="relative font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>เลือกไฟล์</span>
                                            <input id="registration_card_file" wire:model="registration_card_file" type="file" class="sr-only" accept="image/*,application/pdf">
                                        </div>
                                        <p class="pl-1">หรือลากไฟล์มาวางที่นี่</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF สูงสุด 2MB</p>
                                </div>
                            </label>
                            
                            <!-- Progress Bar -->
                            <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-indigo-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                            
                            <!-- File Preview and Remove Button -->
                            @if ($registration_card_file)
                                <div class="flex items-center justify-between mt-2 p-2 border rounded-md">
                                    <p class="text-sm text-gray-700">{{ $registration_card_file->getClientOriginalName() }}</p>
                                    <button type="button" wire:click="$set('registration_card_file', null)" class="text-red-500 hover:text-red-700 text-sm">
                                        ลบ
                                    </button>
                                </div>
                            @endif
                            @error('registration_card_file') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label class="block text-sm font-medium text-gray-700 mb-2">ไฟล์สลิปโอนเงิน (PDF/Image)</label>
                            
                            <!-- File Input Area -->
                            <label for="slip_file_name" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 cursor-pointer transition duration-150 ease-in-out">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <div class="relative font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>เลือกไฟล์</span>
                                            <input id="slip_file_name" wire:model="slip_file_name" type="file" class="sr-only" accept="image/*,application/pdf">
                                        </div>
                                        <p class="pl-1">หรือลากไฟล์มาวางที่นี่</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF สูงสุด 2MB</p>
                                </div>
                            </label>
                            
                            <!-- Progress Bar -->
                            <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-indigo-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                            
                            <!-- File Preview and Remove Button -->
                            @if ($slip_file_name)
                                <div class="flex items-center justify-between mt-2 p-2 border rounded-md">
                                    <p class="text-sm text-gray-700">{{ $slip_file_name->getClientOriginalName() }}</p>
                                    <button type="button" wire:click="$set('slip_file_name', null)" class="text-red-500 hover:text-red-700 text-sm">
                                        ลบ
                                    </button>
                                </div>
                            @endif
                            @error('slip_file_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150" 
                                wire:loading.attr="disabled"
                                @if(!$registration_card_file || !$slip_file_name) disabled @endif>
                            <span wire:loading.remove>ยืนยันการส่งเอกสาร</span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                กำลังบันทึก...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            ยังไม่มีภาคเรียนที่เปิดให้ลงทะเบียนในขณะนี้
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <h2 class="text-xl font-bold mb-4">ประวัติการลงทะเบียน</h2>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">เทอม/ปี</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่ส่ง</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($registrations as $registration)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registration->semester }}/{{ $registration->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($registration->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registration->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">ไม่พบประวัติการลงทะเบียน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
