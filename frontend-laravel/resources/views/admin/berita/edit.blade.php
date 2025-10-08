@extends('admin.layout')
@section('title','Edit Berita — Admin')

@section('content')
  <h1 class="text-2xl font-extrabold mb-4">Edit Berita</h1>

  <form action="{{ route('admin.berita.update', $row['id']) }}" method="POST"
        class="bg-white rounded-2xl shadow p-5 space-y-4">
    @csrf @method('PUT')
    <div>
      <label class="block text-sm mb-1">Judul</label>
      <input name="judul" class="w-full px-3 py-2 rounded-md border" value="{{ $row['judul'] ?? '' }}" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Tanggal</label>
      <input type="date" name="tanggal_post" class="px-3 py-2 rounded-md border" value="{{ $row['tanggal_post'] ?? '' }}" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Isi</label>
      <textarea name="isi" rows="6" class="w-full px-3 py-2 rounded-md border" required>{{ $row['isi'] ?? '' }}</textarea>
    </div>
    <div class="pt-2">
      <button class="bg-[#0b5ea8] text-white px-4 py-2 rounded-full">Update</button>
      <a href="{{ route('admin.berita.index') }}" class="ml-2 px-4 py-2 rounded-full bg-gray-100">Kembali</a>
    </div>
  </form>

  <div class="bg-white rounded-2xl shadow p-5 mt-6">
    <h2 class="font-bold mb-3">Ganti Gambar</h2>
    <form action="{{ route('admin.berita.updateImage', $row['id']) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
      @csrf
      <input type="file" name="gambar" accept="image/*" required>
      <button class="bg-[#0b5ea8] text-white px-4 py-2 rounded-full">Upload</button>
    </form>
  </div>
@endsection
