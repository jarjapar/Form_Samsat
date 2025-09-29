@extends('layouts.public')
@section('title','Beranda — Samsat Mataram')

@section('content')
<main>

  {{-- HERO --}}
  <section class="relative h-[440px] md:h-[520px]">
    <img src="{{ asset('images/hero.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="hero">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative max-w-[1100px] mx-auto h-full flex items-center px-4">
      <div class="bg-white/35 backdrop-blur-md rounded-[22px] p-6 md:p-10 max-w-xl shadow-lg">
        <h1 class="text-[36px] md:text-[52px] font-extrabold text-white leading-tight drop-shadow">
          SAMSAT<br/>MATARAM
        </h1>
        <p class="mt-4 text-white font-semibold drop-shadow text-[14px] md:text-[16px]">
          “KEPUASAN MASYARAKAT MERUPAKAN<br/>KEBANGGAAN PELAYANAN KAMI”
        </p>
      </div>
    </div>
  </section>

  {{-- 24/7 + MAKLUMAT --}}
  <section class="max-w-[1100px] mx-auto grid md:grid-cols-2 gap-10 items-center px-4 py-14">
    <div class="flex justify-center">
      <img src="{{ asset('images/247.png') }}" class="h-48 md:h-56" alt="24/7">
    </div>
    <div class="text-center md:text-left">
      <h2 class="text-[26px] md:text-[30px] font-extrabold tracking-wide">MAKLUMAT PELAYANAN</h2>
      <p class="mt-3 leading-relaxed font-semibold md:pr-6">
        PELAYANAN CEPAT, TEPAT DAN MUDAH MEMBERIKAN PELAYANAN DENGAN
        SANTUN DAN RAMAH MENIADAKAN SEGALA BENTUK PUNGUTAN DI LUAR
        KETENTUAN PKBP
      </p>
    </div>
  </section>

  {{-- KONTAK + JAM (overlay) --}}
  <section id="kontak" class="relative">
    <img src="{{ asset('images/hall.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="hall">
    <div class="absolute inset-0 bg-black/45"></div>
    <div class="relative max-w-[1100px] mx-auto grid md:grid-cols-2 gap-6 px-4 py-14 text-white">
      <div class="bg-black/35 rounded-2xl p-7 shadow-lg">
        <h3 class="text-3xl font-extrabold">CONTACT</h3>
        <p class="mt-4 leading-relaxed font-semibold text-white/95">
          Jalan Langko No. 28, Selaparang, Dasan Agung Baru, Kec. Mataram, Kota Mataram,
          Nusa Tenggara Bar. 83112
        </p>
        <ul class="mt-4 space-y-1 text-sm opacity-95">
          <li>📍 jalan langko (83112)</li>
          <li>☎️ (0370) 631230</li>
          <li>📷 @samsat_mataram</li>
        </ul>
      </div>
      <div class="bg-white/25 backdrop-blur-md rounded-2xl p-7 shadow-lg">
        <h3 class="text-3xl font-extrabold">Jam pelayanan</h3>
        <ul class="mt-4 space-y-2 font-semibold">
          <li class="flex justify-between"><span>Senin – Kamis</span><span>08.00 – 14.30</span></li>
          <li class="flex justify-between"><span>Jumat</span><span>08.00 – 11.00</span></li>
          <li class="flex justify-between"><span>Sabtu</span><span>08.00 – 14.30</span></li>
          <li class="flex justify-between"><span>Minggu</span><span>Tutup</span></li>
        </ul>
      </div>
    </div>
  </section>

  {{-- PELAYANAN (slider sederhana) --}}
  <section class="max-w-[1100px] mx-auto px-4 py-16">
    <h2 class="text-center text-[28px] md:text-[32px] font-extrabold mb-8 tracking-wide">PELAYANAN</h2>

    <div x-data="{i:0,c:[
      {t:'SAMSAT DRIVE THRU',d:'Layanan cepat tanpa turun kendaraan.'},
      {t:'PEMBAYARAN PAJAK',d:'Pembayaran PKB & layanan pajak kendaraan.'},
      {t:'E–SAMSAT',d:'Pembayaran online melalui kanal resmi.'},
      {t:'CEK FISIK',d:'Informasi & alur cek fisik kendaraan.'}
    ]}" class="relative">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <template x-for="(card,idx) in c.slice(i, i+3)" :key="idx">
          <div class="border rounded-2xl p-6 shadow-sm bg-white min-h-[180px]">
            <div class="font-bold mb-2" x-text="card.t"></div>
            <p class="text-sm opacity-80" x-text="card.d"></p>
          </div>
        </template>
      </div>
      <button @click="i = Math.max(0,i-1)"
        class="absolute -left-4 top-1/2 -translate-y-1/2 bg-white border rounded-full w-9 h-9 shadow">‹</button>
      <button @click="i = Math.min(c.length-3, i+1)"
        class="absolute -right-4 top-1/2 -translate-y-1/2 bg-white border rounded-full w-9 h-9 shadow">›</button>
    </div>

    <div class="text-center mt-6">
      <a href="#" class="inline-block border rounded-full px-5 py-2 hover:bg-gray-50 font-medium">
        Lihat Semua
      </a>
    </div>
  </section>

  {{-- VISI pita abu --}}
  <section class="bg-gray-800 text-white py-10">
    <div class="max-w-[1100px] mx-auto px-4 text-center">
      <h2 class="text-xl md:text-2xl font-extrabold mb-2 tracking-wide">VISI</h2>
      <p class="font-semibold">
        TERWUJUDNYA PELAYANAN PRIMA SAMSAT MATARAM YANG PROFESIONAL BERBASIS
        TI (TEKNOLOGI INFORMASI)
      </p>
    </div>
  </section>

  {{-- MISI (4 kartu) --}}
  <section class="max-w-[1100px] mx-auto grid md:grid-cols-2 gap-6 px-4 py-14">
    @php $misi = [
      'Meningkatkan Kualitas Pelayanan SAMSAT yang berbasis TI (Teknologi Informasi)',
      'Meningkatkan Mutu Registrasi dan Identifikasi Kendaraan Bermotor',
      'Meningkatkan Penerimaan PKB dan BBNKB',
      'Meningkatkan Penerimaan Negara dan Daerah untuk Perlindungan dan Kesejahteraan Masyarakat',
    ]; @endphp
    @foreach ($misi as $item)
      <div class="bg-white border rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.15)] p-5 flex items-start gap-4">
        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-xl">📈</div>
        <div class="font-semibold">{{ $item }}</div>
      </div>
    @endforeach
  </section>

  {{-- BERITA placeholder --}}
  <section id="berita" class="max-w-[1100px] mx-auto px-4 pb-16">
    <h2 class="text-2xl font-extrabold mb-4">Berita Terbaru</h2>
    <p class="text-sm opacity-70">Nanti kita tarik dari API <code>/berita</code>.</p>
  </section>

</main>
@endsection
