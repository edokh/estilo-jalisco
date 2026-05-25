<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/favicon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script>
        window.whenJQueryReady = function(callback) {
            if (window.jQuery) return callback(window.jQuery);
            var interval = setInterval(function() {
                if (window.jQuery) {
                    clearInterval(interval);
                    callback(window.jQuery);
                }
            }, 50);
        };

        // when jQuery is ready, log a message to the console
        $(function() {
            console.log('jQuery is ready!');
        });
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div class="lg:flex lg:items-start">
            @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->is_staff))
                <aside class="hidden lg:block lg:w-72 xl:w-80">
                    @include('layouts.sidebar')
                </aside>
            @endif

            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
