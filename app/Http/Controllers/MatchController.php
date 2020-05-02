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
use App\Models\Matches as Match;

class MatchController extends Controller
{
   public function __construct(Request $request) 
   {   
      $this->middleware('web'); 
   }
   public function home(){

   	$user = User::all(); 
   	$data =  User::where('id',1)->pluck('name','id'); 
   	$xyz = 10;
   	$css_path = "";
   	return view('website.home',compact('xyz','css_path','user'));
   }
   public function logout(){
       Auth::logout();
      return Redirect::to('/');  
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

   public function contest(Request $request){

      $contest = file_get_contents(url('getContest?match_id='.$request->match_id));
      $match = Match::where('match_id',$request->match_id)->select('short_title','match_id','date_start')->first();
      
      $contest_arr = json_decode($contest);  
      if($contest_arr && $contest_arr->code==200){
         $contest = $contest_arr->response->matchcontests;
         $start_time = $match->date_start??date('Y-m-d H:i:s',$contest_arr->system_time);
      }else{
         $contest = [];
         $start_time =$match->date_start??date('Y-m-d H:i:s');
      }
      $page_title = $match->short_title??'Contest';
      return view('website.contest',compact('contest','start_time','page_title'));
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

   public function signin(User $user){ 

   	return view('signin',compact('user'));

   } 
}
