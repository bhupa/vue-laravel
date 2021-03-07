<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(){

        return Category::orderBy('created_at','desc')->get();
    }

    public function store(Request $request){

        $this->validate($request,[
            'categoryName'=>'required',
            'iconImage'=>'required'
        ]);

        return Category::create([
            'categoryName'=> $request->categoryName,
            'iconImage'=>$request->iconImage
        ]);

    }
    public function update(Request $request){

        $this->validate($request,[
            'categoryName'=>'required',
        ]);
        Category::where('id',$request->id)->update([
            'categoryName'=> $request->categoryName,
            'iconImage'=>$request->iconImage
            ]);

            return response()->json(['categoryName'=>$request->categoryName,'iconImage'=>$request->iconImage]);
    }
    public function destroy(Request $request){


        $this->validate($request,[
            'categoryName'=>'required'
        ]);
        Category::where('id',$request->id)->delete();

            return response()->json(['categoryName'=>$request->categoryName]);
    }
}
