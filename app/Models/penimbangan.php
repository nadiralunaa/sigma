<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penimbangan extends Model
{
    use HasFactory;

    protected $table = 'penimbangans';

    protected $fillable = [
        'umur','tinggi_asli','berat_asli','tinggi_sensor','berat_sensor','status_bb','status_tb','status_gizi','kode_anak','tanggal_timbang'
    ] ;

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'kode_anak', 'id');
    }
}
