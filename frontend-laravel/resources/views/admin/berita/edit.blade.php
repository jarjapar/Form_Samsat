@extends('admin.layout')
@section('title','Edit Berita')
@section('content')
<h1 class="text-xl font-bold mb-4">Edit Berita</h1>

<form method="POST" action="{{ route('admin.berita.update',$row['id']) }}" class="space-y-4 bg-white p-4 rounded shadow">
  @csrf @method('PUT')
  <div>
    <label class="block text-sm font-semibold">Judul</label>
    <input name="judul" value="{{ old('judul',$row['judul']) }}" class="border rounded w-full px-3 py-2" required>
  </div>
  <div>
    <label class="block text-sm font-semibold">Isi</label>
    <textarea name="isi" rows="6" class="border rounded w-full px-3 py-2" required>{{ old('isi',$row['isi']) }}</textarea>
  </div>
  <div class="grid sm:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-semibold">Tanggal Post</label>
      <input type="date" name="tanggal_post" value="{{ old('tanggal_post',$row['tanggal_post']) }}" class="border rounded w-full px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-semibold">Gambar Saat Ini</label>
      @if(!empty($row['gambar_url']))
        <img src="{{ $row['gambar_url'] }}" class="h-20 rounded border">
      @endif
    </div>
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-[#0b5ea8] text-white">Simpan Perubahan</button>
    <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 rounded border">Kembali</a>
  </div>
</form>

<form method="POST" action="{{ route('admin.berita.updateImage',$row['id']) }}" enctype="multipart/form-data" class="mt-6 bg-white p-4 rounded shadow">
  @csrf
  <label class="block text-sm font-semibold mb-1">Ganti Gambar</label>
  <input type="file" name="gambar" accept="image/*" class="border rounded w-full px-3 py-2" required>
  <button class="mt-3 px-4 py-2 rounded border">Upload Gambar Baru</button>
</form>
@endsection
