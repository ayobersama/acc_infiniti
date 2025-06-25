<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relasi;
use Illuminate\Support\Facades\Validator;
use DB;

class RelasiController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $relasi = DB::table('relasi')->get();
        $menu='relasi';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('RELASI');
        return view('admin.relasi',compact('menu','relasi','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='relasi';
        return view('admin.tambah_relasi', compact('menu'));
    }

    public function store(Request $request)
    {
         //tambahkan data
         $rules = [
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
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'ket'=>$request->ket,
            'aktif'=>'Y'
        );

        Relasi::create($data);

        return redirect()->route('relasi.index')
            ->with('success', 'Penambahan data berhasil');
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $relasi = Relasi::findOrFail($id);
        $menu='relasi';
        return view('admin.edit_relasi', compact('menu','relasi'));
    }

    public function update(Request $request, $id)
    {
        //update data
        $rules = [
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
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'ket'=>$request->ket,
            'aktif'=>'Y'
        );   
        Relasi::whereId($id)->update($data);

        return redirect('admin/relasi')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        //hapus data
        $relasi = Relasi::findOrFail($id);
        $relasi->delete();
        return redirect('admin/relasi')->with('success', 'Data sudah berhasil dihapus');
    }
}
