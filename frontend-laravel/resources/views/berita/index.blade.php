@extends('layouts.public')
@section('title','Berita')

@section('content')
<main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <h1 class="text-2xl font-bold mb-6">Berita</h1>

  <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($list as $b)
      <a href="{{ route('berita.show', $b['slug'] ?? $b['id']) }}" class="block rounded-2xl border shadow hover:shadow-md transition overflow-hidden">
        <div class="w-full aspect-[16/9] bg-gray-100">
          <img src="{{ $b['image_url'] }}" alt="{{ $b['judul'] }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-lg line-clamp-2">{{ $b['judul'] }}</h3>
          <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($b['tanggal_post'])->translatedFormat('j F Y') }}</p>
          <p class="mt-2 text-sm text-gray-700 line-clamp-3">{{ $b['excerpt'] }}</p>
        </div>
      </a>
    @endforeach
  </section>
</main>
@endsection
