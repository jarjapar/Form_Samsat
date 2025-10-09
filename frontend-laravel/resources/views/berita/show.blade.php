@extends('layouts.public')
@section('title', $row['judul'])

@section('content')
<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <a href="{{ route('berita.index') }}" class="text-blue-600 hover:underline">← Kembali</a>

  <h1 class="text-3xl font-bold mt-2">{{ $row['judul'] }}</h1>
  <p class="text-sm text-gray-500 mt-1">
    {{ \Carbon\Carbon::parse($row['tanggal_post'])->translatedFormat('j F Y') }}
  </p>

  @if(!empty($row['image_url']))
    <img src="{{ $row['image_url'] }}" alt="{{ $row['judul'] }}" class="mt-4 rounded-xl w-full object-cover">
  @endif

  <article class="prose max-w-none mt-6">
    {!! nl2br(e($row['isi'])) !!}
  </article>

  @if($lainnya->count())
    <hr class="my-10">
    <h2 class="font-semibold mb-3">Berita lainnya</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      @foreach($lainnya as $x)
        <a href="{{ route('berita.show', $x['slug'] ?? $x['id']) }}" class="rounded-xl border hover:shadow-sm transition overflow-hidden">
          <img src="{{ $x['image_url'] }}" class="w-full aspect-[16/9] object-cover">
          <div class="p-3 text-sm"><p class="font-medium line-clamp-2">{{ $x['judul'] }}</p></div>
        </a>
      @endforeach
    </div>
  @endif
</main>
@endsection
