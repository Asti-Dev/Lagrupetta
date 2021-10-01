<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


    <!-- Styles -->
    @livewireStyles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>

    <div x-data="{ sidebar: true }" id="app">
        @include('layouts.topnav')
        <div :class="{ 'sidebarshow': sidebar === true }" class="wrapper">
            @auth
                @include('layouts.sideNav')
            @endauth
            <main class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-5">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @yield('javascript')
    @stack('scripts')
</body>

</html>