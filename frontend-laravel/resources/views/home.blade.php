@extends('layouts.public')
@section('title','Beranda — Samsat Mataram')

@section('content')
<main class="min-h-screen">

  {{-- HERO --}}
  <section class="relative h-[320px] sm:h-[420px] lg:h-[520px]">
    <img src="{{ asset('images/hero.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="hero">
    <div class="absolute inset-0 bg-black/35"></div>

    <div class="relative max-w-screen-xl mx-auto h-full flex items-center px-4 sm:px-6 lg:px-8">
      <div class="bg-white/30 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-lg
                  p-4 sm:p-6 lg:p-10 max-w-[90%] sm:max-w-lg lg:max-w-xl">
        <h1 class="leading-tight text-white font-extrabold drop-shadow
                   text-3xl sm:text-4xl lg:text-[52px]">
          SAMSAT<br/>MATARAM
        </h1>
        <p class="mt-3 sm:mt-4 text-white/95 font-semibold drop-shadow
                  text-sm sm:text-base lg:text-lg">
          “KEPUASAN MASYARAKAT MERUPAKAN<br class="hidden sm:block"/>KEBANGGAAN PELAYANAN KAMI”
        </p>
      </div>
    </div>
  </section>

  {{-- MAKLUMAT --}}
  <section class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 items-center px-4 sm:px-6 lg:px-8 py-10 sm:py-12 lg:py-14">
    <div class="flex justify-center">
      <img src="{{ asset('images/247.png') }}" class="h-32 sm:h-40 lg:h-56 object-contain" alt="24/7">
    </div>
    <div class="text-center md:text-left">
      <h2 class="font-extrabold tracking-wide text-2xl sm:text-3xl lg:text-[30px]">MAKLUMAT PELAYANAN</h2>
      <p class="mt-3 sm:mt-4 leading-relaxed font-medium sm:font-semibold md:pr-6 text-[15px] sm:text-base">
        PELAYANAN CEPAT, TEPAT DAN MUDAH MEMBERIKAN PELAYANAN DENGAN
        SANTUN DAN RAMAH MENIADAKAN SEGALA BENTUK PUNGUTAN DI LUAR
        KETENTUAN PKBP
      </p>
    </div>
  </section>

  {{-- KONTAK + JAM --}}
  <section id="kontak" class="relative">
    <img src="{{ asset('images/hall.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="hall">
    <div class="absolute inset-0 bg-black/45"></div>

    <div class="relative max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 px-4 sm:px-6 lg:px-8 py-10 sm:py-12 lg:py-14 text-white">
      <div class="bg-black/35 rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-7 shadow-lg">
        <h3 class="text-2xl sm:text-3xl font-extrabold">CONTACT</h3>
        <p class="mt-3 sm:mt-4 leading-relaxed font-medium sm:font-semibold text-white/95 text-sm sm:text-base">
          Jalan Langko No. 28, Selaparang, Dasan Agung Baru, Kec. Mataram, Kota Mataram, Nusa Tenggara Bar. 83112
        </p>
        <ul class="mt-4 space-y-1 text-xs sm:text-sm opacity-95">
          <li>📍 jalan langko (83112)</li>
          <li>☎️ (0370) 631230</li>
          <li>📷 @samsat_mataram</li>
        </ul>
      </div>

      <div class="bg-white/25 backdrop-blur-md rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-7 shadow-lg">
        <h3 class="text-2xl sm:text-3xl font-extrabold">Jam pelayanan</h3>
        <ul class="mt-3 sm:mt-4 space-y-1.5 sm:space-y-2 font-semibold text-sm sm:text-base">
          <li class="flex justify-between"><span>Senin – Kamis</span><span>08.00 – 14.30</span></li>
          <li class="flex justify-between"><span>Jumat</span><span>08.00 – 11.00</span></li>
          <li class="flex justify-between"><span>Sabtu</span><span>08.00 – 14.30</span></li>
          <li class="flex justify-between"><span>Minggu</span><span>Tutup</span></li>
        </ul>
      </div>
    </div>
  </section>

  {{-- PELAYANAN --}}
  <section class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-14 lg:py-16">
    <h2 class="text-center font-extrabold tracking-wide mb-6 sm:mb-8 text-2xl sm:text-3xl lg:text-[32px]">PELAYANAN</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
      <div class="border rounded-xl p-4 sm:p-6 bg-white shadow">SAMSAT DRIVE THRU</div>
      <div class="border rounded-xl p-4 sm:p-6 bg-white shadow">PEMBAYARAN PAJAK</div>
      <div class="border rounded-xl p-4 sm:p-6 bg-white shadow">E–SAMSAT</div>
      <div class="border rounded-xl p-4 sm:p-6 bg-white shadow">CEK FISIK</div>
    </div>
  </section>

  {{-- VISI --}}
  <section class="bg-gray-800 text-white py-8 sm:py-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="font-extrabold tracking-wide mb-2 text-lg sm:text-xl lg:text-2xl">VISI</h2>
      <p class="font-semibold text-sm sm:text-base">
        TERWUJUDNYA PELAYANAN PRIMA SAMSAT MATARAM YANG PROFESIONAL BERBASIS TI (TEKNOLOGI INFORMASI)
      </p>
    </div>
  </section>

  {{-- MISI --}}
  <section class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 px-4 sm:px-6 lg:px-8 py-12 lg:py-14">
    @php $misi = [
      'Meningkatkan Kualitas Pelayanan SAMSAT yang berbasis TI',
      'Meningkatkan Mutu Registrasi dan Identifikasi Kendaraan Bermotor',
      'Meningkatkan Penerimaan PKB dan BBNKB',
      'Meningkatkan Penerimaan Negara dan Daerah untuk Perlindungan dan Kesejahteraan Masyarakat',
    ]; @endphp
    @foreach ($misi as $item)
      <div class="bg-white border rounded-xl p-4 sm:p-5 flex items-start gap-3 sm:gap-4 shadow">
        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gray-100 flex items-center justify-center">📈</div>
        <div class="font-medium sm:font-semibold text-sm sm:text-base">{{ $item }}</div>
      </div>
    @endforeach
  </section>

  {{-- BERITA --}}
  <section id="berita" class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-16">
    <h2 class="font-extrabold mb-4 text-xl sm:text-2xl">Berita Terbaru</h2>
    <p class="text-sm opacity-70">Nanti kita tarik dari API <code>/berita</code>.</p>
  </section>

</main>
@endsection
