@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<h1 class="text-xl font-bold mb-4">Dashboard</h1>
<div class="grid sm:grid-cols-3 gap-4">
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm opacity-70">Pengaduan</div>
    <div class="text-2xl font-bold">{{ $stats['pengunjung'] ?? 0 }}</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm opacity-70">Berita</div>
    <div class="text-2xl font-bold">{{ $stats['berita'] ?? 0 }}</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm opacity-70">Akun Samsat</div>
    <div class="text-2xl font-bold">{{ $stats['samsat'] ?? 0 }}</div>
  </div>
</div>
@endsection
    