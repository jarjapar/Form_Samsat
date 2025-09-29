<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Samsat Mataram</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  {{-- Alpine untuk slider ringan --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="text-gray-800">
  {{-- NAVBAR --}}
  <header class="bg-[#0b5ea8] text-white sticky top-0 z-30">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" class="h-9" alt="Logo" />
        <div class="font-bold tracking-wide">BAPPENDA NTB</div>
      </div>
      <nav class="hidden md:flex items-center gap-6 font-semibold">
        <a href="{{ route('landing') }}" class="hover:opacity-80">Beranda</a>
        <a href="#pengaduan" class="hover:opacity-80">Pengaduan</a>
        <a href="#staf" class="hover:opacity-80">Staf</a>
        <a href="#berita" class="hover:opacity-80">Berita</a>
        <a href="#kontak" class="hover:opacity-80">Contact</a>
        <a href="#sop" class="hover:opacity-80">SOP</a>
      </nav>
    </div>
  </header>

  @yield('content')

  {{-- FOOTER --}}
  <footer class="bg-[#0b5ea8] text-white mt-16">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 px-4 py-8">
      <div>
        <div class="font-bold mb-2">BAPPENDA NTB</div>
        <div class="text-sm opacity-90">Kuat & Amanah</div>
      </div>
      <div class="text-sm opacity-90">
        Bappenda.ntb.prov<br/>jalan langko (83112)<br/>samsat_mataram<br/>(0370) 631230
      </div>
      <div class="space-y-2 text-sm">
        <a class="underline" href="#">E-samsat</a><br/>
        <a class="underline" href="#">Simaskot</a>
      </div>
    </div>
  </footer>
</body>
</html>
