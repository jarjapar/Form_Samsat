<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BeritaFactory extends Factory
{
    // Untuk Laravel 9, nama factory "BeritaFactory" otomatis ke App\Models\Berita

    public function definition(): array
    {
        $judul = $this->faker->unique()->sentence(6);

        return [
            'judul'        => $judul,
            'slug'         => Str::slug($judul) . '-' . Str::random(6),
            'isi'          => $this->faker->paragraphs(5, true),
            'status'       => 'published',
            'published_at' => now()->subDays(rand(0, 30)),
            'cover'        => null,
        ];
    }
}
