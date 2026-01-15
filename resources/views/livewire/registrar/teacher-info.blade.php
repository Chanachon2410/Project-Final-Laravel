<div>
    <div class="p-6">
        <div class="flex items-center justify-end mb-4">
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" class="border border-gray-300 rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search teachers...">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teacher Info
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Advisor For (ที่ปรึกษาประจำชั้น)
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">View</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($teachers as $teacher)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold text-lg">
                                        {{ substr($teacher->firstname, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $teacher->title }} {{ $teacher->firstname }} {{ $teacher->lastname }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Code: {{ $teacher->teacher_code }}
                                    </div>
                                </div>
                            </div>
                        </td>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $teacher->user->email ?? '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $teacher->user->username ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="viewTeacher({{ $teacher->id }})" class="text-indigo-600 hover:text-indigo-900">View Details</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No teachers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 px-6 mb-6">
            {{ $teachers->links() }}
        </div>

        <!-- Teacher Details Modal -->
        @if($isViewModalOpen && $selectedTeacher)
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center mb-6">
                            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold text-2xl mr-4">
                                {{ substr($selectedTeacher->firstname, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-xl leading-6 font-bold text-gray-900">
                                    {{ $selectedTeacher->title }} {{ $selectedTeacher->firstname }} {{ $selectedTeacher->lastname }}
                                </h3>
                                <p class="text-sm text-gray-500">Code: {{ $selectedTeacher->teacher_code }}</p>
                                <p class="text-sm text-gray-500">Email: {{ $selectedTeacher->user->email ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Advisor Section -->
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-bold text-green-800 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Class Advisor (ที่ปรึกษา)
                                </h4>
                                @if($selectedTeacher->advisedClassGroups->count() > 0)
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($selectedTeacher->advisedClassGroups as $group)
                                            <li class="text-green-900">
                                                <span class="font-semibold">{{ $group->course_group_name }}</span>
                                                <span class="text-sm text-green-700">
                                                    ({{ $group->level->name }} @if($group->class_room) Room {{ $group->class_room }} @endif)
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500 italic">No advisory classes.</p>
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
        @endif
    </div>
</div>