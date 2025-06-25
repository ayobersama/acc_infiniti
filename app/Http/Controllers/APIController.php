<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function upload_foto_user(Request $request)
    {
         //validasi data
         $rules = [
            'email'                 => 'required|email',
            'foto'                  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ];

        $messages = [
            'email.required'        => 'Email harus diisi',
            'email.email'           => 'Email tidak valid',
            'foto.required'        => 'Foto harus diisi',
            'foto.image'           => 'Foto harus berupa gambar',
            'foto.mimes'           => 'Format gambar yang didukung : jpeg, png, jpg, gif atau svg',
            'foto.max'             => 'ukuran file tidak boleh melebihi 10 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['sukses'=>'0','pesan'=>$validator->errors()]);
        }
        //hapus foto lama
        $foto=DB::table('users')->where('email',$request->email)->value("foto");
        /*if ($foto!=''){
            File::delete(public_path('images/user/'.$foto));
        }*/

        //upload foto
        $extension = $request->foto->getClientOriginalExtension();
        $nama_file = time().'.'.$extension;
        $data=array(
            'foto'=>$nama_file,
        );
        DB::table('users')->where('email',$request->email)->update($data);
        $request->foto->move(public_path('images/user'), $nama_file);

        //sukses
        $lokasi=['file_hasil'=>asset('images/user/'.$nama_file)];
        $data = [
            'sukses' =>'1',
            'data'=>$lokasi
        ];
        return response()->json($data);
    }
}
