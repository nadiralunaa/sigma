<?php

namespace App\Exports;

use App\Models\Penimbangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenimbangansExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil data Penimbangan dengan relasi ke tabel Anak
        return Penimbangan::with('anak.posyandu')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Umur',
            'Tinggi',
            'Berat',
            'Status_BB',
            'Status_TB',
            'Status_Gizi',
            'Tanggal_Timbang',
            'Nama_Anak',  // Ubah heading ke 'Nama Anak'
            'posyandu'
        ];
    }

    /**
     * @param mixed $penimbangan
     * @return array
     */
    public function map($penimbangan): array
    {
        return [
            $penimbangan->id,
            $penimbangan->umur,
            $penimbangan->tinggi_asli,
            $penimbangan->berat_asli,
            $penimbangan->status_bb,
            $penimbangan->status_tb,
            $penimbangan->status_gizi,
            $penimbangan->tanggal_timbang,
            $penimbangan->anak->nama,  // Ubah ke nama anak
            $penimbangan->anak->posyandu->nama
        ];
    }
}
