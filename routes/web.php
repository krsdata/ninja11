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

Route::group(['middleware' => ['web']], function () { 
	Route::get('/', 'HomeController@signin'); 
	Route::get('login', 'HomeController@signin');
	Route::match(['get','post'], 'login', [
	        'as' => 'login',
	        'uses' => 'HomeController@signin'
	    ]);
	Route::match(['get','post'], 'member/signin', [
	        'as' => 'signin',
	        'uses' => 'Web\UserController@signin'
	    ]);

	/*GET MATCH*/ 
	Route::match(['post','get'],'getMatch', 'Web\WebController@getMatch');
	Route::match(['post','get'],'getContest', 'Web\WebController@getContestByMatch');
	Route::match(['get','post'],'logout', 'MatchController@logout');

	Route::match(['get','post'], 'member/signup', [
	        'as' => 'signup',
	        'uses' => 'Web\UserController@signup'
	    ]);


	Route::match(['get','post'],'contest', 'MatchController@contest');
	Route::match(['get','post'],'register', 'HomeController@register')->name('register');
	Route::match(['get','post'],'signin', 'HomeController@signin');

	Route::match(['get','post'],'wallet', 'HomeController@wallet');

	Route::match(['get','post'],'joinedMatches', 'HomeController@joinedMatches');

	Route::match(['get','post'],'liveMatches', 'HomeController@liveMatches');

	Route::match(['get','post'],'resultMatches', 'HomeController@resultMatches');

	Route::match(['get','post'],'joined', 'HomeController@joined');

	Route::match(['get','post'],'profile', 'HomeController@profile');

});
