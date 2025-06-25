<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use DB;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        //menampilkan seluruh data
        $user = DB::table('admin')->get();
        $menu='user';
        $hak_akses=app('App\Http\Controllers\Admin\AuthAdminController')->hak_akses('USER');
        return view('admin.user',compact('menu','user','hak_akses'));
    }

    public function create()
    {
        //tampilkan form tambah data
        $menu='user';
        return view('admin.tambah_user', compact('menu'));
    }

    public function store(Request $request)
    {
         //tambahkan data
         $rules = [
            'username' => 'required|unique:admin,username',
            'nama' =>'required'
        ];

        $messages = [
            'username.required'     => 'Username harus diisi',
            'username.unique'       => 'Username sudah dipakai, isi yang lain',
            'password.required'     => 'Password harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        /*
        if (isset($request->gambar)){
            $extension = $request->gambar->getClientOriginalExtension(); 
            $nama_file = time().'.'.$extension;
            $request->gambar->move(public_path('images/user'), $nama_file);
        } else  $nama_file ="";
        */
        
        $data=array(
            'username'=>$request->username,
            'nama'=>$request->nama,
            'aktif'=>'Y',
            'password' => Hash::make($request->password)
        );

        Admin::create($data);

        return redirect('admin/user')
            ->with('success', 'Penambahan data berhasil');
    }

    public function edit($id)
    {
        //tampilkan form edit data
        $user = Admin::findOrFail($id);
        $menu='user';  
        return view('admin.edit_user', compact('menu','user'));
    }

    public function update(Request $request, $id)
    {
        //update data
        $rules = [
            'nama' =>'required'
        ];

        $messages = [
            'username.required'  => 'Username harus diisi',
            'nama.required'     => 'Nama harus diisi'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        /*if(isset($request->gambar)){
            $extension = $request->gambar->getClientOriginalExtension(); 
            $nama_file = time().'.'.$extension;  
            $request->gambar->move(public_path('images/user'), $nama_file);
            $data=array(
                'nama'=>ucwords(strtolower($request->nama)),
                'email'=>strtolower($request->email),
                'hp'=>$request->hp,
                'ktp'=>$request->ktp,
                'foto'=>$nama_file,
                'alamat'=>$request->alamat,
                'prov'=>$request->id_provinsi,
                'kota'=>$request->id_kota,
                'kec'=>$request->id_kecamatan,
                'kel'=>$request->id_kelurahan,
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
                'kode'=>$request->kode,
                'aktif'=>$request->aktif,
            );  
        } else {   */
            $data=array(
                'nama'=>$request->nama,
                'username'=>$request->username,
                'aktif'=>$request->aktif
            );   
        /* } */
        Admin::whereId($id)->update($data);
        return redirect('admin/user')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        //hapus data
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect('admin/user')->with('success', 'Data sudah berhasil dihapus');
    }
}
