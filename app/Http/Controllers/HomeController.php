<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{

   public function home(){

   	$user = User::all();
 	

   	$data =  User::where('id',1)->pluck('name','id');


   	$xyz = 10;
   	$css_path = "";
   	return view('website.home',compact('xyz','css_path','user'));

   }

   public function contest(){
      return view('website.contest');
   }

   public function wallet(){
      return view('website.wallet');
   }

   public function joinedMatches(){
      return view('website.joinedMatches');
   }

   public function liveMatches(){
      return view('website.liveMatches');
   }

   public function resultMatches(){
      return view('website.resultMatches');
   }

   public function joined(){
      return view('website.joined');
   }

   public function profile(){
      return view('website.profile');
   }







   

   public function login(){

   	$xyz = 10;
   	return view('website.login',compact('xyz'));

   }

   public function signup(){

   	$xyz = 10;

   	$css = "css_path";

   	return view('website.signup',compact('xyz','css'));

   }
}
