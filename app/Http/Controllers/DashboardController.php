<?php

namespace App\Http\Controllers;

use App\Models\anak;
use App\Models\posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $jmlPos = posyandu::count();
        $jmlAnak = anak::count();
        // dd($jmlPos);
        $pos = posyandu::all()->take(5);
        $anak = anak::all()->take(5);
        return view('user_admin.dashboard',compact('jmlPos','jmlAnak','pos','anak'));
    }

    public function posyandu(){
        $user = Auth::user();
        $kode_pos = $user->kode_posyandu;
        $jmlAnak = anak::where('kode_posyandu','=',$kode_pos)->count();
        $anak = anak::where('kode_posyandu','=',$kode_pos)->get();
        $pos = posyandu::where('id','=',$kode_pos)->get()->first();
        //dd($anak);
        return view('user_posyandu.dashboard', compact('user','jmlAnak','anak','pos'));
    }

    public function ortu(){
        return view('user_ortu.dashboard');
    }

    public function guest(){
        $jmlPos = posyandu::count();
        $jmlAnak = anak::count();
        $pos = posyandu::all();
        return view('user_guest.dashboard',compact('jmlPos','jmlAnak','pos'));
    }
}
