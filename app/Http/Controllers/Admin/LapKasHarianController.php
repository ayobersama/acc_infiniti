<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relasi;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class LapKasHarianController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $kas_list=DB::table('account')->select('id','nama','kode')->where('kb','K')->where('aktif','Y')->get();
        $menu='lap_kas_harian';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('LKASH');
        return view('admin.lap_kas_harian',compact('menu','kas_list','hak_akses'));
    }

    public function cetak(Request $request)
    {
        $tgl1=$request->tgl1;
        $tgl2=$request->tgl2;
        $tgl1a=FormatTglDB($tgl1);
        $tgl2a=FormatTglDB($tgl2);
        $sd = DB::table('saldo_awal') 
                ->where('cha',$request->kas)
                ->where('dk','D')
                ->sum('nilai');
        $sk = DB::table('saldo_awal') 
                ->where('cha',$request->kas)
                ->where('dk','K')
                ->sum('nilai');
        $debet = DB::table('kasm') 
                ->where('kas',$request->kas)
                ->where('tgl','<',$tgl1a)
                ->sum('nilai');
        $kredit = DB::table('kask') 
                ->where('kas',$request->kas)
                ->where('tgl','<',$tgl1a)
                ->sum('nilai');
        $sawal=$sd-$sk+$debet-$kredit;        
        $nkas=DB::table('account')->where('id',$request->kas)->value('nama');
        $data2 = DB::table('kask as km')->select('km.bukti','km.tgl','r.nama as nrelasi',DB::raw("0 as debet"),'km.nilai as kredit','km.ket')
                ->leftJoin('relasi as r','r.id','km.relasi')
                ->where('kas',$request->kas)
                ->where('tgl','>=',$tgl1a)
                ->where('tgl','<=',$tgl2a);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               

        $data = DB::table('kasm as km')->select('km.bukti','km.tgl','r.nama as nrelasi','km.nilai as debet',DB::raw("0 as kredit"),'km.ket')
                ->leftJoin('relasi as r','r.id','km.relasi')
                ->where('kas',$request->kas)
                ->where('tgl','>=',$tgl1a)
                ->where('tgl','<=',$tgl2a)
                ->union($data2)
                ->orderby('tgl','asc')
                ->orderby('bukti','asc')
                ->get();           
        //dd($data);
        //$customPaper  = [0, 0, 567.00, 500.80];
        $pdf = PDF::loadView('admin.pdf_lap_kas_harian', compact('data','tgl1','tgl2','nkas','sawal'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_kas_harian.pdf');
    }

}
