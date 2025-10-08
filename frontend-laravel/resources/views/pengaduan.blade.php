@extends('layouts.public')
@section('title','Pengaduan — Samsat Mataram')

@section('content')
<main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10"
      x-data="pengaduanPage('{{ env('API_BASE') }}')"
      x-init="loadLatest()">

  {{-- Logo bar (opsional, bisa ganti asetnya) --}}
  <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 mb-6">
    <img src="{{ asset('images/logo.png') }}" class="h-10" alt="logo">
    <img src="{{ asset('images/hero.jpg') }}" class="h-10 rounded hidden sm:block" alt="dummy">
    <img src="{{ asset('images/247.png') }}" class="h-10" alt="247">
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- FORM PANEL (span 2 kolom di desktop) --}}
    <section class="lg:col-span-2 bg-[#2f2f2f] text-white rounded-2xl p-4 sm:p-6 lg:p-7 shadow">
      <h1 class="text-xl sm:text-2xl font-extrabold mb-4">Form Pengaduan</h1>

      <form @submit.prevent="submit" class="space-y-4">
        {{-- baris 2 kolom --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1">Nama</label>
            <input x-model="form.nama" type="text" required
                   class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Nama lengkap" />
          </div>
          <div>
            <label class="block text-sm mb-1">No telp</label>
            <input x-model="form.no_hp" type="tel" required
                   class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="08xxxxxxxxxx" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1">Jenis kelamin</label>
            <select x-model="form.jenis_kelamin" required
                    class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500">
              <option value="" disabled>Pilih</option>
              <option>Laki-laki</option>
              <option>Perempuan</option>
            </select>
          </div>
          <div>
            <label class="block text-sm mb-1">Usia</label>
            <input x-model="form.usia" type="number" min="0"
                   class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="contoh: 25" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1">Pendidikan</label>
            <input x-model="form.pendidikan" type="text"
                   class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="SMA/D3/S1/..." />
          </div>
          <div>
            <label class="block text-sm mb-1">Pekerjaan</label>
            <input x-model="form.pekerjaan" type="text"
                   class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="PNS, Swasta, dll" />
          </div>
        </div>

        {{-- SURVEY ringkas --}}
        <div class="space-y-5 bg-[#222] rounded-xl p-4 sm:p-5">
          <template x-for="(q,qi) in pertanyaan" :key="qi">
            <div>
              <div class="font-semibold mb-2 text-sm sm:text-base" x-text="q.t"></div>
              <div class="flex flex-wrap gap-3">
                <template x-for="(opt,oi) in opsi" :key="oi">
                  <label class="inline-flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-md cursor-pointer">
                    <input type="radio" class="accent-blue-600"
                           :name="'q'+qi" :value="opt.v" x-model="form.jawaban[qi]">
                    <span class="text-sm" x-text="opt.l"></span>
                  </label>
                </template>
              </div>
            </div>
          </template>
        </div>

        <div>
          <label class="block text-sm mb-1">Saran</label>
          <textarea x-model="form.saran" rows="4"
                    class="w-full rounded-md border-0 text-gray-800 px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    placeholder="Tuliskan saran/keluhan Anda di sini..."></textarea>
        </div>

        <div class="pt-2">
          <button type="submit"
                  class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full px-5 py-2.5">
            SIMPAN
          </button>
          <span class="ml-3 text-sm" x-text="statusMsg"></span>
        </div>
      </form>
    </section>

    {{-- SIDEBAR: PENGADUAN TERBARU (full height, hanya nama & saran) --}}
    <aside
      class="bg-[#2f2f2f] text-white rounded-2xl p-4 sm:p-5 shadow
             lg:sticky lg:top-20 lg:self-start"
      style="max-height: calc(100vh - 6rem);"
    >
      <div class="flex items-center justify-between mb-3">
        <h2 class="font-extrabold text-lg">Pengaduan terbaru</h2>
        <button @click="loadLatest()" class="text-sm underline hover:opacity-90">Muat ulang</button>
      </div>

      <div class="space-y-3 overflow-auto pr-1" style="max-height: calc(100vh - 8.5rem);">
        <template x-if="latest.length === 0">
          <div class="text-white/70 text-sm">Belum ada data.</div>
        </template>

        <template x-for="(p, i) in latest" :key="i">
          <div class="bg-white/10 rounded-xl p-3">
            <div class="font-semibold text-sm" x-text="p.nama ?? 'Tanpa nama'"></div>
            <div class="text-xs text-white/80 mt-1 line-clamp-3" x-text="p.saran ?? '-'"></div>
          </div>
        </template>
      </div>
    </aside>
  </div>
</main>

{{-- Alpine store / helpers --}}
<script>
function pengaduanPage(API_BASE) {
  return {
    statusMsg: '',
    latest: [],
    pertanyaan: [
      { t: 'Kesesuaian persyaratan pelayanan dengan yang diinformasikan?' },
      { t: 'Kompetensi / kesiapan petugas pelayanan?' },
      { t: 'Kesesuaian jangka waktu penyelesaian?' },
      { t: 'Tidak ada pungutan di luar ketentuan?' },
    ],
    opsi: [
      { l:'Tidak sesuai', v:'TS' },
      { l:'Kurang sesuai', v:'KS' },
      { l:'Sesuai',       v:'S'  },
      { l:'Sangat sesuai',v:'SS' },
    ],
    form: {
      nama: '', no_hp: '', jenis_kelamin: '', usia: '', pendidikan: '', pekerjaan: '', saran: '',
      jawaban: {0:'',1:'',2:'',3:''},
    },

    // Ambil teks "Saran: ..." dari field alamat
    takeSaran(alamat) {
      if (!alamat) return '';
      const m = alamat.match(/Saran:\s*(.*)$/i);
      return (m && m[1]) ? m[1].trim() : '';
    },

    async loadLatest() {
      try {
        const r = await fetch(`${API_BASE}/pengunjung?limit=30`);
        const j = await r.json();
        this.latest = (j.data || []).map(row => ({
          ...row,
          saran: this.takeSaran(row.alamat || '')
        }));
      } catch (e) { console.error(e); }
    },

    async submit() {
      this.statusMsg = 'Menyimpan...';

      // Catat info + survey, letakkan Saran di bagian akhir:
      const catatan =
        `Usia: ${this.form.usia || '-'}; Pendidikan: ${this.form.pendidikan || '-'}; ` +
        `Pekerjaan: ${this.form.pekerjaan || '-'}; ` +
        `Survey: [${[0,1,2,3].map(i=>this.form.jawaban[i]||'-').join(', ')}]; ` +
        `Saran: ${this.form.saran || '-'}`;

      const payload = {
        nama: this.form.nama,
        alamat: catatan,                  // masih disimpan ke kolom "alamat"
        jenis_kelamin: this.form.jenis_kelamin,
        no_hp: this.form.no_hp,
      };

      try {
        const r = await fetch(`${API_BASE}/pengunjung`, {
          method: 'POST',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify(payload),
        });
        const j = await r.json();
        if (r.ok && j.ok) {
          this.statusMsg = 'Tersimpan. Terima kasih atas masukannya!';
          this.form = {nama:'',no_hp:'',jenis_kelamin:'',usia:'',pendidikan:'',pekerjaan:'',saran:'',jawaban:{0:'',1:'',2:'',3:''}};
          this.loadLatest();
        } else {
          this.statusMsg = `Gagal: ${j.error || r.status}`;
        }
      } catch (e) {
        console.error(e);
        this.statusMsg = 'Gagal terhubung ke server.';
      }
    },
  }
}
</script>
@endsection
