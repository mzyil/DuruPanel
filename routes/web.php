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

Route::get('customer', 'Admin\CustomerCrudController@index');

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace' => 'Admin'
], function() {
    Route::get('/customer/{customer_id}/interviews', 'CustomerCrudController@interviews');
    Route::get('/interview/create/{customer_id}', 'InterviewCrudController@create');
    // your CRUD resources and other admin routes here
    CRUD::resource('customer', 'CustomerCrudController');
    CRUD::resource('interview', 'InterviewCrudController');
    CRUD::resource('address', 'AddressCrudController');
});

Route::get('/api/customer', 'Admin\CustomerCrudController@apiIndex');
Route::get('/api/customer/{id}', 'Admin\CustomerCrudController@apiShow');

Route::get('/api/countries', 'Admin\AddressCrudController@apiCountry');
Route::get('/api/countries/{id}', 'Admin\AddressCrudController@apiCountryShow');

Route::get('/api/zones/{country_id}', 'Admin\AddressCrudController@apiZone');
Route::get('/api/zones/show/{id}', 'Admin\AddressCrudController@apiZoneShow');



