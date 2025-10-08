<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    protected string $api;

    public function __construct()
    {
        $this->api = rtrim(env('API_BASE'), '/');
    }

    public function index(Request $req)
    {
        $q   = $req->query('q');
        $res = Http::acceptJson()->get("{$this->api}/berita", ['q' => $q, 'limit' => 50]);
        $list = $res->successful() ? ($res->json('data') ?? []) : [];

        return view('admin.berita.index', ['list' => $list, 'q' => $q]);

    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'judul'         => 'required|string|max:200',
            'isi'           => 'required|string',
            'tanggal_post'  => 'required|date',
            'gambar'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // contoh upload multipart (sesuaikan dgn backend-mu)
        $res = Http::attach(
                    'gambar',
                    file_get_contents($req->file('gambar')->getRealPath()),
                    $req->file('gambar')->getClientOriginalName()
                )->asMultipart()->post("{$this->api}/berita", [
                    'judul'        => $req->judul,
                    'isi'          => $req->isi,
                    'tanggal_post' => $req->tanggal_post,
                ]);

        if (!$res->successful()) {
            return back()->withErrors($res->json('error') ?? 'Gagal simpan')->withInput();
        }

        return redirect()->route('admin.berita.index')->with('ok', 'Berita dibuat');
    }

    public function edit($id)
    {
        $row = Http::acceptJson()->get("{$this->api}/berita/{$id}")->json('data');
        abort_unless($row, 404);

        return view('admin.berita.edit', compact('row'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal_post' => 'required|date',
        ]);

        $res = Http::acceptJson()->put("{$this->api}/berita/{$id}", $req->only('judul','isi','tanggal_post'));

        if (!$res->successful()) {
            return back()->withErrors($res->json('error') ?? 'Gagal update');
        }

        return redirect()->route('admin.berita.index')->with('ok', 'Berita diupdate');
    }

    public function updateImage(Request $req, $id)
    {
        $req->validate(['gambar'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048']);

        $res = Http::attach(
                    'gambar',
                    file_get_contents($req->file('gambar')->getRealPath()),
                    $req->file('gambar')->getClientOriginalName()
               )->post("{$this->api}/berita/{$id}/gambar");

        if (!$res->successful()) {
            return back()->withErrors($res->json('error') ?? 'Gagal ganti gambar');
        }

        return back()->with('ok', 'Gambar diganti');
    }

    public function destroy($id)
    {
        Http::delete("{$this->api}/berita/{$id}");
        return back()->with('ok', 'Berita dihapus');
    }
}
