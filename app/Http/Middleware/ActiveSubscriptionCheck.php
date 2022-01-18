<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;

class ActiveSubscriptionCheck extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $auth_user = request()->user();
        $has_active_subscription = User::select('user.user_id')
            ->where('user.active','=','1')
            ->leftJoin('user_subscription',function($query){
                $query
                    ->on('user_subscription.user_id','=','user.user_id')
                    ->where('user_subscription.type','=','tradiereview');
            })
            ->where('user_subscription.active','=','1')
            ->find($auth_user->user_id);

        if (!$has_active_subscription) {
            return redirect('settings/subscriptions');
        }

        return $next($request);
    }
}
