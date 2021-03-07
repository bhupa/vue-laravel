<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index(){
        return Role::orderBy('created_at','desc')->get();
    }

    public function store(Request $request){
        $this->validate($request,[
            'roleName'=>'required',
        ]);

        return Role::create([
            'roleName'=> $request->roleName,
        ]);
    }
    public function update(Request $request){
        dd(auth()->user()->role->isAdmin);
        $this->validate($request,[
            'roleName'=>'required',
        ]);
        $data = $request->except(['_token','id']);
        Role::where('id',$request->id)->update($data);
        return response()->json(['categoryName'=>$request->roleName,]);
    }
    public function destroy(Request $request){


        $this->validate($request,[
            'roleName'=>'required'
        ]);
        Role::where('id',$request->id)->delete();

            return response()->json(['roleName'=>$request->roleName]);
    }
}
