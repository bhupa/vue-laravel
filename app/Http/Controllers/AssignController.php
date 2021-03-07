<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class AssignController extends Controller
{


    public function store(Request $request){
       
        $this->validate($request,[
            'permission'=>'required',
            'id'=>'required'
        ]);
        return Role::where('id',$request->id)->update(['permission'=>$request->permission]);

    }
}
