<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ktp;

class KtpSeeder extends Seeder
{
    public function run()
    {
        // Generate 10.000 data KTP
        Ktp::factory()->count(10000)->create();
    }
}
