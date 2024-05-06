<?php

namespace App\Http\Controllers;

use App\Models\anak;
use App\Models\posyandu;
use Illuminate\Http\Request;

class AnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        anak::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(anak $anak)
    {
        // dd($anak);
        $posyandu = posyandu::all();
        return view('user_admin.anak.edit', compact('anak','posyandu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, anak $anak)
    {
        $anak->update($request->all());
        return redirect()->back()->with('success','Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(anak $anak)
    {
        $anak->delete();
        return redirect()->back()->with('success','Data Berhasil Dihapus');
    }
}
