<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoUrut;
use Illuminate\Support\Facades\Validator;
use DB;

class NoUrutController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $nourut = DB::table('no_urut')->get();
        $menu='nourut';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('NOURUT');
        return view('admin.nourut',compact('menu','nourut','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
    }

    public function store(Request $request)
    {
         //tambahkan data
        
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $nourut = NoUrut::findOrFail($id);
        $menu='nourut';
        return view('admin.edit_nourut', compact('menu','nourut'));
    }

    public function update(Request $request, $id)
    {
        //update data
        $rules = [
            'kode' =>'required'
        ];

        $messages = [
            'kode.required'     => 'Kode harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data=array(
            'kode'=>$request->kode,
            'no_akhir'=>$request->no_akhir,
        );   
        NoUrut::whereId($id)->update($data);

        return redirect('admin/nourut')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        //hapus data
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect('admin/vendor')->with('success', 'Data sudah berhasil dihapus');
    }

    public function ambil_nourut($tipe)
    {
        $no_akhir = DB::table('no_urut')->where('tipe',$tipe)->value('no_akhir');
        $kode = DB::table('no_urut')->where('tipe',$tipe)->value('kode');
        $thn = DB::table('psys')->value('thn');
        $thn_akhir=substr($thn,-2);
        if($no_akhir!='') $no_akhir=$no_akhir+1; else $no_akhir=1;
        $no_akhirs=str_pad($no_akhir, 6, "0", STR_PAD_LEFT); 
        $data=array(
            'no_akhir'=>$no_akhir
        );   
        DB::table('no_urut')->where('tipe',$tipe)->update($data);
        $bukti=$kode.$thn_akhir.$no_akhirs;
        return  $bukti;
    }
    
}
