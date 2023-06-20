<?php

namespace App\Repositry;

use App\Traits\GeneralTrait;
use App\Mail\VerificationEmail;
use App\Interface\AuthInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthRepositry implements AuthInterface{

    use GeneralTrait;

    public $model ;
    public $guard ;

    public function __construct($model,$guard)
    {

        $this->model= new $model;
        $this->guard= $guard;

    }
    public function login($validator){
        if (! $token = Auth::guard("$this->guard")->attempt($validator->validated())) {
           return $this->returnError(422,'E001','Unauthorized');
        }
        return $this->createNewToken($token);

    }

    public function sendEmail($user){
        Mail::to($user->email)->send(new VerificationEmail($user));
    }

    public function register($validator){

        $user = $this->model->create(array_merge(
        $validator->validated(),
        [
            'password' => bcrypt($validator->password),
            'photo'    => $validator->file('photo')->store('admins'),
        ]
        ));
        // return $user;
        $this->sendEmail($user);
        return $this->returnSuccessMessage(200,'verify your email');

        // return $this->returnData(201,'user',$user);
    }

    public function verfyEmail($email){
        $user = $this->model->where('email',$email)->first();

        if(!$user){
            return $this->returnError(403,501,"This email is not registered");
        }
        $user->verified_at = now();
        $user->save();
        return $this->returnData(201,'user',$user);
        // update()

        // return $this->returnSuccessMessage(200,'email verified');
    }

    public function logout(){
        Auth::guard("$this->guard")->logout();
        return $this->returnSuccessMessage(200,'User successfully signed out');
    }

    public function refresh() {
        return $this->createNewToken(Auth::guard("$this->guard")->refresh());
    }

    public function userProfile() {
        return $this->returnData(200,'user',Auth::guard("$this->guard")->user());
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard("$this->guard")->factory()->getTTL() .' minute',
            'user' => Auth::guard("$this->guard")->user()
        ]);
    }
}
