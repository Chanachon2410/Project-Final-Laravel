<!-- Sidebar -->
<div class="fixed top-0 left-0 flex h-screen flex-col justify-between border-e bg-white w-64">
    <div class="px-4 py-6">
        <!-- Logo -->
        <div class="shrink-0 flex items-center justify-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
        </div>

        <ul class="mt-6 space-y-1">
            <!-- Common Dashboard Link -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('*.dashboard') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                    Dashboard
                </a>
            </li>

            <!-- Role-specific Links -->
            @role('Admin')
            <li>
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ request()->routeIs('admin.*') ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <span class="text-sm font-medium"> Management </span>
                        <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul class="mt-2 space-y-1 px-4">
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
                <a href="{{ route('student.registration.upload') }}" 
                   class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('student.registration.upload') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                    ลงทะเบียนเรียน
                </a>
            </li>
            @endrole

            @role('Teacher')
            <li>
                <a href="{{ route('teacher.students.view') }}" 
                   class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('teacher.students.view') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                    นักเรียนในที่ปรึกษา
                </a>
            </li>
            @endrole

            @role('Registrar')
            <li>
                <details class="group [&_summary::-webkit-details-marker]:hidden" {{ request()->routeIs('registrar.*') ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <span class="text-sm font-medium"> จัดการข้อมูลหลัก </span>
                        <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </summary>
                    <ul class="mt-2 space-y-1 px-4">
                        <li>
                            <a href="{{ route('registrar.majors.index') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.majors.index') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Majors
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.subjects.index') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.subjects.index') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Subjects
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.class-groups.index') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.class-groups.index') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Class Groups
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.semesters.index') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.semesters.index') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Semesters
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrar.tuition-fees.index') }}" 
                               class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.tuition-fees.index') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                                Tuition Fees
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            <li>
                <a href="{{ route('registrar.payment-structures.index') }}" 
                   class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('registrar.payment-structures.*') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                    จัดการใบแจ้งหนี้ (PDF)
                </a>
            </li>
            @endrole

            <li>
                <a href="{{ route('profile.edit') }}" 
                   class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('profile.edit') ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
                    Profile
                </a>
            </li>
        </ul>
    </div>

    <div class="sticky inset-x-0 bottom-0 border-t border-gray-100">
        <div class="flex items-center gap-2 bg-white p-4 hover:bg-gray-50">
            <img alt="" src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" class="size-10 rounded-full object-cover" />
            <div>
                <p class="text-xs">
                    <strong class="block font-medium">{{ Auth::user()->username }}</strong>
                    <span> {{ Auth::user()->email }} </span>
                </p>
            </div>
            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                @csrf
                <button type="submit" class="block rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                    <span class="sr-only">Log Out</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
