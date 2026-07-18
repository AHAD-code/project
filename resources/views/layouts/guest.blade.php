<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Student Intern Portal') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">

            <div class="flex w-full max-w-5xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <!-- Left Side: Branding Banner -->
                <div class="hidden md:flex md:w-1/2 bg-blue-700 p-12 flex-col justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-900 opacity-90"></div>

                    <div class="relative z-10">
                        <svg class="w-12 h-12 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                        <h1 class="text-3xl font-bold text-white mb-4">Student Intern Portal</h1>
                        <p class="text-blue-100 text-lg">Manage your internship lifecycle, submit daily logbooks, and track evaluations efficiently.</p>
                    </div>

                    <div class="relative z-10">
                        <p class="text-blue-200 text-sm">COMSATS University Islamabad</p>
                    </div>
                </div>

                <!-- Right Side: Dynamic Form Area -->
                <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
