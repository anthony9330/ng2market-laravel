<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/quote',[
    'uses'=>'QuoteController@postQuote',
    'middleware'=>'auth.jwt'
]);

Route::get('/quotes',[
    'uses'=>'QuoteController@getQuotes'
]);

Route::put('/quote/{id}',[
    'uses'=>'QuoteController@putQuote',
    'middleware'=>'auth.jwt'
]);
Route::delete('/quote/{id}',[
    'uses'=>'QuoteController@deleteQuote',
    'middleware'=>'auth.jwt'
]);


Route::post('/product',[
    'uses'=>'ProductsController@createProduct',
    'middleware'=>'auth.jwt'
]);



Route::post('/imageload',[
    'uses'=>'ProductsController@storeIMG',
//    'middleware'=>'auth.jwt'


]);




Route::get('/categories',[
    'uses'=>'ProductsController@getAllCategories',
]);








Route::post('/user/signup',[
    'uses'=>'UserController@signup'
]);

Route::post('/user/signin',[
    'uses'=>'UserController@signin'
]);

