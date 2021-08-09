<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    //
    public function add(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'category'=>'required',
            'brand'=>'required',
            'desc'=>'required',
            'image '=>'required|image',
            'price'=>'required',

        ]);
        if($validator->fails())
        {
             return response()->json(['error'=>$validator->errors()->all()], 409);
        }
        $p=new product();
        $p->name=$request->name;
        $p->category=$request->category;
        $p->brand=$request->brand;
        $p->desc=$request->desc;
        $p->image=$request->image; 
        $p->price=$request->name;
        $p->save();

          //storing image
          $url="http://localhost:8000/storage/";
          $file = $request->file('image');
          $extension= $file->getClientOriginalExtension();
          $path = $request->file('image')->storAs('proimages/', $p->id. "." .$extension);
          $p->image=$path;
          $p->imgpath=$url.$path;
          $p->save();
          return response()->json(['message'=>"ajoute avec succes"]);

    }

    public function update(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'category'=>'required',
            'brand'=>'required',
            'desc'=>'required',
            'price'=>'required',
            'id'=>'required',

        ]);
        if($validator->fails())
        {
             return response()->json(['error'=>$validator->errors()->all()], 409);
        }
        $p=product::find($request->id);
        $p->name=$request->name;
        $p->category=$request->category;
        $p->brand=$request->brand;
        $p->desc=$request->desc;
        $p->image=$request->image; 
        $p->price=$request->name;
        $p->save();
        return response()->json(['message'=>"modifie avec succes"]);

         
    }

    public function delete(Request $request)
    {
        $validator=Validator::make($request->all(),[
            
            'id'=>'required',

        ]);
        if($validator->fails())
        {
             return response()->json(['error'=>$validator->errors()->all()], 409);
        }
        $p=product::find($request->id) ->delete();
        
      
        return response()->json(['message'=>"supprime avec succes"]);

    }
    public function show(Request $request)
    {
        session(['keys'=>$request->keys]);
        $products=product::where(function($q){
            $q->where('products.id','LIKE','%'.session('keys').'%')
            ->orwhere('products.name','LIKE','%'.session('keys').'%')
            ->orwhere('products.price','LIKE','%'.session('keys').'%')
            ->orwhere('products.category','LIKE','%'.session('keys').'%')
            ->orwhere('products.brand','LIKE','%'.session('keys').'%');
        })->select('products.*')->get();
        return response()->json(['products'=>$products]);
    

    }
}
