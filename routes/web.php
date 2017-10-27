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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/ads', function () {
    return view('ad');
})->name('ads')->middleware('auth');

Route::get('/admin', ['middleware' => ['role:admin'], 'uses' =>'AdminController@index'])->name('admin');
Route::get('/admin/categories', function () {
    return view('category');
})->name('categories');
Route::get('/admin/conditions', function () {
    return view('condition');
})->name('conditions')->middleware('auth');
Route::get('/admin/currencies', function () {
    return view('currency');
})->name('currencies')->middleware('auth');
Route::get('/admin/districts', function () {
    return view('district');
})->name('districts')->middleware('auth');

Route::post('/category/search', 'CategoryController@search');
Route::post('/condition/search', 'ConditionController@search');
Route::post('/district/search', 'DistrictController@search');
Route::post('/currency/search', 'CurrencyController@search');
Route::post('/ad/search', 'AdController@search');

Route::resource('/task', 'TaskController');
Route::resource('/category', 'CategoryController');
Route::resource('/condition', 'ConditionController');
Route::resource('/district', 'DistrictController');
Route::resource('/currency', 'CurrencyController');
Route::resource('/ad', 'AdController');
