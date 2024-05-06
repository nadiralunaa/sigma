<?php

namespace Database\Seeders;

use App\Models\role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        role::create(['role' => 'admin']);
        role::create(['role'=> 'posyandu']);
        role::create(['role'=> 'orangtua']);
    }
}
