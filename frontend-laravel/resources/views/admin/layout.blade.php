<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>@yield('title','Admin')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">
  <header class="bg-[#0b5ea8] text-white">
    <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
      <div class="font-bold">Samsat Admin</div>
      <nav class="flex gap-5 text-sm font-semibold">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.berita.index') }}">Berita</a>
        <a href="{{ route('admin.pengaduan.index') }}">Pengaduan</a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf <button class="opacity-90 hover:opacity-100">Logout</button>
        </form>
      </nav>
    </div>
  </header>

  <main class="max-w-6xl mx-auto p-4">
    @if(session('ok')) <div class="mb-3 rounded bg-green-50 border border-green-200 p-3 text-green-700">{{ session('ok') }}</div> @endif
    @if($errors->any()) <div class="mb-3 rounded bg-red-50 border border-red-200 p-3 text-red-700">{{ $errors->first() }}</div> @endif
    @yield('content')
  </main>
</body>
</html>
