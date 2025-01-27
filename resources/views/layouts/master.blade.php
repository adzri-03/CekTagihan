<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="text/javascript">
        console.log('Script after Vite loaded');
    </script>
    @livewireStyles
</head>

<body class="font-sans antialiased">
    @yield('content')

    @livewireScripts
    @stack('scripts')
    <script type="text/javascript">
        console.log('Livewire status:', typeof window.Livewire !== 'undefined' ? 'Loaded' : 'Not Loaded');
    </script>

</body>

</html>
