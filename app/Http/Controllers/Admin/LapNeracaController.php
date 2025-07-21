<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class LapNeracaController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $menu='lap_neraca';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('LNERACA');
        return view('admin.lap_neraca',compact('menu','hak_akses'));
    }

    public function cetak(Request $request)
    {
        $bln=$request->bln1;
        $thn=$request->thn;

        $saldo='';
        for($i=1;$i<=$bln;$i++){
            if($saldo!='') $saldo=$saldo.'+';
            $saldo=$saldo.'d'.$i.'-'.'k'.$i;
        }
        $saldo=$saldo.' as saldo';
        $aktif='Y';
        $jns_aktiva='A';
        $jns_pasiva='P';
       //DB::enableQueryLog();
        $aktiva = DB::table('account as a')->selectRaw("id,kode,nama,header,$saldo")
                        ->leftjoin('mut_saldo as m',function ($join) use ($thn) {
                            $join->on('m.cha','a.id')
                                 ->where('m.thn', $thn);
                        })
                ->where('a.aktif',$aktif)
                ->where('a.jenis', $jns_aktiva)
                ->orderby('kode','asc')
                ->get();

        $pasiva = DB::table('account as a')->selectRaw("id,kode,nama,header,$saldo")
                        ->leftjoin('mut_saldo as m',function ($join) use ($thn) {
                            $join->on('m.cha','a.id')
                                 ->where('m.thn', $thn);
                        })
                ->where('a.aktif',$aktif)
                ->where('a.jenis', $jns_pasiva)
                ->orderby('kode','asc')
                ->get();        
                
        $pdf = PDF::loadView('admin.pdf_lap_neraca', compact('aktiva','pasiva','bln','thn'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_neraca.pdf');
    }
}
