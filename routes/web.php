<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace' => 'Admin'
], function() {
    // your CRUD resources and other admin routes here
    CRUD::resource('customer', 'CustomerCrudController');
    CRUD::resource('interview', 'InterviewCrudController');
    
});

Route::get('/api/customer', 'Admin\CustomerCrudController@apiIndex');
Route::get('/api/customer/{id}', 'Admin\CustomerCrudController@apiShow');
