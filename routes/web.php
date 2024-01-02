<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/','HomeController@index')->name('home');
Route::get('/about','HomeController@about')->name('about');
Route::get('/prefix-rfc','HomeController@statsRFC')->name('stats.rfc');
Route::get('/healthz',function(){
	return response('Good', 200);
});

Route::get('/get/roa/{range}','HomeController@roaRange');
Route::get('/get/roa/{start}/{end}','HomeController@roaDateRange');
Route::get('/get/prefix/{range}/{source}','HomeController@prefixRange');
Route::get('/get/prefix/{start}/{end}/{source}','HomeController@prefixDateRange');
Route::get('/get/as/{range}','HomeController@asRange');
Route::get('/get/as/{start}/{end}','HomeController@asDateRange');
Route::get('/get/prefix-summary/{range}/{source}','HomeController@prefixSummaryRange');
Route::get('/get/prefix-summary/{range}/{source}/{value}','HomeController@prefixSummaryRange');
Route::get('/get/prefix-summary-date/{start}/{end}/{source}','HomeController@prefixSummaryDateRange');
Route::get('/get/as-summary/{range}','HomeController@asSummaryRange');
Route::get('/get/as-summary-date/{start}/{end}','HomeController@asSummaryDateRange');
Route::get('/get/prefix-rfc/{range}','HomeController@rfcNewRegRange');
Route::get('/get/prefix-rfc/{start}/{end}','HomeController@rfcNewRegDateRange');
Route::get('/get/prefix-rfc-summary/{range}','HomeController@rfcSummaryRange');
Route::get('/get/prefix-rfc-summary/{start}/{end}','HomeController@rfcSummaryDateRange');
Route::get('/get/prefix-rfc-data/{range}','HomeController@rfcDataRange');
Route::get('/get/prefix-rfc-data/{start}/{end}','HomeController@rfcDataDateRange');

// login
Route::get('/login','LoginController@login')->name('login');
Route::post('/login','LoginController@postLogin')->name('login.post');
Route::get('/logout','LoginController@logout')->name('logout');

//dahsboard
Route::get('/admin/dashboard',function(){
	return redirect()->route('prefix_history',['page=1']);
})->name('dashboard');
Route::get('/admin/prefix-history','AdminController@prefixHistory')->name('prefix_history');
Route::get('/admin/prefix-history/data/{page}','AdminController@getPrefixHistory')->name('prefix_history.page');
Route::get('/admin/prefix-history/data/{page}/{find}/{value}','AdminController@getPrefixHistoryCustom')->name('prefix_history.find');