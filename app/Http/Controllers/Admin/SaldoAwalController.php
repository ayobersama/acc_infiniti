<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaldoAwal;
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
        if($request->nilai!='') $nilai=UnformatAngka($request->nilai); else  $nilai=0;       
        $data=array(
            'cha'=>$request->account,
            'dk'=>$request->dk,
            'nilai'=>$nilai
        );   
        SaldoAwal::whereId($id)->update($data);

        return redirect('admin/sawal')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        //hapus data
        $saldo_awal = SaldoAwal::findOrFail($id);
        $saldo_awal->delete();
        return redirect('admin/sawal')->with('success', 'Data sudah berhasil dihapus');
    }
}
