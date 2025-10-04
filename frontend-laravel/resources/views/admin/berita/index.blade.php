@extends('admin.layout')
@section('title','Berita')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-bold">Berita</h1>
  <a href="{{ route('admin.berita.create') }}" class="px-3 py-2 rounded bg-[#0b5ea8] text-white">+ Tambah</a>
</div>

<form class="mb-4">
  <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul/isi..."
         class="border rounded px-3 py-2 w-64">
  <button class="ml-2 px-3 py-2 rounded border">Cari</button>
</form>

<div class="bg-white rounded shadow overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="bg-gray-100">
      <tr><th class="p-2 text-left">Judul</th><th class="p-2">Tanggal</th><th class="p-2">Gambar</th><th class="p-2">Aksi</th></tr>
    </thead>
    <tbody>
      @forelse ($list as $r)
        <tr class="border-t">
          <td class="p-2">{{ $r['judul'] }}</td>
          <td class="p-2 text-center">{{ $r['tanggal_post'] }}</td>
          <td class="p-2 text-center">
            @if(!empty($r['gambar']))
              <img src="{{ $r['gambar_url'] ?? '' }}" class="h-10 inline-block rounded" alt="">
            @endif
          </td>
          <td class="p-2 text-center">
            <a href="{{ route('admin.berita.edit',$r['id']) }}" class="px-2 py-1 border rounded">Edit</a>
            <form action="{{ route('admin.berita.destroy',$r['id']) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini?')">
              @csrf @method('DELETE')
              <button class="px-2 py-1 border rounded text-red-600">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td class="p-3 text-center opacity-60" colspan="4">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
