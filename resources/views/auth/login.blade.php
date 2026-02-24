<x-guest-layout>
    <div class="px-2 py-4">
        <!-- Header / Logo Area -->
        <div class="text-center mb-8">
            <div
                class="mx-auto h-16 w-16 bg-gradient-to-tr from-violet-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg mb-4 transform hover:rotate-3 transition-transform duration-300">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-800">ยินดีต้อนรับ</h2>
            <p class="text-sm text-gray-500 mt-1">กรุณาลงชื่อเข้าใช้เพื่อดำเนินการต่อ</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-bold text-gray-700 mb-1 pl-1">
                    {{ __('Username') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-indigo-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input id="username"
                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all"
                        type="text" name="username" :value="old('username')" required autofocus
                        autocomplete="username" placeholder="กรอกชื่อผู้ใช้ของคุณ" />
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-1 pl-1">
                    {{ __('Password') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-indigo-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <input id="password"
                        class="block w-full pl-11 pr-4 py-3 border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="กรอกรหัสผ่าน" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer"
                        name="remember">
                    <span
                        class="ms-2 text-sm text-gray-600 group-hover:text-indigo-600 transition-colors">{{ __('จดจำฉันไว้') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors"
                        href="{{ route('password.request') }}">
                        {{ __('ลืมรหัสผ่าน?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-sm font-bold text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                    {{ __('เข้าสู่ระบบ') }}
                </button>
            </div>
        </form>

        <!-- Optional: Footer text -->
        <p class="text-center text-xs text-gray-400 mt-8">
            &copy; {{ date('Y') }} ระบบลงทะเบียนเรียนออนไลน์
        </p>
    </div>

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let statusMessage = '{{ session('status') }}';
                
                // แปลข้อความสถานะเป็นภาษาไทย
                if (statusMessage === 'Your password has been reset.') {
                    statusMessage = 'รีเซ็ตรหัสผ่านของคุณเรียบร้อยแล้ว';
                } else if (statusMessage === 'We have emailed your password reset link!') {
                    statusMessage = 'เราได้ส่งลิงก์รีเซ็ตรหัสผ่านไปยังอีเมลของคุณแล้ว';
                }

                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: statusMessage,
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errorMessage = '{{ $errors->first() }}';
                
                // แปลข้อความผิดพลาดเป็นภาษาไทย
                if (errorMessage === 'These credentials do not match our records.') {
                    errorMessage = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
                } else if (errorMessage.includes('throttle')) {
                    errorMessage = 'คุณพยายามเข้าระบบบ่อยเกินไป กรุณาลองใหม่ในภายหลัง';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'เข้าสู่ระบบไม่สำเร็จ',
                    text: errorMessage,
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#4f46e5',
                });
            });
        </script>
    @endif
</x-guest-layout>
