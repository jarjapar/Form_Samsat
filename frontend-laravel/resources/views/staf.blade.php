@extends('layouts.public')
@section('title','Staf — Samsat Mataram')

@section('content')
<main class="pb-16">

  {{-- baris logo (opsional) --}}
  <section class="max-w-[1100px] mx-auto px-4 py-6">
    <div class="flex flex-wrap items-center justify-center gap-6 opacity-90">
      <img src="{{ asset('images/logo1.png') }}" class="h-10" alt="logo1">
      <img src="{{ asset('images/logo2.png') }}" class="h-10" alt="logo2">
      <img src="{{ asset('images/logo3.png') }}" class="h-10" alt="logo3">
      <img src="{{ asset('images/247.png') }}" class="h-10" alt="24/7">
    </div>
  </section>

  {{-- judul --}}
  <section class="max-w-[1100px] mx-auto px-4">
    <h1 class="text-center text-2xl md:text-[28px] font-extrabold tracking-wide">
      TENAGA  KERJA DAN STAFF
    </h1>
    <div class="mx-auto mt-2 h-[3px] w-20 bg-gray-800/70"></div>
  </section>

  {{-- grid staf --}}
  @php
    // sementara dummy data; nanti bisa diganti dari API
    $staf = [
      ['nama'=>'bapak','jabatan'=>'—','foto'=>null,'bio'=>'Tenun regol alam timbul dari Pringgasela dikenal dengan motif yang mengalir dan bertekstur. Kain ini menggambarkan kearifan lokal dan kekayaan budaya Lombok.'],
      ['nama'=>'bapak','jabatan'=>'—','foto'=>null,'bio'=>'Tenun regol alam timbul dari Pringgasela dikenal dengan motif yang mengalir dan bertekstur. Kain ini menggambarkan kearifan lokal dan kekayaan budaya Lombok.'],
      ['nama'=>'bapak','jabatan'=>'—','foto'=>null,'bio'=>'Tenun regol alam timbul dari Pringgasela dikenal dengan motif yang mengalir dan bertekstur. Kain ini menggambarkan kearifan lokal dan kekayaan budaya Lombok.'],
      ['nama'=>'ibu','jabatan'=>'—','foto'=>null,'bio'=>'Tenun regol alam timbul dari Pringgasela dikenal dengan motif yang mengalir dan bertekstur. Kain ini menggambarkan kearifan lokal dan kekayaan budaya Lombok.'],
      // tambah sesuai kebutuhan …
    ];
  @endphp

  <section class="max-w-[1100px] mx-auto px-4 mt-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

      @foreach ($staf as $s)
        <article class="rounded-2xl border bg-white shadow-sm hover:shadow-md transition">
          <div class="aspect-[4/5] rounded-t-2xl bg-gray-200"></div>
          {{-- kalau nanti ada foto:
              <img src="{{ asset('uploads/staf/'.$s['foto']) }}" class="w-full aspect-[4/5] object-cover rounded-t-2xl" alt="{{ $s['nama'] }}">
          --}}
          <div class="p-4">
            <div class="font-extrabold capitalize">{{ $s['nama'] }}</div>
            @if(!empty($s['jabatan']))
              <div class="text-xs opacity-70 -mt-0.5 mb-1">{{ $s['jabatan'] }}</div>
            @endif
            <p class="text-[12px] leading-relaxed opacity-80">
              {!! $s['bio'] !!}
            </p>
          </div>
        </article>
      @endforeach

    </div>
  </section>

</main>
@endsection
