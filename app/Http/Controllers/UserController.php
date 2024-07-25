<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        //dd($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'kode_posyandu' => $request->kode_posyandu,
            'password' => Hash::make($request->password),
            'kode_roles' => 2, // kode_roles untuk posyandu
            'alamat_users' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);



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
    public function edit(User $user)
    {
        $posyandu = posyandu::all();
        return view('user_admin.user.edit', compact('user','posyandu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success','Data Berhasil Dihapus');
    }
}
