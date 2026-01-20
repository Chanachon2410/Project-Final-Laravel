<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <label for="perPage" class="text-sm text-gray-600 mr-2">Show:</label>
                <select wire:model.live="perPage" id="perPage" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
            <div class="flex flex-grow w-full sm:w-auto">
                <input type="text" wire:model="search" placeholder="Search payment structures..." class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md rounded-r-none leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <button wire:click="$refresh" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-l-none rounded-md flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <a href="{{ route('registrar.payment-structures.create') }}" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + สร้างใบแจ้งหนี้ใหม่
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 border-b">
                    <th class="p-3">#</th>
                    <th class="p-3">ชื่อรายการ</th>
                    <th class="p-3">ภาคเรียน/ปี</th>
                    <th class="p-3">กลุ่มเป้าหมาย</th>
                    <th class="p-3 text-center">สถานะ</th>
                    <th class="p-3 text-right">ยอดรวม</th>
                    <th class="p-3 text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($structures as $structure)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $structure->id }}</td>
                        <td class="p-3 font-medium">{{ $structure->name }}</td>
                        <td class="p-3">{{ $structure->semester }}/{{ $structure->year }}</td>
                        <td class="p-3">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $structure->major->major_name }}
                            </span>
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded ml-1">
                                {{ $structure->level->name }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:click="toggleStatus({{ $structure->id }})" class="sr-only peer" @if($structure->is_active ?? true) checked @endif>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </td>
                        <td class="p-3 text-right font-bold text-green-600">
                            {{ number_format($structure->total_amount, 2) }}
                        </td>
                        <td class="p-3 text-center">
                            <button wire:click="delete({{ $structure->id }})" 
                                    wire:confirm="คุณแน่ใจหรือไม่ที่จะลบรายการนี้?"
                                    class="text-red-500 hover:text-red-700 text-sm">
                                ลบ
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-500">
                            ยังไม่มีรายการใบแจ้งหนี้
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 flex justify-between items-center">
        <div class="text-sm text-gray-700">
            @if ($structures->total() > 0)
                Showing {{ $structures->firstItem() }} to {{ $structures->lastItem() }} of {{ $structures->total() }} results
            @else
                No results found
            @endif
        </div>
        <div>
            {{ $structures->links() }}
        </div>
    </div>
</div>