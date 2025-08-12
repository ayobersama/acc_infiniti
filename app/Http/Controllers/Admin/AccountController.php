<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use DB;

class AccountController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $account = DB::table('account as a')->select('a.id','a.kode','a.nama','a.jenis','a.induk','a.kb','a.header','a.aktif','i.kode as kode_induk')
                    ->leftJoin('account as i','i.id','a.induk')->orderby('a.kode')->get();
        $menu='account';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('RELASI');
        return view('admin.account',compact('menu','account','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='account';
        $induk_list=DB::table('account')->select('id','nama','kode')->where('header','Y')->where('aktif','Y')->get();
        return view('admin.tambah_account', compact('menu','induk_list'));
    }

    public function store(Request $request)
    {
         //tambahkan data
         $rules = [
            'kode' =>'required',
            'nama' =>'required'
        ];

        $messages = [
            'nama.required'     => 'Nama harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data=array(
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'induk'=>$request->induk,
            'jenis'=>$request->jenis,
            'kb'=>$request->kb,
            'header'=>$request->header,
            'aktif'=>'Y'
        );

        Account::create($data);

        return redirect()->route('account.index')
            ->with('success', 'Penambahan data berhasil');
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $account = DB::table('account as a')->select('a.id','a.kode','a.nama','a.jenis','a.induk','a.kb','a.header','a.aktif','i.kode as kode_induk')
                     ->leftJoin('account as i','i.id','a.induk')
                     ->where('a.id',$id)->first();
        $induk_list=DB::table('account')->select('id','nama','kode')->where('header','Y')->where('aktif','Y')->get();
        $menu='account';
        return view('admin.edit_account', compact('menu','account','induk_list'));
    }

    public function update(Request $request, $id)
    {
        //update data
        $rules = [
            'kode' =>'required',
            'nama' =>'required'
        ];

        $messages = [
            'kode.required'     => 'Kode harus diisi',
            'nama.required'     => 'Nama harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data=array(
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'induk'=>$request->induk,
            'jenis'=>$request->jenis,
            'kb'=>$request->kb,
            'header'=>$request->header,
            'aktif'=>$request->aktif
        );   
        Account::whereId($id)->update($data);

        return redirect('admin/account')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        //hapus data
        $account = Account::findOrFail($id);
        $account->delete();
        return redirect('admin/account')->with('success', 'Data sudah berhasil dihapus');
    }
}
