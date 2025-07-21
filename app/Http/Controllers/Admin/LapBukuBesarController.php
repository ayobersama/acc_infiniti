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
        $tgl1="$tgl1";
        if($request->bln2<12){
            $tgl_akhir=date('t',strtotime($request->thn.'-'.$request->bln2.'-1'));
            $tgl2=date("Y-m-d", strtotime($request->thn.'-'.$request->bln2.'-'.$tgl_akhir)); 
        } else {
            $tgl2=date("Y-m-d", strtotime($request->thn.'-12-31')); 
        }    
        $tgl2="$tgl2";

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
        $debet4 = DB::table('kask')
                ->where('kas',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('nilai');
        $kredit4 = DB::table('kasm') 
                ->where('kas',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('nilai');                          
        $debet5 = DB::table('bankk')
                ->where('bank',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('nilai');
        $kredit5 = DB::table('bankm') 
                ->where('bank',$request->account)
                ->where('tgl','<',$tgl1)
                ->sum('nilai');                 
        $dk1='D';
        $dk2='K';        
        $sawal=$sd-$sk+$debet1-$kredit1+$debet2-$kredit2+$debet3-$kredit3;  
        $nacc=DB::table('account')->where('id',$request->account)->value('nama');
        $data1 = DB::table('kasmd as km')->select('km.bukti','tgl',DB::raw("0 as debet"),'km.nilai as kredit','km.uraian')
                ->leftJoin('kasm as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);                            

        $data2 = DB::table('kaskd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('kask as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]); 

        $data3 = DB::table('bankmd as km')->select('km.bukti','tgl',DB::raw("0 as debet"),'km.nilai as kredit','km.uraian')
                ->leftJoin('bankm as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);                        

        $data4 = DB::table('bankkd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('bankk as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                
        $data5 = DB::table('jurumd as km')->select('km.bukti','tgl',DB::raw("0 as debet"),'km.nilai as kredit','km.uraian')
                ->leftJoin('jurum as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('dk',$dk2)
                ->whereBetween('tgl',[$tgl1,$tgl2]);                                       

        $data6 = DB::table('kasm')->select('bukti','tgl','nilai as debet',DB::raw("0 as kredit"),'ket')
                ->where('kas',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);                            
        
        $data7 = DB::table('kask')->select('bukti','tgl',DB::raw("0 as debet"),'nilai as kredit','ket')
                ->where('kas',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);           
                
        $data8 = DB::table('bankm')->select('bukti','tgl','nilai as debet',DB::raw("0 as kredit"),'ket')
                ->where('bank',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);                  
        
        $data9 = DB::table('bankk')->select('bukti','tgl',DB::raw("0 as debet"),'nilai as kredit','ket')
                ->where('bank',$request->account)
                ->whereBetween('tgl',[$tgl1,$tgl2]);

       //DB::enableQueryLog();
        $data = DB::table('jurumd as km')->select('km.bukti','tgl','km.nilai as debet',DB::raw("0 as kredit"),'km.uraian')
                ->leftJoin('jurum as t','t.bukti','km.bukti')
                ->where('cha',$request->account)
                ->where('dk',$dk1)
                ->whereBetween('tgl',[$tgl1,$tgl2])
                ->unionAll($data1)
                ->unionAll($data2)
                ->unionAll($data3)
                ->unionAll($data4)
                ->unionAll($data5)
                ->unionAll($data6)
                ->unionAll($data7)
                ->unionAll($data8)
                ->unionAll($data9) 
                ->orderby('tgl','asc')
                ->orderby('bukti','asc')
                ->get();      
      //dd(DB::getQueryLog());   
      //dd($data);               

        $pdf = PDF::loadView('admin.pdf_lap_buku_besar', compact('data','bln1','bln2','thn','nacc','sawal'))->setPaper('a4', 'portrait');
        return $pdf->download('lap_buku_besar.pdf');
    }

}
