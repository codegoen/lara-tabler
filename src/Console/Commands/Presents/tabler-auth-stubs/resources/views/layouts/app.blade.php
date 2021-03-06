<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale', 'en'))">
  <head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <!-- icon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <title>{{ $title ?? config('app.name', 'Laravel Tabler') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    
  </head>

  <body class="antialiased">  

    <!-- Aside -->
    <x-aside></x-aside>

    <div class="page">
        <!-- Header -->
        <x-header></x-header>

        <!-- Content -->
        <div class="content container">

            @yield('content')

            <!-- Footer -->
            <x-footer></x-footer>
        </div>
    </div>

    <script src="{{ mix('/js/app.js') }}" charset="utf-8"></script>

  </body>

</html>
