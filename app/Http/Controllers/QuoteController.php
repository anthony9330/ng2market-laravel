<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
//use JWTAuth;

class QuoteController extends Controller
{
       public function postQuote(Request $request){
           if(!$user =JWTAuth::parseToken()->authenticate()){
               return response()->json(['message'=>'User not found'],404);
           }

           $quote= new Quote();
           $quote->content=$request->input('content');
           $quote->save();
           return response()->json(['quote'=>$quote],201);
        }

        public function getQuotes(){
            $quotes=Quote::all();
            return response()->json(['quotes'=>$quotes],201);
        }
        public function putQuote(Request $request,$id){
                $quote=Quote::where('id',$id)->first();
            if(!$quote){
                return response()->json(['message'=>'Quote not found'],404);
            }
            $quote->content=$request->input('content');
            $quote->save();
            return response()->json(['quote'=>$quote],201);

        }
        public function deleteQuote($id){
            $quote=Quote::where('id',$id)->first();
            $quote->delete();
            return response()->json(['message'=>'qoute deleted'],201);
        }

}

