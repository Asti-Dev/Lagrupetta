<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Styles -->
    @livewireStyles

</head>
<body>
    <div id="app">

        <main class="container d-flex justify-content-center align-items-center py-4">
            @yield('content')
        </main>
    </div>
    @livewireScripts
    @yield('javascript')

</body>
</html>
