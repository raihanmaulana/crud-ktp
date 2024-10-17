<?php

namespace Database\Factories;

use App\Models\Ktp;
use Illuminate\Database\Eloquent\Factories\Factory;

class KtpFactory extends Factory
{
    protected $model = Ktp::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->firstName() . ' ' . $this->faker->lastName(), // Nama acak
            'nik' => $this->generateNik(),
            'alamat' => $this->faker->streetAddress(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2005-12-31'), // Acak sebelum 2005
        ];
    }

    private function generateNik()
    {
        // Generate NIK unik dengan 16 digit
        return str_pad(random_int(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }
}
