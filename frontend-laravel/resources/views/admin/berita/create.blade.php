@extends('admin.layout')
@section('title','Tambah Berita — Admin')

@section('content')
  <h1 class="text-2xl font-extrabold mb-4">Tambah Berita</h1>

  <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow p-5 space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Judul</label>
      <input name="judul" class="w-full px-3 py-2 rounded-md border" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Tanggal</label>
      <input type="date" name="tanggal_post" class="px-3 py-2 rounded-md border" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Isi</label>
      <textarea name="isi" rows="6" class="w-full px-3 py-2 rounded-md border" required></textarea>
    </div>
    <div>
      <label class="block text-sm mb-1">Gambar</label>
      <input type="file" name="gambar" accept="image/*" class="block" required>
    </div>
    <div class="pt-2">
      <button class="bg-[#0b5ea8] text-white px-4 py-2 rounded-full">Simpan</button>
      <a href="{{ route('admin.berita.index') }}" class="ml-2 px-4 py-2 rounded-full bg-gray-100">Batal</a>
    </div>
  </form>
@endsection
