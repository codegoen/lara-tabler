<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale', 'en'))">
  <head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="en" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>{{ $title ?? 'Tabler Crud Generator' }}</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
  </head>

  <body class="antialiased">

    <!-- Header -->
    @include('tabler::components.header')

    <!-- Navbar -->
    @include('tabler::components.navbar')

    <div class="page">
        <!-- Content -->
        <div class="content container pt-0">

            @yield('content')
            <!-- Footer -->
            {{-- @include('tabler::components.footer') --}}
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}" charset="utf-8"></script>
    <?php session()->forget('message') ?>
    @stack('scripts')
  </body>

</html>
