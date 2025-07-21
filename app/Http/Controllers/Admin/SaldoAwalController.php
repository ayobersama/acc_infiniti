<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaldoAwal;
use App\Models\MutasiSaldo;
use Illuminate\Support\Facades\Validator;
use DB;

class SaldoAwalController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $sawal = DB::table('saldo_awal as s')->select('s.id','s.cha','a.kode','a.nama','dk','nilai')
                ->LeftJoin('account as a','a.id','s.cha')->get();
        $menu='sawal';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('SAWAL');
        return view('admin.saldo_awal',compact('menu','sawal','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='sawal';
        return view('admin.tambah_saldo_awal', compact('menu','acc_list'));
    }

    public function store(Request $request)
    {
         //tambahkan data
         $rules = [
            'account' =>'required'
        ];

        $messages = [
            'account.required'     => 'Account harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0; 
        $data=array(
            'cha'=>$request->account,
            'dk'=>$request->dk,
            'nilai'=>$nilai
        );
        SaldoAwal::create($data);
        
        //mutasi
        $thn_awal=DB::table('psys')->value('awal');
        if($request->dk=='K') $nilai=-$nilai;
        $key=array(
            'cha'=>$request->account,
            'thn'=>$thn_awal,
        );
        $data=array(
            'sa'=> DB::raw('sa+'.$nilai),
        );
        MutasiSaldo::updateOrInsert($key,$data);

        return redirect()->route('sawal.index')
            ->with('success', 'Penambahan data berhasil');
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $sawal = SaldoAwal::findOrFail($id);
        $acc_list=DB::table('account')->select('id','nama','kode')->where('aktif','Y')->where('header','N')->get();
        $menu='sawal';
        return view('admin.edit_saldo_awal', compact('menu','sawal','acc_list'));
    }

    public function update(Request $request, $id)
    {
        //update data
        $rules = [
            'account' =>'required'
        ];

        $messages = [
            'account.required'     => 'Account harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $nilai_lama=DB::table('saldo_awal')->where('cha',$request->account)->value('nilai');
        $dk_lama=DB::table('saldo_awal')->where('cha',$request->account)->value('dk');
        if($dk_lama=='D') $koreksi=-$nilai_lama; else $koreksi=$nilai_lama;

        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;       
        $data=array(
            'cha'=>$request->account,
            'dk'=>$request->dk,
            'nilai'=>$nilai
        );   
        SaldoAwal::whereId($id)->update($data);
        
        //mutasi
        $thn_awal=DB::table('psys')->value('awal');
        if($request->dk=='K') $nilai=-$nilai;
        $nilai=$koreksi+$nilai;       

        $key=array(
            'cha'=>$request->account,
            'thn'=>$thn_awal,
        );
        $data=array(
            'sa'=> DB::raw('sa+'.$nilai),
        );
        MutasiSaldo::updateOrInsert($key,$data);
        return redirect('admin/sawal')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $nilai_lama=DB::table('saldo_awal')->where('cha',$request->account)->value('nilai');
        $dk_lama=DB::table('saldo_awal')->where('cha',$request->account)->value('dk');
        if($dk_lama=='D') $koreksi=-$nilai_lama; else $koreksi=$nilai_lama;

        //hapus data
        $saldo_awal = SaldoAwal::findOrFail($id);
        $saldo_awal->delete();
        
        //mutasi
        $thn_awal=DB::table('psys')->value('awal');

        $key=array(
            'cha'=>$request->account,
            'thn'=>$thn_awal,
        );
        $data=array(
            'sa'=> DB::raw('sa+'.$koreksi),
        );
        MutasiSaldo::updateOrInsert($key,$data);
 
        return redirect('admin/sawal')->with('success', 'Data sudah berhasil dihapus');
    }
}
