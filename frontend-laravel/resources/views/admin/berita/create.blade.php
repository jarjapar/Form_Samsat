@extends('admin.layout')
@section('title','Tambah Berita')
@section('content')
<h1 class="text-xl font-bold mb-4">Tambah Berita</h1>

<form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
  @csrf
  <div>
    <label class="block text-sm font-semibold">Judul</label>
    <input name="judul" value="{{ old('judul') }}" class="border rounded w-full px-3 py-2" required>
  </div>
  <div>
    <label class="block text-sm font-semibold">Isi</label>
    <textarea name="isi" rows="6" class="border rounded w-full px-3 py-2" required>{{ old('isi') }}</textarea>
  </div>
  <div class="grid sm:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-semibold">Tanggal Post</label>
      <input type="date" name="tanggal_post" value="{{ old('tanggal_post', date('Y-m-d')) }}" class="border rounded w-full px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-semibold">Gambar</label>
      <input type="file" name="gambar" accept="image/*" class="border rounded w-full px-3 py-2" required>
    </div>
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-[#0b5ea8] text-white">Simpan</button>
    <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 rounded border">Batal</a>
  </div>
</form>
@endsection
