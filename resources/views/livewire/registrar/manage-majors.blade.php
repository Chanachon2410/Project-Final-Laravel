<div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
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
                    <input type="text" wire:model="search" placeholder="ค้นหารหัส หรือ ชื่อสาขา..." class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md rounded-r-none leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <button wire:click="$refresh" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-l-none rounded-md flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <button wire:click="create()" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Major</button>
            </div>
        </div>

        @if($isOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <label for="major_code" class="block text-gray-700 text-sm font-bold mb-2">Major Code:</label>
                                <input type="text" wire:model="major_code" id="major_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('major_code') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="major_name" class="block text-gray-700 text-sm font-bold mb-2">Major Name:</label>
                                <input type="text" wire:model="major_name" id="major_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('major_name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click.prevent="store()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            <button wire:click="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6 bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Major Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Major Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($majors as $major)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $major->major_code }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $major->major_name }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="edit({{ $major->id }})" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $major->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs ml-1 transition-colors duration-200">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $majors->links() }}
            </div>
        </div>
    </div>
</div>
