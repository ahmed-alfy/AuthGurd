<?php
namespace App\Http\Controllers\Auth;

use App\Interface\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\WorkerRegisterRequest;

class WorkerAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(protected AuthInterface $authInterface) {
        $this->middleware('ApiAuth:worker', ['except' => ['login', 'register','verify']]);
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
    public function register(WorkerRegisterRequest $request) {

        return $this->authInterface->register($request);
    }

    public function verify($email) {
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
