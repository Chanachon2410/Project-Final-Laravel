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
    </head>
    <body class="font-sans text-gray-900 antialiased">
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

                // 2. Show loader immediately when clicking links
                document.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (link && link.href && !link.target && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
                        const isLocal = link.hostname === window.location.hostname;
                        const isAnchor = link.getAttribute('href').startsWith('#');
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

                // 3. Fix "Back Button" issue
                window.addEventListener('pageshow', function(event) {
                    if (event.persisted && loader) {
                        loader.classList.add('opacity-0');
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 100);
                    }
                });

                // 4. Show loader on Form Submit (e.g. Login)
                document.addEventListener('submit', function(e) {
                    const form = e.target;
                    // Check if form is not opening in new tab/window
                    if (!form.target || form.target === '_self') {
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

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        @livewireScripts
    </body>
</html>
