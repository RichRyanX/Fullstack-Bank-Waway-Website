<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Bank Waway Lampung')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
  @yield('styles')
</head>
<body @yield('bodyClass')>

  <x-public.navbar />

  @yield('content')

  <x-public.footer />

  <script src="{{ asset('frontend/js/main.js') }}"></script>
  @yield('scripts')
</body>
</html>
