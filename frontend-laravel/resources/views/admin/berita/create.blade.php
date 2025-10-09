@extends('layouts.admin')
@section('title','Tambah Berita')

@section('content')
<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <h1 class="text-2xl font-bold mb-6">Tambah Berita</h1>

  {{-- tampilkan error validasi --}}
  @if ($errors->any())
    <div class="mb-4 rounded bg-red-100 text-red-800 px-3 py-2">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div>
      <label class="block font-semibold">Judul</label>
      <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border rounded px-3 py-2" required>
      @error('judul') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block font-semibold">Tanggal</label>
      <input type="date" name="tanggal_post" value="{{ old('tanggal_post', now()->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2">
      @error('tanggal_post') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block font-semibold">Isi</label>
      <textarea name="isi" rows="6" class="w-full border rounded px-3 py-2" required>{{ old('isi') }}</textarea>
      @error('isi') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div x-data="{ preview: null }">
      <label class="block font-semibold">Gambar</label>
      <input type="file" name="gambar" accept="image/*" @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
      <template x-if="preview"><img :src="preview" class="mt-2 w-64 rounded-xl shadow"></template>
      @error('gambar') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="flex gap-3">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
      <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
    </div>
  </form>
</main>
@endsection
