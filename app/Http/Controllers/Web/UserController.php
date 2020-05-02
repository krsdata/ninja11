<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response;
use Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL;
use App\Helpers\Helper as Helper;
use PHPMailerAutoload;
use PHPMailer;
use App\Models\Competition;
use App\Models\TeamA;
use App\Models\TeamB;
use App\Models\Toss;
use App\Models\Venue;
use App\Models\Matches;
use App\Models\Player;
use App\Models\TeamASquad;
use App\Models\TeamBSquad;
use App\Models\CreateContest;
use App\Models\CreateTeam;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Rank;
use App\Models\JoinContest;
use App\Models\ReferralCode;
use Modules\Admin\Models\Program;
use Session;

class UserController extends Controller
{
    public $download_link;
    public $referral_bonus;
    public $signup_bonus;
    public $smsUrl;
    
    public function __construct(Request $request) {
        // SMS Url
        $this->smsUrl = "https://sms.waysms.in/api/api_http.php";
        /*APK URL*/
        $apk_updates = \DB::table('apk_updates')->orderBy('id','desc')->first();
        $this->download_link = $apk_updates->url??null;
 
        /*Promotion*/
        $program  = Program::whereDate('end_date','>=',date('Y-m-d'))
            ->get()
            ->transform(function($item, $key){

                if($item->promotion_type==1)
                {
                    $item->referral = true;
                    $item->bonus = false;
                }
                if($item->promotion_type==2)
                {
                    $item->referral = false;
                    $item->bonus = true;
                }
                if($item->trigger_condition==1)
                {
                    $item->signup = true;
                }else{
                    $item->signup = false;
                }

                return $item;
            });
        $signup_bonus = $program->where('signup',true)->first();
        $referral_bonus = $program->where('referral',true)->first();

        $this->referral_bonus = $referral_bonus->amount??5;
        $this->signup_bonus = $signup_bonus->amount??100;
    }

