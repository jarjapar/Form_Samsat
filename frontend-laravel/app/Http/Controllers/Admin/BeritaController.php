<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    protected string $api;

    public function __construct()
    {
        $this->api = rtrim((string) env('API_BASE'), '/');
    }

    public function index(Request $req)
    {
        $q   = $req->query('q');
        $res = Http::acceptJson()->timeout(20)
                ->get("{$this->api}/berita", ['q' => $q, 'limit' => 50]);

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
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal_post' => 'required|date',
            'gambar'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $tanggal = date('Y-m-d', strtotime($req->tanggal_post));

        $http = Http::asMultipart()->acceptJson()->timeout(30);
        if ($req->hasFile('gambar')) {
            $f = $req->file('gambar');
            $http = $http->attach('gambar', file_get_contents($f->getRealPath()), $f->getClientOriginalName());
        }

        $payload = [
            'judul'        => $req->judul,
            'isi'          => $req->isi,
            'tanggal_post' => $tanggal,
            'slug'         => Str::slug($req->judul) . '-' . Str::random(6),
        ];

        $res = $http->post("{$this->api}/berita", $payload);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? $res->json('error') ?? 'Gagal simpan';
            return back()->withErrors($msg)->withInput();
        }

        return redirect()->route('admin.berita.index')->with('ok', 'Berita dibuat');
    }

    public function edit($id)
    {
        $res = Http::acceptJson()->timeout(20)->get("{$this->api}/berita/{$id}");
        abort_unless($res->successful(), 404);
        $row = $res->json('data');

        return view('admin.berita.edit', compact('row'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal_post' => 'required|date',
        ]);

        $payload = [
            'judul'        => $req->judul,
            'isi'          => $req->isi,
            'tanggal_post' => date('Y-m-d', strtotime($req->tanggal_post)),
        ];

        $res = Http::acceptJson()->timeout(20)->put("{$this->api}/berita/{$id}", $payload);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? $res->json('error') ?? 'Gagal update';
            return back()->withErrors($msg);
        }

        return redirect()->route('admin.berita.index')->with('ok', 'Berita diupdate');
    }

    public function updateImage(Request $req, $id)
    {
        $req->validate(['gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);

        $f = $req->file('gambar');
        $res = Http::asMultipart()->acceptJson()->timeout(30)
                ->attach('gambar', file_get_contents($f->getRealPath()), $f->getClientOriginalName())
                ->post("{$this->api}/berita/{$id}/gambar");

        if (!$res->successful()) {
            $msg = $res->json('message') ?? $res->json('error') ?? 'Gagal ganti gambar';
            return back()->withErrors($msg);
        }

        return back()->with('ok', 'Gambar diganti');
    }

    public function destroy($id)
    {
        Http::timeout(15)->delete("{$this->api}/berita/{$id}");
        return back()->with('ok', 'Berita dihapus');
    }
}
