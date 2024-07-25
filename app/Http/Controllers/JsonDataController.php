<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class JsonDataController extends Controller
{
    public function getData($filename)
    {
        // Buat path ke file JSON
        $path = 'data/' . $filename . '.json';

        // Cek apakah file ada
        if (!Storage::exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Baca isi file
        $content = Storage::get($path);
        $json = json_decode($content, true);
        return response()->json($json);
    }

    public function getDataMap()
    {
        $path = 'data/map.json';
        if (!Storage::exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $content = Storage::get($path);
        $json = json_decode($content, true);

        return response()->json($json);
    }
}
