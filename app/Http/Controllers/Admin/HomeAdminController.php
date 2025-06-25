<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeAdminController extends Controller
{
    public function __construct()
    {
 
    }

    public function index()
    {
        $userid=Auth::guard('admin')->user()->id;
        //$hak_akses=DB::table('akses_menu')->where('userid',$userid)->get();
        $hak_akses=[];
        return view('admin.dashboard',['menu' => 'dashboard','hak_akses'=>$hak_akses]);
    }
}
