<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(){
        return User::orderBy('created_at','desc')->get();
    }
    public function store(Request $request){

        $this->validate($request,[
            'fullName'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'role_id'=>'required'
        ]);
        $password = bcrypt($request->password);
        return User::create([
            'fullname'=>$request->fullName,
            'email'=>$request->email,
            'password'=>$password,
            'role_id'=>$request->role_id
        ]);

    }
    public function update(Request $request){
        $this->validate($request,[
            'fullName'=>'required',
            'email'=>'required|email',
            'role_id'=>'required'
        ]);
        $data = $request->except(['_token','fullName']);
        $data['fullname'] = $request->fullName;
        $data['role_id'] = $request->role_id;
        if(!empty($request->password)){
            $data['password'] = bcrypt($request->password);
        }

        return User::where('id',$request->id)->update($data);
    }
}
