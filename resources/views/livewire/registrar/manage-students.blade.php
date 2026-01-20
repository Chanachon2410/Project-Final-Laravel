<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                
                <!-- Header & Search & Controls -->
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-4">
                        <!-- PerPage Dropdown -->
                        <div class="flex items-center">
                            <label for="perPage" class="text-sm text-gray-600 mr-2">Show:</label>
                            <select wire:model.live="perPage" id="perPage" class="block w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>

                        <!-- Column Selector Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Columns
                                <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute left-0 z-10 w-48 mt-2 origin-top-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="p-2" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    @foreach($allColumns as $key => $value)
                                        <label class="flex items-center px-2 py-1 text-sm text-gray-700">
                                            <input type="checkbox" wire:model.live="selectedColumns" value="{{ $key }}" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <span class="ml-2">{{ $value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                        <input type="text" wire:model.live="search" placeholder="Search students..." class="flex-grow text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                        <button wire:click="create()" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Add New Student
                        </button>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @if(in_array('citizen_id', $selectedColumns))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Citizen ID</th>
                                @endif
                                @if(in_array('student_code', $selectedColumns))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Code</th>
                                @endif
                                @if(in_array('name', $selectedColumns))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                @endif
                                @if(in_array('level', $selectedColumns))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                                @endif
                                @if(in_array('room', $selectedColumns))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                @endif
                                @if(in_array('class_group', $selectedColumns))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Group</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($students as $student)
                            <tr>
                                @if(in_array('citizen_id', $selectedColumns))
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->citizen_id ?? '-' }}</td>
                                @endif
                                @if(in_array('student_code', $selectedColumns))
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->student_code }}</td>
                                @endif
                                @if(in_array('name', $selectedColumns))
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->title ? $student->title . ' ' : '' }}{{ $student->firstname }} {{ $student->lastname }}</td>
                                @endif
                                @if(in_array('level', $selectedColumns))
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->level->name ?? '-' }}</td>
                                @endif
                                @if(in_array('room', $selectedColumns))
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->classGroup->class_room ?? '-' }}</td>
                                @endif
                                @if(in_array('class_group', $selectedColumns))
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->classGroup->course_group_name ?? '-' }}</td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('registrar.students.view', $student->id) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                                    <button wire:click="edit({{ $student->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                    <button wire:click="confirmDelete({{ $student->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($selectedColumns) + 1 }}" class="px-6 py-4 text-center text-gray-500">No students found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        @if ($students->total() > 0)
                            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                        @else
                            No results found
                        @endif
                    </div>
                    <div>
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($isModalOpen)
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="{{ $student_id ? 'update' : 'store' }}">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <label for="student_code" class="block text-gray-700 text-sm font-bold mb-2">Student Code (Username):</label>
                            <input type="text" wire:model="student_code" id="student_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('student_code') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                            <div class="md:col-span-1">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                                <select wire:model="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Title</option>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                                <input type="text" wire:model="firstname" id="firstname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('firstname') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                                <input type="text" wire:model="lastname" id="lastname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('lastname') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <input type="email" wire:model="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password {{ $student_id ? '(Leave blank to keep current)' : '' }}:</label>
                            <input type="password" wire:model="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="level_id" class="block text-gray-700 text-sm font-bold mb-2">Level:</label>
                                <select wire:model="level_id" id="level_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Level</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                                @error('level_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="class_group_id" class="block text-gray-700 text-sm font-bold mb-2">Class Group:</label>
                                <select wire:model="class_group_id" id="class_group_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Class Group</option>
                                    @foreach($classGroups as $group)
                                        <option value="{{ $group->id }}">{{ $group->course_group_name }}</option>
                                    @endforeach
                                </select>
                                @error('class_group_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="citizen_id" class="block text-gray-700 text-sm font-bold mb-2">Citizen ID:</label>
                            <input type="text" wire:model="citizen_id" id="citizen_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('citizen_id') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $student_id ? 'Update' : 'Save' }}
                        </button>
                        <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletion)
    {{-- ... existing delete modal ... --}}
    @endif


</div>