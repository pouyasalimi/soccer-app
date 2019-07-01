<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Response\Json as JsonResponse;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Manager as JWTManager;
use Tymon\JWTAuth\JWTAuth;
class AuthController extends Controller {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var JsonResponse
     */
    public $response;

    /**
     * @var JWTManager
     */
    protected $JWTManager;

    /**
     * @var JWTAuth
     */
    protected $jwt;

    /**
     * AuthController constructor.
     *
     * @param UserService $userService
     * @param JsonResponse $response
     * @param JWTManager $JWTManager
     * @param JWTAuth $jwt
     */
    public function __construct( UserService $userService, JsonResponse $response, JWTManager $JWTManager, JWTAuth $jwt) {
        $this->userService = $userService;
        $this->response    = $response;
        $this->JWTManager    = $JWTManager;
        $this->jwt    = $jwt;
    }

    /**
     * @param UserRequest $request
     *
     * @return JsonResponse
     */
    public function register( UserRequest $request ) {

        try {
            $this->userService->create( $request );
            return $this->response->successfulStatus( [], 'Successfully registered!', Response::HTTP_CREATED );
        } catch ( \Exception $e ) {
            return $this->response->failureStatus( [], $e->getMessage() );
        }

    }

    /**
     * @param UserRequest $request
     *
     * @return JsonResponse
     */
    public function login( UserRequest $request ) {
        $credentials = $request->only( 'email', 'password' );
        if ( $token = $this->guard()->attempt( $credentials ) ) {
            return $this->response->successfulStatus( [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth( 'api' )->factory()->getTTL(),
            ], '', Response::HTTP_OK, [ 'Authorization' => $token ] );
        }

        return $this->response->failureStatus( [], 'Password mismatch!', Response::HTTP_UNAUTHORIZED );
    }

    /**
     * @return JsonResponse
     */
    public function logout() {
        $this->guard()->logout();

        return $this->response->successfulStatus( [], 'Logged out Successfully.' );
    }

    /**
     * @return JsonResponse
     */
    public function user()
    {
        return $this->response->successfulStatus( $this->userService->user(Auth::user()->id) );
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->response->successfulStatus( [
                'access_token' =>  $token = $this->JWTManager->refresh($this->jwt->getToken())->get(),
                'token_type'   => 'bearer',
                'expires_in'   => auth( 'api' )->factory()->getTTL(),
            ], '', Response::HTTP_OK, [ 'Authorization' => $token ] );

        } catch (JWTException $e) {
            return $this->response->failureStatus([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @return mixed
     */
    private function guard() {
        return Auth::guard();
    }
}
