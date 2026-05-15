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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJ+Y3v1HQpG8aFf2fN7fWkPXx1E6s4R9RP3gU=" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
        $(document).ready(function() {
            // Example: Toggle sidebar on mobile
            console.log('Document is ready, you can add your custom JS here');
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
