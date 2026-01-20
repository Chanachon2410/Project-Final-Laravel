<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarCollapsed: false }" class="min-h-screen bg-gray-100 flex">
            <!-- Collapsible Sidebar -->
            <div class="flex-shrink-0 bg-white border-r border-gray-200 h-screen overflow-y-auto fixed z-20 transition-[width] duration-300"
                 :class="sidebarCollapsed ? 'w-20' : 'w-64'">
                @include('layouts.navigation')
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col transition-[margin-left] duration-300"
                 :class="sidebarCollapsed ? 'ml-20' : 'ml-64'">
                <!-- Page Heading -->
                <header class="bg-white shadow sticky top-0 z-10 flex items-center justify-between px-6" style="min-height: 81px">
                    <!-- Dynamic Header Title -->
                    <div class="flex-1">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                @if(request()->routeIs('admin.users.*'))
                                    User Management
                                @elseif(request()->routeIs('teacher.students.*'))
                                    นักเรียนในที่ปรึกษา
                                @elseif(request()->routeIs('student.registration.form'))
                                    ลงทะเบียนเรียน
                                @elseif(request()->routeIs('student.registration.upload'))
                                    อัพโหลดสลิปและหลักฐาน
                                @elseif(request()->routeIs('registrar.majors.*'))
                                    Manage Majors (สาขาวิชาเรียน)
                                @elseif(request()->routeIs('registrar.subjects.*'))
                                    Manage Subjects (วิชาที่เรียน)
                                @elseif(request()->routeIs('registrar.class-groups.*'))
                                    Manage Class Groups (ชั้นปีการศึกษา)
                                @elseif(request()->routeIs('registrar.teachers-info.*'))
                                    Teacher Information (ข้อมูลคุณครู)
                                @elseif(request()->routeIs('registrar.semesters.*'))
                                    Manage Semesters (ภาคเรียน)
                                @elseif(request()->routeIs('registrar.tuition-fees.*'))
                                    Manage Tuition Fees (ค่าบำรุงการศึกษา)
                                @elseif(request()->routeIs('registrar.payment-structures.index'))
                                    จัดการโครงสร้างค่าเทอม / ใบแจ้งหนี้
                                @elseif(request()->routeIs('registrar.payment-structures.create'))
                                    สร้าง/แก้ไข โครงสร้างค่าเทอม
                                @elseif(request()->routeIs('registrar.import-data.*'))
                                    Import Excel Data (นำเข้าข้อมูล Excel)
                                @elseif(request()->routeIs('registrar.students.*'))
                                    Manage Students (จัดการข้อมูลนักเรียน)
                                @else
                                    Dashboard
                                @endif
                            </h2>
                        @endisset
                    </div>

                    <!-- User Menu Dropdown -->
                    <div x-data="{ open: false }" class="relative ml-4">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-full p-1 text-gray-600 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <img alt="User" src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" class="h-10 w-10 rounded-full object-cover" />
                            <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->username }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="hidden sm:block h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" 
                             role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <div class="px-4 py-2 text-sm text-gray-500 border-b border-gray-100">
                                    <p class="font-semibold">Signed in as</p>
                                    <p class="truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-0">Profile</a>
                                <!-- Logout Form -->
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit" class="text-gray-700 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
        @include('components.sweetalert-script')
        @stack('scripts')
    </body>
</html>