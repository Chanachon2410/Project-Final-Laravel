<div>
    <div class="p-6 bg-white border-b border-gray-200">
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
                    <input wire:model="search" type="text" placeholder="Search class groups..." class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md rounded-r-none leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <button wire:click="$refresh" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-l-none rounded-md flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <button wire:click="create()" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Class Group</button>
            </div>
        </div>

        @if($isOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <label for="course_group_code" class="block text-gray-700 text-sm font-bold mb-2">Code:</label>
                                <input type="text" wire:model="course_group_code" id="course_group_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('course_group_code') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="course_group_name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" wire:model="course_group_name" id="course_group_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('course_group_name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="level_id" class="block text-gray-700 text-sm font-bold mb-2">Level:</label>
                                <select wire:model="level_id" id="level_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Level</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                                @error('level_id') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="level_year" class="block text-gray-700 text-sm font-bold mb-2">Year:</label>
                                <input type="number" wire:model="level_year" id="level_year" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('level_year') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="major_id" class="block text-gray-700 text-sm font-bold mb-2">Major:</label>
                                <select wire:model="major_id" id="major_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Major</option>
                                    @foreach($majors as $major)
                                        <option value="{{ $major->id }}">{{ $major->major_name }} ({{ $major->major_code }})</option>
                                    @endforeach
                                </select>
                                @error('major_id') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="teacher_advisor_id" class="block text-gray-700 text-sm font-bold mb-2">Advisor:</label>
                                <select wire:model="teacher_advisor_id" id="teacher_advisor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Advisor</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ ($teacher->title ? $teacher->title . ' ' : '') }}{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
                                    @endforeach
                                </select>
                                @error('teacher_advisor_id') <span class="text-red-500">{{ $message }}</span> @enderror
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

        @if($isViewOpen && $viewingClassGroup)
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            Class Group: {{ $viewingClassGroup->course_group_name }}
                        </h3>
                        <div class="mt-4">
                            <p class="text-sm text-gray-700">
                                <span class="font-bold">Level:</span> {{ $viewingClassGroup->level->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-700 mt-1">
                                <span class="font-bold">Major:</span> {{ $viewingClassGroup->major->major_name ?? 'N/A' }} ({{ $viewingClassGroup->major->major_code ?? 'N/A' }})
                            </p>
                            <p class="text-sm text-gray-700 mt-1">
                                <span class="font-bold">Advisor:</span> 
                                {{ $viewingClassGroup->advisor ? ($viewingClassGroup->advisor->title ? $viewingClassGroup->advisor->title . ' ' : '') . $viewingClassGroup->advisor->firstname . ' ' . $viewingClassGroup->advisor->lastname : 'N/A' }}
                            </p>
                            
                            <h4 class="text-md font-medium text-gray-800 mt-6 mb-2">Students ({{ $viewingClassGroup->students->count() }})</h4>
                            <div class="overflow-x-auto max-h-80 border rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($viewingClassGroup->students as $student)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $student->student_code }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ ($student->title ? $student->title . ' ' : '') . $student->firstname . ' ' . $student->lastname }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="px-4 py-4 text-center text-sm text-gray-500">No students in this class group.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeViewModal()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Major</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Advisor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($classGroups as $classGroup)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $classGroup->course_group_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classGroup->course_group_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classGroup->level->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classGroup->class_room ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classGroup->major->major_name }} ({{ $classGroup->major->major_code }})</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classGroup->advisor ? ($classGroup->advisor->title ? $classGroup->advisor->title . ' ' : '') . $classGroup->advisor->firstname . ' ' . $classGroup->advisor->lastname : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="view({{ $classGroup->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</button>
                                <button wire:click="edit({{ $classGroup->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">Edit</button>
                                <button wire:click="delete({{ $classGroup->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No class groups found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-700">
                @if ($classGroups->total() > 0)
                    Showing {{ $classGroups->firstItem() }} to {{ $classGroups->lastItem() }} of {{ $classGroups->total() }} results
                @else
                    No results found
                @endif
            </div>
            <div>
                {{ $classGroups->links() }}
            </div>
        </div>
    </div>
</div>
