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
            <div class="flex-shrink-0 bg-white border-r border-gray-200 h-screen overflow-y-auto fixed z-20 transition-all duration-300"
                 :class="sidebarCollapsed ? 'w-20' : 'w-64'">
                @include('layouts.navigation')
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col transition-all duration-300"
                 :class="sidebarCollapsed ? 'ml-20' : 'ml-64'">
                <!-- Page Heading -->
                <header class="bg-white shadow sticky top-0 z-10 flex items-center px-4" style="min-height: 81px">
                    <!-- Dynamic Header Title -->
                    <div class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
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
                                @elseif(request()->routeIs('registrar.students.*'))
                                    Manage Students (จัดการข้อมูลนักเรียน)
                                @else
                                    Dashboard
                                @endif
                            </h2>
                        @endisset
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