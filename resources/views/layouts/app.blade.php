<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="{{ asset('css/maspos-styles.css') }}" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Your App Name')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:components.navbar />

        <main>
            {{ $slot }}
        </main>

        
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.1.0/dist/turbo.es5-umd.js"></script>
</body>
</html>