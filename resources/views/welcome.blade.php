<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Classroom Manager - Light Tech</title>

    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Load Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Inter"', '"Sarabun"', 'sans-serif'],
                    },
                    backgroundImage: {
                        'grid-pattern': "linear-gradient(to right, #e2e8f0 1px, transparent 1px), linear-gradient(to bottom, #e2e8f0 1px, transparent 1px)",
                    },
                    animation: {
                        'pulse-slow': 'pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'spin-slow': 'spin 12s linear infinite',
                        'shimmer': 'shimmer 2s infinite',
                    },
                    keyframes: {
                        shimmer: {
                            '0%': {
                                transform: 'translateX(-100%)'
                            },
                            '100%': {
                                transform: 'translateX(100%)'
                            }
                        }
                    }
                },
            },
        }
    </script>

    <style>
        .bg-grid {
            background-size: 40px 40px;
            /* Mask ให้จางลงตรงขอบ */
            mask-image: linear-gradient(to bottom, transparent, 5%, black, 95%, transparent);
            -webkit-mask-image: linear-gradient(to bottom, transparent, 5%, black, 95%, transparent);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        /* Animations */
        @keyframes tilt {

            0%,
            50%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(1deg);
            }

            75% {
                transform: rotate(-1deg);
            }
        }

        .animate-tilt {
            animation: tilt 10s infinite linear;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-slate-50 text-slate-800 h-screen w-full overflow-hidden relative selection:bg-indigo-500 selection:text-white">

    <!-- Background Elements -->
    <!-- Grid Pattern (Light Gray) -->
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.6] bg-grid z-0"></div>

    <!-- Glowing Orbs (Ambient Light - Pastel Colors) -->
    <div
        class="absolute top-[-10%] left-[20%] w-[500px] h-[500px] bg-indigo-200 rounded-full blur-[100px] animate-pulse-slow mix-blend-multiply opacity-70">
    </div>
    <div class="absolute bottom-[-10%] right-[20%] w-[400px] h-[400px] bg-violet-200 rounded-full blur-[80px] animate-pulse-slow mix-blend-multiply opacity-70"
        style="animation-delay: 2s;"></div>
    <div class="absolute top-[40%] left-[50%] w-[300px] h-[300px] bg-cyan-100 rounded-full blur-[80px] animate-pulse-slow mix-blend-multiply opacity-60"
        style="animation-delay: 4s;"></div>

    <!-- Main Content Container -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full px-4">

        <!-- Logo / Icon Floating -->
        <div class="mb-8 relative group">
            <!-- Glow Effect behind Logo -->
            <div
                class="absolute -inset-1 bg-gradient-to-r from-indigo-400 to-cyan-400 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000 group-hover:duration-200 animate-tilt">
            </div>

            <!-- Logo Box (White) -->
            <div
                class="relative w-20 h-20 bg-white rounded-2xl flex items-center justify-center border border-slate-200 shadow-xl">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
            </div>

            <!-- Orbit Ring (Decoration - Light Gray) -->
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 border border-dashed border-slate-300 rounded-full animate-spin-slow opacity-60 pointer-events-none">
            </div>
        </div>

        <!-- Typography -->
        <div class="text-center mb-10 space-y-4 max-w-lg">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">
                Classroom <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500">Manager</span>
            </h1>
            <p class="text-slate-500 text-lg font-light leading-relaxed">
                ระบบบริหารจัดการชั้นเรียนอัจฉริยะ<br class="hidden sm:block">
                เข้าถึงข้อมูลนักเรียนและวิเคราะห์ผลการเรียนได้ทุกที่
            </p>
        </div>

        <!-- Glass Card for Actions -->
        <div class="glass-light p-2 rounded-2xl w-full max-w-sm">
            <div class="bg-white/50 rounded-xl p-6 border border-slate-200">

                <div class="space-y-4">
                    <!-- Primary Button (Login) -->
                    <a href="{{ route('login') }}"
                        class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-slate-900 hover:bg-slate-800 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 overflow-hidden">
                        <!-- Shimmer Effect -->
                        <div
                            class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent z-10">
                        </div>

                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400 group-hover:text-white transition-colors"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        เข้าสู่ระบบ (Login)
                    </a>

                    <!-- Removed Register Button as requested -->
                </div>

                <!-- Divider -->
                <div class="relative mt-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold">Secure
                            Access</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-6 text-center w-full">
            <p class="text-xs text-slate-400 font-mono">
                System Status: <span class="text-emerald-500 font-semibold">● Online</span> | Version 2.0.1
            </p>
        </div>

    </div>

</body>

</html>
