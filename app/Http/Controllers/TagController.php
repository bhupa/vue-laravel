<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{


    public function index() {
        return Tag::orderBy('created_at','desc')->get();
    }
    public function store(Request $request){

        $this->validate($request,[
            'tagName'=>'required'
        ]);
        return  Tag::create([
                'tagName'=>$request->tagName
            ]);
    }
    public function update(Request $request){

        $this->validate($request,[
            'tagName'=>'required'
        ]);
        Tag::where('id',$request->id)->update([
                'tagName'=>$request->tagName
            ]);

            return response()->json(['tagName'=>$request->tagName]);
    }
    public function destroy(Request $request){

    
        $this->validate($request,[
            'tagName'=>'required'
        ]);
        Tag::where('id',$request->id)->delete();

            return response()->json(['tagName'=>$request->tagName]);
    }
    public function upload(Request $request){


        $this->validate($request,[
            'file'=>'required|mimes:jpeg,jpg,png'
        ]);
        $picName =  str_replace(" ","_",time().$request->file->getClientOriginalName());

        $request->file->move(public_path('uploads'),$picName );
        return $picName ;
    }
}
