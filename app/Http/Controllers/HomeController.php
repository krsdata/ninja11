<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth; 
use App\Models\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Mail,View,Validator,Response,DB,Route,Str; 
use Crypt,okie,Hash,Lang,Input,Closure,URL,HTML,Form,Session; 
use App\Helpers\Helper as Helper;
use Illuminate\Support\Facades\Storage;  
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;  
use Illuminate\Http\Dispatcher;

class HomeController extends Controller
{
   public function __construct(Request $request) 
   {  
      $this->middleware('web'); 
      
   }
   public function home(){ 
   	  return view('website.home');
   }

   public function register(User $user, Request $request){

      if($request->method()=='POST'){
          
         $request->validate([
             'name' => 'bail|required|min:3',
             'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
             'email' => 'email|required|unique:users,email',
             'password' => 'required|confirmed|min:6'
         ]); 
      }
      return view('website.register',compact('user'));
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

   public function signin(User $user, Request $request){ 

      $auth = Auth::check();
      if($auth){
        return redirect('getMatch');
      }
      
      if($request->method()=='POST'){
          
         $request->validate([
             'email' => 'email|required',
             'password' => 'required'
         ]); 

         $data = []; 
        $input = $request->all();
        
        $credentials = [
            'email'     =>$request->get('email'),
            'password'  =>$request->get('password'),
            'status'    => 1
        ];

        $auth = Auth::attempt($credentials);
        if($auth){
            return redirect('getMatch');
        }
      } 
   	return view('signin',compact('user'));

   } 
}
