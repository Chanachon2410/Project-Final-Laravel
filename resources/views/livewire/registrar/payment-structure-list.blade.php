<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">จัดการโครงสร้างค่าเทอม / ใบแจ้งหนี้</h2>
        <a href="{{ route('registrar.payment-structures.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + สร้างใบแจ้งหนี้ใหม่
        </a>
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
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            ยังไม่มีรายการใบแจ้งหนี้
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $structures->links() }}
    </div>
</div>