<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductsController extends Controller
{
    public function createProduct(Request $request){

        $user=JWTAuth::parseToken()->authenticate();
        $user_info= json_decode($request->input("user_info"));

        If($request->hasFile('image')){
            $file = $request->file('image');
            $destinationPath = public_path(). '/img/';
            $filename = $file->getClientOriginalName();
            $filename='user_'.$user->id.'_'.time().'_'.$filename;
            $file->move($destinationPath, $filename);
            $user_info->imagesPath=$destinationPath.$filename;
        }



        if($user!=null ){


            $product=new Product();


            $product->title=$user_info->title;
            $product->categoryID=$user_info->categoryID;
            $product->userID=$user->id;
            $product->description=$user_info->description;
            $product->location=$user_info->location;
            $product->price=$user_info->price;

            $product->imagesPath=$user_info->imagesPath;

            $product->additionalFields=$user_info->additionalFields;

            $product->save();


            return response()->json(['product'=>$user_info],201);
        }
        else {
            return response()->json(['error'=>'can not find user'],404);
        }

    }


    public function getAllProducts(){
        $products=Product::all();

        foreach($products as $product){

            $product->category=$product->category;

        }


       return response()->json(['products'=> $products],201);
    }



    public function updateProduct(Request $request,$id){
        $product= Product::where('id',$id)->first();

        if($product){
            $product->title=$request->title;
            $product->categoryID=$request->categoryID;
            $product->description=$request->description;
            $product->location=$request->location;
            $product->approved=$request->approved;
            $product->price=$request->price;
            $product->additionalFields=$request->additionalFields;
            $product->update();
            return response()->json(['product'=>$product],201);
        }
        else {
            return response()->json(['message'=>'no such product'],201);
        }
    }

    public function deleteProduct($id){
        $product=Product::where('id',$id)->first();

        if($product){

            $product->delete();
            return response()->json(['product'=>$product],201);

        }
        else {
            return response()->json(['product'=>'no such product'],201);
        }

    }

    public function storeIMG(Request $request){
        If($request->hasFile('image')){


            $file = $request->file('image');

            $destinationPath = public_path(). '/img/';
            $filename = $file->getClientOriginalName();

            $file->move($destinationPath, $filename);



        }

//        $title=$request->input("");


        return response()->json(['image'=>$request->all()],201);

//        $destinationPath = 'uploads/carImages/';
//        date_default_timezone_set('Asia/Jerusalem');
//        $date = date('Y_m_d_His', time());
//
//
//        $i = 0;
//        foreach ($file as $file_item) {
//            // VERIFY THIS IS IMAGE ONLY
//            $allowed =['image/jpeg','image/jpg','image/png','image/gif'];
//
//            if(in_array($file_item->getMimeType(),$allowed)){
//
//
//                $filename = $file_item->getClientOriginalName();
//
//                $extension = $file_item->getClientOriginalExtension();
//                $filename = $filename . "_" . $date . "." . $extension;
//
//                $image_file_link = 'uploads/carImages/' . $filename;
//
//
//                // COMPRESS IMAGES
//                $tinify=new TinifyService();
//                $source =  $tinify->fromFile($file_item);
//                $source->toFile($image_file_link);
//                // USE IT WITHOUT TINYIMG
////                Input::file('file')[$i]->move($destinationPath, $filename);
//                $car_img = new TmpCarImages();
//                $car_img->car_image_link = $image_file_link;
//                $car_img->save();
//                $i++;
//
//            }
//
//
//        }


    }

    public function storeLocalImg(Request $request){
        If($request->hasFile('image')){


            $file = $request->file('image');

            $destinationPath = public_path(). '/img/';
            $filename = $file->getClientOriginalName();

            $file->move($destinationPath, $filename);

            echo  $filename;
            //echo '<img src="uploads/'. $filename . '"/>';


        }
        return $request->all();
    }


    public function getAllCategories(){
        $categories=Category::all();
        return response()->json(['categories'=>$categories],201);
    }

    public function storeCategory(Request $request){
        $this->validate($request,[
            'category_name'=>'required'

        ]);

        $category= new Category();
        $category->category_name=$request->category_name;
        $category->additionalFields=$request->additionalFields;
        $category->save();
        return response()->json(['category'=>$category],201);
    }



    public function  editCategory(Request $request,$id){
        $category=Category::where('id',$id)->first();
        $this->validate($request,[
            'category_name'=>'required'
        ]);
        if(!$category){
            return response()->json(['message'=>"cannot find category"],404);
        }
        else {

            $category->category_name = $request->category_name;
            $category->additionalFields = $request->additionalFields;
            $category->update();
            return response()->json(['category' => $category], 201);

        }
    }

    public function deleteCategory($id){
        $category=Category::where('id',$id)->first();
        if($category){
            $category->delete();
               return response()->json(['category'=>$category],201);
        }else {
            return response()->json(['error'=>'no such category'],201);
        }


    }
}
