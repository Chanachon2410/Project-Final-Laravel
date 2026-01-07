<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @role('Student')
            <!-- Student Profile Information -->
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-8">
                    <div class="flex items-center space-x-6 mb-8">
                        <div class="flex-shrink-0">
                            <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ Auth::user()->student->firstname }} {{ Auth::user()->student->lastname }}
                            </h1>
                            <p class="text-gray-500 font-medium italic">รหัสนักเรียน: {{ Auth::user()->student->student_code }}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mt-2">
                                สถานะ: กำลังศึกษา
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-8">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">ข้อมูลการเรียน</h3>
                            <div class="flex flex-col space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ระดับชั้น:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->student->level->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">สาขาวิชา:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->student->classGroup->major->major_name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">กลุ่มเรียน:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->student->classGroup->course_group_name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">อาจารย์ที่ปรึกษา:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ Auth::user()->student->classGroup->advisor->firstname ?? '-' }} 
                                        {{ Auth::user()->student->classGroup->advisor->lastname ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">ข้อมูลส่วนตัว</h3>
                            <div class="flex flex-col space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">เลขบัตรประชาชน:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->student->citizen_id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ชื่อผู้ใช้ (Username):</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->username }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">อีเมล:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elserole('Teacher')
            <!-- Teacher Profile Information -->
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-8">
                    <div class="flex items-center space-x-6 mb-8">
                        <div class="flex-shrink-0">
                            <div class="h-24 w-24 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ Auth::user()->teacher->title }}{{ Auth::user()->teacher->firstname }} {{ Auth::user()->teacher->lastname }}
                            </h1>
                            <p class="text-gray-500 font-medium italic">รหัสบุคลากร: {{ Auth::user()->teacher->teacher_code }}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mt-2">
                                สถานะ: อาจารย์ / ครูที่ปรึกษา
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-8">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">ข้อมูลบุคลากร</h3>
                            <div class="flex flex-col space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">คำนำหน้า:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->teacher->title }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ชื่อ-นามสกุล:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->teacher->firstname }} {{ Auth::user()->teacher->lastname }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">รหัสบุคลากร:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->teacher->teacher_code }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">ข้อมูลส่วนตัวและบัญชี</h3>
                            <div class="flex flex-col space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">เลขบัตรประชาชน:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->teacher->citizen_id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ชื่อผู้ใช้ (Username):</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->username }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">อีเมล:</span>
                                    <span class="font-medium text-gray-900">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Default User Information (Admin/Teacher/Registrar) -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Personal Information') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Your personal account details.") }}
                    </p>
                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">{{ __('Username') }}</label>
                            <p class="mt-1 text-gray-900">{{ Auth::user()->username }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                            <p class="mt-1 text-gray-900">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">{{ __('Role') }}</label>
                            <p class="mt-1 text-gray-900 capitalize">{{ Auth::user()->getRoleNames()->first() ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endrole

        </div>
    </div>
</x-app-layout>