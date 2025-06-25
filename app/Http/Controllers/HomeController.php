<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller
{
    public function index()
    {
       if(Auth::guard('admin')->check()) return redirect()->route('home_admin'); 
        return view('login');
    }

    public function dashboard(){
        $menu="dashboard";
        return view('dashboard',compact('menu'));
    }
}
