<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200 h-screen">
    <div id="app">
        <nav class="flex items-center justify-between flex-wrap p-6">
            <div class="flex flex-grow items-center flex-shrink-0 mr-6">
                <a href="{{ route('welcome') }}" class="font-semibold text-xl tracking-tight">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="block lg:hidden">
                <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                </button>
            </div>
            <div class="w-auto block ">
                <div class="text-sm float-right">
                    @guest
                    <a href="{{ route('login') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block mt-4 lg:inline-block lg:mt-0">
                        Register
                    </a>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="p-16 pt-8 mx-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
