<?php

namespace App\Http\Controllers;

use App\Models\anak;
use App\Models\posyandu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function posyandu(){
        $posyandu = posyandu::all();
        return view('user_admin.posyandu.index',compact('posyandu'));
    }

    public function anak(){
        $user = Auth::user();
        if ($user->kode_roles==2){
            $kode_pos = $user->kode_posyandu;
            $anak = anak::where('kode_posyandu','=',$kode_pos)->get();
            $posyandu = posyandu::where('id','=',$kode_pos)->get()->first();
            //dd($posyandu);
            return view('user_posyandu.anak.index',compact('user','anak','posyandu'));
        }else{
            $anak = anak::all();
            $posyandu = posyandu::all();
            return view('user_admin.anak.index',compact('anak','posyandu'));
        }
    }

    public function user(){
        $users = User::where('kode_roles','=','2')->get();
        $posyandu = posyandu::all();
        //dd($user);
        return view('user_admin.user.index',compact('users','posyandu'));
    }

}
