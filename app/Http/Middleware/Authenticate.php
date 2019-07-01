<?php

namespace App\Http\Middleware;

use App\Http\Response\Json;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;

class Authenticate extends Middleware {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function redirectTo( $request ) {
        if ( ! $request->expectsJson() ) {
            return route( 'login' );
        }
    }

    /**
     * custom handle method to check auth and response with correct format
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param mixed ...$guards
     *
     * @return Json|mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle( $request, Closure $next, ...$guards ) {
        $response = new Json();
        if ( $this->authenticate( $request, $guards ) === 'auth_error' ) {
            return $response->failureStatus( [], 'Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $next( $request );
    }


    protected function authenticate( $request, array $guards ) {
        if ( empty( $guards ) ) {
            $guards = [ null ];
        }
        foreach ( $guards as $guard ) {
            if ( $this->auth->guard( $guard )->check() ) {
                return $this->auth->shouldUse( $guard );
            }
        }

        return 'auth_error';
    }
}
