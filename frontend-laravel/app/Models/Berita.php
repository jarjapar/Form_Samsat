<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    // Paling gampang: izinkan semua kolom
    protected $guarded = [];
    // (alternatif)
    // protected $fillable = ['judul','slug','isi','status','published_at','cover'];

    protected $casts = ['published_at' => 'datetime'];

    public function getRouteKeyName() { return 'slug'; }
}
