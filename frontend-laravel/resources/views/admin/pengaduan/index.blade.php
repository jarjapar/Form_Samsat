@extends('admin.layout')
@section('title','Pengaduan')

@section('content')
@php($list = $list ?? [])

<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-extrabold">Data Pengaduan</h1>
  <a href="{{ route('admin.pengaduan.export') }}" class="px-4 py-2 rounded-full bg-white border hover:bg-gray-50">Export CSV</a>
</div>

<div class="bg-white rounded-2xl shadow overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="p-3 text-left">Nama</th>
        <th class="p-3 text-left">Saran / Catatan</th>
        <th class="p-3 text-center">Gender</th>
        <th class="p-3 text-center">No HP</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($list as $r)
        <tr class="border-t">
          <td class="p-3">{{ $r['nama'] ?? '-' }}</td>
          <td class="p-3">{{ $r['alamat'] ?? '-' }}</td>
          <td class="p-3 text-center">{{ $r['jenis_kelamin'] ?? '-' }}</td>
          <td class="p-3 text-center">{{ $r['no_hp'] ?? '-' }}</td>
        </tr>
      @empty
        <tr>
          <td class="p-5 text-center text-gray-500" colspan="4">Belum ada data.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
