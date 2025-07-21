<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankMasuk;
use App\Models\BankMasukDetail;
use App\Models\MutasiSaldo;
use Illuminate\Support\Facades\Validator;
use DB;

class BankMasukController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $bankm = DB::table('bankm as k')->select('bukti', 'tgl', 'bank', 'a.nama as nbank', 'k.relasi','r.nama as nrelasi', 'nilai', 'status')
                ->leftjoin('relasi as r','r.id','k.relasi')
                ->leftjoin('account as a','a.id','k.bank')
                ->get();
        $menu='bankm';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('BANKM');
        return view('admin.bankm',compact('menu','bankm','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='bankm';
        $bank_list=DB::table('account')->select('id','nama','kode')->where('kb','B')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        return view('admin.tambah_bankm', compact('menu','bank_list','relasi_list','acc_list'));
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
        BankMasuk::create($data);            
        return response()->json(['success'=>true]);     
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $bankm = DB::table('bankm')->where('bukti',$id)->first();
        $bankd = DB::table('bankmd')->where('bukti',$id)->get();

        $bank_list=DB::table('account')->select('id','nama','kode')->where('kb','B')->where('aktif','Y')->get();
        $relasi_list=DB::table('relasi')->select('id','nama')->where('aktif','Y')->get();
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='bankm';
        return view('admin.edit_bankm', compact('menu','bankm','bankd','bank_list','relasi_list','acc_list'));
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
        BankMasuk::where('bukti',$id)->update($data);

        return response()->json(['success'=>true]);   
    }

    public function destroy($id)
    {
        //hapus data
        BankMasuk::where('bukti',$id)->delete();
        return redirect('admin/bankm')->with('success', 'Data sudah berhasil dihapus');
    }

    public function tampilkan_detail($id)
    {
        $bankm=DB::table('bankm')->select('nilai')->where('bukti',$id)->get();
        $bankd=DB::table('bankmd as d')->select('d.id','d.cha','a.kode','a.nama','d.uraian','d.nilai')
                      ->leftjoin('account as a','a.id','d.cha')
                      ->where('bukti',$id)->orderby('d.id')->get();   
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('BANKM');                      
        return view('admin.detail_bankm', compact('bankm','bankd','hak_akses'));
    }

    public function edit_detail($id)
    {
        //tampilkan form edit data
        $bankd = DB::table('bankmd')->where('id',$id)->first();
        return response()->json($bankd); 
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
        BankMasukDetail::create($data);

        $total=DB::table('bankmd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        BankMasuk::where('bukti',$request->bukti)->update($data);

        $tgl=DB::table('bankm')->where('bukti',$request->bukti)->value('tgl');
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
        $bukti=DB::table('bankmd')->where('id',$id)->value('bukti');
        $cha=DB::table('bankmd')->where('id',$id)->value('cha');
        $tgl=DB::table('bankm')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $nilai_lama=DB::table('bankmd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('bankmd')->where('id',$id)->value('dk');       
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

        DB::table('bankmd')->where('id',$id)->delete();
        $total=DB::table('bankmd')->where('bukti',$bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        BankMasuk::where('bukti',$bukti)->update($data);

        return response()->json(['success'=>true]);  
    }

    public function update_detail(Request $request, $id)
    {
        //update data
        $bukti=DB::table('bankmd')->where('id',$id)->value('bukti');
        $tgl=DB::table('bankm')->where('bukti',$bukti)->value('tgl');
        $bln=substr($tgl,5,2);
        if(substr($bln,0,1)=='0') $bln=substr($bln,1,1);
        $thn=substr($tgl,0,4);
        $cha_lama=DB::table('bankmd')->where('id',$id)->value('cha');
        $nilai_lama=DB::table('bankmd')->where('id',$id)->value('nilai');
        $dk_lama=DB::table('bankmd')->where('id',$id)->value('dk');       
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
        BankMasukDetail::whereId($id)->update($data);

        $total=DB::table('bankmd')->where('bukti',$request->bukti)->sum('nilai');
        $data=array(
            'nilai'=>$total
        );
        BankMasuk::where('bukti',$request->bukti)->update($data);

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
