<?php
namespace App\Http\Controllers\Admin;

use Session;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;
use DB;

class AuthAdminController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request){
        //validasi data
        $rules = [
            'username'              => 'required|string',
            'password'              => 'required|string'
        ];
  
        $messages = [
            'username.required'     => 'Username harus diisi',
            'password.required'     => 'Password harus diisi'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'username'  => $request->input('username'),
            'password'  => $request->input('password'),
        ];
        
        Auth::guard('admin')->attempt($data);
        $auth = Auth::guard('admin');
        if ($auth->check()) {
            return redirect('admin/home');
         } else { 
            Session::flash('error', 'Email atau password salah');
            return back()->withInput($request->only('username'));
         }   

    }

    public function ada_menu($menu){
        $userid=Auth::guard('admin')->user()->id;
        $hak_akses=DB::table('admin_akses')->where('userid',$userid)->where('menu','SUPER')->value('baca');
        if ($hak_akses!='Y'){
            $hak_akses=DB::table('admin_akses')->where('userid',$userid)->where('menu',$menu)->value('baca');
            if($hak_akses=='Y') $terlihat=true; else $terlihat=false;
        } else  $terlihat=true;   
        return $terlihat;
    }

    public function hak_akses($menu){
        $userid=Auth::guard('admin')->user()->id;
        $hak_akses=DB::table('admin_akses')->where('userid',$userid)->where('menu','SUPER')->value('baca');
        if ($hak_akses!='Y'){
            $hak_baca=DB::table('admin_akses')->where('userid',$userid)->where('menu',$menu)->value('baca');
            $hak_tambah=DB::table('admin_akses')->where('userid',$userid)->where('menu',$menu)->value('tambah');
            $hak_edit=DB::table('admin_akses')->where('userid',$userid)->where('menu',$menu)->value('edit');
            $hak_hapus=DB::table('admin_akses')->where('userid',$userid)->where('menu',$menu)->value('hapus');
            if($hak_baca=='Y') $baca=true; else $baca=false;
            if($hak_tambah=='Y') $tambah=true; else $tambah=false;
            if($hak_edit=='Y') $edit=true; else $edit=false;
            if($hak_hapus=='Y') $hapus=true; else $hapus=false;
        } else {
            $baca=true;
            $tambah=true;
            $edit=true;
            $hapus=true;
        }    
        return array('baca' => $baca, 'tambah' => $tambah, 'edit' => $edit, 'hapus' => $hapus);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->flush();

        return redirect('/');
    }

}
