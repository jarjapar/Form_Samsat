<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Samsat Mataram')</title>
  {{-- Google Font: Poppins --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    html,body{font-family:"Poppins",system-ui,Arial,Helvetica,sans-serif}
  </style>
</head>
<body class="text-gray-800 bg-white">
  {{-- NAVBAR --}}
  <header class="bg-[#0b5ea8] text-white sticky top-0 z-40 shadow">
    <div class="max-w-[1100px] mx-auto px-4">
      <div class="h-14 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
          <div class="text-sm leading-tight">
            <div class="font-bold tracking-wide">BAPPENDA NTB</div>
            <div class="text-[10px] opacity-80">Kuat & Amanah</div>
          </div>
        </div>
        <nav class="hidden md:flex items-center gap-6 text-[15px] font-semibold">
          @php $menu = [
            ['Beranda', route('landing')],
            ['Pengaduan', '#pengaduan'],
            ['Staf', '#staf'],
            ['Berita', '#berita'],
            ['Contact', '#kontak'],
            ['Sop', '#sop'],
          ]; @endphp
          @foreach ($menu as $i => $it)
            <a href="{{ $it[1] }}"
              class="relative hover:opacity-90
                {{ $i===0 ? 'after:absolute after:left-0 after:-bottom-3 after:h-[3px] after:w-full after:bg-yellow-300' : '' }}">
              {{ $it[0] }}
            </a>
          @endforeach
        </nav>
      </div>
    </div>
  </header>

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
