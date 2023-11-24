<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="{{__('meta-description.name')}}" content="{{__('meta-description.content')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link fetchpriority="high" rel="preload" href="{{asset('images/atacamastargazing-logo.png')}}" as="image">

    <title>AtacamaStargazing | {{$title ?? ''}}</title>
    {{-- TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Livewire --}}
    @livewireStyles
    @stack('styles')
</head>
<body class="antialiased bg-gradient-to-b from-[#DDE0E5] via-[#BEC2CB] to-[#DDE0E5] h-full">
{{ $slot }}
@livewireScripts
@stack('scripts')
</body>
</html>
