<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasMasuk;
use App\Models\KasMasukDetail;
use App\Models\MutasiSaldo;
use Illuminate\Support\Facades\Validator;
use DB;

class KasMasukController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $kasm = DB::table('kasm as k')->select('bukti', 'tgl', 'kas', 'a.nama as nkas', 'k.relasi','r.nama as nrelasi', 'nilai', 'status')
                ->leftjoin('relasi as r','r.id','k.relasi')
                ->leftjoin('account as a','a.id','k.kas')
                ->get();
        $menu='kasm';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('KASM');
        return view('admin.kasm',compact('menu','kasm','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='kasm';
        $kas_list=DB::table('account')->select('id','nama','kode')->where('kb','K')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        return view('admin.tambah_kasm', compact('menu','kas_list','relasi_list','acc_list'));
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
        KasMasuk::create($data);            
        return response()->json(['success'=>true]);     
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $kasm = DB::table('kasm')->where('bukti',$id)->first();
        $kasd = DB::table('kasmd')->where('bukti',$id)->get();

        $kas_list=DB::table('account')->select('id','nama','kode')->where('kb','K')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='kasm';
        return view('admin.edit_kasm', compact('menu','kasm','kasd','kas_list','relasi_list','acc_list'));
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
        KasMasuk::where('bukti',$id)->update($data);

        return response()->json(['success'=>true]);   
    }

    public function destroy($id)
    {
        //hapus data
        KasMasuk::where('bukti',$id)->delete();
        return redirect('admin/kasm')->with('success', 'Data sudah berhasil dihapus');
    }

    public function tampilkan_detail($id)
    {
        $kasm=DB::table('kasm')->select('nilai')->where('bukti',$id)->get();
        $kasd=DB::table('kasmd as d')->select('d.id','d.cha','a.kode','a.nama','d.uraian','d.nilai')
                      ->leftjoin('account as a','a.id','d.cha')
                      ->where('bukti',$id)->orderby('d.id')->get();   
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('KASM');                      
        return view('admin.detail_kasm', compact('kasm','kasd','hak_akses'));
    }

    public function edit_detail($id)
    {
        //tampilkan form edit data
        $kasd = DB::table('kasmd')->where('id',$id)->first();
        return response()->json($kasd); 
    }


    public function simpan_detail(Request $request)
    {
         //tambahkan data
         $rules = [
            'account' =>'required',
            'nilai' =>'required'
        ];

        $messages = [
            'account.required'     => 'COA harus diisi',
            'nilai.required'     => 'Nilai harus diisi',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['success'=>false,'error:'=>$errors->all()]);  
        }
        
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;    
        $data=array(
            'bukti'=>$request->bukti,
            'cha'=>$request->account,
            'dk'=>'K',
            'uraian'=>$request->uraian,
            'nilai'=>$nilai,
        );
        KasMasukDetail::create($data);

        $total=DB::table('kasmd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        KasMasuk::where('bukti',$request->bukti)->update($data);
    
        $tgl=DB::table('kasm')->where('bukti',$request->bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
  
        $key=array(
            'cha'=>$request->account,
            'thn'=>$thn,
        );
      //  DB::enableQueryLog();
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
       // dd(DB::getQueryLog());  
        
        return response()->json(['success'=>true]);  
    }

    public function hapus_detail($id)
    {
        $bukti=DB::table('kasmd')->where('id',$id)->value('bukti');
        $cha=DB::table('kasmd')->where('id',$id)->value('cha');
        $tgl=DB::table('kasm')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $nilai_lama=DB::table('kasmd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('kasmd')->where('id',$id)->value('dk');       
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

        DB::table('kasmd')->where('id',$id)->delete();
        
        $total=DB::table('kasmd')->where('bukti',$bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        KasMasuk::where('bukti',$bukti)->update($data);
        return response()->json(['success'=>true]);  
    }

    public function update_detail(Request $request, $id)
    {
        //update data
        $bukti=DB::table('kasmd')->where('id',$id)->value('bukti');
        $tgl=DB::table('kasm')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $cha_lama=DB::table('kasmd')->where('id',$id)->value('cha');
        $nilai_lama=DB::table('kasmd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('kasmd')->where('id',$id)->value('dk');       
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
        KasMasukDetail::whereId($id)->update($data);

        $total=DB::table('kasmd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        KasMasuk::where('bukti',$request->bukti)->update($data);

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
