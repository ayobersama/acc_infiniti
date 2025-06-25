<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankKeluar;
use App\Models\BankKeluarDetail;
use Illuminate\Support\Facades\Validator;
use DB;

class BankKeluarController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $bankk = DB::table('bankk as k')->select('bukti', 'tgl', 'bank', 'a.nama as nbank', 'k.relasi','r.nama as nrelasi', 'nilai', 'status')
                ->leftjoin('relasi as r','r.id','k.relasi')
                ->leftjoin('account as a','a.id','k.bank')
                ->get();
        $menu='bankk';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('BANKK');
        return view('admin.bankk',compact('menu','bankk','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='bankk';
        $bank_list=DB::table('account')->select('id','nama','kode')->where('kb','B')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        return view('admin.tambah_bankk', compact('menu','bank_list','relasi_list','acc_list'));
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
            'bank'=>$request->bank,
            'relasi'=>$request->relasi,
            'ket'=>$request->ket,
            'nilai'=>0,
            'status'=>'0'
        );
        BankKeluar::create($data);            
        return response()->json(['success'=>true]);     
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $bankk = DB::table('bankk')->where('bukti',$id)->first();
        $bankd = DB::table('bankkd')->where('bukti',$id)->get();

        $bank_list=DB::table('account')->select('id','nama','kode')->where('kb','B')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='bankk';
        return view('admin.edit_bankk', compact('menu','bankk','bankd','bank_list','relasi_list','acc_list'));
    }

    public function update(Request $request, $id)
    {
        //update data
        if(isset($request->tgl))
            $tgl=FormatTglDB($request->tgl);
        else $tgl=null;

        $data=array(
            'tgl'=>$tgl,
            'bank'=>$request->bank,
            'relasi'=>$request->relasi,
            'ket'=>$request->ket,
        );   
        BankKeluar::where('bukti',$id)->update($data);

        return response()->json(['success'=>true]);   
    }

    public function destroy($id)
    {
        //hapus data
        BankKeluar::where('bukti',$id)->delete();
        return redirect('admin/bankk')->with('success', 'Data sudah berhasil dihapus');
    }

    public function tampilkan_detail($id)
    {
        $bankm=DB::table('bankk')->select('nilai')->where('bukti',$id)->get();
        $bankd=DB::table('bankkd as d')->select('d.id','d.cha','a.kode','a.nama','d.uraian','d.nilai')
                      ->leftjoin('account as a','a.id','d.cha')
                      ->where('bukti',$id)->orderby('d.id')->get();   
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('BANKK');                      
        return view('admin.detail_bankk', compact('bankm','bankd','hak_akses'));
    }

    public function edit_detail($id)
    {
        //tampilkan form edit data
        $bankd = DB::table('bankkd')->where('id',$id)->first();
        return response()->json($bankd); 
    }


    public function simpan_detail(Request $request)
    {
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;      
        
        $data=array(
            'bukti'=>$request->bukti,
            'cha'=>$request->account,
            'dk'=>'D',
            'uraian'=>$request->uraian,
            'nilai'=>$nilai,
        );
        BankKeluarDetail::create($data);

        $total=DB::table('bankkd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        BankKeluar::where('bukti',$request->bukti)->update($data);

        return response()->json(['success'=>true]);  
    }

    public function hapus_detail($id)
    {
        //tampilkan form edit data
        $bukti=DB::table('bankkd')->where('id',$id)->value('bukti');
        DB::table('bankkd')->where('id',$id)->delete();
        $total=DB::table('kaskd')->where('bukti',$bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        BankKeluar::where('bukti',$bukti)->update($data);
        return response()->json(['success'=>true]);  
    }

    public function update_detail(Request $request, $id)
    {
        //update data
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;      
        $data=array(
            'cha'=>$request->account,
            'uraian'=>$request->uraian,
            'nilai'=>$nilai,
        );
        BankKeluarDetail::whereId($id)->update($data);

        $total=DB::table('bankkd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        BankKeluar::where('bukti',$request->bukti)->update($data);

        return response()->json(['success'=>true]);  
    }
}
