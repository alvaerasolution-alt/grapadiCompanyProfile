<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $companyName = site_setting('site_company_name', config('app.name', 'Grapadi'));
        $tagline = site_setting('site_tagline', 'Market Intelligence & Consulting');
        $favicon = site_setting('site_favicon', '');
    @endphp

    <title>@yield('title', $companyName)</title>
    <meta name="description" content="@yield('description', $tagline)">

    @if($favicon)
    <link rel="icon" href="{{ str_starts_with($favicon, 'http') ? $favicon : asset('storage/' . $favicon) }}" type="image/x-icon">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark text-gray-800 dark:text-gray-200 font-body transition-colors duration-300">
    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />

    {{-- Floating WhatsApp CTA Button --}}
    <x-whatsapp-cta style="floating" text="Chat WA" />

    {{-- Lead Capture Modal --}}
    <livewire:lead-capture-modal />

    @livewireScripts
    @stack('scripts')
</body>
</html>
