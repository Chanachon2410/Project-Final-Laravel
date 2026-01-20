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
                    <input type="text" wire:model="search" placeholder="Search subjects..." class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md rounded-r-none leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <button wire:click="$refresh" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-l-none rounded-md flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <button wire:click="create()" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Subject</button>
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
                                <label for="subject_code" class="block text-gray-700 text-sm font-bold mb-2">Subject Code:</label>
                                <input type="text" wire:model="subject_code" id="subject_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('subject_code') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="subject_name" class="block text-gray-700 text-sm font-bold mb-2">Subject Name:</label>
                                <input type="text" wire:model="subject_name" id="subject_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('subject_name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="credit" class="block text-gray-700 text-sm font-bold mb-2">Credit:</label>
                                <input type="number" wire:model="credit" id="credit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('credit') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="hour_theory" class="block text-gray-700 text-sm font-bold mb-2">Theory Hours:</label>
                                <input type="number" wire:model="hour_theory" id="hour_theory" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('hour_theory') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="hour_practical" class="block text-gray-700 text-sm font-bold mb-2">Practical Hours:</label>
                                <input type="number" wire:model="hour_practical" id="hour_practical" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('hour_practical') <span class="text-red-500">{{ $message }}</span> @enderror
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

        <div class="mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Credit</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($subjects as $subject)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $subject->subject_code }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $subject->subject_name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $subject->credit }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <button wire:click="edit({{ $subject->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                <button wire:click="delete({{ $subject->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-700">
                @if ($subjects->total() > 0)
                    Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of {{ $subjects->total() }} results
                @else
                    No results found
                @endif
            </div>
            <div>
                {{ $subjects->links() }}
            </div>
        </div>
    </div>
</div>
