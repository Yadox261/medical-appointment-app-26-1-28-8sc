@props([
    'breadcrumb' => [],
    'title' => '',
])
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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/8e295323f1.js" crossorigin="anonymous"></script>
        
        <!-- sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- wireui scripts -->
        <wireui:scripts />

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-100">

        @include('layouts.includes.admin.navigation')
        @include('layouts.includes.admin.sidebar')

        <div class="p-4 sm:ml-64 mt-14">
            <h1 class="text-2xl font-semibold text-blue-600">{{ $title }}</h1>
            <div class="mt-14 flex justify-between items-center w-full">
                @include('layouts.includes.admin.breadcrumb', ['breadcrumb' => $breadcrumb])
                @isset($action)
                    <div>
                        {{ $action }}
                    </div>
                @endisset
            </div>
            {{ $slot }}
        </div>

        @stack('modals')

        {{-- Mostrar sweetalerts --}}

        @if (@session('swal'))

            <script>
                Swal.fire(@json(@session('swal')));
            </script>
            
        @endif

        <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

        {{-- Solo una vez, al final del body --}}
        @livewireScripts
    </body>
</html>
