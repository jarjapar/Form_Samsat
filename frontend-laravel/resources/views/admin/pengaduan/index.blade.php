@extends('admin.layout')
@section('title','Pengaduan')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-bold">Data Pengaduan</h1>
  <a href="{{ route('admin.pengaduan.export') }}" class="px-3 py-2 rounded border">Export CSV</a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 text-left">Nama</th>
        <th class="p-2 text-left">Alamat</th>
        <th class="p-2">Gender</th>
        <th class="p-2">No HP</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($list as $r)
        <tr class="border-t">
          <td class="p-2">{{ $r['nama'] }}</td>
          <td class="p-2">{{ $r['alamat'] }}</td>
          <td class="p-2 text-center">{{ $r['jenis_kelamin'] }}</td>
          <td class="p-2 text-center">{{ $r['no_hp'] }}</td>
        </tr>
      @empty
        <tr><td class="p-3 text-center opacity-60" colspan="4">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
