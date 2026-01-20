<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-800">
                            Student Details: {{ $student->firstname }} {{ $student->lastname }}
                        </h1>
                        <a href="{{ route('registrar.students.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                            &larr; Back to Student List
                        </a>
                    </div>
                </div>

                <div class="p-6 sm:p-8 border-b">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Personal Information -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Personal Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->firstname }} {{ $student->lastname }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Citizen ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->citizen_id ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Student Code</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->student_code }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Account Information -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Account Information</h3>
                            @if($student->user)
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Username</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->user->username }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->user->email }}</dd>
                                </div>
                            </dl>
                            @else
                            <p class="text-sm text-gray-500">No account information linked.</p>
                            @endif
                        </div>

                        <!-- Academic Information -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3">Academic Information</h3>
                            @if($student->classGroup)
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Class Group</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->classGroup->course_group_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Level</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->classGroup->level->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Room</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->classGroup->class_room }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Major</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->classGroup->major->major_name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Advisor</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->classGroup->advisor->firstname ?? 'N/A' }} {{ $student->classGroup->advisor->lastname ?? '' }}</dd>
                                </div>
                            </dl>
                            @else
                            <p class="text-sm text-gray-500">Not assigned to any class group.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>