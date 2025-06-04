<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPARK') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen font-sans antialiased">

    <!-- Main Page Wrapper -->
    <div class="flex-grow flex flex-col bg-gray-100 dark:bg-gray-300">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-600 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        <!-- Main Content Area with Full Background -->
        <main class="flex-grow bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/app-bg.jpg') }}');">
            <div class="max-w-7xl mx-auto p-6 sm:px-6 lg:px-8 h-full">
                <div class="bg-white/50 p-6 rounded shadow backdrop-blur-sm h-full">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    <!-- Sticky Footer -->
    <footer class="bg-gray-200 text-center text-gray-700 py-4">
        &copy; {{ date('Y') }} SPARK. All rights reserved.
    </footer>

</body>
</html>
