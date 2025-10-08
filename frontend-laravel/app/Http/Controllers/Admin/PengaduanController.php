<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;

class PengaduanController extends Controller
{
    protected string $api;

    public function __construct()
    {
        $this->api = rtrim(env('API_BASE'), '/');
    }

    public function index()
    {
        $res  = Http::acceptJson()->get("{$this->api}/pengunjung", ['limit' => 200]);
        $list = $res->successful() ? ($res->json('data') ?? []) : [];

        return view('admin.pengaduan.index', ['list' => $list]);

    }

    public function export(): StreamedResponse
    {
        $res  = Http::acceptJson()->get("{$this->api}/pengunjung", ['limit' => 10000]);
        $rows = $res->successful() ? ($res->json('data') ?? []) : [];

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=pengaduan.csv',
        ];

        $callback = static function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','nama','alamat','jenis_kelamin','no_hp']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r['id'] ?? null,
                    $r['nama'] ?? null,
                    $r['alamat'] ?? null,
                    $r['jenis_kelamin'] ?? null,
                    $r['no_hp'] ?? null,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
