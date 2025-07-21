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
        $menu='lap_rekap_buku_besar';
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
        $sa='sa';
        for($i=1;$i<$bln1;$i++){
            $sa=$sa.'+d'.$i.'-k'.$i;
        }
        $sa=$sa.' as sa';
        $md='';$mk='';
        for($i=$bln1;$i<=$bln2;$i++){
            if($md!='') $md=$md.'+';
            if($mk!='') $mk=$mk.'+';
            $md=$md.'d'.$i;
            $mk=$mk.'k'.$i;
        }
        $md=$md.' as md';
        $mk=$mk.' as mk';
        $aktif='Y';
        //DB::enableQueryLog();
        $data = DB::table('account as a')->selectRaw("id,kode,nama,header,$sa,$md,$mk")
                        ->leftjoin('mut_saldo as m',function ($join) use ($thn) {
                                $join->on('m.cha','a.id')
                                    ->where('m.thn', $thn);
                            })
                        ->where('a.aktif',$aktif)
                        ->orderby('kode','asc')
                        ->get();
        //dd(DB::getQueryLog());        
        //dd($data);        
        $pdf = PDF::loadView('admin.pdf_lap_rekap_buku_besar', compact('data','bln1','bln2','thn'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_rekap_buku_besar.pdf');
    }

}
