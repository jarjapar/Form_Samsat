@extends('admin.layout')
@section('title','Berita — Admin')

@section('content')
@php($list = $list ?? [])
@php($q = $q ?? '')

<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-extrabold">Berita</h1>
  <a href="{{ route('admin.berita.create') }}" class="bg-[#0b5ea8] text-white px-4 py-2 rounded-full hover:opacity-90">+ Tambah</a>
</div>

<form method="GET" class="mb-4">
  <input name="q" value="{{ $q }}" placeholder="Cari judul…" class="w-full sm:max-w-sm px-3 py-2 rounded-md border">
</form>

<div class="bg-white rounded-2xl shadow overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr class="text-left">
        <th class="px-4 py-3">Judul</th>
        <th class="px-4 py-3 w-40">Tanggal</th>
        <th class="px-4 py-3 w-40">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($list as $row)
        <tr class="border-t">
          <td class="px-4 py-3 font-semibold">{{ $row['judul'] ?? '-' }}</td>
          <td class="px-4 py-3">{{ $row['tanggal_post'] ?? '-' }}</td>
          <td class="px-4 py-3">
            <a href="{{ route('admin.berita.edit', $row['id']) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('admin.berita.destroy', $row['id']) }}" method="POST" class="inline"
                  onsubmit="return confirm('Hapus berita ini?')">
              @csrf @method('DELETE')
              <button class="ml-2 text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td class="px-4 py-6 text-center text-gray-500" colspan="3">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
