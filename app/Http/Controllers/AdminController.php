<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use App\Models\Country;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserGiveawayReferral;
use App\Models\UserOnboarding;
use App\Models\UserRegisterQueue;
use App\Models\UserSubscription;
use App\Models\UserTwilioPhone;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin_auth');
    }

    /**
     * Display a dashboard of the resource.
     *
     * @return Response
     */
    public function users()
    {
        $auth_user = Auth::user();
        $users = User::select('user.*','user_signup_ip.ip')
            ->selectRaw('(select current_subscription.subscription_plan_name from user_subscription as current_subscription where current_subscription.user_id = user.user_id and current_subscription.type="tradiereview" and current_subscription.active = 1 limit 1) as current_subscription_name')
            ->where('user.role','=','user')
            ->where('user.active','=','1')
            ->leftJoin('user_subscription',function($query){
                $query
                    ->on('user_subscription.user_id','=','user.user_id')
                    ->where('user_subscription.type','=','tradiereview');
            })
            ->leftJoin('user_signup_ip',function($query){
                $query
                    ->on('user_signup_ip.user_id','=','user.user_id')
                    ->where('user_signup_ip.product','=','tradiereview');
            })
            ->whereNotNull('user_subscription.user_subscription_id')
            ->groupBy('user.user_id')
            ->get();

        return view('admin.users', compact(
            'auth_user',
            'users'
        ));
    }

    public function impersonate($user_id)
    {
        $user = User::select('user.*')
            ->leftJoin('user_subscription',function($query){
                $query
                    ->on('user_subscription.user_id','=','user.user_id')
                    ->where('user_subscription.type','=','tradiereview');
            })
            ->whereNotNull('user_subscription.user_subscription_id')
            ->find($user_id);

        if ($user) {
            Session::flush();
            Auth::logout();
            Auth::loginUsingId($user->user_id);
            return redirect('settings/account');
        }

        return redirect()
            ->back()
            ->with('error','User not found');
    }
    
//    public function referrals(Request $request)
//    {
//        $auth_user = Auth::user();
//        $referrals = UserGiveawayReferral::select('*')
//            ->selectRaw('case when status = "accepted" then 1 else 0 end as accepted_stage')
//            ->orderBy('created_at','desc');
//        $referral_months = Constant::GET_ADMIN_REFERRAL_GIVEAWAY_MONTHS();
//
//        switch ($request['sort_by']) {
//            case 'name_asc':
//                $referrals->orderBy('name','asc');
//            break;
//            case 'name_desc':
//                $referrals->orderBy('name', 'desc');
//            break;
//            case 'email_asc':
//                $referrals->orderBy('email', 'asc');
//            break;
//            case 'email_desc':
//                $referrals->orderBy('email', 'desc');
//            break;
//            case 'type_asc':
//                $referrals->orderBy('months', 'asc');
//            break;
//            case 'type_desc':
//                $referrals->orderBy('months', 'desc');
//            break;
//            case 'sent_asc':
//                $referrals->orderBy('created_at', 'asc');
//            break;
//            case 'sent_desc':
//                $referrals->orderBy('created_at', 'desc');
//            break;
//            case 'status_asc':
//                $referrals->orderBy('status', 'asc');
//                break;
//            case 'status_desc':
//                $referrals->orderBy('status', 'desc');
//            break;
//            case 'accepted_asc':
//                $referrals
//                    ->orderBy('accepted_stage','asc')
//                    ->orderBy('updated_at','asc');
//            break;
//            case 'accepted_desc':
//                $referrals
//                    ->orderBy('accepted_stage','desc')
//                    ->orderBy('updated_at','desc');
//            break;
//        }
//
//        $referrals = $referrals
//            ->groupBy('user_giveaway_referral_id')
//            ->paginate(10);
//
//        return view('admin.referrals',compact(
//            'auth_user',
//            'referrals',
//            'referral_months',
//            'request'
//        ));
//    }
//
//    public function sendReferral(Request $request)
//    {
//        $auth_user = request()->user();
//        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
//            return redirect()
//                ->back()
//                ->withInput()
//                ->with('error','Please type a valid email');
//        }
//
//        if (!$request['name']) {
//            return redirect()
//                ->back()
//                ->withInput()
//                ->with('error','Please specify first name');
//        }
//
//        if (!array_key_exists($request['total_months'],Constant::GET_ADMIN_REFERRAL_GIVEAWAY_MONTHS())) {
//            return redirect()
//                ->back()
//                ->withInput()
//                ->with('error','Please specify first name');
//        }
//
//        /**Check if we have a user*/
//        $user = User::where('email','=',$request['email'])
//            ->orWhere('email','=',strtolower($request['email']))
//            ->orWhere('email','=',strtoupper($request['email']))
//            ->first();
//
//        /**Save queue*/
//        $model = new UserGiveawayReferral();
//        $model->user_id = ($user) ? $user->user_id : null;
//        $model->name = $request['name'];
//        $model->email = $request['email'];
//        $model->code = md5($auth_user->user_id.uniqid().rand(1,100));
//        $model->status = 'pending';
//        $model->months = $request['total_months'];
//        $model->save();
//
//        /**Email User*/
//        NotificationHelper::sendAdminGiveawayReferral($request['name'], $request['total_months'], $model->code, $request['email']);
//        return redirect()
//            ->back()
//            ->with('success','Invitation sent successfully');
//    }

    public function verificationCodes()
    {
        $auth_user = Auth::user();
        $users = UserRegisterQueue::with('Country')->where('type','=','tradiereview')->orderBy('created_at','desc')->get();
        return view('admin.verification_codes',compact(
            'auth_user',
            'users'
        ));
    }
}
