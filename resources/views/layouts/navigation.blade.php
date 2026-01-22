<!-- Sidebar Content -->
<div class="flex h-full flex-col justify-between bg-white">
    <div class="px-4 py-6">
        <!-- Logo and Toggle -->
        <div class="flex items-center h-9 mb-6" :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">
            <div x-show="!sidebarCollapsed" class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>
            <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-1.5 rounded-md border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>


        <ul class="space-y-1">
            <!-- Common Dashboard Link -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   title="Dashboard"
                   class="flex items-center gap-2 rounded-lg py-2 text-sm font-medium {{ request()->routeIs('*.dashboard') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : 'px-4'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="!sidebarCollapsed">Dashboard</span>
                </a>
            </li>

            <!-- Role-specific Links -->
            @role('Admin')
            <li>
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ request()->routeIs('admin.*') ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="text-sm font-medium"> Management </span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul x-show="!sidebarCollapsed"
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition-all ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="mt-2 space-y-1 overflow-hidden px-4">
                        <li>
                            <a href="{{ route('admin.users.index') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.users.index') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Users
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endrole

            @role('Student')
            <li>
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ request()->routeIs('student.registration.*') ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="text-sm font-medium"> การลงทะเบียน </span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul x-show="!sidebarCollapsed"
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition-all ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="mt-2 space-y-1 overflow-hidden px-4">
                        <li>
                            <a href="{{ route('student.registration.form') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('student.registration.form') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                ลงทะเบียน/พิมพ์ใบแจ้งหนี้
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.registration.upload') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('student.registration.upload') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                อัพโหลดหลักฐาน
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endrole

            @role('Teacher')
            <li>
                @php
                    $teacher = auth()->user()->teacher;
                    $advisedGroups = $teacher ? $teacher->advisedClassGroups : collect();
                @endphp
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ request()->routeIs('teacher.students.view') ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="text-sm font-medium"> นักเรียนในที่ปรึกษา </span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul x-show="!sidebarCollapsed"
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-screen"
                        class="mt-2 space-y-1 overflow-hidden px-4">
                        <li>
                            <a href="{{ route('teacher.students.view') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ (request()->routeIs('teacher.students.view') && !request()->route('groupId')) ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                ทั้งหมด
                            </a>
                        </li>
                        @foreach($advisedGroups as $group)
                            <li>
                                <a href="{{ route('teacher.students.view', ['groupId' => $group->id]) }}" 
                                   class="block rounded-lg px-4 py-2 text-sm font-medium {{ (request()->route('groupId') == $group->id) ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                    {{ $group->course_group_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </details>
            </li>
            @endrole

            @role('Registrar')
            <li>
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ (request()->routeIs('registrar.students.*') || request()->routeIs('registrar.teachers-info.*')) ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center rounded-lg py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700" :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-between px-4'">
                        <div class="flex items-center gap-2">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h4a2 2 0 012 2v1m-4 0h4m-4 0H9m-4 4h14m-5 4H9" />
                           </svg>
                           <span x-show="!sidebarCollapsed" class="text-sm font-medium"> จัดการข้อมูลบุคคล </span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul x-show="!sidebarCollapsed"
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition-all ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="mt-2 space-y-1 overflow-hidden px-4">
                        <li>
                            <a href="{{ route('registrar.students.index') }}" title="Students" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.students.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Students (นักเรียน)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.teachers-info.index') }}" title="Teachers" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.teachers-info.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Teacher Info (ข้อมูลคุณครู)
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            <li>
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ (request()->routeIs('registrar.majors.*') || request()->routeIs('registrar.subjects.*') || request()->routeIs('registrar.class-groups.*') || request()->routeIs('registrar.semesters.*') || request()->routeIs('registrar.tuition-fees.*')) ? 'open' : '' }}>
                     <summary class="flex cursor-pointer items-center rounded-lg py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700" :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-between px-4'">
                        <div class="flex items-center gap-2">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7l8-4 8 4M4 11v4c0 2.21 3.582 4 8 4s8-1.79 8-4v-4" />
                           </svg>
                           <span x-show="!sidebarCollapsed" class="text-sm font-medium"> จัดการข้อมูลหลัก </span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul x-show="!sidebarCollapsed"
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition-all ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="mt-2 space-y-1 overflow-hidden px-4">
                        <li>
                            <a href="{{ route('registrar.majors.index') }}" title="Majors" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.majors.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Majors
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.subjects.index') }}" title="Subjects" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.subjects.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Subjects
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.class-groups.index') }}" title="Class Groups" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.class-groups.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Class Groups
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.semesters.index') }}" title="Semesters" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.semesters.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Semesters
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.tuition-fees.index') }}" title="Tuition Fees" class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.tuition-fees.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Tuition Fees
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            <li>
                <a href="{{ route('registrar.payment-structures.index') }}" 
                   title="จัดการใบแจ้งหนี้ (PDF)"
                   class="flex items-center gap-2 rounded-lg py-2 text-sm font-medium {{ request()->routeIs('registrar.payment-structures.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : 'px-4'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="!sidebarCollapsed">จัดการใบแจ้งหนี้ (PDF)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registrar.import-data.index') }}" 
                   title="Import Excel Data"
                   class="flex items-center gap-2 rounded-lg py-2 text-sm font-medium {{ request()->routeIs('registrar.import-data.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : 'px-4'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span x-show="!sidebarCollapsed">Import Excel Data</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registrar.registration-status.index') }}" 
                   title="ตรวจสอบการลงทะเบียน"
                   class="flex items-center gap-2 rounded-lg py-2 text-sm font-medium {{ request()->routeIs('registrar.registration-status.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : 'px-4'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-show="!sidebarCollapsed">ตรวจสอบการลงทะเบียน</span>
                </a>
            </li>

            @endrole
        </ul>
    </div>
</div>