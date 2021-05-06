<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('client')->get('/user', function (Request $request) {
    return \App\Helper\Security::obtainUserIdFromRequest($request);
});

Route::group(['prefix'=>'event','as'=>'event.'], function(){
    Route::get('/provider/status', 'App\Http\Controllers\EventController@providerStatus')->name('list');
    Route::post('/create', 'App\Http\Controllers\EventController@store')->name('create');
    Route::get('/list', 'App\Http\Controllers\EventController@index')->name('list');
    Route::get('/report', 'App\Http\Controllers\EventController@report')->name('report');
    Route::get('/upcoming', 'App\Http\Controllers\EventController@upcoming')->name('upcoming');
    Route::get('/past', 'App\Http\Controllers\EventController@past')->name('report');
    Route::post('/order/create', 'App\Http\Controllers\EventController@orderCreate')->name('order.create');
    Route::put('/{event}/close', 'App\Http\Controllers\EventController@close')->name('close');
    Route::put('/{event}/start', 'App\Http\Controllers\EventController@start')->name('start');
    Route::get('/{event}/products', 'App\Http\Controllers\EventController@getProducts')->name('products');
    Route::post('/product/{product}/highlight', 'App\Http\Controllers\EventController@highlightProduct')->name('product.highlight');
    Route::post('/product/{product}/discount', 'App\Http\Controllers\EventController@discountProduct')->name('product.discount');
    Route::post('/reflink/create', 'App\Http\Controllers\EventController@reflinkCreate')->name('reflink.create');
    Route::get('/reflink/list', 'App\Http\Controllers\EventController@reflinkList')->name('reflink.list');
    Route::get('/showBySlug/{slug}', 'App\Http\Controllers\EventController@showBySlug')->name('showBySlug');
    Route::put('/{event}/update', 'App\Http\Controllers\EventController@update')->name('update');
    Route::get('/{event}', 'App\Http\Controllers\EventController@show')->name('show');
});



Route::group(['prefix'=>'product','as'=>'product.'], function(){
    Route::post('/create', 'App\Http\Controllers\ProductController@store')->name('list');
    Route::get('/list', 'App\Http\Controllers\ProductController@index')->name('create');
    Route::put('/edit/{event}', 'App\Http\Controllers\ProductController@update')->name('update');
    Route::get('/getOmnitron/', 'App\Http\Controllers\ProductController@getOmnitron')->name('getOmnitron');
    Route::get('/getCollections/', 'App\Http\Controllers\ProductController@getCollections')->name('getCollections');
});






