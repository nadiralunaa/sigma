<?php

namespace App\Http\Controllers;

use App\Models\anak;
use App\Models\posyandu;
use Illuminate\Http\Request;

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
        return view('user_posyandu.dashboard');
    }

    public function ortu(){
        return view('user_ortu.dashboard');
    }
}
