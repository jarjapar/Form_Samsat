@extends('layouts.public')
@section('title','Berita — Samsat Mataram')

@section('content')
<main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12"
      x-data="beritaPage('{{ rtrim(env('API_BASE',''),'/') }}')"
      x-init="load()">

  {{-- Banner --}}
  <div class="flex flex-col items-center mb-8">
    <img src="{{ asset('images/banner.png') }}" alt="banner" class="h-14 sm:h-16 md:h-20 object-contain">
  </div>

  {{-- Search + Sort --}}
  <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between mb-6">
    <div class="flex items-center gap-2">
      <input x-model.debounce.400ms="q" @input="load()" type="search"
             placeholder="Cari judul/isi…"
             class="w-full sm:w-72 border rounded-md px-3 py-2">
      <button @click="q=''; load();" class="text-sm underline">Reset</button>
    </div>
    <div class="flex items-center gap-2 text-sm">
      <label>Urut:</label>
      <select x-model="order" @change="load()" class="border rounded-md px-2 py-1">
        <option value="tanggal_post">Tanggal</option>
        <option value="judul">Judul</option>
        <option value="id">Terbaru</option>
      </select>
      <select x-model="dir" @change="load()" class="border rounded-md px-2 py-1">
        <option value="desc">↓</option>
        <option value="asc">↑</option>
      </select>
    </div>
  </div>

  {{-- Error / Loading --}}
  <template x-if="error">
    <div class="text-red-600 text-sm mb-4" x-text="error"></div>
  </template>

  <div x-show="loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <template x-for="i in 6" :key="i">
      <div class="animate-pulse rounded-xl border bg-white p-4">
        <div class="h-40 w-full bg-gray-200 rounded"></div>
        <div class="h-4 bg-gray-200 rounded mt-3 w-3/4"></div>
        <div class="h-3 bg-gray-200 rounded mt-2 w-1/2"></div>
      </div>
    </template>
  </div>

  {{-- List Berita --}}
  <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <template x-for="b in list" :key="b.id">
      <article class="rounded-2xl border bg-white shadow overflow-hidden" :id="`id-${b.id}`">
        <img :src="img(b)" class="w-full h-44 object-cover" alt="">
        <div class="p-4">
          <h3 class="font-bold text-lg leading-tight line-clamp-2" x-text="b.judul"></h3>
          <div class="text-xs opacity-70 mt-1" x-text="formatDate(b.tanggal_post)"></div>
          <p class="text-sm opacity-80 mt-2 line-clamp-3" x-text="preview(b.isi)"></p>
        </div>
      </article>
    </template>

    <template x-if="list.length===0 && !loading && !error">
      <div class="text-sm opacity-70">Belum ada berita.</div>
    </template>
  </div>

  {{-- Pager sederhana --}}
  <div class="flex items-center justify-center gap-2 mt-8" x-show="pagination.total>pagination.limit">
    <button class="px-3 py-1 border rounded" :disabled="pagination.page<=1"
            @click="pagination.page--; load()">Sebelumnya</button>
    <div class="text-sm">Hal. <span x-text="pagination.page"></span></div>
    <button class="px-3 py-1 border rounded"
            :disabled="pagination.page>=Math.ceil(pagination.total/pagination.limit)"
            @click="pagination.page++; load()">Berikutnya</button>
  </div>
</main>

<script>
function beritaPage(API_BASE){
  return {
    q:'', order:'tanggal_post', dir:'desc',
    list:[], loading:false, error:'',
    pagination:{page:1, limit: nineCols() ? 9 : 6, total:0},

    async load(){
      if(!API_BASE){ this.error='API_BASE belum di-set.'; return; }
      this.loading = true; this.error='';
      try{
        const params = new URLSearchParams({
          q:this.q||'',
          order:this.order,
          dir:this.dir,
          limit:this.pagination.limit,
          page:this.pagination.page
        });
        const r = await fetch(`${API_BASE}/berita?${params.toString()}`);
        const j = await r.json();
        if(!r.ok || !j.ok){ throw new Error(j.error || `HTTP ${r.status}`); }
        this.list = j.data || [];
        this.pagination = Object.assign(this.pagination, j.pagination || {});
      }catch(e){ console.error(e); this.error='Gagal memuat daftar berita.'; }
      finally{ this.loading = false; }
    },
    img(b){ return (b.gambar_url||'').startsWith('/') ? `${API_BASE}${b.gambar_url}` : (b.gambar_url || '{{ asset('images/hero.jpg') }}'); },
    formatDate(s){ if(!s) return ''; const d=new Date(s); return isNaN(d)? s : d.toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'}); },
    preview(s){ if(!s) return ''; return s.length>140 ? s.slice(0,140)+'…' : s; },
  }
}
function nineCols(){ return window.innerWidth>=1024; }
</script>
@endsection
