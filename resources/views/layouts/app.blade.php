<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Student Intern Portal') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Added flex and flex-col to stack the layout vertically -->
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">

            <!-- ========================================== -->
            <!-- 1. NAVIGATION HEADER                       -->
            <!-- ========================================== -->
            @if(auth()->check() && auth()->user()->role === 'supervisor')
                @include('layouts.supervisor-navigation')
            @elseif(auth()->check() && auth()->user()->role === 'student')
                @include('layouts.student-navigation')
            @else
                @include('layouts.navigation')
            @endif

            <!-- ========================================== -->
            <!-- 2. PAGE HEADING (Optional Title Bar)       -->
            <!-- ========================================== -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- ========================================== -->
            <!-- 3. MAIN PAGE CONTENT                       -->
            <!-- ========================================== -->
            <!-- flex-grow forces this section to fill empty space, pushing the footer down -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- ========================================== -->
            <!-- 4. FOOTER                                  -->
            <!-- ========================================== -->
            <!-- mt-auto pushes the footer to the bottom of the flex container -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Student Intern Portal') }}. All rights reserved.
                </div>
            </footer>

        </div>
    </body>
</html>
