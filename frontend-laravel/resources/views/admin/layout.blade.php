<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title','Admin — Samsat Mataram')</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    html,body{font-family:"Poppins",system-ui,Arial,sans-serif}
    [x-cloak]{display:none!important}
  </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800">

@php
  $menu = [
    ['label'=>'Dashboard', 'route'=>'admin.dashboard',       'href'=>route('admin.dashboard')],
    ['label'=>'Berita',    'route'=>'admin.berita.index',    'href'=>route('admin.berita.index')],
    ['label'=>'Pengaduan', 'route'=>'admin.pengaduan.index', 'href'=>route('admin.pengaduan.index')],
  ];
  $isActive = fn($r) => request()->routeIs($r);
@endphp

{{-- HEADER --}}
<header x-data="{open:false,userMenu:false}" class="bg-[#0b5ea8] text-white sticky top-0 z-50 shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="h-14 flex items-center justify-between">

      {{-- Brand --}}
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
        <div class="leading-tight hidden sm:block">
          <div class="font-extrabold">Admin Panel</div>
          <div class="text-[11px] opacity-90">Samsat Mataram</div>
        </div>
      </a>

      {{-- Hamburger (mobile) --}}
      <button class="md:hidden text-2xl" @click="open=!open" :aria-expanded="open.toString()" aria-label="Toggle Menu">
        <span x-show="!open">☰</span>
        <span x-cloak x-show="open">✕</span>
      </button>

      {{-- Menu desktop --}}
      <nav class="hidden md:flex items-center gap-6 text-[15px] font-semibold">
        @foreach ($menu as $it)
          <a href="{{ $it['href'] }}"
             class="relative pb-1 hover:opacity-90
                    {{ $isActive($it['route']) ? 'after:absolute after:left-0 after:-bottom-1 after:h-[3px] after:w-full after:bg-yellow-300' : '' }}">
            {{ $it['label'] }}
          </a>
        @endforeach

        <a href="{{ route('landing') }}" class="hover:opacity-90">↩ Kembali ke Situs</a>

        {{-- User dropdown --}}
        <div class="relative">
          <button @click="userMenu=!userMenu" class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20">
            {{ auth()->user()->name ?? 'Admin' }}
          </button>
          <div x-cloak x-show="userMenu" @click.outside="userMenu=false"
               class="absolute right-0 mt-2 w-44 bg-white text-gray-700 rounded-lg shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="w-full text-left px-3 py-2 hover:bg-gray-50">Logout</button>
            </form>
          </div>
        </div>
      </nav>
    </div>
  </div>

  {{-- Menu mobile --}}
  <div x-cloak x-show="open" x-transition
       @resize.window="if (window.innerWidth>=768) open=false"
       class="md:hidden border-t border-white/10 bg-[#0b5ea8] text-white">
    <nav class="max-w-7xl mx-auto px-4 py-2 text-[15px] font-semibold">
      @foreach ($menu as $it)
        <a href="{{ $it['href'] }}" @click="open=false"
           class="relative block rounded-md px-4 py-2 my-1 hover:bg-white/10
                  {{ $isActive($it['route']) ? 'bg-white/10 before:absolute before:left-0 before:top-0 before:h-full before:w-[3px] before:bg-yellow-300' : '' }}">
          {{ $it['label'] }}
        </a>
      @endforeach

      <a href="{{ route('landing') }}" @click="open=false"
         class="block rounded-md px-4 py-2 my-1 hover:bg-white/10">↩ Kembali ke Situs</a>

      <form method="POST" action="{{ route('logout') }}" class="px-2 py-2">
        @csrf
        <button class="w-full text-left rounded-md px-2 py-2 hover:bg-white/10">Logout</button>
      </form>
    </nav>
  </div>
</header>

{{-- FLASH --}}
@if (session('ok') || $errors->any())
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    @if (session('ok'))
      <div class="rounded-md bg-green-50 text-green-700 px-4 py-3 mb-3">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
      <div class="rounded-md bg-red-50 text-red-700 px-4 py-3">
        <ul class="list-disc ml-5">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
@endif

{{-- MAIN --}}
<main class="flex-1 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @yield('content')
  </div>
</main>

{{-- FOOTER --}}
<footer class="bg-[#0b5ea8] text-white mt-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
      <img src="{{ asset('images/logo.png') }}" class="h-7" alt="logo">
      <div class="font-semibold">BAPPENDA NTB</div>
    </a>
    <div class="text-sm opacity-90 text-center sm:text-right">
      © {{ now()->year }} Admin — Samsat Mataram
    </div>
  </div>
</footer>

</body>
</html>
