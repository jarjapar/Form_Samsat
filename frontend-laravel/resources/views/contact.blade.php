@extends('layouts.public')
@section('title','Contact — Samsat Mataram')

@section('content')
<main class="max-w-[1100px] mx-auto px-4 py-10">

  {{-- Banner logo bar --}}
  <div class="flex items-center justify-center gap-6 mb-6 opacity-95">
    <img src="{{ asset('images/logo1.png') }}" class="h-10" alt="">
    <img src="{{ asset('images/logo2.png') }}" class="h-10" alt="">
    <img src="{{ asset('images/logo3.png') }}" class="h-10" alt="">
  </div>
  <div class="flex items-center justify-center gap-4 mb-8">
    <img src="{{ asset('images/samsat.png') }}" class="h-12 md:h-14" alt="Samsat">
    <img src="{{ asset('images/247.png') }}" class="h-12 md:h-14" alt="24/7">
  </div>

  <h2 class="text-center text-xl md:text-2xl font-extrabold">CONTACT</h2>
  <div class="mx-auto mt-2 mb-10 h-[2px] w-24 bg-black/80"></div>

  <div class="grid md:grid-cols-2 gap-8 items-start">
    {{-- Peta Google Maps --}}
    <div class="rounded-lg overflow-hidden shadow-md">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.3734723149194!2d116.101086!3d-8.583231!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdbf1e8d9fd0ef%3A0x1234567890abcdef!2sSamsat%20Mataram!5e0!3m2!1sid!2sid!4v1234567890"
        width="100%"
        height="400"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    {{-- Info alamat & kontak --}}
    <div class="space-y-8">
      <div>
        <h3 class="text-lg font-bold text-center md:text-left">ALAMAT</h3>
        <div class="mx-auto mt-2 mb-4 h-[2px] w-20 bg-black/70"></div>
        <p class="text-sm leading-relaxed text-center md:text-left">
          Jalan Langko No. 28, Selaparang, Dasan Agung Baru,<br>
          Kec. Mataram, Kota Mataram, Nusa Tenggara Bar. 83112
        </p>
      </div>

      <div>
        <h3 class="text-lg font-bold text-center md:text-left">CONTACT</h3>
        <div class="mx-auto mt-2 mb-4 h-[2px] w-20 bg-black/70"></div>
        <ul class="text-sm space-y-2 text-center md:text-left">
          <li>+6202204912039120</li>
          <li>+6202204912039120</li>
          <li>+6202204912039120</li>
        </ul>
      </div>
    </div>
  </div>

</main>
@endsection
