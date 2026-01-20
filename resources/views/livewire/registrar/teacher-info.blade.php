<div>
    <div class="p-6">
        <div class="flex items-start justify-between mb-4">
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

            {{-- Search Bar --}}
            <div class="flex ml-auto">
                <input wire:model.live="search" type="text" class="border border-gray-300 rounded-md py-2 px-4 pl-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search teachers...">
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @if(in_array('teacher_info', $selectedColumns))
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teacher Info
                        </th>
                        @endif
                        @if(in_array('advisor_for', $selectedColumns))
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Advisor For (ที่ปรึกษาประจำชั้น)
                        </th>
                        @endif
                        @if(in_array('contact', $selectedColumns))
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        @endif
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">View</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($teachers as $teacher)
                    <tr>
                        @if(in_array('teacher_info', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold text-lg">
                                        {{ mb_substr($teacher->firstname ?? '?', 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $teacher->title }} {{ $teacher->firstname }} {{ $teacher->lastname }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Code: {{ $teacher->teacher_code ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
                        @if(in_array('advisor_for', $selectedColumns))
                        <td class="px-6 py-4">
                            @if($teacher->advisedClassGroups->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($teacher->advisedClassGroups as $group)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $group->course_group_name }} 
                                            @if($group->class_room) (Room {{ $group->class_room }}) @endif
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-sm italic">No class assigned</span>
                            @endif
                        </td>
                        @endif
                        @if(in_array('contact', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $teacher->user->email ?? '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $teacher->user->username ?? '-' }}</div>
                        </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="viewTeacher({{ $teacher->id }})" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition-colors">View Details</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($selectedColumns) + 1 }}" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No teachers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-700">
                @if ($teachers->total() > 0)
                    Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of {{ $teachers->total() }} results
                @else
                    No results found
                @endif
            </div>
            <div>
                {{ $teachers->links() }}
            </div>
        </div>

        <!-- Teacher Details Modal -->
        @if($isViewModalOpen && $selectedTeacher)
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-headline">
                            Teacher Details: {{ $selectedTeacher->title }} {{ $selectedTeacher->firstname }} {{ $selectedTeacher->lastname }}
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Teacher Code:</p>
                                <p class="font-medium text-gray-900">{{ $selectedTeacher->teacher_code ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Full Name:</p>
                                <p class="font-medium text-gray-900">{{ $selectedTeacher->title }} {{ $selectedTeacher->firstname }} {{ $selectedTeacher->lastname }}</p>
                            </div>
                            @if($selectedTeacher->user)
                            <div>
                                <p class="text-sm text-gray-500">Email:</p>
                                <p class="font-medium text-gray-900">{{ $selectedTeacher->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Username:</p>
                                <p class="font-medium text-gray-900">{{ $selectedTeacher->user->username }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500">Advised Class Groups:</p>
                                @if($selectedTeacher->advisedClassGroups->count() > 0)
                                    <div class="space-y-2 mt-2">
                                        @foreach($selectedTeacher->advisedClassGroups as $group)
                                            <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                                                <span class="text-sm font-medium text-blue-800">
                                                    {{ $group->course_group_name }} 
                                                    @if($group->class_room) (Room {{ $group->class_room }}) @endif
                                                </span>
                                                <button wire:click="openStudentListModal({{ $group->id }})" class="px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                    View Students
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-400 text-sm italic mt-1">No class groups advised.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeViewModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List Modal (Nested) -->
        @if($isStudentListModalOpen)
        <div class="fixed z-20 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="student-modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="student-modal-headline">
                            Students in Group
                        </h3>
                        @if(count($studentsInGroup) > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($studentsInGroup as $student)
                                    <li class="py-2 flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-800">{{ $student->firstname }} {{ $student->lastname }}</span>
                                            @if($student->classGroup)
                                                <span class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Room: {{ $student->classGroup->class_room }}</span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded-full">{{ $student->student_code }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No students found in this class group.</p>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeStudentListModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>