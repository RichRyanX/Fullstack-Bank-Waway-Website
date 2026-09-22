<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Bank Waway Admin CMS')</title>
<link rel="stylesheet" href="{{ asset('admin/CSS/style.css') }}">
<link rel="stylesheet" href="{{ asset('admin/CSS/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('admin/CSS/sidebar.css') }}">
@yield('styles')
</head>
<body>

  <div class="dash">

    <x-admin.sidebar />

    <div class="dash-main">

      <x-admin.header />

      <main class="dash-content">
        @yield('content')
      </main>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('admin/JS/script.js') }}"></script>
<script src="{{ asset('admin/JS/logout.js') }}"></script>
@yield('scripts')
</body>
</html>