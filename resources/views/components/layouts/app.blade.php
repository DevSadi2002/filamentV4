<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--  cdn tailwind --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
    <title>{{ $title ?? 'Hope Store' }}</title>
    {{-- <script src="https://unpkg.com/preline@1.x.x/dist/preline.js"></script> --}}


    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles()
</head>

<body class="bg-slate-200 dark:bg-slate-700">
    @livewire('partials.navbar')
    <main>
        {{ $slot }}
    </main>

    @livewire('partials.footer')
    {{--
<x-livewire-alert::scripts /> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts()


</body>

</html>
