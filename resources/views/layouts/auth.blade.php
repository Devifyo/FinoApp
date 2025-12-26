<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ 'Sign In' }} | {{ config('app.name', 'Financial App') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Secure access to FinoApp. Sign in to manage your project portfolios, review contribution benchmarks, and track revenue allocations.">
    <meta name="robots" content="noindex, nofollow"> <meta property="og:title" content="FinoApp Secure Portal">
    <meta property="og:description" content="Authorized access for project stakeholders. Manage your professional revenue distributions securely.">
    <meta property="og:image" content="{{ asset('images/auth-preview.jpg') }}">
    <meta property="og:type" content="website">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- If you are using Vite, keep this. If not, use CDN below --}}
    
    {{-- Fallback Tailwind CDN for immediate testing without building assets --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased bg-gradient-to-br from-gray-50 to-gray-200 dark:from-gray-900 dark:to-gray-800 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    <div class="sm:mx-auto sm:w-full sm:max-w-md mb-6">
        <div class="flex justify-center">
            <div class="h-12 w-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg transform rotate-3">
                <span class="text-white font-bold text-xl">$</span>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
            {{ $title ?? 'Welcome Back' }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            {{ $subtitle ?? 'Manage your projects and earnings efficiently.' }}
        </p>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="glass-effect py-8 px-4 shadow-2xl sm:rounded-2xl sm:px-10 relative overflow-hidden bg-white/80 dark:bg-gray-800/80">
            
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            {{ $slot }}

        </div>

        <div class="mt-6 text-center">
             <p class="text-xs text-gray-500">
                &copy; {{ date('Y') }} Financial Allocator. All rights reserved.
            </p>
        </div>
    </div>

    @livewireScripts
</body>
</html>