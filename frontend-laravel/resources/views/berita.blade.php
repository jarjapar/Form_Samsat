@extends('layouts.public')
@section('title','Berita — Samsat Mataram')

@section('content')
<main class="max-w-[1100px] mx-auto px-4 py-12">

  {{-- Banner Logo --}}
  <div class="flex flex-col items-center mb-10">
    <img src="{{ asset('images/banner.png') }}" alt="banner" class="h-16 md:h-20">
  </div>

  {{-- Section Builder --}}
  @php
    $sections = [
      'BERITA' => [
        ['title'=>'SAMSAT DRIVE THRU','desc'=>'Tenun reg alam timbul dari Pringgasela ...'],
        ['title'=>'PEMBAYARAN PAJAK','desc'=>'Tenun bebok celet dari Pringgasela ...'],
        ['title'=>'E–SAMSAT','desc'=>'Tenun pucuk rebung dari Pringgasela ...'],
      ],
      'PELAYANAN' => [
        ['title'=>'SAMSAT DRIVE THRU','desc'=>'Tenun reg alam timbul dari Pringgasela ...'],
        ['title'=>'PEMBAYARAN PAJAK','desc'=>'Tenun bebok celet dari Pringgasela ...'],
        ['title'=>'E–SAMSAT','desc'=>'Tenun pucuk rebung dari Pringgasela ...'],
      ],
      'ARTIKEL' => [
        ['title'=>'SAMSAT DRIVE THRU','desc'=>'Tenun reg alam timbul dari Pringgasela ...'],
        ['title'=>'PEMBAYARAN PAJAK','desc'=>'Tenun bebok celet dari Pringgasela ...'],
        ['title'=>'E–SAMSAT','desc'=>'Tenun pucuk rebung dari Pringgasela ...'],
      ],
    ];
  @endphp

  @foreach ($sections as $title => $cards)
    <section class="mb-16">
      <h2 class="text-center text-xl md:text-2xl font-extrabold tracking-wide mb-1">{{ $title }}</h2>
      <div class="h-[2px] w-16 bg-black mx-auto mb-8"></div>

      <div class="relative">
        {{-- Dummy Slider Button --}}
        <button class="absolute -left-6 top-1/2 -translate-y-1/2 text-2xl">‹</button>
        <button class="absolute -right-6 top-1/2 -translate-y-1/2 text-2xl">›</button>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($cards as $c)
            <div class="border rounded-2xl p-6 shadow-sm bg-white text-center">
              <h3 class="font-bold mb-2 uppercase">{{ $c['title'] }}</h3>
              <p class="text-sm opacity-80">{{ $c['desc'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endforeach

</main>
@endsection
