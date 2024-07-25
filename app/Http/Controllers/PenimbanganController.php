<?php

namespace App\Http\Controllers;

use App\Models\anak;
use App\Models\penimbangan;
use App\Models\sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenimbangansImport;
use App\Exports\PenimbangansExport;

class PenimbanganController extends Controller
{

    private $lastdata = ([]);
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd($this->lastdata);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $anak = anak::find($id);
        //dd($anak);
        $riwayat = penimbangan::where("kode_anak", "=", $anak->id)->get()->all();
        return view('user_admin.timbang', compact('anak', 'riwayat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari ESP32
        $validatedData = $request->validate([
            'berat' => 'required|numeric',
            'tinggi' => 'required|numeric',
        ]);

        // // Simpan data sensor ke database
        // $sensorData = new sensor();
        // $sensorData->berat = $validatedData['berat'];
        // $sensorData->tinggi = $validatedData['tinggi'];
        $this->lastdata = $validatedData;
        // $a = $this->lastdata;
        // echo $this->lastdata['berat'];
        return response()->json(['message' => 'data berhasil terupload'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(anak $anak)
    {
        return view('user_admin.timbang', compact('anak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, anak $anak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Mengambil data terbaru sensor untuk ditampilkan pada halaman web.
     *
     * @return \Illuminate\Http\Response
     */
    public function latestData()
    {
        // Ambil data sensor terbaru dari database
        try {
            // Lakukan HTTP GET request ke API eksternal
            $response = Http::get('https://mannn.pythonanywhere.com/get_sigma');

            // Periksa apakah respons berhasil (kode status 2xx)
            if ($response->successful()) {
                $data = $response->json(); // Ambil data JSON dari respons
                return response()->json($data); // Kirim data ke client sebagai JSON
            } else {
                return response()->json(['error' => 'Gagal mengambil data dari API'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function correctData(Request $request, anak $anak)
    {
        // Validasi data koreksi yang diterima dari pengguna
        $validatedData = $request->validate([
            'beratsensor' => 'required',
            'tinggisensor' => 'required',
            'beratasli' => 'required',
            'tinggiasli' => 'required',
            'tanggal' => 'required|date', // Tambahkan validasi untuk tanggal
        ]);

        // Konversi string ke integer
        $beratSensor = intval($validatedData['beratsensor']);
        $tinggiSensor = intval($validatedData['tinggisensor']);
        $beratAsli = intval($validatedData['beratasli']);
        $tinggiAsli = intval($validatedData['tinggiasli']);
        $umur = intval($request['umur']);

        // Lakukan proses penyimpanan nilai koreksi ke database
        $sensorData = new penimbangan();
        $sensorData->berat_asli = $beratAsli;
        $sensorData->tinggi_asli = $tinggiAsli;
        $sensorData->berat_sensor = $beratSensor;
        $sensorData->tinggi_sensor = $tinggiSensor;
        $sensorData->umur = $umur;

        // Menggunakan Carbon untuk format tanggal
        $tanggalTimbang = date('Y-m-d H:i:s', strtotime($validatedData['tanggal']));
        $sensorData->tanggal_timbang = $tanggalTimbang;

        // Panggil fungsi untuk menghitung status TB
        $status_tb = getStatusTB($umur, $tinggiAsli, $request['gender']);
        $status_bb = getStatusBB($umur, $beratAsli, $request['gender']);
        $status_gizi = getStatus($umur, $beratAsli, $tinggiAsli, $request['gender']);
        $sensorData->status_bb = $status_bb; // Asumsi status_bb adalah umur, perlu disesuaikan sesuai kebutuhan
        $sensorData->status_tb = $status_tb;
        $sensorData->status_gizi = $status_gizi;
        $sensorData->kode_anak = $request['id_anak'];

        //dd($sensorData);
        // Simpan data ke database
        $sensorData->save();

        return redirect()->back()->with('success', 'Data berhasil ditambah');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        //dd($request);
        Excel::import(new PenimbangansImport, $request->file('file'));

        return redirect()->back()->with('success', 'Penimbangan data imported successfully.');
    }

    public function export()
    {
        return Excel::download(new PenimbangansExport, 'penimbangan.xlsx');
    }
}


function getStatus($umur, $berat_badan, $tinggi_badan, $jenis_kelamin)
{
    $dataLaki = [
        24 => [-3 => 12.9, -2 => 13.8, -1 => 14.8, 0 => 16.0, 1 => 17.3, 2 => 18.9, 3 => 20.6],
        25 => [-3 => 12.8, -2 => 13.8, -1 => 14.8, 0 => 16.0, 1 => 17.3, 2 => 18.8, 3 => 20.5],
        26 => [-3 => 12.8, -2 => 13.7, -1 => 14.8, 0 => 15.9, 1 => 17.3, 2 => 18.8, 3 => 20.5],
        27 => [-3 => 12.7, -2 => 13.7, -1 => 14.7, 0 => 15.9, 1 => 17.2, 2 => 18.7, 3 => 20.4],
        28 => [-3 => 12.7, -2 => 13.6, -1 => 14.7, 0 => 15.9, 1 => 17.2, 2 => 18.7, 3 => 20.4],
        29 => [-3 => 12.7, -2 => 13.6, -1 => 14.7, 0 => 15.8, 1 => 17.1, 2 => 18.6, 3 => 20.3],
        30 => [-3 => 12.6, -2 => 13.6, -1 => 14.6, 0 => 15.8, 1 => 17.1, 2 => 18.6, 3 => 20.2],
        31 => [-3 => 12.6, -2 => 13.5, -1 => 14.6, 0 => 15.8, 1 => 17.1, 2 => 18.5, 3 => 20.2],
        32 => [-3 => 12.5, -2 => 13.5, -1 => 14.6, 0 => 15.7, 1 => 17.0, 2 => 18.5, 3 => 20.1],
        33 => [-3 => 12.5, -2 => 13.5, -1 => 14.5, 0 => 15.7, 1 => 17.0, 2 => 18.5, 3 => 20.1],
        34 => [-3 => 12.5, -2 => 13.4, -1 => 14.5, 0 => 15.7, 1 => 17.0, 2 => 18.4, 3 => 20.0],
        35 => [-3 => 12.4, -2 => 13.4, -1 => 14.5, 0 => 15.6, 1 => 16.9, 2 => 18.4, 3 => 20.0],
        36 => [-3 => 12.4, -2 => 13.4, -1 => 14.4, 0 => 15.6, 1 => 16.9, 2 => 18.4, 3 => 20.0],
        37 => [-3 => 12.4, -2 => 13.3, -1 => 14.4, 0 => 15.6, 1 => 16.9, 2 => 18.3, 3 => 19.9],
        38 => [-3 => 12.3, -2 => 13.3, -1 => 14.4, 0 => 15.5, 1 => 16.8, 2 => 18.3, 3 => 19.9],
        39 => [-3 => 12.3, -2 => 13.3, -1 => 14.3, 0 => 15.5, 1 => 16.8, 2 => 18.3, 3 => 19.9],
        40 => [-3 => 12.3, -2 => 13.2, -1 => 14.3, 0 => 15.5, 1 => 16.8, 2 => 18.2, 3 => 19.9],
        41 => [-3 => 12.2, -2 => 13.2, -1 => 14.3, 0 => 15.5, 1 => 16.8, 2 => 18.2, 3 => 19.9],
        42 => [-3 => 12.2, -2 => 13.2, -1 => 14.3, 0 => 15.4, 1 => 16.8, 2 => 18.2, 3 => 19.8],
        43 => [-3 => 12.2, -2 => 13.2, -1 => 14.2, 0 => 15.4, 1 => 16.7, 2 => 18.2, 3 => 19.8],
        44 => [-3 => 12.2, -2 => 13.1, -1 => 14.2, 0 => 15.4, 1 => 16.7, 2 => 18.2, 3 => 19.8],
        45 => [-3 => 12.2, -2 => 13.1, -1 => 14.2, 0 => 15.4, 1 => 16.7, 2 => 18.2, 3 => 19.8],
        46 => [-3 => 12.1, -2 => 13.1, -1 => 14.2, 0 => 15.4, 1 => 16.7, 2 => 18.2, 3 => 19.8],
        47 => [-3 => 12.1, -2 => 13.1, -1 => 14.2, 0 => 15.3, 1 => 16.7, 2 => 18.2, 3 => 19.9],
        48 => [-3 => 12.1, -2 => 13.1, -1 => 14.1, 0 => 15.3, 1 => 16.7, 2 => 18.2, 3 => 19.9],
        49 => [-3 => 12.1, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.7, 2 => 18.2, 3 => 19.9],
        50 => [-3 => 12.1, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.7, 2 => 18.2, 3 => 19.9],
        51 => [-3 => 12.1, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.6, 2 => 18.2, 3 => 19.9],
        52 => [-3 => 12.0, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.6, 2 => 18.2, 3 => 19.9],
        53 => [-3 => 12.0, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.6, 2 => 18.2, 3 => 20.0],
        54 => [-3 => 12.0, -2 => 13.0, -1 => 14.0, 0 => 15.3, 1 => 16.6, 2 => 18.2, 3 => 20.0],
        55 => [-3 => 12.0, -2 => 13.0, -1 => 14.0, 0 => 15.2, 1 => 16.6, 2 => 18.2, 3 => 20.0],
        56 => [-3 => 12.0, -2 => 12.9, -1 => 14.0, 0 => 15.2, 1 => 16.6, 2 => 18.2, 3 => 20.1],
        57 => [-3 => 12.0, -2 => 12.9, -1 => 14.0, 0 => 15.2, 1 => 16.6, 2 => 18.2, 3 => 20.1],
        58 => [-3 => 12.0, -2 => 12.9, -1 => 14.0, 0 => 15.2, 1 => 16.6, 2 => 18.3, 3 => 20.2],
        59 => [-3 => 12.0, -2 => 12.9, -1 => 14.0, 0 => 15.2, 1 => 16.6, 2 => 18.3, 3 => 20.2],
        60 => [-3 => 12.0, -2 => 12.9, -1 => 14.0, 0 => 15.2, 1 => 16.6, 2 => 18.3, 3 => 20.3]
    ];

    $dataPerempuan = [
        24 => [-3 => 12.4, -2 => 13.3, -1 => 14.4, 0 => 15.7, 1 => 17.1, 2 => 18.7, 3 => 20.6],
        25 => [-3 => 12.4, -2 => 13.3, -1 => 14.4, 0 => 15.7, 1 => 17.1, 2 => 18.7, 3 => 20.6],
        26 => [-3 => 12.3, -2 => 13.3, -1 => 14.4, 0 => 15.6, 1 => 17.0, 2 => 18.7, 3 => 20.6],
        27 => [-3 => 12.3, -2 => 13.3, -1 => 14.4, 0 => 15.6, 1 => 17.0, 2 => 18.6, 3 => 20.5],
        28 => [-3 => 12.3, -2 => 13.3, -1 => 14.3, 0 => 15.6, 1 => 17.0, 2 => 18.6, 3 => 20.5],
        29 => [-3 => 12.3, -2 => 13.2, -1 => 14.3, 0 => 15.6, 1 => 17.0, 2 => 18.6, 3 => 20.4],
        30 => [-3 => 12.3, -2 => 13.2, -1 => 14.3, 0 => 15.5, 1 => 16.9, 2 => 18.5, 3 => 20.4],
        31 => [-3 => 12.2, -2 => 13.2, -1 => 14.3, 0 => 15.5, 1 => 16.9, 2 => 18.5, 3 => 20.4],
        32 => [-3 => 12.2, -2 => 13.2, -1 => 14.3, 0 => 15.5, 1 => 16.9, 2 => 18.5, 3 => 20.4],
        33 => [-3 => 12.2, -2 => 13.1, -1 => 14.2, 0 => 15.5, 1 => 16.9, 2 => 18.5, 3 => 20.3],
        34 => [-3 => 12.2, -2 => 13.1, -1 => 14.2, 0 => 15.4, 1 => 16.8, 2 => 18.5, 3 => 20.3],
        35 => [-3 => 12.1, -2 => 13.1, -1 => 14.2, 0 => 15.4, 1 => 16.8, 2 => 18.4, 3 => 20.3],
        36 => [-3 => 12.1, -2 => 13.1, -1 => 14.2, 0 => 15.4, 1 => 16.8, 2 => 18.4, 3 => 20.3],
        37 => [-3 => 12.1, -2 => 13.1, -1 => 14.1, 0 => 15.4, 1 => 16.8, 2 => 18.4, 3 => 20.3],
        38 => [-3 => 12.1, -2 => 13.0, -1 => 14.1, 0 => 15.4, 1 => 16.8, 2 => 18.4, 3 => 20.3],
        39 => [-3 => 12.0, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.8, 2 => 18.4, 3 => 20.3],
        40 => [-3 => 12.0, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.8, 2 => 18.4, 3 => 20.3],
        41 => [-3 => 12.0, -2 => 13.0, -1 => 14.1, 0 => 15.3, 1 => 16.8, 2 => 18.4, 3 => 20.4],
        42 => [-3 => 12.0, -2 => 12.9, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.4, 3 => 20.4],
        43 => [-3 => 11.9, -2 => 12.9, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.4, 3 => 20.4],
        44 => [-3 => 11.9, -2 => 12.9, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.5, 3 => 20.4],
        45 => [-3 => 11.9, -2 => 12.9, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.5, 3 => 20.5],
        46 => [-3 => 11.9, -2 => 12.9, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.5, 3 => 20.5],
        47 => [-3 => 11.8, -2 => 12.8, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.5, 3 => 20.5],
        48 => [-3 => 11.8, -2 => 12.8, -1 => 14.0, 0 => 15.3, 1 => 16.8, 2 => 18.5, 3 => 20.6],
        49 => [-3 => 11.8, -2 => 12.8, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.5, 3 => 20.6],
        50 => [-3 => 11.8, -2 => 12.8, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.6, 3 => 20.7],
        51 => [-3 => 11.8, -2 => 12.8, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.6, 3 => 20.7],
        52 => [-3 => 11.7, -2 => 12.8, -1 => 13.9, 0 => 15.2, 1 => 16.8, 2 => 18.6, 3 => 20.7],
        53 => [-3 => 11.7, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.6, 3 => 20.8],
        54 => [-3 => 11.7, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.7, 3 => 20.8],
        55 => [-3 => 11.7, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.7, 3 => 20.9],
        56 => [-3 => 11.7, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.8, 2 => 18.7, 3 => 20.9],
        57 => [-3 => 11.7, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.9, 2 => 18.7, 3 => 21.0],
        58 => [-3 => 11.7, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.9, 2 => 18.8, 3 => 21.0],
        59 => [-3 => 11.6, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.9, 2 => 18.8, 3 => 21.0],
        60 => [-3 => 11.6, -2 => 12.7, -1 => 13.9, 0 => 15.3, 1 => 16.9, 2 => 18.8, 3 => 21.1],
    ];

    // Pilih data berdasarkan jenis kelamin
    $data = ($jenis_kelamin == 'l') ? $dataLaki : $dataPerempuan;

    if (!isset($data[$umur])) {
        return "Umur tidak valid.";
    }

    // Mengonversi tinggi_badan dari cm ke meter
    $tinggi_meter = $tinggi_badan / 100;
    // Menghitung IMT
    $imt = $berat_badan / ($tinggi_meter * $tinggi_meter);

    $z_score = ($imt - $data[$umur][-3]) / ($data[$umur][3] - $data[$umur][-3]);

    if ($z_score < -3) {
        return "Gizi buruk (severely wasted)";
    } elseif ($z_score >= -3 && $z_score < -2) {
        return "Gizi kurang (wasted)";
    } elseif ($z_score >= -2 && $z_score <= 1) {
        return "Gizi baik (normal)";
    } elseif ($z_score > 1 && $z_score <= 2) {
        return "Berisiko gizi lebih (possible risk of overweight)";
    } elseif ($z_score > 2 && $z_score <= 3) {
        return "Gizi lebih (overweight)";
    } elseif ($z_score > 3) {
        return "Obesitas (obese)";
    }
    return "Status tidak ditemukan.";
}

// Fungsi untuk menentukan status gizi berdasarkan umur, berat badan, dan jenis kelamin
function getStatusBB($umur, $berat_badan, $jenis_kelamin)
{
    $dataBBLakiLaki = [
        24 => [-3 => 8.6, -2 => 9.7, -1 => 10.8, 0 => 12.2, 1 => 13.6, 2 => 15.3, 3 => 17.1],
        25 => [-3 => 8.8, -2 => 9.8, -1 => 11.0, 0 => 12.4, 1 => 13.9, 2 => 15.5, 3 => 17.5],
        26 => [-3 => 8.9, -2 => 10.0, -1 => 11.2, 0 => 12.5, 1 => 14.1, 2 => 15.8, 3 => 17.8],
        27 => [-3 => 9.0, -2 => 10.1, -1 => 11.3, 0 => 12.7, 1 => 14.3, 2 => 16.1, 3 => 18.1],
        28 => [-3 => 9.1, -2 => 10.2, -1 => 11.5, 0 => 12.9, 1 => 14.5, 2 => 16.3, 3 => 18.4],
        29 => [-3 => 9.2, -2 => 10.4, -1 => 11.7, 0 => 13.1, 1 => 14.8, 2 => 16.6, 3 => 18.7],
        30 => [-3 => 9.4, -2 => 10.5, -1 => 11.8, 0 => 13.3, 1 => 15.0, 2 => 16.9, 3 => 19.0],
        31 => [-3 => 9.5, -2 => 10.7, -1 => 12.0, 0 => 13.5, 1 => 15.2, 2 => 17.1, 3 => 19.3],
        32 => [-3 => 9.6, -2 => 10.8, -1 => 12.1, 0 => 13.7, 1 => 15.4, 2 => 17.4, 3 => 19.6],
        33 => [-3 => 9.7, -2 => 10.9, -1 => 12.3, 0 => 13.8, 1 => 15.6, 2 => 17.6, 3 => 19.9],
        34 => [-3 => 9.8, -2 => 11.0, -1 => 12.4, 0 => 14.0, 1 => 15.8, 2 => 17.8, 3 => 20.2],
        35 => [-3 => 9.9, -2 => 11.2, -1 => 12.6, 0 => 14.2, 1 => 16.0, 2 => 18.1, 3 => 20.4],
        36 => [-3 => 10.0, -2 => 11.3, -1 => 12.7, 0 => 14.3, 1 => 16.2, 2 => 18.3, 3 => 20.7],
        37 => [-3 => 10.1, -2 => 11.4, -1 => 12.9, 0 => 14.5, 1 => 16.4, 2 => 18.6, 3 => 21.0],
        38 => [-3 => 10.2, -2 => 11.5, -1 => 13.0, 0 => 14.7, 1 => 16.6, 2 => 18.8, 3 => 21.3],
        39 => [-3 => 10.3, -2 => 11.6, -1 => 13.1, 0 => 14.8, 1 => 16.8, 2 => 19.0, 3 => 21.6],
        40 => [-3 => 10.4, -2 => 11.8, -1 => 13.3, 0 => 15.0, 1 => 17.0, 2 => 19.3, 3 => 21.9],
        41 => [-3 => 10.5, -2 => 11.9, -1 => 13.4, 0 => 15.2, 1 => 17.2, 2 => 19.5, 3 => 22.1],
        42 => [-3 => 10.6, -2 => 12.0, -1 => 13.6, 0 => 15.3, 1 => 17.4, 2 => 19.7, 3 => 22.4],
        43 => [-3 => 10.7, -2 => 12.1, -1 => 13.7, 0 => 15.5, 1 => 17.6, 2 => 20.0, 3 => 22.7],
        44 => [-3 => 10.8, -2 => 12.2, -1 => 13.8, 0 => 15.7, 1 => 17.8, 2 => 20.2, 3 => 23.0],
        45 => [-3 => 10.9, -2 => 12.4, -1 => 14.0, 0 => 15.8, 1 => 18.0, 2 => 20.5, 3 => 23.3],
        46 => [-3 => 11.0, -2 => 12.5, -1 => 14.1, 0 => 16.0, 1 => 18.2, 2 => 20.7, 3 => 23.6],
        47 => [-3 => 11.1, -2 => 12.6, -1 => 14.3, 0 => 16.2, 1 => 18.4, 2 => 20.9, 3 => 23.9],
        48 => [-3 => 11.2, -2 => 12.7, -1 => 14.4, 0 => 16.3, 1 => 18.6, 2 => 21.2, 3 => 24.2],
        49 => [-3 => 11.3, -2 => 12.8, -1 => 14.5, 0 => 16.5, 1 => 18.8, 2 => 21.4, 3 => 24.5],
        50 => [-3 => 11.4, -2 => 12.9, -1 => 14.7, 0 => 16.7, 1 => 19.0, 2 => 21.7, 3 => 24.8],
        51 => [-3 => 11.5, -2 => 13.1, -1 => 14.8, 0 => 16.8, 1 => 19.2, 2 => 21.9, 3 => 25.1],
        52 => [-3 => 11.6, -2 => 13.2, -1 => 15.0, 0 => 17.0, 1 => 19.4, 2 => 22.2, 3 => 25.4],
        53 => [-3 => 11.7, -2 => 13.3, -1 => 15.1, 0 => 17.2, 1 => 19.6, 2 => 22.4, 3 => 25.7],
        54 => [-3 => 11.8, -2 => 13.4, -1 => 15.2, 0 => 17.3, 1 => 19.8, 2 => 22.7, 3 => 26.0],
        55 => [-3 => 11.9, -2 => 13.5, -1 => 15.4, 0 => 17.5, 1 => 20.0, 2 => 22.9, 3 => 26.3],
        56 => [-3 => 12.0, -2 => 13.6, -1 => 15.5, 0 => 17.7, 1 => 20.2, 2 => 23.2, 3 => 26.6],
        57 => [-3 => 12.1, -2 => 13.7, -1 => 15.6, 0 => 17.8, 1 => 20.4, 2 => 23.4, 3 => 26.9],
        58 => [-3 => 12.2, -2 => 13.8, -1 => 15.8, 0 => 18.0, 1 => 20.6, 2 => 23.7, 3 => 27.2],
        59 => [-3 => 12.3, -2 => 14.0, -1 => 15.9, 0 => 18.2, 1 => 20.8, 2 => 23.9, 3 => 27.6],
        60 => [-3 => 12.4, -2 => 14.1, -1 => 16.0, 0 => 18.3, 1 => 21.0, 2 => 24.2, 3 => 27.9],
    ];

    $dataBBPerempuan = [
        24 => [-3 => 8.1, -2 => 9.0, -1 => 10.2, 0 => 11.5, 1 => 13.0, 2 => 14.8, 3 => 17.0],
        25 => [-3 => 8.2, -2 => 9.2, -1 => 10.3, 0 => 11.7, 1 => 13.3, 2 => 15.1, 3 => 17.3],
        26 => [-3 => 8.4, -2 => 9.4, -1 => 10.5, 0 => 11.9, 1 => 13.5, 2 => 15.4, 3 => 17.7],
        27 => [-3 => 8.5, -2 => 9.5, -1 => 10.7, 0 => 12.1, 1 => 13.7, 2 => 15.7, 3 => 18.0],
        28 => [-3 => 8.6, -2 => 9.7, -1 => 10.9, 0 => 12.3, 1 => 14.0, 2 => 16.0, 3 => 18.3],
        29 => [-3 => 8.8, -2 => 9.8, -1 => 11.1, 0 => 12.5, 1 => 14.2, 2 => 16.2, 3 => 18.7],
        30 => [-3 => 8.9, -2 => 10.0, -1 => 11.2, 0 => 12.7, 1 => 14.4, 2 => 16.5, 3 => 19.0],
        31 => [-3 => 9.0, -2 => 10.1, -1 => 11.4, 0 => 12.9, 1 => 14.7, 2 => 16.8, 3 => 19.3],
        32 => [-3 => 9.1, -2 => 10.3, -1 => 11.6, 0 => 13.1, 1 => 14.9, 2 => 17.1, 3 => 19.6],
        33 => [-3 => 9.3, -2 => 10.4, -1 => 11.7, 0 => 13.3, 1 => 15.1, 2 => 17.3, 3 => 20.0],
        34 => [-3 => 9.4, -2 => 10.5, -1 => 11.9, 0 => 13.5, 1 => 15.4, 2 => 17.6, 3 => 20.3],
        35 => [-3 => 9.5, -2 => 10.7, -1 => 12.0, 0 => 13.7, 1 => 15.6, 2 => 17.9, 3 => 20.6],
        36 => [-3 => 9.6, -2 => 10.8, -1 => 12.2, 0 => 13.9, 1 => 15.8, 2 => 18.1, 3 => 20.9],
        37 => [-3 => 9.7, -2 => 10.9, -1 => 12.4, 0 => 14.0, 1 => 16.0, 2 => 18.4, 3 => 21.3],
        38 => [-3 => 9.8, -2 => 11.1, -1 => 12.5, 0 => 14.2, 1 => 16.3, 2 => 18.7, 3 => 21.6],
        39 => [-3 => 9.9, -2 => 11.2, -1 => 12.7, 0 => 14.4, 1 => 16.5, 2 => 19.0, 3 => 22.0],
        40 => [-3 => 10.1, -2 => 11.3, -1 => 12.8, 0 => 14.6, 1 => 16.7, 2 => 19.2, 3 => 22.3],
        41 => [-3 => 10.2, -2 => 11.5, -1 => 13.0, 0 => 14.8, 1 => 16.9, 2 => 19.5, 3 => 22.7],
        42 => [-3 => 10.3, -2 => 11.6, -1 => 13.1, 0 => 15.0, 1 => 17.2, 2 => 19.8, 3 => 23.0],
        43 => [-3 => 10.4, -2 => 11.7, -1 => 13.3, 0 => 15.2, 1 => 17.4, 2 => 20.1, 3 => 23.4],
        44 => [-3 => 10.5, -2 => 11.8, -1 => 13.4, 0 => 15.3, 1 => 17.6, 2 => 20.4, 3 => 23.7],
        45 => [-3 => 10.6, -2 => 12.0, -1 => 13.6, 0 => 15.5, 1 => 17.8, 2 => 20.7, 3 => 24.1],
        46 => [-3 => 10.7, -2 => 12.1, -1 => 13.7, 0 => 15.7, 1 => 18.1, 2 => 20.9, 3 => 24.5],
        47 => [-3 => 10.8, -2 => 12.2, -1 => 13.9, 0 => 15.9, 1 => 18.3, 2 => 21.2, 3 => 24.8],
        48 => [-3 => 10.9, -2 => 12.3, -1 => 14.0, 0 => 16.1, 1 => 18.5, 2 => 21.5, 3 => 25.2],
        49 => [-3 => 11.0, -2 => 12.4, -1 => 14.2, 0 => 16.3, 1 => 18.8, 2 => 21.8, 3 => 25.5],
        50 => [-3 => 11.1, -2 => 12.6, -1 => 14.3, 0 => 16.4, 1 => 19.0, 2 => 22.1, 3 => 25.9],
        51 => [-3 => 11.2, -2 => 12.7, -1 => 14.5, 0 => 16.6, 1 => 19.2, 2 => 22.4, 3 => 26.3],
        52 => [-3 => 11.3, -2 => 12.8, -1 => 14.6, 0 => 16.8, 1 => 19.4, 2 => 22.6, 3 => 26.6],
        53 => [-3 => 11.4, -2 => 12.9, -1 => 14.8, 0 => 17.0, 1 => 19.7, 2 => 22.9, 3 => 27.0],
        54 => [-3 => 11.5, -2 => 13.0, -1 => 14.9, 0 => 17.2, 1 => 19.9, 2 => 23.2, 3 => 27.4],
        55 => [-3 => 11.6, -2 => 13.2, -1 => 15.1, 0 => 17.3, 1 => 20.1, 2 => 23.5, 3 => 27.7],
        56 => [-3 => 11.7, -2 => 13.3, -1 => 15.2, 0 => 17.5, 1 => 20.3, 2 => 23.8, 3 => 28.1],
        57 => [-3 => 11.8, -2 => 13.4, -1 => 15.3, 0 => 17.7, 1 => 20.6, 2 => 24.1, 3 => 28.5],
        58 => [-3 => 11.9, -2 => 13.5, -1 => 15.5, 0 => 17.9, 1 => 20.8, 2 => 24.4, 3 => 28.8],
        59 => [-3 => 12.0, -2 => 13.6, -1 => 15.6, 0 => 18.0, 1 => 21.0, 2 => 24.6, 3 => 29.2],
        60 => [-3 => 12.1, -2 => 13.7, -1 => 15.8, 0 => 18.2, 1 => 21.2, 2 => 24.9, 3 => 29.5],
    ];

    // Pilih data berdasarkan jenis kelamin
    $data = ($jenis_kelamin == 'l') ? $dataBBLakiLaki : $dataBBPerempuan;

    if (!isset($data[$umur])) {
        return "Umur tidak valid.";
    }

    // Hitung z-score berdasarkan berat badan
    $z_score = ($berat_badan - $data[$umur][-3]) / ($data[$umur][3] - $data[$umur][-3]);

    // Tentukan status gizi berdasarkan z-score
    if ($z_score < -3) {
        return "Berat Badan Sangat Kurang (Severely underweight)";
    } elseif ($z_score >= -3 && $z_score < -2) {
        return "Berat Badan Kurang (Underweight)";
    } elseif ($z_score >= -2 && $z_score <= 1) {
        return "Berat Badan Normal";
    } elseif ($z_score > 1) {
        return "Risiko Berat Badan Lebih";
    }

    return "Status tidak ditemukan.";
}


// Fungsi untuk menentukan kategori tinggi badan anak berdasarkan usia dan jenis kelamin
function getStatusTB($usia, $tinggi_badan, $jenis_kelamin)
{
    // global $dataTBlaki, $dataTBperempuan;
    // Data tinggi badan dalam SD untuk anak laki-laki (dalam sentimeter)
    $dataTBlaki = [
        24 => [-3 => 78.0, -2 => 81.0, -1 => 84.1, 0 => 87.1, 1 => 90.2, 2 => 93.2, 3 => 96.3],
        25 => [-3 => 78.6, -2 => 81.7, -1 => 84.9, 0 => 88.0, 1 => 91.1, 2 => 94.2, 3 => 97.3],
        26 => [-3 => 79.3, -2 => 82.5, -1 => 85.6, 0 => 88.8, 1 => 92.0, 2 => 95.2, 3 => 98.3],
        27 => [-3 => 79.9, -2 => 83.1, -1 => 86.4, 0 => 89.6, 1 => 92.9, 2 => 96.1, 3 => 99.3],
        28 => [-3 => 80.5, -2 => 83.8, -1 => 87.1, 0 => 90.4, 1 => 93.7, 2 => 97.0, 3 => 100.3],
        29 => [-3 => 81.1, -2 => 84.5, -1 => 87.8, 0 => 91.2, 1 => 94.5, 2 => 97.9, 3 => 101.2],
        30 => [-3 => 81.7, -2 => 85.1, -1 => 88.5, 0 => 91.9, 1 => 95.3, 2 => 98.7, 3 => 102.1],
        31 => [-3 => 82.3, -2 => 85.7, -1 => 89.2, 0 => 92.7, 1 => 96.1, 2 => 99.6, 3 => 103.0],
        32 => [-3 => 82.8, -2 => 86.4, -1 => 89.9, 0 => 93.4, 1 => 96.9, 2 => 100.4, 3 => 103.9],
        33 => [-3 => 83.4, -2 => 86.9, -1 => 90.5, 0 => 94.1, 1 => 97.6, 2 => 101.2, 3 => 104.8],
        34 => [-3 => 83.9, -2 => 87.5, -1 => 91.1, 0 => 94.8, 1 => 98.4, 2 => 102.0, 3 => 105.6],
        35 => [-3 => 84.4, -2 => 88.1, -1 => 91.8, 0 => 95.4, 1 => 99.1, 2 => 102.7, 3 => 106.4],
        36 => [-3 => 85.0, -2 => 88.7, -1 => 92.4, 0 => 96.1, 1 => 99.8, 2 => 103.5, 3 => 107.2],
        37 => [-3 => 85.5, -2 => 89.2, -1 => 93.0, 0 => 96.7, 1 => 100.5, 2 => 104.2, 3 => 108.0],
        38 => [-3 => 86.0, -2 => 89.8, -1 => 93.6, 0 => 97.4, 1 => 101.2, 2 => 105.0, 3 => 108.8],
        39 => [-3 => 86.5, -2 => 90.3, -1 => 94.2, 0 => 98.0, 1 => 101.8, 2 => 105.7, 3 => 109.5],
        40 => [-3 => 87.0, -2 => 90.9, -1 => 94.7, 0 => 98.6, 1 => 102.5, 2 => 106.4, 3 => 110.3],
        41 => [-3 => 87.5, -2 => 91.4, -1 => 95.3, 0 => 99.2, 1 => 103.2, 2 => 107.1, 3 => 111.0],
        42 => [-3 => 88.0, -2 => 91.9, -1 => 95.9, 0 => 99.9, 1 => 103.8, 2 => 107.8, 3 => 111.7],
        43 => [-3 => 88.4, -2 => 92.4, -1 => 96.4, 0 => 100.4, 1 => 104.5, 2 => 108.5, 3 => 112.5],
        44 => [-3 => 88.9, -2 => 93.0, -1 => 97.0, 0 => 101.0, 1 => 105.1, 2 => 109.1, 3 => 113.2],
        45 => [-3 => 89.4, -2 => 93.5, -1 => 97.5, 0 => 101.6, 1 => 105.7, 2 => 109.8, 3 => 113.9],
        46 => [-3 => 89.8, -2 => 94.0, -1 => 98.1, 0 => 102.2, 1 => 106.3, 2 => 110.4, 3 => 114.6],
        47 => [-3 => 90.3, -2 => 94.4, -1 => 98.6, 0 => 102.8, 1 => 106.9, 2 => 111.1, 3 => 115.2],
        48 => [-3 => 90.7, -2 => 94.9, -1 => 99.1, 0 => 103.3, 1 => 107.5, 2 => 111.7, 3 => 115.9],
        49 => [-3 => 91.2, -2 => 95.4, -1 => 99.7, 0 => 103.9, 1 => 108.1, 2 => 112.4, 3 => 116.6],
        50 => [-3 => 91.6, -2 => 95.9, -1 => 100.2, 0 => 104.4, 1 => 108.7, 2 => 113.0, 3 => 117.3],
        51 => [-3 => 92.1, -2 => 96.4, -1 => 100.7, 0 => 105.0, 1 => 109.3, 2 => 113.6, 3 => 117.9],
        52 => [-3 => 92.5, -2 => 96.9, -1 => 101.2, 0 => 105.6, 1 => 109.9, 2 => 114.2, 3 => 118.6],
        53 => [-3 => 93.0, -2 => 97.4, -1 => 101.7, 0 => 106.1, 1 => 110.5, 2 => 114.9, 3 => 119.2],
        54 => [-3 => 93.4, -2 => 97.8, -1 => 102.3, 0 => 106.7, 1 => 111.1, 2 => 115.5, 3 => 119.9],
        55 => [-3 => 93.9, -2 => 98.3, -1 => 102.8, 0 => 107.2, 1 => 111.7, 2 => 116.1, 3 => 120.6],
        56 => [-3 => 94.3, -2 => 98.8, -1 => 103.3, 0 => 107.8, 1 => 112.3, 2 => 116.7, 3 => 121.2],
        57 => [-3 => 94.7, -2 => 99.3, -1 => 103.8, 0 => 108.3, 1 => 112.8, 2 => 117.4, 3 => 121.9],
        58 => [-3 => 95.2, -2 => 99.7, -1 => 104.3, 0 => 108.9, 1 => 113.4, 2 => 118.0, 3 => 122.6],
        59 => [-3 => 95.6, -2 => 100.2, -1 => 104.8, 0 => 109.4, 1 => 114.0, 2 => 118.6, 3 => 123.2],
        60 => [-3 => 96.1, -2 => 100.7, -1 => 105.3, 0 => 110.0, 1 => 114.6, 2 => 119.2, 3 => 123.9]
    ];

    // Data tinggi badan dalam SD untuk anak perempuan (dalam sentimeter)
    $dataTBperempuan = [
        24 => [-3 => 76.0, -2 => 79.3, -1 => 82.5, 0 => 85.7, 1 => 88.9, 2 => 92.2, 3 => 95.4],
        25 => [-3 => 78.6, -2 => 80.0, -1 => 83.3, 0 => 86.6, 1 => 89.9, 2 => 93.1, 3 => 96.4],
        26 => [-3 => 77.5, -2 => 80.8, -1 => 84.1, 0 => 87.4, 1 => 90.8, 2 => 94.1, 3 => 97.4],
        27 => [-3 => 78.1, -2 => 81.5, -1 => 84.9, 0 => 88.3, 1 => 91.7, 2 => 95.0, 3 => 98.4],
        28 => [-3 => 78.8, -2 => 82.2, -1 => 85.7, 0 => 89.1, 1 => 92.5, 2 => 96.0, 3 => 99.4],
        29 => [-3 => 79.5, -2 => 82.9, -1 => 86.4, 0 => 89.9, 1 => 93.4, 2 => 96.9, 3 => 100.3],
        30 => [-3 => 80.1, -2 => 83.6, -1 => 87.1, 0 => 90.7, 1 => 94.2, 2 => 97.7, 3 => 101.3],
        31 => [-3 => 80.7, -2 => 84.3, -1 => 87.9, 0 => 91.4, 1 => 95.0, 2 => 98.6, 3 => 102.2],
        32 => [-3 => 81.3, -2 => 84.9, -1 => 88.6, 0 => 92.2, 1 => 95.8, 2 => 99.4, 3 => 103.1],
        33 => [-3 => 81.9, -2 => 85.6, -1 => 89.3, 0 => 92.9, 1 => 96.6, 2 => 100.3, 3 => 103.9],
        34 => [-3 => 82.5, -2 => 86.2, -1 => 89.9, 0 => 93.6, 1 => 97.4, 2 => 101.1, 3 => 104.8],
        35 => [-3 => 83.1, -2 => 86.8, -1 => 90.6, 0 => 94.4, 1 => 98.1, 2 => 101.9, 3 => 105.6],
        36 => [-3 => 83.6, -2 => 87.4, -1 => 91.2, 0 => 95.1, 1 => 98.9, 2 => 102.7, 3 => 106.5],
        37 => [-3 => 84.2, -2 => 88.0, -1 => 91.9, 0 => 95.7, 1 => 99.6, 2 => 103.4, 3 => 107.3],
        38 => [-3 => 84.7, -2 => 88.6, -1 => 92.5, 0 => 96.4, 1 => 100.3, 2 => 104.2, 3 => 108.1],
        39 => [-3 => 85.3, -2 => 89.2, -1 => 93.1, 0 => 97.1, 1 => 101.0, 2 => 105.0, 3 => 108.9],
        40 => [-3 => 85.8, -2 => 89.8, -1 => 93.8, 0 => 97.7, 1 => 101.7, 2 => 105.7, 3 => 109.7],
        41 => [-3 => 86.3, -2 => 90.4, -1 => 94.4, 0 => 98.4, 1 => 102.4, 2 => 106.4, 3 => 110.5],
        42 => [-3 => 86.8, -2 => 90.9, -1 => 95.0, 0 => 99.0, 1 => 103.1, 2 => 107.2, 3 => 111.2],
        43 => [-3 => 87.4, -2 => 91.5, -1 => 95.6, 0 => 99.7, 1 => 103.8, 2 => 107.9, 3 => 112.0],
        44 => [-3 => 87.9, -2 => 92.0, -1 => 96.2, 0 => 100.3, 1 => 104.5, 2 => 108.6, 3 => 112.7],
        45 => [-3 => 88.4, -2 => 92.5, -1 => 96.7, 0 => 100.9, 1 => 105.1, 2 => 109.3, 3 => 113.5],
        46 => [-3 => 88.9, -2 => 93.1, -1 => 97.3, 0 => 101.5, 1 => 105.8, 2 => 110.0, 3 => 114.2],
        47 => [-3 => 89.3, -2 => 93.6, -1 => 97.9, 0 => 102.1, 1 => 106.4, 2 => 110.7, 3 => 114.9],
        48 => [-3 => 89.8, -2 => 94.1, -1 => 98.4, 0 => 102.7, 1 => 107.0, 2 => 111.3, 3 => 115.7],
        49 => [-3 => 90.3, -2 => 94.6, -1 => 99.0, 0 => 103.3, 1 => 107.7, 2 => 112.0, 3 => 116.4],
        50 => [-3 => 90.7, -2 => 95.1, -1 => 99.5, 0 => 103.9, 1 => 108.3, 2 => 112.7, 3 => 117.1],
        51 => [-3 => 91.2, -2 => 95.6, -1 => 100.1, 0 => 104.5, 1 => 108.9, 2 => 113.3, 3 => 117.7],
        52 => [-3 => 91.7, -2 => 96.1, -1 => 100.6, 0 => 105.0, 1 => 109.5, 2 => 114.0, 3 => 118.4],
        53 => [-3 => 92.1, -2 => 96.6, -1 => 101.1, 0 => 105.6, 1 => 110.1, 2 => 114.6, 3 => 119.1],
        54 => [-3 => 92.6, -2 => 97.1, -1 => 101.6, 0 => 106.2, 1 => 110.7, 2 => 115.2, 3 => 119.8],
        55 => [-3 => 93.0, -2 => 97.6, -1 => 102.2, 0 => 106.7, 1 => 111.3, 2 => 115.9, 3 => 120.4],
        56 => [-3 => 93.4, -2 => 98.1, -1 => 102.7, 0 => 107.3, 1 => 111.9, 2 => 116.5, 3 => 121.1],
        57 => [-3 => 93.9, -2 => 98.5, -1 => 103.2, 0 => 107.8, 1 => 112.5, 2 => 117.1, 3 => 121.8],
        58 => [-3 => 94.3, -2 => 99.0, -1 => 103.7, 0 => 108.4, 1 => 113.0, 2 => 117.7, 3 => 122.4],
        59 => [-3 => 94.7, -2 => 99.5, -1 => 104.2, 0 => 108.9, 1 => 113.6, 2 => 118.3, 3 => 123.1],
        60 => [-3 => 95.2, -2 => 99.9, -1 => 104.7, 0 => 109.4, 1 => 114.2, 2 => 118.9, 3 => 123.7]
    ];


    // Pastikan array $tinggi memiliki elemen yang cukup untuk mengakses indeks yang diperlukan
    // Tentukan data berdasarkan jenis kelamin
    if ($jenis_kelamin == 'l') {
        $data = $dataTBlaki;
    } elseif ($jenis_kelamin == 'p') {
        $data = $dataTBperempuan;
    } else {
        return "Jenis kelamin tidak valid";
    }

    // Cek apakah data untuk usia tersedia
    if (!isset($data[$usia])) {
        return "Usia tidak valid";
    }

    $tinggi = $data[$usia];

    // Pastikan array $tinggi memiliki elemen yang cukup untuk mengakses indeks yang diperlukan
    if (count($tinggi) < 5) {
        return "Data tinggi badan tidak lengkap";
    }

    // return $tinggi;
    // Evaluasi status tinggi badan berdasarkan standar
    $z_score = null;

    if ($tinggi_badan < $tinggi[-3]) {
        $z_score = -3; // Sangat Pendek (Stunted)
    } elseif ($tinggi_badan >= $tinggi[-3] && $tinggi_badan < $tinggi[-2]) {
        $z_score = -2; // Pendek
    } elseif ($tinggi_badan >= $tinggi[-2] && $tinggi_badan <= $tinggi[0]) {
        $z_score = 0; // Normal
    } elseif ($tinggi_badan > $tinggi[0] && $tinggi_badan <= $tinggi[1]) {
        $z_score = 2; // Tinggi
    } else {
        $z_score = 3; // Sangat Tinggi
    }

    if ($z_score < -3) {
        return "Sangat Pendek (Stunted)";
    } elseif ($z_score >= -3 && $z_score < -2) {
        return "Pendek";
    } elseif ($z_score >= -2 && $z_score <= 1) {
        return "Normal";
    } elseif ($z_score > 1 && $z_score <= 2) {
        return "Tinggi";
    } else {
        return "Sangat Tinggi";
    }
}
