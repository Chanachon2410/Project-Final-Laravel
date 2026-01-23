<!-- Sidebar Content -->
<div class="flex h-full flex-col justify-between bg-white overflow-hidden transition-all duration-300">
    <div class="py-6 overflow-y-auto custom-scrollbar flex-1 flex flex-col items-center" :class="sidebarCollapsed ? 'px-2' : 'px-4'">
        <!-- Logo and Toggle Section -->
        <div class="flex items-center h-12 mb-8 w-full" :class="sidebarCollapsed ? 'justify-center' : 'justify-between px-2'">
            <div x-show="!sidebarCollapsed" class="shrink-0 flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-violet-600 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-black text-gray-800 leading-none uppercase tracking-tighter">Registration</span>
                    <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mt-0.5">System</span>
                </div>
            </div>
            
            <button @click="sidebarCollapsed = !sidebarCollapsed" 
                    class="hidden md:flex p-2 rounded-xl border border-gray-100 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-100 focus:outline-none transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-500" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>

        <nav class="w-full flex-1">
            <ul class="space-y-2 w-full">
                <!-- Admin Section -->
                @role('Admin')
                <li class="w-full flex justify-center">
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('admin.users.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.users.index') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">จัดการผู้ใช้งาน</span>
                    </a>
                </li>
                @endrole

                <!-- Student Section -->
                @role('Student')
                <li class="w-full flex flex-col items-center gap-2">
                    <a href="{{ route('student.registration.form') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('student.registration.form') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('student.registration.form') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">ลงทะเบียน & ใบแจ้งหนี้</span>
                    </a>
                    <a href="{{ route('student.registration.upload') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('student.registration.upload') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('student.registration.upload') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">อัปโหลดหลักฐาน</span>
                    </a>
                </li>
                @endrole

                <!-- Teacher Section -->
                @role('Teacher')
                @php
                    $teacher = auth()->user()->teacher;
                    $advisedGroups = $teacher ? $teacher->advisedClassGroups : collect();
                @endphp
                <li class="w-full flex justify-center">
                    <details class="group [&_summary::-webkit-details-marker]:hidden w-full" {{ request()->routeIs('teacher.students.view') ? 'open' : '' }}>
                        <summary class="flex cursor-pointer items-center rounded-xl py-2.5 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all"
                                 :class="sidebarCollapsed ? 'w-12 h-12 mx-auto justify-center px-0' : 'w-full justify-between px-4 gap-3'">
                            <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                                <svg class="w-5 h-5 flex-shrink-0 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">นักเรียนในที่ปรึกษา</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <ul x-show="!sidebarCollapsed" class="mt-1 ml-4 border-l-2 border-indigo-100 space-y-1 pl-2">
                            <li>
                                <a href="{{ route('teacher.students.view') }}" 
                                   class="block rounded-lg px-4 py-2 text-xs font-bold {{ (request()->routeIs('teacher.students.view') && !request()->route('groupId')) ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                                    ทั้งหมด
                                </a>
                            </li>
                            @foreach($advisedGroups as $group)
                                <li>
                                    <a href="{{ route('teacher.students.view', ['groupId' => $group->id]) }}" 
                                       class="block rounded-lg px-4 py-2 text-xs font-bold {{ (request()->route('groupId') == $group->id) ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                                        {{ $group->course_group_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                </li>
                @endrole

                <!-- Registrar Section -->
                @role('Registrar')
                <!-- Person Management -->
                <li class="w-full flex justify-center">
                    <details class="group [&_summary::-webkit-details-marker]:hidden w-full" {{ (request()->routeIs('registrar.students.*') || request()->routeIs('registrar.teachers-info.*')) ? 'open' : '' }}>
                        <summary class="flex cursor-pointer items-center rounded-xl py-2.5 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all"
                                 :class="sidebarCollapsed ? 'w-12 h-12 mx-auto justify-center px-0' : 'w-full justify-between px-4 gap-3'">
                            <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                                <svg class="w-5 h-5 flex-shrink-0 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">ข้อมูลบุคคล</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                                                    <ul x-show="!sidebarCollapsed" class="mt-1 ml-4 border-l-2 border-indigo-100 space-y-1 pl-2">
                                                        <li>
                                                            <a href="{{ route('registrar.students.index') }}" 
                                                               class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.students.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                                                                รายชื่อนักเรียน
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('registrar.teachers-info.index') }}" 
                                                               class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.teachers-info.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                                                                ข้อมูลอาจารย์
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('registrar.registrars.index') }}" 
                                                               class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.registrars.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                                                                ข้อมูลเจ้าหน้าที่ทะเบียน
                                                            </a>
                                                        </li>
                                                    </ul>                    </details>
                </li>

                <!-- Master Data -->
                <li class="w-full flex justify-center">
                    <details class="group [&_summary::-webkit-details-marker]:hidden w-full" {{ (request()->routeIs('registrar.majors.*') || request()->routeIs('registrar.subjects.*') || request()->routeIs('registrar.class-groups.*') || request()->routeIs('registrar.semesters.*') || request()->routeIs('registrar.tuition-fees.*')) ? 'open' : '' }}>
                        <summary class="flex cursor-pointer items-center rounded-xl py-2.5 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all"
                                 :class="sidebarCollapsed ? 'w-12 h-12 mx-auto justify-center px-0' : 'w-full justify-between px-4 gap-3'">
                            <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                                <svg class="w-5 h-5 flex-shrink-0 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7l8-4 8 4M4 11v4c0 2.21 3.582 4 8 4s8-1.79 8-4v-4" />
                                </svg>
                                <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">ข้อมูลหลัก (Master)</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="shrink-0 transition duration-300 group-open:-rotate-180">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <ul x-show="!sidebarCollapsed" class="mt-1 ml-4 border-l-2 border-indigo-100 space-y-1 pl-2">
                            <li><a href="{{ route('registrar.majors.index') }}" class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.majors.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">สาขาวิชา</a></li>
                            <li><a href="{{ route('registrar.subjects.index') }}" class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.subjects.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">รายวิชา</a></li>
                            <li><a href="{{ route('registrar.class-groups.index') }}" class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.class-groups.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">กลุ่มเรียน</a></li>
                            <li><a href="{{ route('registrar.semesters.index') }}" class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.semesters.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">ภาคเรียน/ปีการศึกษา</a></li>
                            <li><a href="{{ route('registrar.tuition-fees.index') }}" class="block rounded-lg px-4 py-2 text-xs font-bold {{ request()->routeIs('registrar.tuition-fees.index') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">ค่าเทอม/ค่าบำรุง</a></li>
                        </ul>
                    </details>
                </li>

                <!-- Actions -->
                <li class="w-full flex flex-col items-center gap-2">
                    <a href="{{ route('registrar.payment-structures.index') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('registrar.payment-structures.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('registrar.payment-structures.*') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">จัดการใบแจ้งหนี้</span>
                    </a>
                    <a href="{{ route('registrar.registration-status.index') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('registrar.registration-status.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('registrar.registration-status.*') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">ตรวจสอบสถานะ</span>
                    </a>
                    <a href="{{ route('registrar.import-data.index') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('registrar.import-data.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('registrar.import-data.*') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">นำเข้าข้อมูล (Excel)</span>
                    </a>
                </li>
                @endrole

                <!-- Profile Menu -->
                <li class="w-full flex justify-center">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center rounded-xl py-2.5 transition-all duration-200 group {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' }}"
                       :class="sidebarCollapsed ? 'w-12 h-12 justify-center px-0' : 'w-full justify-start px-4 gap-3'">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="text-sm font-bold truncate">โปรไฟล์ของฉัน</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- User Profile & Logout Area -->
    <div class="p-4 bg-gray-50/50 border-t border-gray-100">
        <div class="flex items-center justify-between" :class="sidebarCollapsed ? 'flex-col gap-4' : 'flex-row px-2'">
            <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                <div class="relative flex-shrink-0">
                    <img alt="User" src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}&background=6366f1&color=fff&bold=true" 
                         class="h-10 w-10 rounded-xl object-cover shadow-sm border border-white" />
                    <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                </div>
                <div x-show="!sidebarCollapsed" class="overflow-hidden">
                    <p class="truncate text-xs font-black text-gray-900 leading-tight">{{ Auth::user()->username }}</p>
                    <p class="truncate text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">{{ Auth::user()->getRoleNames()->first() }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="flex" :class="sidebarCollapsed ? 'w-full justify-center' : ''">
                @csrf
                <button type="submit" title="ออกจากระบบ" 
                        class="p-2.5 rounded-xl text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200 group flex items-center justify-center">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>