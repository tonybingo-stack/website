<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pro;

class ProSeeder extends Seeder
{
    public function run()
    {
        // Creează 10 înregistrări folosind fabrica
        Pro::factory()->count(6)->create();;
    }
}
