<?php

namespace App\Http\Controllers;

use App\Models\posyandu;
use Illuminate\Http\Request;

class PosyanduController extends Controller
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
        posyandu::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil diimpor');
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
    public function edit(posyandu $posyandu)
    {
        return view('user_admin.posyandu.edit', compact('posyandu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, posyandu $posyandu)
    {
        $posyandu->update($request->all());
        return redirect('/admin/posyandu');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(posyandu $posyandu)
    {
        $posyandu->delete();
        return redirect()->back()->with('success','Data Berhasil Dihapus');
    }
}
