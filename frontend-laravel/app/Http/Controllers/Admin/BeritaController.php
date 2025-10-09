<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $req)
    {
        $q = trim((string) $req->q);

        $list = Berita::when($q, function ($w) use ($q) {
                    $w->where('judul', 'like', "%{$q}%")
                      ->orWhere('isi', 'like', "%{$q}%");
                })
                ->latest()
                ->paginate(20); // atau ->limit(50)->get()

        return view('admin.berita.index', compact('list', 'q'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal_post' => 'nullable|date',
            'status'       => 'nullable|in:draft,published',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $row = new Berita();
        $row->judul = $data['judul'];
        $row->slug  = Str::slug($data['judul']).'-'.Str::random(4);
        $row->isi   = $data['isi'];
        $row->status = $data['status'] ?? 'published';
        $row->published_at = $data['tanggal_post'] ?? now();

        if ($req->hasFile('gambar')) {
            $row->cover = $req->file('gambar')->store('berita', 'public');
        }

        $row->save();

        return redirect()->route('admin.berita.index')->with('ok', 'Berita dibuat');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $req, Berita $berita)
    {
        $data = $req->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal_post' => 'nullable|date',
            'status'       => 'nullable|in:draft,published',
        ]);

        $berita->fill([
            'judul'        => $data['judul'],
            'isi'          => $data['isi'],
            'status'       => $data['status'] ?? $berita->status,
            'published_at' => $data['tanggal_post'] ?? $berita->published_at,
        ]);

        if ($berita->isDirty('judul')) {
            $berita->slug = Str::slug($data['judul']).'-'.Str::random(4);
        }

        $berita->save();

        return redirect()->route('admin.berita.index')->with('ok', 'Berita diupdate');
    }

    public function updateImage(Request $req, Berita $berita)
    {
        $req->validate(['gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);

        if ($berita->cover) {
            Storage::disk('public')->delete($berita->cover);
        }

        $berita->cover = $req->file('gambar')->store('berita', 'public');
        $berita->save();

        return back()->with('ok', 'Gambar diganti');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->cover) {
            Storage::disk('public')->delete($berita->cover);
        }
        $berita->delete();

        return back()->with('ok', 'Berita dihapus');
    }
}
