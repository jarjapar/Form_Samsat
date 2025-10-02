<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Samsat Mataram')</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Google Font: Poppins --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  {{-- AlpineJS --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    html,body{font-family:"Poppins",system-ui,Arial,Helvetica,sans-serif}
    /* Sembunyikan elemen sampai Alpine siap */
    [x-cloak]{ display:none !important; }
  </style>
</head>
<body class="text-gray-800 bg-white">

  {{-- NAVBAR --}}
  <header class="bg-[#0b5ea8] text-white sticky top-0 z-40 shadow" x-data="{open:false}">
    <div class="max-w-[1100px] mx-auto px-4">

      @php
        // Daftar menu: label, nama route (optional), dan href
        $menu = [
          ['label' => 'Beranda',   'route' => 'landing',   'href' => route('landing')],
          ['label' => 'Pengaduan', 'route' => 'pengaduan', 'href' => route('pengaduan')],
          ['label' => 'Staf',      'route' => null,        'href' => '#staf'],
          ['label' => 'Berita',    'route' => null,        'href' => '#berita'],
          ['label' => 'Contact',   'route' => null,        'href' => '#kontak'],
          ['label' => 'Sop',       'route' => null,        'href' => '#sop'],
        ];
        $isActive = fn($item) => $item['route'] ? request()->routeIs($item['route']) : false;
      @endphp

      <div class="h-14 flex items-center justify-between">
        {{-- Logo --}}
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
          <div class="text-sm leading-tight">
            <div class="font-bold tracking-wide">BAPPENDA NTB</div>
            <div class="text-[10px] opacity-80">Kuat & Amanah</div>
          </div>
        </div>

        {{-- Tombol hamburger (terlihat < md) --}}
        <button
          class="block md:hidden text-2xl focus:outline-none"
          @click="open = !open"
          @keydown.escape.window="open=false"
          :aria-expanded="open.toString()"
          aria-label="Toggle Menu">
          <span x-show="!open">☰</span>
          <span x-cloak x-show="open">✕</span>
        </button>

        {{-- Menu desktop --}}
        <nav class="hidden md:flex items-center gap-6 text-[15px] font-semibold">
          @foreach ($menu as $it)
            <a href="{{ $it['href'] }}"
               class="relative hover:opacity-90 pb-1
                 {{ $isActive($it)
                    ? 'after:absolute after:left-0 after:-bottom-1 after:h-[3px] after:w-full after:bg-yellow-300'
                    : '' }}">
              {{ $it['label'] }}
            </a>
          @endforeach
        </nav>
      </div>
    </div>

    {{-- Menu mobile (overlay; default TERTUTUP) --}}
    <div x-cloak
         x-show="open"
         x-transition
         @resize.window="if (window.innerWidth >= 768) open = false"
         class="md:hidden fixed inset-x-0 top-14 bottom-0 z-40
                bg-[#0b5ea8] text-white shadow-lg overflow-y-auto">

      <nav class="flex flex-col py-2 text-[15px] font-semibold">
        @foreach ($menu as $it)
          <a href="{{ $it['href'] }}" @click="open=false"
             class="relative pl-4 pr-3 py-2 mx-2 my-0.5 rounded-md hover:bg-white/10
               {{ $isActive($it)
                  ? 'bg-white/10 before:absolute before:left-0 before:top-0 before:h-full before:w-[3px] before:bg-yellow-300'
                  : '' }}">
            {{ $it['label'] }}
          </a>
        @endforeach
      </nav>
    </div>
  </header>

  {{-- KONTEN HALAMAN --}}
  @yield('content')

  {{-- FOOTER --}}
  <footer class="bg-[#0b5ea8] text-white mt-20">
    <div class="max-w-[1100px] mx-auto px-4 py-8 grid md:grid-cols-3 gap-8 text-sm">
      <div class="space-y-2">
        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="logo">
        <div class="font-semibold">BAPPENDA NTB</div>
        <div class="opacity-80 text-xs">Kuat &amp; Amanah</div>
      </div>
      <div class="opacity-90">
        <div class="font-semibold mb-2">Kontak</div>
        <div>Bappenda.ntb.prov</div>
        <div>jalan langko (83112)</div>
        <div>samsat_mataram</div>
        <div>(0370) 631230</div>
      </div>
      <div class="space-y-1">
        <a class="underline" href="#">E-samsat</a><br>
        <a class="underline" href="#">Simaskot</a>
      </div>
    </div>
  </footer>
</body>
</html>
