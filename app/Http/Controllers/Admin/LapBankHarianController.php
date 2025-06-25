<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relasi;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class LapBankHarianController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $bank_list=DB::table('account')->select('id','nama','kode')->where('kb','B')->where('aktif','Y')->get();
        $menu='lap_bank_harian';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('LBANKH');
        return view('admin.lap_bank_harian',compact('menu','bank_list','hak_akses'));
    }

    public function cetak(Request $request)
    {
        $tgl1=$request->tgl1;
        $tgl2=$request->tgl2;
        $tgl1a=FormatTglDB($tgl1);
        $tgl2a=FormatTglDB($tgl2);
        $sd = DB::table('saldo_awal') 
                ->where('cha',$request->bank)
                ->where('dk','D')
                ->sum('nilai');
        $sk = DB::table('saldo_awal') 
                ->where('cha',$request->bank)
                ->where('dk','K')
                ->sum('nilai');
        $debet = DB::table('bankm') 
                ->where('bank',$request->bank)
                ->where('tgl','<',$tgl1a)
                ->sum('nilai');
        $kredit = DB::table('bankk') 
                ->where('bank',$request->bank)
                ->where('tgl','<',$tgl1a)
                ->sum('nilai');
        $sawal=$sd-$sk+$debet-$kredit;  
        $nbank=DB::table('account')->where('id',$request->bank)->value('nama');
        $data2 = DB::table('bankk as km')->select('km.bukti','km.tgl','r.nama as nrelasi',DB::raw("0 as debet"),'km.nilai as kredit','km.ket')
                ->leftJoin('relasi as r','r.id','km.relasi')
                ->where('bank',$request->bank)
                ->where('tgl','>=',$tgl1a)
                ->where('tgl','<=',$tgl2a);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               

        $data = DB::table('bankm as km')->select('km.bukti','km.tgl','r.nama as nrelasi','km.nilai as debet',DB::raw("0 as kredit"),'km.ket')
                ->leftJoin('relasi as r','r.id','km.relasi')
                ->where('bank',$request->bank)
                ->where('tgl','>=',$tgl1a)
                ->where('tgl','<=',$tgl2a)
                ->union($data2)
                ->orderby('tgl','asc')
                ->orderby('bukti','asc')
                ->get();           
       
        $pdf = PDF::loadView('admin.pdf_lap_bank_harian', compact('data','tgl1','tgl2','nbank','sawal'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_bank_harian.pdf');
    }

}
