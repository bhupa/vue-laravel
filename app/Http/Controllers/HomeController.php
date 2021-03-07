<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(!Auth::check() && $request->path() != 'login'){
            return redirect('/login');
        }
        if(!Auth::check() && $request->path() == 'login'){
            return view('welcome');
        }
        $user  = Auth::user();
        if($user->role->isAdmin == 0){
            return redirect('/login');
        }
        if( $request->path() == 'login'){
            return redirect('/');
        }
        return $this->checkpermisson( $user,$request);
    }
    public function checkpermisson($user,$request){
        $permissions = json_decode($user->role->permission);
        $hasPermission = false;
        if(!$permissions) return  view('welcome');
        foreach($permissions as $p){
            if($p->name == $request->path()){
                if($p->read){
                    $hasPermission = true;
                }

            }

        }
        if($hasPermission) return  view('welcome');
        return  view('notfound');


    }
}
