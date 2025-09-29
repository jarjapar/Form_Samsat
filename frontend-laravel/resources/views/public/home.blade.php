@extends('layouts.public')

@section('content')
<main>

  {{-- HERO --}}
  <section class="relative h-[420px] md:h-[520px]">
    <img src="{{ asset('images/hero.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="hero">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative max-w-6xl mx-auto h-full flex items-center px-4">
      <div class="bg-white/30 backdrop-blur-md rounded-xl p-6 md:p-10 max-w-xl">
        <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight text-shadow">SAMSAT<br/>MATARAM</h1>
        <p class="mt-3 md:mt-4 text-white/90 font-semibold text-shadow">
          “KEPUASAN MASYARAKAT MERUPAKAN<br/>KEBANGGAAN PELAYANAN KAMI”
        </p>
      </div>
    </div>
  </section>

  {{-- 24/7 + MAKLUMAT --}}
  <section class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 items-center px-4 py-12">
    <div class="flex justify-center">
      <img src="{{ asset('images/247.png') }}" class="h-44 md:h-56" alt="24/7">
    </div>
    <div class="text-center md:text-left">
      <h2 class="text-2xl md:text-3xl font-extrabold">MAKLUMAT PELAYANAN</h2>
      <p class="mt-3 leading-relaxed">
        PELAYANAN CEPAT, TEPAT DAN MUDAH MEMBERIKAN PELAYANAN DENGAN
        SANTUN DAN RAMAH MENIADAKAN SEGALA BENTUK PUNGUTAN DI LUAR
        KETENTUAN PKBP
      </p>
    </div>
  </section>

  {{-- KONTAK + JAM (overlay gambar) --}}
  <section id="kontak" class="relative">
    <img src="{{ asset('images/hall.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="hall">
    <div class="absolute inset-0 bg-black/45"></div>
    <div class="relative max-w-6xl mx-auto grid md:grid-cols-2 gap-6 px-4 py-14 text-white">
      <div class="bg-black/30 rounded-xl p-6">
        <h3 class="text-2xl font-extrabold">CONTACT</h3>
        <p class="mt-3 leading-relaxed">
          Jalan Langko No. 28, Selaparang, Dasan Agung Baru,
          Kec. Mataram, Kota Mataram, Nusa Tenggara Bar. 83112
        </p>
        <ul class="mt-3 space-y-1 text-sm opacity-90">
          <li>📍 jalan langko (83112)</li>
          <li>☎️ (0370) 631230</li>
          <li>📷 @samsat_mataram</li>
        </ul>
      </div>
      <div class="bg-white/25 backdrop-blur-md rounded-xl p-6">
        <h3 class="text-2xl font-extrabold">Jam pelayanan</h3>
        <ul class="mt-3 space-y-2">
          <li class="flex justify-between"><span>Senin – Kamis</span><b>08.00 – 14.30</b></li>
          <li class="flex justify-between"><span>Jumat</span><b>08.00 – 11.00</b></li>
          <li class="flex justify-between"><span>Sabtu</span><b>08.00 – 14.30</b></li>
          <li class="flex justify-between"><span>Minggu</span><b>Tutup</b></li>
        </ul>
      </div>
    </div>
  </section>

  {{-- PELAYANAN (slider simple) --}}
  <section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="text-center text-2xl md:text-3xl font-extrabold mb-6">PELAYANAN</h2>

    <div x-data="{i:0,c:[
      {t:'SAMSAT DRIVE THRU',d:'Layanan cepat tanpa turun kendaraan.'},
      {t:'PEMBAYARAN PAJAK',d:'Pembayaran PKB & layanan pajak kendaraan.'},
      {t:'E–SAMSAT',d:'Pembayaran online melalui kanal resmi.'},
      {t:'CEK FISIK',d:'Informasi & alur cek fisik kendaraan.'}
    ]}" class="relative">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <template x-for="(card,idx) in c.slice(i, i+3)" :key="idx">
          <div class="border rounded-xl p-5 shadow-sm bg-white">
            <div class="font-bold mb-2" x-text="card.t"></div>
            <p class="text-sm opacity-80" x-text="card.d"></p>
          </div>
        </template>
      </div>
      <button @click="i = Math.max(0,i-1)" class="absolute -left-3 top-1/2 -translate-y-1/2 bg-white border rounded-full w-9 h-9">‹</button>
      <button @click="i = Math.min(c.length-3, i+1)" class="absolute -right-3 top-1/2 -translate-y-1/2 bg-white border rounded-full w-9 h-9">›</button>
    </div>

    <div class="text-center mt-5">
      <a href="#" class="border rounded-full px-5 py-2 hover:bg-gray-50">Lihat Semua</a>
    </div>
  </section>

  {{-- VISI --}}
  <section class="bg-gray-800 text-white py-10">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-xl md:text-2xl font-extrabold mb-2">VISI</h2>
      <p class="font-semibold">
        TERWUJUDNYA PELAYANAN PRIMA SAMSAT MATARAM YANG PROFESIONAL BERBASIS TI (TEKNOLOGI INFORMASI)
      </p>
    </div>
  </section>

  {{-- MISI (4 kartu) --}}
  <section class="max-w-6xl mx-auto grid md:grid-cols-2 gap-5 px-4 py-12" id="sop">
    @php $misi = [
      'Meningkatkan Kualitas Pelayanan SAMSAT yang berbasis TI (Teknik Informasi)',
      'Meningkatkan Mutu Registrasi dan Identifikasi Kendaraan Bermotor',
      'Meningkatkan Penerimaan PKB dan BBNKB',
      'Meningkatkan Penerimaan Negara dan Daerah untuk Perlindungan dan Kesejahteraan Masyarakat',
    ]; @endphp
    @foreach ($misi as $item)
      <div class="bg-white border rounded-2xl shadow-md p-5 flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">📈</div>
        <div class="font-semibold">{{ $item }}</div>
      </div>
    @endforeach
  </section>

  {{-- BERITA (opsional, nanti dari API) --}}
  <section id="berita" class="max-w-6xl mx-auto px-4 pb-16">
    <h2 class="text-2xl font-extrabold mb-4">Berita Terbaru</h2>
    <p class="text-sm opacity-70">Integrasi ke API /berita bisa ditambahkan berikutnya.</p>
  </section>

</main>
@endsection
