<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relasi;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;

class LapBukuBesarController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $acc_list=DB::table('account')->select('id','nama','kode')->where('header','N')->where('aktif','Y')->get();
        $menu='lap_buku_besar';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('LBUKUB');
        return view('admin.lap_buku_besar',compact('menu','acc_list','hak_akses'));
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
     
        $sd = DB::table('saldo_awal') 
                ->where('cha',$request->account)
                ->where('dk','D')
                ->sum('nilai');
        $sk = DB::table('saldo_awal') 
                ->where('cha',$request->account)
                ->where('dk','K')
                ->sum('nilai');
        $debet1 = DB::table('kaskd as km')
                ->leftJoin('kask as t','t.bukti','km.bukti')  
                ->where('cha',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('km.nilai');
        $kredit1 = DB::table('kasmd  as km') 
                ->leftJoin('kasm as t','t.bukti','km.bukti')  
                ->where('cha',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('km.nilai');                
        $debet2 = DB::table('bankkd  as km') 
                ->leftJoin('bankk as t','t.bukti','km.bukti')  
                ->where('cha',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('km.nilai');
        $kredit2 = DB::table('bankmd as km') 
                ->leftJoin('bankm as t','t.bukti','km.bukti')  
                ->where('cha',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('km.nilai');
        $debet3 = DB::table('jurumd as km') 
                ->leftJoin('jurum as t','t.bukti','km.bukti')  
                ->where('cha',$request->account)
                ->where('dk','D')
                ->where('tgl','<',$tgl1)
                ->sum('km.nilai');
        $kredit3 = DB::table('jurumd as km') 
                ->leftJoin('jurum as t','t.bukti','km.bukti')  
                ->where('cha',$request->account)
                ->where('dk','K')
                ->where('tgl','<',$tgl1)
                ->sum('km.nilai');
                
        $sawal=$sd-$sk+$debet1-$kredit1+$debet2-$kredit2+$debet3-$kredit3;  
        $nacc=DB::table('account')->where('id',$request->account)->value('nama');
        $data1 = DB::table('kasmd as km')->select('km.bukti','tgl',DB::raw("0 as debet"),'km.nilai as kredit','km.uraian')
                ->leftJoin('kasm as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('tgl','>=','$tgl1')
                ->where('tgl','<=','$tgl2');                            

        $data2 = DB::table('kaskd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('kask as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('tgl','>=','$tgl1')
                ->where('tgl','<=','$tgl2');

        $data3 = DB::table('bankmd as km')->select('km.bukti','tgl',DB::raw("0 as debet"),'km.nilai as kredit','km.uraian')
                ->leftJoin('bankm as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('tgl','>=','$tgl1')
                ->where('tgl','<=','$tgl2');                           

        $data4 = DB::table('bankkd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('bankk as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('tgl','>=','$tgl1')
                ->where('tgl','<=','$tgl2');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
                
        $data5 = DB::table('jurumd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('jurum as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('dk','D')
                ->where('tgl','>=','$tgl1')
                ->where('tgl','<=','$tgl2');                                        

        $data = DB::table('jurumd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('jurum as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('dk','K')
                ->where('tgl','>=','$tgl1')
                ->where('tgl','<=','$tgl2')    
                ->union($data1)
                ->union($data2)
                ->union($data3)
                ->union($data4)
                ->union($data5)
                ->orderby('tgl','asc')
                ->orderby('bukti','asc')
                ->get();         
        $pdf = PDF::loadView('admin.pdf_lap_buku_besar', compact('data','bln1','bln2','thn','nacc','sawal'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_buku_besar.pdf');
    }

}
