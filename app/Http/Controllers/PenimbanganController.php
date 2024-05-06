<?php

namespace App\Http\Controllers;

use App\Models\anak;
use App\Models\penimbangan;
use App\Models\sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
        $riwayat = penimbangan::where("kode_anak","=", $anak->id)->get()->all();
        return view('user_admin.timbang', compact('anak','riwayat'));
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

        //dd($request->all());
        // dd($validatedData);
        // Lakukan proses penyimpanan nilai koreksi ke database
        $sensorData = new penimbangan();
        $sensorData->berat_asli = $validatedData['beratasli'];
        $sensorData->tinggi_asli = $validatedData['tinggiasli'];
        $sensorData->berat_sensor = $validatedData['beratsensor'];
        $sensorData->tinggi_sensor = $validatedData['tinggisensor'];
        $sensorData->umur = $request['umur'];
        // Menggunakan Carbon untuk format tanggal
        $tanggalTimbang = date('Y-m-d H:i:s', strtotime($validatedData['tanggal']));
        $sensorData->tanggal_timbang = $tanggalTimbang;
        // pake rumus
        $sensorData->status_bb = "baik";
        $sensorData->status_tb = "baik";
        $sensorData->status_gizi = "baik";
        $sensorData->kode_anak = $request['id_anak'];
        $sensorData->save();

        //dd($sensorData);

        return redirect()->back()->with('success', 'Data berhasil ditambah');
    }
}
