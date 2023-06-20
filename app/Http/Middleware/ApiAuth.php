<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class ApiAuth
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard = null): Response
    {
        if($guard != null){

            Auth::shouldUse($guard);

            try{
                $user = JWTAuth::parseToken()->authenticate();
                // $token =
            }catch(TokenExpiredException $e){
                return $this->returnError(401,'','token is Expired');
            }catch(JWTException $e){
                return $this->returnError('401','',$e->getMessage());
            }
        }else{
            return  $this -> returnError(401,'', 'guard undefined');
        }
        return $next($request);
    }
}
