@extends('admin.layout')
@section('title','Dashboard — Admin')

@section('content')
  <h1 class="text-2xl font-extrabold mb-6">Dashboard</h1>

  <div class="grid sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl shadow p-5">
      <div class="text-sm opacity-70">Pengunjung</div>
      <div class="text-3xl font-extrabold">{{ $stats['pengunjung'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
      <div class="text-sm opacity-70">Berita</div>
      <div class="text-3xl font-extrabold">{{ $stats['berita'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
      <div class="text-sm opacity-70">E-Samsat</div>
      <div class="text-3xl font-extrabold">{{ $stats['samsat'] ?? 0 }}</div>
    </div>
  </div>
@endsection
