<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relasi;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class LapRekapBukuBesarController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $acc_list=DB::table('account')->select('id','nama','kode')->where('header','N')->where('aktif','Y')->get();
        $menu='lap_buku_besar';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('LRBUKUB');
        return view('admin.lap_rekap_buku_besar',compact('menu','acc_list','hak_akses'));
    }

    public function cetak(Request $request)
    {
        $bln1=$request->bln1;
        $bln2=$request->bln2;
        $thn=$request->thn;
        $tgl1=date("Y-m-d", strtotime($request->thn.'-'.$request->bln1.'-1')); 
        $tgl1="'$tgl1'";
        if($request->bln2<12){
            $tgl_akhir=date('t',strtotime($request->thn.'-'.$request->bln2.'-1'));
            $tgl2=date("Y-m-d", strtotime($request->thn.'-'.$request->bln2.'-'.$tgl_akhir)); 
        } else {
            $tgl2=date("Y-m-d", strtotime($request->thn.'-12-31')); 
        }    
        $tgl2="'$tgl2'";
        $data = DB::table('account')->select('id','kode','nama','header')
                ->where('aktif','Y')
                ->orderby('kode','asc')
                ->get();         
        $pdf = PDF::loadView('admin.pdf_lap_rekap_buku_besar', compact('data','bln1','bln2','thn'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_buku_besar.pdf');
    }

}
