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

        <!-- Favicon -->
        <link rel='icon' type='image/x-icon' href="{{ asset('favicon.ico') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">

            <!-- Navbar for homepage -->
            <div class='inline-flex min-w-full'>
                <a href="/" class="pt-1 pl-1">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
                <div class='inline-flex flex-row text-white text-xl w-full justify-end gap-4 pr-7'>
                    @auth
                        <a href='/dashboard' class='flex items-center hover:text-gray-400'>
                            <span>Return to Game</span>
                        </a>
                    @endauth
                    <a href='/login' class='flex items-center hover:text-gray-400'>
                        <span>Login</span>
                    </a>
                    <a href='/register' class='flex items-center hover:text-gray-400'>
                        <span>Register</span>
                    </a>
                </div>
            </div>

            <div class="w-full mt-6">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
