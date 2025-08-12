<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class LapLabaRugiController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $menu='lap_laba_rugi';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('LLABARUGI');
        return view('admin.lap_laba_rugi',compact('menu','hak_akses'));
    }

    public function cetak(Request $request)
    {
        $bln=$request->bln1;
        $thn=$request->thn;
        $saldo='d'.$bln.'-'.'k'.$bln;
        $saldo=$saldo.' as saldo';
        $aktif='Y';
        $jns_aktiva='D';
        $jns_pasiva='B';
       //DB::enableQueryLog();
        $pendapatan = DB::table('account as a')->selectRaw("id,kode,nama,jenis,header,$saldo")
                        ->leftjoin('mut_saldo as m',function ($join) use ($thn) {
                            $join->on('m.cha','a.id')
                                 ->where('m.thn', $thn);
                        })
                ->where('a.aktif',$aktif)
                ->where('a.jenis', $jns_aktiva)
                ->orderby('kode','asc')
                ->get();

        $biaya = DB::table('account as a')->selectRaw("id,kode,nama,jenis,header,$saldo")
                        ->leftjoin('mut_saldo as m',function ($join) use ($thn) {
                            $join->on('m.cha','a.id')
                                 ->where('m.thn', $thn);
                        })
                ->where('a.aktif',$aktif)
                ->where('a.jenis', $jns_pasiva)
                ->orderby('kode','asc')
                ->get();  

        $pdf = PDF::loadView('admin.pdf_lap_laba_rugi', compact('pendapatan','biaya','bln','thn'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_laba_rugi.pdf');
    }

}
