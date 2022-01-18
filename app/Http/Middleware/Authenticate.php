<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;
class Authenticate extends Middleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }

            return redirect()->guest('auth/login');
        }

        if (request()->user()->is_boost_reviews_user) {
            if (config('APP_URL') == env('APP_TRADIE_REVIEWS_URL')) {
                return redirect(env('APP_GET_REVIEW_BOOST_URL'));
            }
        }
        else{
            if (config('APP_URL') == env('APP_GET_REVIEW_BOOST_URL')) {
                return redirect(env('APP_TRADIE_REVIEWS_URL'));
            }
        }

        return $next($request);
    }
}
