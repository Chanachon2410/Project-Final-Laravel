<div>
    <div class="max-w-5xl mx-auto px-4 py-8 font-sans">
        
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
            <div class="flex items-center gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-indigo-100">
                        @if($student)
                            {{ mb_substr($student->firstname, 0, 1) }}
                        @elseif($teacher)
                            {{ mb_substr($teacher->firstname, 0, 1) }}
                        @else
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        @endif
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-2xl font-black text-gray-900">
                            @if($student)
                                {{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}
                            @elseif($teacher)
                                {{ $teacher->title }}{{ $teacher->firstname }} {{ $teacher->lastname }}
                            @else
                                {{ $user->username }}
                            @endif
                        </h1>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-100">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    </div>
                    <p class="text-gray-500 font-medium">
                        @if($student)
                            รหัสนักเรียน: <span class="font-bold text-gray-700">{{ $student->student_code }}</span>
                        @elseif($teacher)
                            รหัสบุคลากร: <span class="font-bold text-gray-700">{{ $teacher->teacher_code ?? 'N/A' }}</span>
                        @else
                            {{ $user->email }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                @if($student)
                <!-- Student Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            ข้อมูลการศึกษา
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">รหัสประจำตัว</label>
                                <p class="text-gray-900 font-bold font-mono">{{ $student->student_code }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">ชื่อ-นามสกุล</label>
                                <p class="text-gray-900 font-bold">{{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">ระดับชั้น</label>
                                <p class="text-gray-900 font-bold">{{ $student->classGroup->level->name ?? '-' }} (ปีที่ {{ $student->classGroup->level_year ?? '-' }})</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">สาขาวิชา</label>
                                <p class="text-indigo-600 font-black tracking-tight">{{ $student->classGroup->major->major_name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">กลุ่มเรียน</label>
                                <p class="text-gray-900 font-bold">{{ $student->classGroup->course_group_name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">อาจารย์ที่ปรึกษา</label>
                                <p class="text-gray-900 font-bold">
                                    {{ $student->classGroup->advisor->firstname ?? '-' }} 
                                    {{ $student->classGroup->advisor->lastname ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($teacher)
                <!-- Teacher Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            ข้อมูลบุคลากรครู
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">รหัสบุคลากร</label>
                                <p class="text-gray-900 font-bold font-mono">{{ $teacher->teacher_code ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">ชื่อ-นามสกุล</label>
                                <p class="text-gray-900 font-bold">{{ $teacher->title }}{{ $teacher->firstname }} {{ $teacher->lastname }}</p>
                            </div>
                            <div class="col-span-full">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-2">กลุ่มเรียนที่ปรึกษา</label>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($teacher->advisedClassGroups as $group)
                                        <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl border border-indigo-100 text-xs font-bold">
                                            {{ $group->course_group_name }}
                                        </span>
                                    @empty
                                        <p class="text-sm text-gray-400 italic">ไม่มีข้อมูลที่ปรึกษา</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Account Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            ข้อมูลบัญชีผู้ใช้
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">Username</label>
                                <p class="text-gray-900 font-bold">{{ $user->username }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">บทบาทในระบบ</label>
                                <p class="text-indigo-600 font-black">
                                    {{ match($user->getRoleNames()->first()) {
                                        'Admin' => 'ผู้ดูแลระบบ (Admin)',
                                        'Teacher' => 'อาจารย์ / ครูที่ปรึกษา (Teacher)',
                                        'Registrar' => 'เจ้าหน้าที่ทะเบียน (Registrar)',
                                        'Student' => 'นักเรียน / นักศึกษา (Student)',
                                        default => $user->getRoleNames()->first()
                                    } }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">อีเมล</label>
                                <p class="text-gray-900 font-bold break-all">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-1">เลขบัตรประชาชน</label>
                                <p class="text-gray-900 font-bold tracking-[0.2em]">
                                    {{ $student->citizen_id ?? ($teacher->citizen_id ?? 'N/A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Security Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-50 text-green-600 rounded-xl mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.952 0 0112 2.944a11.952 11.952 0 00-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-black text-gray-900 mb-1">ความปลอดภัย</h3>
                    <p class="text-xs text-gray-500 font-medium">บัญชีของคุณอยู่ในสถานะปกติและปลอดภัย</p>
                </div>

                <!-- Roles Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-black text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-indigo-500 rounded-full"></span>
                        สิทธิ์การเข้าถึง
                    </h3>
                    <div class="space-y-2">
                        @foreach($user->roles as $role)
                        <div class="flex items-center gap-2 px-3 py-2 bg-indigo-50/50 rounded-xl border border-indigo-100">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                            <span class="text-xs font-black text-indigo-700 uppercase tracking-widest">{{ $role->name }}</span>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-gray-400 mt-6 leading-relaxed font-medium">
                        สิทธิ์การใช้งานระบบถูกกำหนดโดยเจ้าหน้าที่ หากพบข้อมูลไม่ถูกต้องกรุณาติดต่อฝ่ายทะเบียน
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>
