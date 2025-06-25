<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JurnalUmum;
use App\Models\JurnalUmumDetail;
use Illuminate\Support\Facades\Validator;
use DB;

class JurumController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $jurum = DB::table('jurum')->select('bukti', 'tgl',  'ket', 'tdebet', 'tkredit', 'status')
                ->orderby('bukti','desc')
                ->get();
        $menu='jurum';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('jurum');
        return view('admin.jurum',compact('menu','jurum','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='jurum';
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        return view('admin.tambah_jurum', compact('menu','acc_list'));
    }

    public function store(Request $request)
    {
        //tambahkan data
        if(isset($request->tgl))
            $tgl=FormatTglDB($request->tgl);
        else $tgl=null;

        $data=array(
            'bukti'=>$request->bukti,
            'tgl'=>$tgl,
            'ket'=>$request->ket,
            'status'=>'0'
        );
        JurnalUmum::create($data);            
        return response()->json(['success'=>true]);     
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $jurum = DB::table('jurum')->where('bukti',$id)->first();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='jurum';
        return view('admin.edit_jurum', compact('menu','jurum','acc_list'));
    }

    public function update(Request $request, $id)
    {
        //update data
        if(isset($request->tgl))
            $tgl=FormatTglDB($request->tgl);
        else $tgl=null;

        $data=array(
            'tgl'=>$tgl,
            'ket'=>$request->ket,
        );   
        JurnalUmum::where('bukti',$id)->update($data);

        return response()->json(['success'=>true]);   
    }

    public function destroy($id)
    {
        //hapus data
        JurnalUmum::where('bukti',$id)->delete();
        return redirect('admin/jurum')->with('success', 'Data sudah berhasil dihapus');
    }

    public function tampilkan_detail($id)
    {
        $jurumd=DB::table('jurumd as d')->select('d.id','d.cha','a.kode','d.dk','a.nama','d.uraian','d.nilai')
                      ->leftjoin('account as a','a.id','d.cha')
                      ->where('bukti',$id)->orderby('d.id')->get();   
        $jurum=DB::table('jurum')->select('tdebet','tkredit')->where('bukti',$id)->get();                 
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('jurum');                      
        return view('admin.detail_jurum', compact('jurum','jurumd','hak_akses'));
    }

    public function edit_detail($id)
    {
        //tampilkan form edit data
        $jurumd = DB::table('jurumd')->where('id',$id)->first();
        return response()->json($jurumd); 
    }


    public function simpan_detail(Request $request)
    {
         //tambahkan data
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;      
        
        $data=array(
            'bukti'=>$request->bukti,
            'cha'=>$request->account,
            'dk'=>$request->dk,
            'uraian'=>$request->uraian,
            'nilai'=>$nilai,
        );
        JurnalUmumDetail::create($data);

        $totald=DB::table('jurumd')->where('bukti',$request->bukti)->where('dk','D')->sum('nilai');
        $totalk=DB::table('jurumd')->where('bukti',$request->bukti)->where('dk','K')->sum('nilai');
        $data=array(
            'tdebet'=>$totald,
            'tkredit'=>$totalk,
        );
        
        JurnalUmum::where('bukti',$request->bukti)->update($data);
        return response()->json(['success'=>true]);  
    }

    public function hapus_detail($id)
    {
        //tampilkan form edit data
        $bukti=DB::table('jurumd')->where('id',$id)->value('bukti');

        DB::table('jurumd')->where('id',$id)->delete();
       
        $totald=DB::table('jurumd')->where('bukti',$bukti)->where('dk','D')->sum('nilai');
        $totalk=DB::table('jurumd')->where('bukti',$bukti)->where('dk','K')->sum('nilai');
        $data=array(
            'tdebet'=>$totald,
            'tkredit'=>$totalk,
        );
        JurnalUmum::where('bukti',$bukti)->update($data);
        
        return response()->json(['success'=>true]);  
    }

    public function update_detail(Request $request, $id)
    {
        //update data
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;      
        $data=array(
            'cha'=>$request->account,
            'uraian'=>$request->uraian,
            'dk'=>$request->dk,
            'nilai'=>$nilai,
        );
        JurnalUmumDetail::whereId($id)->update($data);

        $totald=DB::table('jurumd')->where('bukti',$request->bukti)->where('dk','D')->sum('nilai');
        $totalk=DB::table('jurumd')->where('bukti',$request->bukti)->where('dk','K')->sum('nilai');
        $data=array(
            'tdebet'=>$totald,
            'tkredit'=>$totalk,
        );
        JurnalUmum::where('bukti',$request->bukti)->update($data);
        
        return response()->json(['success'=>true]);  
    }
}
