<div>
    <div class="py-8 md:py-12 font-sans text-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section with Gradient -->
            <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 shadow-lg shadow-indigo-200 text-white p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-pink-500 opacity-20 blur-xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <span class="bg-white/20 p-2 rounded-xl">
                                <svg class="w-8 h-8 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </span>
                            จัดการเอกสารลงทะเบียน (Registration Documents)
                        </h2>
                        <p class="text-indigo-100 text-sm mt-1 opacity-80 pl-14">สร้างและจัดการเอกสารลงทะเบียนสำหรับนักศึกษา</p>
                    </div>
                    
                    <a href="{{ route('registrar.registration-documents.create') }}" class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold py-2.5 px-5 rounded-xl border border-white/20 shadow-sm transition-all duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
                        <span class="bg-white text-indigo-600 rounded-lg p-1 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </span>
                        <span>สร้างเอกสารลงทะเบียนใหม่</span>
                    </a>
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
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ค้นหาเอกสารลงทะเบียน..." class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>
                        <button wire:click="$refresh" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-md transition-colors flex items-center font-medium">
                            ค้นหา
                        </button>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-r-xl flex items-center gap-3 shadow-sm">
                        <div class="flex-shrink-0 text-green-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-green-700 font-medium text-sm">{{ session('message') }}</span>
                    </div>
                @endif

                <!-- Modern Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ชื่อรายการ</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ภาคเรียน/ปี</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">กลุ่มเป้าหมาย</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">สถานะ</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">ยอดรวม (บาท)</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($documents as $document)
                                <tr class="hover:bg-violet-50/30 transition duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                                        {{ $document->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal break-words max-w-xs">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex-shrink-0 flex items-center justify-center font-bold border border-indigo-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">{{ $document->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-600 border border-gray-200">
                                            {{ $document->semester }}/{{ $document->year }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal min-w-[150px]">
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex w-fit items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                <span class="w-1 h-1 rounded-full bg-blue-500 mr-1.5"></span>
                                                {{ $document->major->major_name ?? 'ทุกสาขา' }}
                                            </span>
                                            <span class="inline-flex w-fit items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                                <span class="w-1 h-1 rounded-full bg-purple-500 mr-1.5"></span>
                                                {{ $document->level->name ?? 'ทุกระดับชั้น' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" wire:click="toggleStatus({{ $document->id }})" class="sr-only peer" @if($document->is_active ?? true) checked @endif>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-bold text-emerald-600">{{ number_format($document->total_amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('registrar.registration-documents.edit', $document->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors group relative" title="แก้ไข">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <button type="button" 
                                                    onclick="confirmDelete({{ $document->id }})"
                                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors group relative" title="ลบ">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium">ยังไม่มีรายการเอกสารลงทะเบียน</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- SweetAlert Script -->
    @push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            // Handle Session Flashes (Redirects)
            @if(session()->has('message'))
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: "{{ session('message') }}",
                    icon: 'success',
                    confirmButtonColor: '#4f46e5',
                });
            @endif

            @if(session()->has('error'))
                Swal.fire({
                    title: 'ผิดพลาด!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                });
            @endif

            // Handle Livewire Events
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
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "ข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'ลบข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id);
                }
            })
        }
    </script>
    @endpush
</div>