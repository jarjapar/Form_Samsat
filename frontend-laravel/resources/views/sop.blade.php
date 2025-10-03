@extends('layouts.public')
@section('title','SOP / Video — Samsat Mataram')

@section('content')
<main class="max-w-[1100px] mx-auto px-4 py-10">

  {{-- Banner logo bar (opsional, sesuaikan asetmu) --}}
  <div class="flex items-center justify-center gap-6 mb-6 opacity-95">
    <img src="{{ asset('images/logo1.png') }}" class="h-10" alt="">
    <img src="{{ asset('images/logo2.png') }}" class="h-10" alt="">
    <img src="{{ asset('images/logo3.png') }}" class="h-10" alt="">
  </div>
  <div class="flex items-center justify-center gap-4 mb-8">
    <img src="{{ asset('images/samsat.png') }}" class="h-12 md:h-14" alt="Samsat">
    <img src="{{ asset('images/247.png') }}" class="h-12 md:h-14" alt="24/7">
  </div>

  @php
    // ====== DATA VIDEO ======
    // Letakkan file video di /public/videos dan poster di /public/images/posters
    // Ganti dengan sumber sebenarnya (MP4/WEBM/YouTube embed).
    $sections = [
      [
        'title' => 'VIDEO SOP PEMBAYARAN PAJAK SATU TAHUNAN',
        'videos' => [
          ['src'=>asset('videos/video1.mp4'), 'poster'=>asset('images/posters/poster1.jpg'), 'duration'=>'1:56:30'],
        ],
      ],
      [
        'title' => 'BERITA',
        'videos' => [
          ['src'=>asset('videos/video2.mp4'), 'poster'=>asset('images/posters/poster2.jpg'), 'duration'=>'1:56:30'],
        ],
      ],
      [
        'title' => 'BERITA',
        'videos' => [
          ['src'=>asset('videos/video3.mp4'), 'poster'=>asset('images/posters/poster3.jpg'), 'duration'=>'1:56:30'],
        ],
      ],
    ];
  @endphp

  @foreach ($sections as $sec)
    {{-- Judul section --}}
    <section class="mb-10">
      <h2 class="text-center text-xl md:text-2xl font-extrabold">{{ $sec['title'] }}</h2>
      <div class="mx-auto mt-2 mb-6 h-[2px] w-24 bg-black/80"></div>

      {{-- Satu video per section (sesuai desain) --}}
      @foreach ($sec['videos'] as $v)
        <div class="w-full rounded-xl overflow-hidden shadow-lg bg-black/5">
          {{-- HTML5 video responsif: 16:9 --}}
          <div class="aspect-video bg-black">
            <video
              class="w-full h-full"
              controls
              preload="metadata"
              @if(!empty($v['poster'])) poster="{{ $v['poster'] }}" @endif
            >
              <source src="{{ $v['src'] }}" type="video/mp4">
              Browser Anda tidak mendukung pemutar video HTML5.
            </video>
          </div>
        </div>
      @endforeach
    </section>
  @endforeach

</main>
@endsection
