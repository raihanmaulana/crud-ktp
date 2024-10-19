<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ktp extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama',
        'nik',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'foto',
    ];

    // Tentukan nama tabel (opsional jika tabel sesuai konvensi)
    protected $table = 'ktps';

    public function linkCollection()
    {
        return $this->appends(request()->except('page'))->links()->toHtml();
    }

}
