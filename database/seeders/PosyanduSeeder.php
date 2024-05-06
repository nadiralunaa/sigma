<?php

namespace Database\Seeders;

use App\Models\posyandu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        posyandu::create([
            'nama' => 'Tulip',
            'alamat' => 'Gayungan',
        ]);
    }
}
