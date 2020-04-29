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

Route::get('/', function () {
    return view('signin');
});
 
/*GET MATCH*/
Route::match(['post','get'],'getMatch', 'Web\WebController@getMatch');


Route::match(['get','post'],'home', 'Web\WebController@getMatch')->name('registration');

Route::match(['get','post'],'contest', 'HomeController@contest');

Route::match(['get','post'],'wallet', 'HomeController@wallet');

Route::match(['get','post'],'joinedMatches', 'HomeController@joinedMatches');

Route::match(['get','post'],'liveMatches', 'HomeController@liveMatches');

Route::match(['get','post'],'resultMatches', 'HomeController@resultMatches');

Route::match(['get','post'],'joined', 'HomeController@joined');

Route::match(['get','post'],'profile', 'HomeController@profile');
