<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anak extends Model
{
    use HasFactory;
    protected $table = 'anaks';

    protected $fillable = [
        'nama','gender','alamat','umur','namaortu','kode_posyandu','kode_ortu'
    ] ;
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'kode_posyandu', 'id');
    }

    public function timbang(){
        return $this->hasMany(penimbangan::class, 'kode_anak', 'id');
    }
}
