<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function login(Request $request){

        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);


        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){

            $user = Auth::user();

            if(auth()->user()->role->isAdmin == 1){
                return response([
                    'status'=>200,
                    'msg'=>'Your are logged in',
                    'user'=>$user->role
                ],200);

            }
            Auth::logout();
            return response()->json([
                'msg'=>'Your are not allowed'
            ],401);

        }
        return response([
            'msg'=>'Incorrect Login details'
        ],401);


    }

    public function logout(){

        Auth::logout();
        return redirect('/login');
    }
}