    public function inviteUser(Request $request,User $inviteUser)
    {
        $messages = [
            'user_id.required' => 'Invalid User id',
            'email.required' => 'Provide email id'

        ];
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'email' => 'required|email'
        ],$messages);

        $user_id = $request->get('user_id');
        $invited_user = User::find($user_id);
        // Return Error Message
        if ($validator->fails() || $invited_user ==null) {
            $error_msg =[];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                    'status' => false,
                    "code"=> 201,
                    'message' => $error_msg??'Opps! This user is not available'
                )
            );
        }

        $user_first_name = $invited_user->name ;

        $user_email = $request->input('email');

        /** --Send Mail after Sign Up-- **/

        $user_data     = User::find($user_id);
        $sender_name   = $user_data->name;
        $invited_by    = $user_data->name==null?$invited_user->first_name.' '.$invited_user->last_name:$user_data->name;
        $referal_code  = $user_data->user_name;
        $receipent_name = "Hi,";
        $subject       = ucfirst($sender_name)." has invited you to join Ninja11";

        $email_content = [
            'receipent_email'=> $user_email,
            'subject'=>$subject,
            'receipent_name'=>$receipent_name,
            'invite_by'=>$invited_by,
            'download_link' => $this->download_link,
            'referal_code' => $referal_code
        ];

        $helper = new Helper;

        $invite_notification_mail = $helper->sendNotificationMail($email_content,'invite_notification_mail');

        //$user->save();

        return  response()->json([
                "status"=>1,
                "code"=> 200,
                "message"=>"You've invited your colleague, nice work!",
                'data' => ['receipentEmail'=>$user_email]
            ]
        );
    }

    public function generateUserName(){
        $uname =  Helper::generateRandomString();
        $is_user = 1;
        while ($is_user=null) {
            $is_user = User::where('user_name',$uname)->first();
            if($is_user){
                $uname      = Helper::generateRandomString();
            }
        }
        return $uname;
    }

    public function verifyDocument(Request $request){

        $user = User::find($request->user_id);
        $messages = [
            'user_id.required' => 'Invalid User id',
            'adhar.required' => 'Please upload Adhar card'

        ];
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'pan'       => 'mimes:jpeg,bmp,jpg,png,gif,pdf',
            'adhar'     => 'mimes:jpeg,bmp,jpg,png,gif,pdf'
        ],$messages);

        // Return Error Message
        if ($validator->fails() || $user ==null) {
            $error_msg =[];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                    'status' => false,
                    "code"=> 201,
                    'message' => $error_msg??'Opps! This user is not available'
                )
            );
        }
        $doc = \DB::table('verify_documents')
            ->where('user_id',$user->id)
            ->first();
        if($doc){

            return Response::json(array(
                    'status' => true,
                    "code"=> 200,
                    'message' => $doc->status==1?'Document already verified':'Waiting for approval'
                )
            );
        }

        $data['user_id'] = $user->id;

        if ($request->get('pan')) {

            $bin = base64_decode($request->get('pan'));

            $im = imageCreateFromString($bin);
            if (!$im) {
                die('Base64 value is not a valid image');
            }

            $image_name= $user->id.'_pan'.'.jpg';
            $path = storage_path() . "/image/" . $image_name;
            //file_put_contents($path, $im);
            imagepng($im, $path, 0);
            $urls = url::to(asset('storage/image/'.$image_name));

            $request->merge(['pan_url'=>$urls]);
            $data['pan_url']  = $urls;
            $data['pan'] = $image_name;
            $data['upload_status'] = 'uploaded';
        }

        if ($request->get('adhar')) {
            $bin = base64_decode($request->get('adhar'));
            $im = imageCreateFromString($bin);
            if (!$im) {
                die('Base64 value is not a valid image');
            }

            $image_name= $user->id.'_pan'.'.jpg';
            $path = storage_path() . "/image/" . $image_name;
            //file_put_contents($path, $im);
            imagepng($im, $path, 0);
            $urls = url::to(asset('storage/image/'.$image_name));

            $request->merge(['adhar_url'=>$urls]);
            $data['adhar_url']  = $urls;
            $data['adhar'] = $image_name;
            $data['upload_status'] = 'uploaded';
        }

        if ($request->get('address_proof')) {
            $bin = base64_decode($request->get('address_proof'));
            $im = imageCreateFromString($bin);
            if (!$im) {
                die('Base64 value is not a valid image');
            }

            $image_name= $user->id.'_pan'.'.jpg';
            $path = storage_path() . "/image/" . $image_name;
            //file_put_contents($path, $im);
            imagepng($im, $path, 0);
            $urls = url::to(asset('storage/image/'.$image_name));

            $request->merge(['address_proof_url'=>$urls]);
            $data['address_proof_url']  = $urls;
            $data['address_proof'] = $image_name;
            $data['upload_status'] = 'uploaded';
        }


        $doc = \DB::table('verify_documents')
            ->updateOrInsert(['user_id'=>$user->id],$data);

        return Response::json(array(
                'status' => true,
                "code"=> 200,
                'message' => "Document uploaded.We'll notify you soon."
            )
        );

    }
    public function myReferralDetails(Request $request)
    {
        $referal_user = ReferralCode::where('refer_by',$request->user_id)
            ->select('referral_amount','user_id','is_verified','created_at')
            ->get()
            ->transform(function($item,$key){
                $user = User::find($item->user_id);
                if($user){
                    $item->name = $user->name;
                    return $item; 
                }
               
            })->toArray(); 
          
        if($referal_user){
            return Response::json(array(
                    'status' => true,
                    "code"=> 200,
                    'message' => "List of referal",
                    'referal_user' => array_values(array_filter($referal_user))
                )
            );
        }else{
            return Response::json(array(
                    'status' => false,
                    "code"=> 201,
                    'message' => "No referal user found"
                )
            );
        }

    }
    public function updateAfterLogin(Request $request){

        $refer_by = User::where('referal_code',$request->referral_code)
            ->orWhere('user_name',$request->referral_code)
            ->first();

        $user_id = $request->user_id;
        $user = User::find($user_id);

        if($refer_by && $user)
        {
            $referralCode = new ReferralCode;
            $referralCode->referral_code    =   $request->referral_code;
            $referralCode->user_id          =   $user_id;
            $referralCode->refer_by         =   $refer_by->id;
            $referralCode->save();


            $wallet_trns['user_id']         =  $refer_by->id??null;
            $wallet_trns['amount']          =  $this->referral_bonus;
            $wallet_trns['payment_type']    =  2;
            $wallet_trns['payment_type_string'] = "Referral";
            $wallet_trns['transaction_id']  = time().'-'.$refer_by->id??null;
            $wallet_trns['payment_mode']    = "Ninja11";
            $wallet_trns['payment_details'] = json_encode($wallet_trns);
            $wallet_trns['payment_status']  = "success";

            $wallet_transactions = WalletTransaction::create(
                $wallet_trns
            );

            $wallet = Wallet::firstOrNew(
                [
                    'payment_type' => 2,
                    'user_id' => $refer_by->id
                ]
            );

            $wallet->user_id        = $refer_by->id;
            $wallet->validate_user  = Hash::make($refer_by->id);
            $wallet->payment_type   = 2 ;
            $wallet->payment_type_string = "Referral";
            $wallet->referal_amount = ($wallet->referal_amount)+$this->referral_bonus;
            $wallet->amount = ($wallet->referal_amount)+$this->referral_bonus;

            $wallet->save();
        }

        if($user){
            $user->name             = $request->name;
            $user->mobile_number    = $request->mobile_number;
            $user->phone            = $request->phone;
            $user->profile_image    = $request->image_url;
            $user->reference_code   = $request->referral_code;
            $user->save();

            return Response::json(array(
                    'status' => true,
                    "code"=> 200,
                    'message' => "Details successfully saved",
                    'login_user' =>$user->id
                )
            );
        }else{
            return Response::json(array(
                    'status' => false,
                    "code"=> 201,
                    'message' => "user is not registered"
                )
            );
        }

    }
    public function signup(Request $request, User $user)
    {   
       
        if($request->method()=='GET'){
            return Redirect::to(route('register'));
        }
        
        $request->validate([
         'name' => 'bail|required|min:3',
         'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
         'email' => 'email|required|unique:users,email',
         'password' => 'required|confirmed|min:6'
        ]);  

       $request->merge([
            'role_type' => 3,
            'user_type' => 'website',
            'password'  => Hash::make($request->password),
            'first_name' => $request->name,
            'phone' => $request->mobile_number
       ]); 
        $input = $request->except('_token','password_confirmation','refferal_code');
       
        \DB::beginTransaction();

        $helper = new Helper;
        /** --Create USER-- **/ 

        foreach ($input as $key => $value) {
            $user->$key = $value;
        }
        $uname = strtoupper(substr($user->name, 0, 3)).$this->generateUserName();
        $user->user_name        = $uname;
        $user->referal_code     = $uname;
        $user->reference_code   = $request->refferal_code; 
        $user->save();

        if($user->id){
            $wallet = new Wallet;
            $wallet->user_id = $user->id;
            $wallet->validate_user = Hash::make($user->id);
            $wallet->payment_type  =  1;
            $wallet->payment_type_string = "Bonus";
            $wallet->amount         = $this->signup_bonus;
            $wallet->bonus_amount   = $this->signup_bonus;
            $wallet->save();
            $wallet  =  Wallet::find($wallet->id);

            $wallet_trns['user_id']         =  $user->id??null;
            $wallet_trns['amount']          =  $this->signup_bonus;
            $wallet_trns['payment_type']    =  1;
            $wallet_trns['payment_type_string'] = "Bonus";
            $wallet_trns['transaction_id']  = time().'-'.$user->id??null;
            $wallet_trns['payment_mode']    = "Ninja11";
            $wallet_trns['payment_details'] = json_encode($wallet_trns);
            $wallet_trns['payment_status']  = "success";

            $wallet_transactions = WalletTransaction::updateOrCreate(
                [
                    'payment_type' => 1,
                    'user_id' => $user->id
                ],
                $wallet_trns
            );
        }

        \DB::commit();

        $user  = User::find($user->id);
        $user->validate_user    = Hash::make($user->id);
        $user->reference_code   = $request->referral_code;
        $user->mobile_number    = $request->mobile_number;
        $user->phone            = $request->phone;
        $user->save();

        $token = null; //$user->createToken('Ninja11')->accessToken;
        $user_data['referal_code']     =  $user->user_name;
        $user_data['user_id']          =  $user->id;
        $user_data['name']             =  $user->name;
        $user_data['email']            =  $user->email;
        $user_data['bonus_amount']     =  (float)$wallet->bonus_amount;
        $user_data['mobile_number']    =  ($user->phone==null)?$user->mobile_number:$user->phone;

        $subject = "Welcome to Ninja11! Verify your email address to get started";
        $email_content = [
            'receipent_email'=> $request->input('email'),
            'subject'=>     $subject,
            'greeting'=>    'Ninja11',
            'first_name'=> $request->input('name')??$request->input('first_name')
        ];

        //$verification_email = $helper->sendMailFrontEnd($email_content,'verification_link');

        $notification = new Notification;
        $notification->addNotification('user_register',$user->id,$user->id,'User register','');
 
        $refer_by = User::where('referal_code',$request->referral_code)
            ->orWhere('user_name',$request->referral_code)
            ->first();


        if($refer_by && $user)
        {
            $referralCode = new ReferralCode;
            $referralCode->referral_code    =   $request->referral_code;
            $referralCode->user_id          =   $user->id;
            $referralCode->refer_by         =   $refer_by->id;
            $referralCode->save();

            $wallet_trns['user_id']         =  $refer_by->id??null;
            $wallet_trns['amount']          =  $this->referral_bonus;
            $wallet_trns['payment_type']    =  2;
            $wallet_trns['payment_type_string'] = "Referral";
            $wallet_trns['transaction_id']  = time().'-'.$refer_by->id??null;
            $wallet_trns['payment_mode']    = "Ninja11";
            $wallet_trns['payment_details'] = json_encode($wallet_trns);
            $wallet_trns['payment_status']  = "success";

            $wallet_transactions = WalletTransaction::create(
                $wallet_trns
            );


            $wallet = Wallet::firstOrNew(
                [
                    'payment_type' => 2,
                    'user_id' => $refer_by->id
                ]
            );

            $wallet->user_id        = $refer_by->id;
            $wallet->validate_user  = Hash::make($refer_by->id);
            $wallet->payment_type   = 2 ;
            $wallet->payment_type_string = "Referral";
            $wallet->referal_amount = ($wallet->referal_amount)+$this->referral_bonus;
            $wallet->amount = ($wallet->referal_amount)+$this->referral_bonus;

            $wallet->save();

        }

        if($user){
            $user->name             = $request->name;
            $user->mobile_number    = $request->mobile_number;
            $user->phone            = $request->phone;
            $user->profile_image    = $request->image_url;
            $user->reference_code   = $request->referral_code;
            $user->save();
        }
        //$request->merge(['user_id'=>$user->id]);
       // $this->generateOtp($request);
        // Otp sent to your register email id and mobile number.
        return view('website.register',
            [
                "status"=>true,
                "code"=>200,
                "message"=>"Thank you for registration.",
                'user' => $user
            ]
        );    
         
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->user_id);
        if(!$request->user_id && (User::find($request->user_id))==null)
        {
            return Response::json(array(
                    'status' => false,
                    'code' => 201,
                    'message' => 'Invalid user Id!',
                    'data'  =>  $request->all()
                )
            );
        }

        $table_cname = \Schema::getColumnListing('users');
        $except = ['id','created_at','updated_at','profile_image','referral_code','user_name','password','device_id','user_type','email'];
        $user_data = [];
        foreach ($table_cname as $key => $value) {

            if(in_array($value, $except )){
                continue;
            }

            $udata = $request->get($value);
            if($request->get($value) && $udata!=""){
                $user->$value = $request->get($value);
                $user_data[$value] = $request->get($value);
            }
        }

        if($request->get('profile_image')){
            $profile_image = $this->createImage($request);
            if($profile_image==false){
                return Response::json(array(
                        'status' => false,
                        'code' => 201,
                        'message' => 'Invalid Image format!'
                    )
                );
            }
            $user->profile_image  = $profile_image;
        }

        try{
            $user->save();
            $status = true;
            $code  = 200;
            $message ="Profile updated successfully";
        }catch(\Exception $e){
            $status = false;
            $code  = 201;
            $message =$e->getMessage();
        }

        return response()->json(
            [
                "status" =>$status,
                'code'   => $code,
                "message"=> $message,
                'data'=>isset($user_data)?$user_data:null
            ]
        );

    }

    // Image upload

    public function createImage($request)
    {
        try{
            //  $request->get('image_bytes');
            $bin = base64_decode($request->get('profile_image'));
            $im = imageCreateFromString($bin);
            if (!$im) {
                die('Base64 value is not a valid image');
            }

            $image_name= time().'.jpg';
            $path = storage_path() . "/image/" . $image_name;
            //file_put_contents($path, $im);
            imagepng($im, $path, 0);
            $urls = url::to(asset('storage/image/'.$image_name));
            return $urls;
        }catch(Exception $e){
            return false;
        }

    }

    // Validate user
    public function validateInput($request,$input){
        //Server side valiation

        $validator = Validator::make($request->all(), $input);

        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg      =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            if($error_msg){
                return array(
                    'status' => false,
                    'code' => 201,
                    'message' => $error_msg[0],
                    'data'  =>  $request->all()
                );
            }

        }
    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {   
        if($request->method()=='POST'){
          
         $request->validate([
             'email' => 'email|required',
             'password' => 'required'
         ]); 
        }

        $data = []; 
        $input = $request->all();
        
        $credentials = [
            'email'     =>$request->get('email'),
            'password'  =>$request->get('password'),
            'status'    => 1
        ];

        $auth = Auth::attempt($credentials);

        if ($auth ){
            $usermodel = Auth::user();

            $request->merge(['user_id'=>$usermodel->id]);
            if($usermodel->is_account_verified==0){
               // $this->generateOtp($request);
            }

            $token = null; //$usermodel->createToken('Ninja11')->accessToken;

            $status = true;
            $code = 200;
            $message = "login successfully";
        }else{
            $usermodel = null;
            $status = false;
            $code = 201;
            $message = "login failed";
            $message_failed = "Invalid email or password!";
            $user = new User;
            return view('signin',compact('user','message_failed'));
        }
               
      

        $data = [];
        if($usermodel){
            $wallet  = Wallet::where('user_id',$usermodel->id)->first();
            if($wallet!=null){
                $data['referal_code']  = $usermodel->user_name;
                $data['name'] = $usermodel->name;
                $data['email'] = $usermodel->email;
                $data['user_id'] = $usermodel->id;
                $data['mobile_number'] = $usermodel->mobile_number??$usermodel->phone;
                $data['bonus_amount']     =  (float)$wallet->bonus_amount;
                $data['usable_amount']    = (float)$wallet->usable_amount;
                $status = true;
            }
            
            \DB::table('users')->where('id',$usermodel->id)->update([
                'login_status' => true,
                'device_id' => $request->device_id
            ]);
        } 

        $token = Hash::make(1);
        if($usermodel){
            $token = null;// $usermodel->createToken('Ninja11')->accessToken;
        }

        $apk_updates = \DB::table('apk_updates')->orderBy('id','desc')->first();
        $data['apk_url'] =  $apk_updates->url??null;
        if($data){

            $server = [
                'USER_DEVICE_IP' => $_SERVER['HTTP_X_FORWARDED_FOR']??null,
                //  'COUNTRY_CODE' => $_SERVER['HTTP_CF_IPCOUNTRY']??null,
                'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
                'SERVER_NAME' => $_SERVER['SERVER_NAME'],
                'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
                'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
                'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                'user_id' => $data['user_id']??null

            ];

            $user_id = $data['user_id']??null;
            $user_agents = \DB::table('user_agents')
                ->updateOrInsert(['user_id'=>$user_id],$server);

            return redirect()->intended('getMatch'); 
            return Redirect::to('getMatch');
        }else{
            $message = "Invalid email or password";
            return view('signin',compact('user','message'));
        }

    }

    /* @method : Email Verification
     * @param : token_id
     * Response : jsonṭ
     * Return :token and email
     */


    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        //Server side valiation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        $helper = new Helper;

        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                    'status' => 0,
                    'message' => $error_msg[0],
                    'data'  =>  ''
                )
            );
        }

        $user =   User::where('email',$email)->first();
        if($user==null){
            return Response::json(array(
                    'status' => false,
                    'code' => 201,
                    'message' => "Oh no! The address you provided isn't in our system",
                    'data'  =>  $request->all()
                )
            );
        }
        $user_data = $user;
        $enc = Crypt::encryptString($user->id);

        $links = url('api/v2/changePassword?token='.$enc);

        $email_content = array(
            'receipent_email'   => $request->input('email'),
            'subject'           => 'Your Ninja11 Account Password',
            'name'              => $user->first_name,
            'greeting'          => 'Ninja11',
            'links'             => $links

        );
        $helper = new Helper;
        $email_response = $helper->sendNotificationMail(
            $email_content,
            'forgot_password_link'
        );

        return   response()->json(
            [
                "status"=>true,
                "code"=> 200,
                "message"=>"Reset password link has sent. Please check your email.",
                'data' => $request->all()
            ]
        );
    }

    public function changePassword(Request $request)
    {
        $token = $request->token;
        return view('changePassword',compact('token'));
    }

    public function emailVerification(Request $request)
    {
        $verification_code = $request->input('verification_code');
        $email    = $request->input('email');

        if (Hash::check($email, $verification_code)) {
            $user = User::where('email',$email)->get()->count();
            if($user>0)
            {
                User::where('email',$email)->update(['status'=>1]);
            }else{
                echo "Verification link is Invalid or expire!"; exit();
                return response()->json([ "status"=>0,"message"=>"Verification link is Invalid!" ,'data' => '']);
            }
            echo "Email verified successfully."; exit();
            return response()->json([ "status"=>1,"message"=>"Email verified successfully." ,'data' => '']);
        }else{
            echo "Verification link is Invalid!"; exit();
            return response()->json([ "status"=>0,"message"=>"Verification link is invalid!" ,'data' => '']);
        }
    }


    public function resetPassword(Request $request){

        $user_id =  $request->user_id;
        $old_password =  $request->old_password;
        $current_password =  $request->new_password;

        $messages = [
            'user_id.required' => 'User id is required',
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required'

        ];
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ],$messages);

        $user = User::where('id',$user_id)->first();

        // Return Error Message
        if ($validator->fails() || $user ==null) {
            $error_msg =[];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                    'status' => false,
                    "code"=> 201,
                    'message' => $error_msg[0]??'Opps! This user is not available'
                )
            );
        }

        $credentials = [
            'email'=>$user->email,
            'password'=>$old_password
        ];

        $auth = Auth::attempt($credentials);
        if($auth){
            $user->password = Hash::make($current_password);
            $user->save();
            return response()->json(
                [
                    "status"=>true,
                    'code'=>200,
                    "message"=>"Password reset successfully"
                ]);

        }else{
            return response()->json([ "status"=>false,'code'=>201,"message"=>"Old password do not match. Try again!"]);

        }
    }

    public function temporaryPassword(Request $request){

        $user_id =  $request->user_id;
        $user = User::where('id',$user_id)->first();
        if($user){
            return Response()->json([ "status"=>true,'code'=>200,"message"=>"Temporary Password sent"]);

        }else{
            return response()->json([ "status"=>false,'code'=>201,"message"=>"Email does not exist!"]);
        }
    }

    public function logout(Request $request){
        $user_id =  User::find($request->user_id);
        if($user_id){
            $user_id->login_status = false;
            $user_id->save();
            return response()->json([ "status"=>true,'code'=>200,"message"=>"Logout successfully"]);
        }else{
            return response()->json([ "status"=>false,'code'=>201,"message"=>"User does not"]);
        }
    }

    public function deviceNotification(Request $request){

        $user_id =  User::find($request->user_id);
        $device_id = $request->device_id;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'device_id' => 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg      =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                    'status' => false,
                    'code'=>201,
                    'message' => $error_msg[0]
                )
            );
        }

        if($user_id){
            $user_id->device_id = $device_id;
            $user_id->save();
            return response()->json([ "status"=>true,'code'=>200,"message"=>"notification updated"]);
        }else{
            return response()->json([ "status"=>false,'code'=>201,"message"=>"something went wrong"]);
        }
    }



    public function sendNotification($token, $data){

        $serverLKey = 'AIzaSyAFIO8uE_q7vdcmymsxwmXf-olotQmOCgE';
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $extraNotificationData = $data;

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => $token, //single token
            //'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key='.$serverLKey,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        //echo "result".$result;
        //die;
        curl_close($ch);
        return true;
    }

    public function generateOtp(Request $request){
        $rs = $request->all();
        //dd($rs);
        $validator = Validator::make($request->all(), [
            'user_id' => "required"
        ]);

        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                    'status' => false,
                    'code' => 201,
                    'message' => $error_msg[0],
                    'data' => count($request->all())?$request->all():null
                )
            );
        }

        $otp = mt_rand(1000, 9999);

        $data['otp'] = $otp;
        $user = User::find($request->get('user_id'));

        if($user){
            $data['mobile'] = $user->mobile_number;
            $request->merge(['mobile_number' => $user->mobile_number]);
        }else{
            $data['mobile'] = $request->get('mobile_number');
        }

        $data['user_id'] = $request->get('user_id');
        $data['timezone'] = config('app.timezone');

        \DB::table('mobile_otp')->insert($data);

        $data['email'] = $user->email??$request->get('email');

        $urlencode = urldecode("Your verification \n OTP is : ".$otp."\n Notes: Ninja11 never calls you asking for OTP.");

        if($request->mobile_number){
            $this->sendSMS($request->mobile_number,$urlencode);
        }

        $this->sendOtpOverEmail($user,$otp);
 
        return response()->json(
            [
                "status"    =>  count($data)?true:false,
                'code'      =>  count($data)?200:201,
                "message"   =>  count($data)?"Otp generated and sent":"Something went wrong",
                'data'      =>  $data
            ] 
        );

    }
    public function sendOtpOverEmail($user=null,$otp=null){

        if($user){
            $email_content = [
                'receipent_email'=> $user->email,
                'subject'=> 'Ninja11: Otp Verification',
                'receipent_name'=> $user->name,
                'sender_name'=>'Ninja11',
                'data' => 'Welcome! <br><br>Your verification Otp is : <br><b>'.$otp.'</b>'
            ];

            $helper = new Helper;
            $helper->sendNotificationMail($email_content, 'mail');
            return true;
        }else{
            return false;
        }


    }
    public function verifyOtp(Request $request){
        $rs = $request->all();
        $validator = Validator::make($request->all(), [
            'otp' => "required",
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                    'status' => false,
                    'code' => 201,
                    'message' => $error_msg[0],
                    'data' => $request->all()
                )
            );
        }


        $data = \DB::table('mobile_otp')
            ->where('otp',$request->get('otp'))
            ->where('user_id',$request->get('user_id'))->first();
        if($data){
            \DB::table('mobile_otp')
                ->where('otp',$request->get('otp'))
                ->where('user_id',$request->get('user_id'))->update(['is_verified'=>1]);
            \DB::table('referral_codes')
                ->where('user_id',$request->get('user_id'))
                ->update(['is_verified'=>1,'referral_amount'=>$this->referral_bonus]);

            if($data->mobile){
                \DB::table('users')
                    ->where('id',$request->get('user_id'))
                    ->update(['phone'=>$data->mobile,'is_account_verified'=>1]);
            }

        }
        return response()->json(
            [
                "status"    =>  ($data!=null)?true:false,
                'code'      =>  ($data!=null)?200:201,
                "message"   =>  ($data!=null)?"Otp Verified":"Invalid Otp",
                'data'      =>  $request->all()
            ]
        );
    }

    public function sendSMS($mobileNumber=null,$message=null)
    {

        $url = $this->smsUrl;
        $recipients[] = $mobileNumber;
        $text =  $message;

        $param = array(
            'username' => 'infoway',
            'password' => 'iwapi@!2020',
            'senderid' => 'INFOWA',
            'text' => $text,
            'route' => 'Informative',
            'type' => 'text',
            'datetime' => date('Y-m-d H:i:s'),
            'to' => implode(';', $recipients),
        );

        $post = http_build_query($param, '', '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
        $result = curl_exec($ch);
        if(curl_errno($ch)) {
            $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch($returnCode) {
                case 200 :
                    break;
                default :
                    $result = "HTTP ERROR: " . $returnCode;
            }
        }
        curl_close($ch);
        return true;

    }
}
