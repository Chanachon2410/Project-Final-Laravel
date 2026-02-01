<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('images/logo (1).png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased">
        <!-- Initial Page Loader -->
        <div id="page-loader" class="fixed inset-0 z-[99999] flex items-center justify-center bg-white transition-opacity duration-500">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 border-4 border-indigo-100 border-t-indigo-600 rounded-full animate-spin"></div>
                <p class="mt-4 text-indigo-600 font-semibold animate-pulse">กำลังโหลด...</p>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loader = document.getElementById('page-loader');
                
                // 1. Hide loader when page is fully loaded
                window.addEventListener('load', function() {
                    if (loader) {
                        loader.classList.add('opacity-0');
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 500);
                    }
                });

                // 2. Show loader immediately when clicking links (Instant Feedback)
                document.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (link && link.href && !link.target && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
                        const isLocal = link.hostname === window.location.hostname;
                        const isAnchor = link.getAttribute('href').startsWith('#');
                        // Exclude downloads or PDF links to prevent loader getting stuck
                        const isDownload = link.hasAttribute('download') || link.href.includes('/pdf/') || link.href.includes('download');

                        if (isLocal && !isAnchor && !isDownload) {
                            if (loader) {
                                loader.style.display = 'flex';
                                requestAnimationFrame(() => {
                                    loader.classList.remove('opacity-0');
                                });
                            }
                        }
                    }
                });

                // 3. Fix "Back Button" issue (Safari/Chrome bfcache)
                window.addEventListener('pageshow', function(event) {
                    if (event.persisted && loader) {
                        loader.classList.add('opacity-0');
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 100);
                    }
                });

                // 4. Show loader on Form Submit
                document.addEventListener('submit', function(e) {
                    const form = e.target;
                    // Check if form is not opening in new tab/window and not a Livewire form (Livewire handles its own loading usually, but for full page reloads via form submit, we want this)
                    // Note: Livewire forms usually use wire:submit which prevents default. If default is prevented, this listener might run but the page won't reload.
                    // However, standard login forms or non-ajax forms need this.
                    if ((!form.target || form.target === '_self') && !e.defaultPrevented) {
                         if (loader) {
                            loader.style.display = 'flex';
                            requestAnimationFrame(() => {
                                loader.classList.remove('opacity-0');
                            });
                        }
                    }
                });
            });
        </script>

        <div x-data="{ 
                sidebarCollapsed: false, 
                mobileOpen: false,
                init() {
                    window.addEventListener('resize', () => {
                        if (window.innerWidth < 768) {
                            this.sidebarCollapsed = false;
                        }
                    });
                }
             }" 
             class="min-h-screen bg-gray-100 flex">
            
            <!-- Mobile Backdrop -->
            <div x-show="mobileOpen" 
                 @click="mobileOpen = false" 
                 x-transition:enter="transition-opacity ease-linear duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-linear duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/50 z-20 md:hidden" 
                 style="display: none;"></div>

            <!-- Collapsible Sidebar -->
            <div class="flex-shrink-0 bg-white border-r border-gray-200 h-screen fixed z-30 transition-all duration-300 transform"
                 :class="[
                    sidebarCollapsed ? 'md:w-20' : 'md:w-64',
                    mobileOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0 w-64'
                 ]">
                @include('layouts.navigation')
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col transition-all duration-300 min-h-screen"
                 :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'">
                
                <!-- Mobile Menu Button (Floating) -->
                <div class="md:hidden p-4 fixed top-0 left-0 z-20">
                    <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-md bg-white shadow-md text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
        @include('components.sweetalert-script')
        @stack('scripts')

        <!-- Global Loading Indicator -->
        <div wire:loading.delay.longest class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/80 backdrop-blur-sm transition-opacity duration-300">
            <div class="flex flex-col items-center">
                <!-- Modern Spinner -->
                <div class="relative w-16 h-16">
                    <div class="absolute inset-0 border-4 border-indigo-100 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-indigo-600 rounded-full border-t-transparent animate-spin"></div>
                </div>
                <!-- Text -->
                <p class="mt-4 text-indigo-700 font-semibold text-lg animate-pulse tracking-wide">
                    Processing...
                </p>
            </div>
        </div>
    </body>
</html>