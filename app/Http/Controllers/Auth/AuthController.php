<?php
namespace App\Http\Controllers\Auth;

use App\Traits\GeneralTrait;
use App\Interface\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;

class AuthController extends Controller
{
    use GeneralTrait;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(protected AuthInterface $authInterface) {

        $guard = request()->route()->parameter('guard');
        $this->middleware("auth:$guard", ['except' => ['login', 'register','verify']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){

        return $this->authInterface->login($request);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {

        return $this->authInterface->register($request);

    }

    public function verify($guard,$email) {
        return $this->authInterface->verfyEmail($email);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
       return $this->authInterface->logout();
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
      return $this->authInterface->refresh();
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return $this->authInterface->userProfile();
    }
}
