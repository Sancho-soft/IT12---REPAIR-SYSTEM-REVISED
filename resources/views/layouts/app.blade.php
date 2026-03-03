<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS (Maps) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Automatic Resolution Scaling for Small Monitors -->
    <style>
        @media screen and (max-width: 1440px) {
            html { zoom: 0.85; }
        }
        @media screen and (max-width: 1280px) {
            html { zoom: 0.80; }
        }
        @media screen and (max-width: 1024px) {
            html { zoom: 1; } /* Reset for tablets/mobile, where Tailwind flex wrap handles it normally */
        }
    </style>

    <!-- Scripts & Styles (Offline TailWind via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Check for dark mode preference to prevent FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Leaflet JS (Maps) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-[#f8f9fa] dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased"
    x-data="{
        confirmModal: false,
        confirmMessage: '',
        confirmAction: null,
        askConfirm(message, action) {
            this.confirmMessage = message;
            this.confirmAction = action;
            this.confirmModal = true;
        },
        doConfirm() {
            if(this.confirmAction) this.confirmAction();
            this.confirmModal = false;
        }
    }"
    @open-confirm.window="askConfirm($event.detail.message, $event.detail.action)">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col ml-64 transition-all duration-300">
            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8f9fa] dark:bg-gray-900 p-6">
                @if(isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Global Confirmation Modal -->
    <div x-show="confirmModal"
        class="fixed inset-0 z-[100] overflow-y-auto" style="display:none;"
        x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="flex min-h-screen items-center justify-center px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/40" @click="confirmModal = false"></div>
            <!-- Modal Card -->
            <div class="relative bg-white rounded-2xl shadow-2xl px-6 py-6 max-w-md w-full z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Confirm Action</h3>
                        <p class="text-sm text-gray-500 mt-0.5" x-text="confirmMessage"></p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button @click="confirmModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button @click="doConfirm()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
        } else {
            if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                // if NOT set via local storage previously
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        }
    </script>
</body>

</html>