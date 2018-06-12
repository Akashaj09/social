<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Auth\RegisterController;
use DB;
use Auth;

class UserRegisterController extends Controller
{

    public function index(){
        if (Auth::viaRemember()) {
            return redirect("/home");
        }
        return view('register.register');
    }

    public function create(Request $request)
    {
    	$obj = new RegisterController;
    	if($request->registerpassword != $request->registerrepass2){
    		return response()->json(["error" => "Password doesn't matched", "status" => false]);
    	}
    	$data = ["firstname" => $request->firstname, "lastname" => $request->lastname, "registeremail" => $request->registeremail, "registerpassword" => $request->registerpassword];
    	if($result = $obj->create($data)){
            $userdata = ["name" => $request->firstname." ".$request->lastname, "sub" => "Activate your account", "email" => $request->registeremail];

            session(['email' => $request->registeremail, 'password' => $request->registerpassword]);

            $rand = rand(1000, 9999);
            $message = "For your account activation please inter the bellow code in confirm code box <br> $rand";

            DB::table("verify")
                ->insert([
                    'user_id' =>  $result->id,
                    'code' => $rand,
                    'link' => 'null'
                ]);
            new MailController($userdata, $message);

            DB::table("user_profile_picture")->insert([
                'user_id' => $result->id,
                'image' => 'people.png',
                'created_at' => date('Y-m-d h:i:s')
            ]);


    		return response()->json(["success" => "Account created successfully", "status" => true]);
    	}else{
    		return response()->json(["error" => "Something went wrong please try again", "status" => false]);
    	}
    }

    public function verifyindex($email) {
        return view("register.verify");
    }
    public function verify(Request $req)
    {
        $user = DB::table("verify")
                    ->select("verify.*", "users.flag")
                    ->join("users", "users.id", "=", "verify.user_id")
                    ->where("users.email", "=", $req->email)
                    ->first();
        if($user){
            if($user->flag != 1){
                if($req->code == $user->code){
                    $result = DB::table("users")
                        ->where("id",'=' , $user->user_id)
                        ->update([
                            'flag' => 1
                        ]);
                    if($result){
                        $email = $req->session()->get("email");
                        $password = $req->session()->get("password");
                        if($req->email == $email){
                            if (Auth::attempt(['email' => $email, 'password' => $password, 'flag' => 1])) {
                                return response()->json(["status" => true, 'login' => true, "message" => "Logged in successfully"]);   
                            }else{
                                return response()->json(["status" => false, 'login' => false, "message" => "Something went wrong!! Please try again"]);
                            }
                        }else{
                            return response()->json(["status" => true, "session" => true]);
                        }
                    }else{
                        return response()->json(["status" => false, "message" => "Something went wrong!! Please try again"]);
                    }
                }
            }else{
                return response()->json(["status" => false, "message" => "Already verified, go to login page"]);
            }
        }else{
            return response()->json(["status" => false, "message" => "This user isn't registered yet"]);
        }
    }
    public function login(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'flag' => 1], $request->remember)) {
            return response()->json(["status" => true, 'login' => true, "message" => "Logged in successfully"]);   
        }else{
            return response()->json(["status" => false, 'login' => false, "message" => "Something went wrong!! Please try again"]);
        }
    }
}
