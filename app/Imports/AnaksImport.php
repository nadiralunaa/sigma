<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Anak;
use App\Models\posyandu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class AnaksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        //dd($row);
        // Cek apakah baris data tidak kosong dan memiliki kolom yang diperlukan
        if (empty($row['nama']) || empty($row['posyandu'])) {
            return null;
        }

        // Cari posyandu berdasarkan nama
        $posyandu = Posyandu::where('nama', $row['posyandu'])->first();

        // Pastikan posyandu ditemukan sebelum mengakses properti id
        if ($posyandu) {
            $excelDate = $row['tanggal'];

            // Periksa apakah nilai adalah numerik atau tidak
            if (is_numeric($excelDate)) {
                // Jika numerik, konversi dari format Excel
                $tanggal = Carbon::createFromTimestamp(($excelDate - 25569) * 86400)->format('Y-m-d');
            } else {
                // Jika bukan numerik, asumsikan format tanggal dd/mm/yyyy dan konversi
                try {
                    $tanggal = Carbon::createFromFormat('d/m/Y', $excelDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Tangani kesalahan jika format tanggal tidak sesuai
                    return null; // Atau tangani secara sesuai dengan logika bisnis Anda
                }
            }
            //dd($tanggal);
            return new Anak([
                'nama' => $row['nama'],
                'gender' => $row['gender'],
                'alamat' => $row['alamat'],
                'tanggal_lahir' => $tanggal,
                'namaortu' => $row['namaortu'],
                'kode_posyandu' => $posyandu->id,
            ]);
        } else {
            // Jika posyandu tidak ditemukan, Anda bisa memilih untuk menangani ini dengan berbagai cara
            // Misalnya, Anda bisa mengembalikan null atau melempar exception
            // return null; // Atau
            throw new \Exception("Posyandu dengan nama {$row['posyandu']} tidak ditemukan.");
        }
    }
}
