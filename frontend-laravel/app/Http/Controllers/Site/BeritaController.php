<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                ->get("{$this->api}/berita", ['q' => $q, 'limit' => 24]);

        $list = $res->successful() ? ($res->json('data') ?? []) : [];

        $list = collect($list)->map(function ($it) {
            $it['image_url'] = $this->imageUrl($it['gambar'] ?? null);
            $it['excerpt']   = str($it['isi'] ?? '')->stripTags()->limit(160);
            return $it;
        });

        return view('berita.index', ['list' => $list, 'q' => $q]);
    }

    public function show($slug)
    {
        // API bisa by slug/id; sesuaikan endpoint kamu
        $res = Http::acceptJson()->timeout(20)
                ->get("{$this->api}/berita/{$slug}");
        abort_unless($res->successful(), 404);

        $row = $res->json('data');
        $row['image_url'] = $this->imageUrl($row['gambar'] ?? null);

        $lainnyaRes = Http::acceptJson()->timeout(20)
            ->get("{$this->api}/berita", ['limit' => 3]);
        $lainnya = $lainnyaRes->successful() ? ($lainnyaRes->json('data') ?? []) : [];
        $lainnya = collect($lainnya)
            ->where('id', '!=', $row['id'])
            ->map(fn($x) => $x + ['image_url' => $this->imageUrl($x['gambar'] ?? null)]);

        return view('berita.show', compact('row','lainnya'));
    }

    private function imageUrl(?string $path): string
    {
        if (!$path) return asset('images/placeholder-news.jpg');
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
        return rtrim($this->api, '/') . '/' . ltrim($path, '/'); // path relatif → absolut
    }
}
        