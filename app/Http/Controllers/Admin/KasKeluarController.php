<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasKeluar;
use App\Models\KasKeluarDetail;
use App\Models\MutasiSaldo;
use Illuminate\Support\Facades\Validator;
use DB;

class KasKeluarController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $kask = DB::table('kask as k')->select('bukti', 'tgl', 'kas', 'a.nama as nkas', 'k.relasi','r.nama as nrelasi', 'nilai', 'status')
                ->leftjoin('relasi as r','r.id','k.relasi')
                ->leftjoin('account as a','a.id','k.kas')
                ->get();
        $menu='kask';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('KASK');
        return view('admin.kask',compact('menu','kask','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='kask';
        $kas_list=DB::table('account')->select('id','nama','kode')->where('kb','K')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        return view('admin.tambah_kask', compact('menu','kas_list','relasi_list','acc_list'));
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
            'kas'=>$request->kas,
            'relasi'=>$request->relasi,
            'ket'=>$request->ket,
            'nilai'=>0,
            'status'=>'0'
        );
        KasKeluar::create($data);            
        return response()->json(['success'=>true]);     
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $kask = DB::table('kask')->where('bukti',$id)->first();
        $kasd = DB::table('kaskd')->where('bukti',$id)->get();

        $kas_list=DB::table('account')->select('id','nama','kode')->where('kb','K')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='kask';
        return view('admin.edit_kask', compact('menu','kask','kasd','kas_list','relasi_list','acc_list'));
    }

    public function update(Request $request, $id)
    {
        //update data
        
        if(isset($request->tgl))
            $tgl=FormatTglDB($request->tgl);
        else $tgl=null;

        $data=array(
            'tgl'=>$tgl,
            'kas'=>$request->kas,
            'relasi'=>$request->relasi,
            'ket'=>$request->ket,
        );   
        KasKeluar::where('bukti',$id)->update($data);

        return response()->json(['success'=>true]);   
    }

    public function destroy($id)
    {
        //hapus data
        KasKeluar::where('bukti',$id)->delete();
        return redirect('admin/kask')->with('success', 'Data sudah berhasil dihapus');
    }

    public function tampilkan_detail($id)
    {
        $kasm=DB::table('kask')->select('nilai')->where('bukti',$id)->get();
        $kasd=DB::table('kaskd as d')->select('d.id','d.cha','a.kode','a.nama','d.uraian','d.nilai')
                      ->leftjoin('account as a','a.id','d.cha')
                      ->where('bukti',$id)->orderby('d.id')->get();   
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('KASK');                      
        return view('admin.detail_kask', compact('kasm','kasd','hak_akses'));
    }

    public function edit_detail($id)
    {
        //tampilkan form edit data
        $kasd = DB::table('kaskd')->where('id',$id)->first();
        return response()->json($kasd); 
    }


    public function simpan_detail(Request $request)
    {
         //tambahkan data
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;      
        
        $data=array(
            'bukti'=>$request->bukti,
            'cha'=>$request->account,
            'dk'=>'D',
            'uraian'=>$request->uraian,
            'nilai'=>$nilai,
        );
        KasKeluarDetail::create($data);

        $total=DB::table('kaskd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        KasKeluar::where('bukti',$request->bukti)->update($data);

        $tgl=DB::table('kask')->where('bukti',$request->bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
  
        $key=array(
            'cha'=>$request->account,
            'thn'=>$thn,
        );
        if($request->dk=='D'){
            $data=array(
                'd'.$bln=> DB::raw('d'.$bln.'+('.$nilai.')'),
            );
        } else {
            $data=array(
                'k'.$bln=> DB::raw('k'.$bln.'+('.$nilai.')'),
            );
        }
        MutasiSaldo::updateOrInsert($key,$data);
        return response()->json(['success'=>true]);  
    }

    public function hapus_detail($id)
    {
        //tampilkan form edit data
        $bukti=DB::table('kaskd')->where('id',$id)->value('bukti');
        $cha=DB::table('kaskd')->where('id',$id)->value('cha');
        $tgl=DB::table('kask')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $nilai_lama=DB::table('kaskd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('kaskd')->where('id',$id)->value('dk');       
        $key=array(
            'cha'=>$cha,
            'thn'=>$thn,
        );
        if($dk_lama=='D'){
            $data=array(
                'd'.$bln=> DB::raw('d'.$bln.'-'.$nilai_lama),
            );
        } else {
            $data=array(
                'k'.$bln=> DB::raw('k'.$bln.'-'.$nilai_lama),
            );
        }
        MutasiSaldo::updateOrInsert($key,$data);

        $bukti=DB::table('kaskd')->where('id',$id)->value('bukti');
        DB::table('kaskd')->where('id',$id)->delete();
        $total=DB::table('kaskd')->where('bukti',$bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        KasKeluar::where('bukti',$bukti)->update($data);
        return response()->json(['success'=>true]);  
    }

    public function update_detail(Request $request, $id)
    {
        //update data
        $bukti=DB::table('kaskd')->where('id',$id)->value('bukti');
        $tgl=DB::table('kask')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $cha_lama=DB::table('kaskd')->where('id',$id)->value('cha');
        $nilai_lama=DB::table('kaskd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('kaskd')->where('id',$id)->value('dk');       
        $key=array(
            'cha'=>$cha_lama,
            'thn'=>$thn,
        );
        if($request->dk_lama=='D'){
            $data=array(
                'd'.$bln=> DB::raw('d'.$bln.'-'.$nilai_lama),
            );
        } else {
            $data=array(
                'k'.$bln=> DB::raw('k'.$bln.'-'.$nilai_lama),
            );
        }
        MutasiSaldo::updateOrInsert($key,$data);

        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;      
        $data=array(
            'cha'=>$request->account,
            'uraian'=>$request->uraian,
            'nilai'=>$nilai,
        );
        KasKeluarDetail::whereId($id)->update($data);

        $total=DB::table('kaskd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        KasKeluar::where('bukti',$request->bukti)->update($data);
        
        $key=array(
            'cha'=>$request->account,
            'thn'=>$thn,
        );
        if($request->dk=='D'){
            $data=array(
                'd'.$bln=> DB::raw('d'.$bln.'+('.$nilai.')'),
            );
        } else {
            $data=array(
                'k'.$bln=> DB::raw('k'.$bln.'+('.$nilai.')'),
            );
        }
        MutasiSaldo::updateOrInsert($key,$data);

        return response()->json(['success'=>true]);  
    }
}
