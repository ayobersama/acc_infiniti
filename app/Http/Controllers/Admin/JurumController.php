<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JurnalUmum;
use App\Models\JurnalUmumDetail;
use App\Models\MutasiSaldo;
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

        $tgl_lama=DB::table('jurum')->where('bukti',$id)->value('tgl');
        if($tgl!=$tgl_lama){
            $bln_lama=substr($tgl_lama,5,2);
            if(substr($bln_lama,0,1)=='0') $bln_lama=substr($bln_lama,1,1);
            $thn_lama=substr($tgl_lama,0,4);
            $detail=DB::table('jurumd')->where('bukti',$id)->get();
            $bln=substr($tgl,5,2);
            if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
            $thn=substr($tgl,0,4);
            foreach($detail as $det){
                $key=array(
                    'cha'=>$det->cha,
                    'thn'=>$thn_lama,
                );
                if($det->dk=='D'){
                    $data=array(
                        'd'.$bln_lama=> DB::raw('d'.$bln_lama.'-('.$det->nilai.')'),
                    );
                } else {
                    $data=array(
                        'k'.$bln_lama=> DB::raw('k'.$bln_lama.'-('.$det->nilai.')'),
                    );
                }
                MutasiSaldo::updateOrInsert($key,$data);

                $key=array(
                    'cha'=>$det->cha,
                    'thn'=>$thn,
                );
                if($det->dk=='D'){
                    $data=array(
                        'd'.$bln=> DB::raw('d'.$bln.'+('.$det->nilai.')'),
                    );
                } else {
                    $data=array(
                        'k'.$bln=> DB::raw('k'.$bln.'+('.$det->nilai.')'),
                    );
                }
                MutasiSaldo::updateOrInsert($key,$data);
            }
        }

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
        $tgl=DB::table('jurum')->where('bukti',$id)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $detail=DB::table('jurumd')->where('bukti',$id)->get();
        foreach($detail as $det){
            $key=array(
                'cha'=>$det->cha,
                'thn'=>$thn,
            );
            if($det->dk=='D'){
                $data=array(
                    'd'.$bln=> DB::raw('d'.$bln.'-('.$det->nilai.')'),
                );
            } else {
                $data=array(
                    'k'.$bln=> DB::raw('k'.$bln.'-('.$det->nilai.')'),
                );
            }
            MutasiSaldo::updateOrInsert($key,$data);
        }   

        JurnalUmum::where('bukti',$id)->delete();
        DB::table('jurumd')->where('bukti',$id)->delete();
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
        
        $tgl=DB::table('jurum')->where('bukti',$request->bukti)->value('tgl');
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
        $bukti=DB::table('jurumd')->where('id',$id)->value('bukti');
        $cha=DB::table('jurumd')->where('id',$id)->value('cha');
        $tgl=DB::table('jurum')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $nilai_lama=DB::table('jurumd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('jurumd')->where('id',$id)->value('dk');       
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
        $bukti=DB::table('jurumd')->where('id',$id)->value('bukti');
        $tgl=DB::table('jurum')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $cha_lama=DB::table('jurumd')->where('id',$id)->value('cha');
        $nilai_lama=DB::table('jurumd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('jurumd')->where('id',$id)->value('dk');       
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
