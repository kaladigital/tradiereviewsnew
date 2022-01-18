<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Country;
use App\Models\EarlyAccessUser;
use App\Models\Notification;
use App\Models\SpecialOfferPagePurchase;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserGiveawayReferral;
use App\Models\UserOnboarding;
use App\Models\UserReferralCode;
use App\Models\UserReferralMonthQueue;
use App\Models\UserRegisterQueue;
use App\Models\UserSignupIP;
use App\Models\UserSubscription;
use App\Models\UserTradiereviewRedirect;
use Illuminate\Http\Request;
use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Config;
use Session;


class AuthController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => [
            'getLogout',
            'getLogin',
            'getProduct',
            'loadIframeSync',
            'processReferral'
        ]]);
    }


    public function getLogin()
    {
        /**Should be changed in next updates*/
        if (Auth::guest()) {
            $auth_user = null;
            return view('auth.login', compact('auth_user'));
        }
        else {
            return redirect('/');
        }
    }

    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $auth_user = Auth::user();
            if (!$auth_user->active) {
                $this->deleteLoggedInSessions();
                return redirect()->back()
                    ->with('error', 'Your account is not active');
            }

            if (!$auth_user->has_email_verified) {
                $this->deleteLoggedInSessions();
                return redirect()
                    ->back()
                    ->with('error', 'Your account pending activation, please check your inbox');
            }

            $has_subscriptions = UserSubscription::where('user_id','=',$auth_user->user_id)
                ->where('type','=','tradiereview')
                ->count();

            if (!$has_subscriptions) {
                $this->deleteLoggedInSessions();
                return redirect()
                    ->back()
                    ->with('error', 'You did not purchase this product please contact support');
            }

            if (!$auth_user->desktop_first_login_date_time) {
                $auth_user->desktop_first_login_date_time = Carbon::now()->format('Y-m-d H:i:s');
                $auth_user->update();
            }

            /**Check if IP tracked*/
            $has_ip_tracked = UserSignupIP::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
            if (!$has_ip_tracked) {
                $user_ip_model = new UserSignupIP();
                $user_ip_model->user_id = $auth_user->user_id;
                $user_ip_model->ip = $_SERVER['REMOTE_ADDR'];
                $user_ip_model->product = 'tradiereview';
                $user_ip_model->save();
            }

            return redirect()->intended('settings/account');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Oops login failed');
    }

    public function deleteLoggedInSessions()
    {
        Session::flush();
        Auth::logout();
    }

    public function getLogout()
    {
        $this->deleteLoggedInSessions();
        return redirect('/');
    }

    public function getPasswordReset()
    {
        $auth_user = null;
        return view('auth.password_reset', compact(
            'auth_user'
        ));
    }

    public function postPasswordReset(Request $request)
    {
        $user = User::where('email', '=', $request['email'])->first();
        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Email not found in system');
        }

        if (!$user->active) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unfortunately your account has been disabled');
        }

        $has_subscriptions = UserSubscription::where('user_id','=',$user->user_id)
            ->where('type','=','tradiereview')
            ->count();

        if (!$has_subscriptions) {
            return redirect()
                ->back()
                ->with('error', 'You did not purchase this product please contact support');
        }

        if (!strlen($user->remember_token)) {
            $user->remember_token = hash('md5', bcrypt('password reset' . uniqid() . $user->user_id));
        }

        $user->otp_code = Helper::generateUniqueFourDigits();
        $user->otp_created_date = Carbon::now()->format('Y-m-d H:i:s');
        $user->remember_token = null;
        $user->update();

        NotificationHelper::resetPassword($user);
        Session::put('password_change_user_id',$user->user_id);
        Session::save();
        return redirect('auth/forgot-password/verify');
    }

    public function verifyPassword()
    {
        $password_user_id = Session::get('password_change_user_id');
        if ($password_user_id) {
            $user = User::find($password_user_id);

            if ($user) {
                if (!$user->active) {
                    return redirect('auth/login')
                        ->with('error', 'Unfortunately your account has been disabled');
                }

                if (!$user->has_email_verified) {
                    $user->has_email_verified = '1';

                    if (!$user->desktop_first_login_date_time) {
                        $user->desktop_first_login_date_time = Carbon::now()->format('Y-m-d H:i:s');
                    }

                    $user->update();
                }

                return view('auth.verify_change_password');
            }
        }
        else{
            return redirect('auth/login');
        }

        return redirect('auth/login');
    }

    public function checkPasswordVerificationCode(Request $request)
    {
        $password_user_id = Session::get('password_change_user_id');
        if (!$password_user_id) {
            return response()->json([
                'status' => false,
                'reload' => true
            ]);
        }

        $user = User::where('otp_code','=',$request['code'])->find($password_user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'Wrong code'
            ]);
        }

        if ($user && !$user->active) {
            Session::forget('password_change_user_id');
            return response()->json([
                'status' => false,
                'reload' => true
            ]);
        }

        Session::forget('password_change_user_id');
        Session::put('verified_otp_code',$request['code']);
        Session::save();

        return response()->json([
            'status' => true
        ]);
    }

    public function resetPassword()
    {
        Session::forget('password_change_user_id');
        $verified_code = Session::get('verified_otp_code');
        if (!$verified_code) {
            return redirect('auth/login');
        }

        $user = User::where('otp_code', '=', $verified_code)->where('active','=','1')->first();
        if (!$user) {
            return redirect('auth/login')
                ->with('error','Code expired');
        }

        return view('auth.password_change');
    }

    public function saveNewPassword(Request $request)
    {
        $verified_code = Session::get('verified_otp_code');
        if (!$verified_code) {
            return redirect('auth/login');
        }

        $user = User::where('otp_code', '=', $verified_code)->where('active','=','1')->first();
        if (!$user) {
            return redirect('auth/login')
                ->with('error','Code expired');
        }

        Session::forget('password_change_user_id');
        Session::forget('verified_otp_code');

        $user->password = bcrypt($request['password']);
        $user->twilio_password = $request['password'];
        $user->remember_token = null;
        $user->has_email_verified = '1';
        $user->otp_code = null;
        $user->otp_created_date = null;
        $user->save();

        Auth::loginUsingId($user->user_id);
        return redirect('settings/account');
    }

    public function register($referral = null)
    {
        $signup_user = Session::get('signup_user');
        $auth_user = Auth::user();
        if ($auth_user) {
            return redirect('settings/account');
        }

        if (strlen($referral)) {
            /**Check User Referrals*/
            $user_referral = UserReferralCode::where('referral_code','=',$referral)->where('type','=','tradiereview')->first();
            if (!$user_referral) {
                /**Check Admin Referrals*/
                $admin_referral = UserGiveawayReferral::where('code','=',$referral)->where('status','=','pending')->where('type','=','tradiereview')->first();
                if (!$admin_referral) {
                    return redirect('free-trial');
                }
            }

            $signup_user = $signup_user ? $signup_user : [];
            $signup_user['ref'] = $referral;
            Session::put('signup_user',$signup_user);
        }

        $user = new \StdClass();
        if (isset($signup_user['email'])) {
            $user->email = $signup_user['email'];
        }

        return view('auth.register',compact(
            'user'
        ));
    }

    public function postRegister(Request $request)
    {
        return $this->processRegister($request,'json');
    }

    public function tradieDigitalJoin(Request $request)
    {
        return $this->processRegister($request,'raw');
    }

    private function processRegister($request, $response_type)
    {
        /**Check if we have a user*/
        $has_user = User::where('email','=',$request['email'])
            ->orWhere('email','=',strtolower($request['email']))
            ->orWhere('email','=',strtoupper($request['email']))
            ->count();

        $special_offer_user = SpecialOfferPagePurchase::where('email','=',$request['email'])
            ->where('status','=','paid')
            ->first();

        if ($has_user) {
            $allow_continue = false;
            if ($special_offer_user) {
                $user = User::where('email', '=', $request['email'])->first();
                if ($user) {
                    $has_subscription = UserSubscription::where('user_id', '=', $user->user_id)
                        ->where('type', '=', 'tradiereview')
                        ->first();

                    if ($has_subscription) {
                        Session::flush();
                        if ($response_type == 'json') {
                            return response()->json([
                                'status' => false,
                                'error' => 'You already have an account, please login',
                                'redirect' => '/auth/login'
                            ]);
                        }
                        else{
                            return redirect('auth/login');
                        }
                    }
                }

                $allow_continue = true;
            }

            if (!$allow_continue) {
                if ($response_type == 'json') {
                    return response()->json([
                        'status' => false,
                        'error' => 'Email already taken'
                    ]);
                }
                else{
                    return redirect('free-trial');
                }
            }
        }

        if (!filter_var($request['email'],FILTER_VALIDATE_EMAIL)) {
            if ($response_type == 'json') {
                return response()->json([
                    'status' => false,
                    'error' => 'Please type valid email address'
                ]);
            }
            else{
                return redirect('free-trial');
            }
        }

        UserRegisterQueue::where('email','=',$request['email'])
            ->where('type','=','tradiereview')
            ->delete();

        $signup_user = Session::get('signup_user');

        $model = new UserRegisterQueue();
        $model->email = $request['email'];
        $model->verify_code = rand(1000,9999);
        $model->type = 'tradiereview';
        $model->referral_code = isset($signup_user['ref']) ? $signup_user['ref'] : null;
        $model->save();

        Session::put('signup_user',[
            'email' => $request['email'],
            'verified' => false,
            'password_set' => false
        ]);

        $notification = Notification::where('object_name','=','registerVersionVerification')
            ->where('active','=','1')
            ->first();

        if ($notification) {
            NotificationHelper::registerVersionVerify($notification, $model->verify_code,$model->email);
        }

        if ($response_type == 'json') {
            return response()->json([
                'status' => true
            ]);
        }
        else{
            return redirect('free-trial/step/1');
        }
    }


    public function verifyRegister()
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return redirect('free-trial');
        }

        return view('auth.verify_register',compact(
            'signup_user'
        ));
    }

    public function verifyRegisterCheck(Request $request)
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return response()->json([
                'status' => false,
                'reload' => true
            ]);
        }

        $user_queue = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->where('verify_code','=',$request['code'])
            ->first();

        if (!$user_queue) {
            return response()->json([
                'status' => false,
                'error' => 'Wrong Code'
            ]);
        }

        Session::put('signup_user',[
            'email' => $signup_user['email'],
            'verified' => true,
            'password_set' => false
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function setRegisterPassword()
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return redirect('free-trial');
        }

        if (!$signup_user['verified']) {
            return redirect('register/verify');
        }

        return view('auth.register_new_password');
    }

    public function saveRegisterNewPassword(Request $request)
    {
        $verify_user_id = Session::get('verify_user_id');
        if (!$verify_user_id) {
            return redirect('auth/login');
        }

        $user = User::where('active','=','1')->find($verify_user_id);
        if (!$user) {
            return redirect('auth/login');
        }

        $user->password = bcrypt($request['password']);
        $user->twilio_password = $request['password'];
        if (!$user->desktop_first_login_date_time) {
            $user->desktop_first_login_date_time = Carbon::now()->format('Y-m-d H:i:s');
        }
        $user->update();

        Auth::loginUsingId($user->user_id);
        return redirect('settings');
    }

    public function getProduct($code)
    {
        $check_code = UserTradiereviewRedirect::with('User')
            ->where('code','=',$code)
            ->first();

        if ($check_code && $check_code->User && $check_code->User->active) {
            Auth::loginUsingId($check_code->user_id);
            return redirect('settings');
        }

        return redirect('auth/logout');
    }

    public function registerSavePassword(Request $request)
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        if (!$signup_user['verified']) {
            return response()->json([
                'status' => false,
                'redirect' => 'register/verify'
            ]);
        }

        $user = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if ($user) {
            if (strlen($request['name'])) {
                $user->name = $request['name'];
            }

            $user->password = bcrypt($request['password']);
            $user->update();

            Session::put('signup_user',[
                'email' => $signup_user['email'],
                'verified' => true,
                'password_set' => true
            ]);

            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false,
            'redirect' => '/free-trial'
        ]);
    }

    public function registerStep1()
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return redirect('free-trial');
        }

        if (!$signup_user['verified']) {
            return redirect('register/verify');
        }

        if (!$signup_user['password_set']) {
            return redirect('register/set/password');
        }

        $user = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if (!$user) {
            return redirect('free-trial');
        }

        return view('auth.register_step_one',compact(
            'user'
        ));
    }

    public function registerProcessStep1(Request $request)
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        if (!$signup_user['verified']) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/verify'
            ]);
        }

        if (!$signup_user['password_set']) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/set/password'
            ]);
        }

        $user = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        $user->name = $request['name'];
        $user->update();
        return response()->json([
            'status' => true
        ]);
    }

    public function registerStep2()
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return redirect('free-trial');
        }

        if (!$signup_user['verified']) {
            return redirect('register/verify');
        }

        if (!$signup_user['password_set']) {
            return redirect('register/set/password');
        }

        $user = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if (!$user) {
            return redirect('free-trial');
        }

        if (!strlen($user->name)) {
            return redirect('register/v/step/1');
        }

        return view('auth.register_step_two',compact(
            'user'
        ));
    }

    public function registerProcessStep2(Request $request)
    {
        if (!$request['company']) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial/step/2'
            ]);
        }

        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        if (!$signup_user['verified']) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/verify'
            ]);
        }

        if (!$signup_user['password_set']) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/v/password'
            ]);
        }

        $user = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        if (!strlen($user->name)) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/v/step/1'
            ]);
        }

        $user->company = $request['company'];
        $user->update();
        return response()->json([
            'status' => true
        ]);
    }

    public function registerStep3()
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return redirect('free-trial');
        }

        if (!$signup_user['verified']) {
            return redirect('register/verify');
        }

        if (!$signup_user['password_set']) {
            return redirect('register/set/password');
        }

        $user = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if (!$user) {
            return redirect('free-trial');
        }

        if (!strlen($user->name)) {
            return redirect('free-trial/step/1');
        }

        if (!strlen($user->company)) {
            return redirect('free-trial/step/2');
        }

        $countries = Country::where('is_twilio','=','1')
            ->get();

        $country_code = Config::get('user_geo_country');
        $country_code = $country_code ? strtolower($country_code) : '';
        return view('auth.register_step_three',compact(
            'user',
            'countries',
            'country_code'
        ));
    }

    public function registerProcessStep3(Request $request)
    {
        $signup_user = Session::get('signup_user');
        if (!$signup_user) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        if (!$signup_user['verified']) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/verify'
            ]);
        }

        if (!$signup_user['password_set']) {
            return response()->json([
                'status' => false,
                'redirect' => '/register/set/password'
            ]);
        }

        $user_register_queue = UserRegisterQueue::where('email','=',$signup_user['email'])
            ->where('type','=','tradiereview')
            ->first();

        if (!$user_register_queue) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial'
            ]);
        }

        if (!strlen($user_register_queue->name)) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial/step/1'
            ]);
        }

        if (!strlen($user_register_queue->company)) {
            return response()->json([
                'status' => false,
                'redirect' => '/free-trial/step/2'
            ]);
        }

        /**Check if we have a user*/
        $user = [];
        $has_user = User::where('email','=',$user_register_queue->email)
            ->orWhere('email','=',strtolower($user_register_queue->email))
            ->orWhere('email','=',strtoupper($user_register_queue->email))
            ->count();

        $special_offer_user = SpecialOfferPagePurchase::where('email','=',$user_register_queue->email)
            ->where('status','=','paid')
            ->first();

        if ($has_user) {
            $allow_continue = false;
            if ($special_offer_user) {
                $user = User::where('email','=',$user_register_queue->email)->first();
                if ($user) {
                    $has_subscription = UserSubscription::where('user_id', '=', $user->user_id)
                        ->where('type', '=', 'tradiereview')
                        ->first();

                    if ($has_subscription) {
                        Session::flush();
                        return response()->json([
                            'status' => false,
                            'redirect' => '/auth/login'
                        ]);
                    }
                }

                $allow_continue = true;
            }

            if (!$allow_continue) {
                return response()->json([
                    'status' => false,
                    'redirect' => '/free-trial',
                    'error' => 'User with this account already exists'
                ]);
            }
        }

        /**Process signup*/
        if ($request['country_id']) {
            $country = Country::where('is_twilio','=','1')->find($request['country_id']);
            $request['country_id'] = ($country) ? $request['country_id'] : null;
        }

        /**Get Subscription Code*/
        $active_campaign_action = 'trial_tag';
        $early_access_user = [];
        if ($special_offer_user) {
            $subscription_plan = SubscriptionPlan::where('plan_code','=',$special_offer_user->plan_code)->where('type','=','other')->first();
            $subscription_expiry_date_obj = Carbon::createFromFormat('Y-m-d H:i:s',$special_offer_user->created_at)->addMonth($subscription_plan->duration_num);
        }
        else{
            $early_access_user = EarlyAccessUser::where('email','=',$user_register_queue->email)
                ->where('type','=','tradiereview')
                ->first();

            if ($early_access_user) {
                $subscription_plan = SubscriptionPlan::where('plan_code','=',$early_access_user->subscription_plan_code)->where('type','=','tradiereview')->first();
                if ($early_access_user->subscription_plan_code == 'pro') {
                    $subscription_expiry_date_obj = Carbon::createFromFormat('Y-m-d H:i:s',$early_access_user->created_at)->addMonth();
                }
                else{
                    $subscription_expiry_date_obj = Carbon::createFromFormat('Y-m-d H:i:s',$early_access_user->created_at)->addYear();
                }

                $active_campaign_action = 'purchase_tag';
            }
            else{
                $subscription_plan = SubscriptionPlan::where('plan_code','=','trial')->where('type','=','tradiereview')->first();
                $subscription_expiry_date_obj = Carbon::now()->addDays($subscription_plan->duration_num);
            }
        }

        if (!$subscription_plan) {
            Session::flush();
            return response()->json([
                'status' => false,
                'redirect' => '/auth/login'
            ]);
        }

        /**Create User*/
        $has_special_offer = false;
        if ($special_offer_user && $user) {
            $model = $user;
            $active_campaign_action = 'purchase_tag';
        }
        else {
            $model = new User();
            $model->name = $user_register_queue->name;
            $model->email = $user_register_queue->email;
            $model->password = $user_register_queue->password;
            $model->reviews_company_name = $user_register_queue->company;
            $model->active = '1';
            $model->role = 'user';
            $model->otp_code = null;
            $model->otp_created_date = null;
            $model->tradiereview_subscription_expire_message = '1 free review request remaining of your free trial';
            $model->is_boost_reviews_user = strpos(config('APP_URL'),'getreviewboost') === false ? '0' : '1';

            if ($early_access_user) {
                $model->currency = $early_access_user->currency;
                $model->stripe_customer_id = $early_access_user->stripe_customer_id;
            }
            else{
                if ($request['country_id']) {
                    $model->currency = ($country->code == 'au') ? 'aud' : 'usd';
                }
                else{
                    $model->currency = 'usd';
                }
            }

            /**Track IP*/
            $user_ip_model = new UserSignupIP();
            $user_ip_model->user_id = $model->user_id;
            $user_ip_model->ip = $_SERVER['REMOTE_ADDR'];
            $user_ip_model->product = 'tradiereview';
            $user_ip_model->save();
        }

        if ($special_offer_user) {
            $model->stripe_customer_id = $special_offer_user->stripe_customer_id;
        }

        $model->country_id = $request['country_id'];
        $model->name_initials = Helper::generateInitials($user_register_queue->name);
        $model->has_email_verified = '1';
        $model->save();


        /**Create ActiveCampaign Log*/
        Helper::addActiveCampaignQueueItem($model->user_id,$model->email,$active_campaign_action);

        /**Check User Referrals*/
        if ($user_register_queue->referral_code) {
            $user_referral = UserReferralCode::where('referral_code','=',$user_register_queue->referral_code)->where('type','=','tradiereview')->first();
            if ($user_referral) {
                $referral_queue = new UserReferralMonthQueue();
                $referral_queue->sent_user_id = $user_referral->user_id;
                $referral_queue->received_user_id = $model->user_id;
                $referral_queue->has_admin_sent = '0';
                $referral_queue->type = 'tradiereview';
                $referral_queue->status = 'pending';
                $referral_queue->save();
            }
            else{
                /**Check Admin Referrals*/
                $admin_referral = UserGiveawayReferral::where('code','=',$user_register_queue->referral_code)->where('status','=','pending')->where('type','=','tradiereview')->first();
                if ($admin_referral) {
                    $admin_referral->registered_user_id = $model->user_id;
                    $admin_referral->status = 'accepted';
                    $admin_referral->update();

                    /**Add new expiry days*/
                    $model->tradiereview_subscription_expire_message = null;
                    $model->update();
                    $subscription_expiry_date_obj = Carbon::now()->addMonths($admin_referral->months);
                }
            }
        }

        /**Save Referral Code*/
        $user_referral_code = new UserReferralCode();
        $user_referral_code->user_id = $model->user_id;
        $user_referral_code->referral_code = md5(uniqid().env('APP_KEY').$model->user_id);
        $user_referral_code->type = 'tradiereview';
        $user_referral_code->save();

        /**Update public review URL*/
        $model->public_reviews_code = $model->user_id.uniqid();
        $model->save();

        /**Create Subscription*/
        $user_subscription = new UserSubscription();
        $user_subscription->user_id = $model->user_id;
        $user_subscription->subscription_plan_id = $subscription_plan->subscription_plan_id;
        $user_subscription->subscription_plan_name = $subscription_plan->name;
        $user_subscription->subscription_plan_code = $subscription_plan->plan_code;
        $user_subscription->type = 'tradiereview';
        $user_subscription->expiry_date_time = $subscription_expiry_date_obj->copy()->format('Y-m-d H:i:s');
        $user_subscription->active = '1';

        if ($special_offer_user && $user) {
            $user_subscription->price = $special_offer_user->price;
            $user_subscription->gst_amount = $special_offer_user->gst_amount;
        }
        elseif($early_access_user) {
            $user_subscription->price = $early_access_user->amount;
            $user_subscription->gst_amount = $early_access_user->gst_amount;
        }
        else{
            $user_subscription->price = '0';
        }

        $user_subscription->currency = $model->currency;
        $user_subscription->save();

        /**Create Onboarding*/
        $user_onboarding = new UserOnboarding();
        $user_onboarding->account = '1';
        $user_onboarding->user_id = $model->user_id;
        $user_onboarding->status = 'pending';
        $user_onboarding->type = 'tradiereview';
        $user_onboarding->save();

        /**Notify Admin*/
        try{
            NotificationHelper::signupAdminAlert($model->name, $model->email, $model->reviews_company_name, null, null, null);
        }
        catch (\Exception $e) {

        }

        /**Clear queue*/
        Session::forget('signup_user');
        $user_register_queue->delete();

        /**Login user*/
        Auth::loginUsingId($model->user_id);
        return response()->json([
            'status' => true
        ]);
    }

    public function loadIframeSync($code)
    {
        $check_code = UserTradiereviewRedirect::with('User')
            ->where('code','=',$code)
            ->first();

        if ($check_code && $check_code->User && $check_code->User->active) {
            $check_code->delete();
            $this->deleteLoggedInSessions();
            Auth::loginUsingId($check_code->user_id);
            return redirect('reviews');
        }

        return redirect('404');
    }

    public function referral($code)
    {
        Session::forget('signup_user');
        $user_referral = UserReferralCode::with('User')->where('referral_code','=',$code)->where('type','=','tradiereview')->first();
        if (!$user_referral || !$user_referral->User) {
            return redirect('free-trial');
        }

        $user = $user_referral->User;
        $auth_user = null;
        $app_cdn_url = env('APP_CDN_URL');
        $app_url = config('APP_URL');
        return view('landing.referral',compact(
            'user_referral',
            'user',
            'auth_user',
            'code',
            'app_cdn_url',
            'app_url'
        ));
    }

    public function processReferral(Request $request)
    {
        $user_referral = UserReferralCode::with('User')->where('referral_code','=',$request['code'])->where('type','=','tradiereview')->first();
        if (!$user_referral || !$user_referral->User) {
            return response()->json([
                'status' => false,
                'error' => 'Referral not found'
            ]);
        }

        if (!$request['name'] || !$request['email'] || !filter_var($request['email'],FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => false,
                'error' => 'Please specify name and email'
            ]);
        }

        /**Check if we have a user*/
        $has_user = User::where('email','=',$request['email'])
            ->orWhere('email','=',strtolower($request['email']))
            ->orWhere('email','=',strtoupper($request['email']))
            ->count();

        if ($has_user) {
            return response()->json([
                'status' => false,
                'error' => 'You already have account associated with this email, please login'
            ]);
        }

        UserRegisterQueue::where('email','=',$request['email'])
            ->where('type','=','tradiereview')
            ->delete();

        $model = new UserRegisterQueue();
        $model->name = $request['name'];
        $model->email = $request['email'];
        $model->verify_code = null;
        $model->type = 'tradiereview';
        $model->referral_code = $request['code'];
        $model->save();

        Session::put('signup_user',[
            'email' => $request['email'],
            'name' => $request['name'],
            'verified' => true,
            'password_set' => false
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function completeSpecialOfferRegistration($id)
    {
        $get_offer = SpecialOfferPagePurchase::where('signup_code','=',$id)->where('status','=','paid')
            ->first();

        if ($get_offer) {
            //hosting_flow_reviews, hosting_reviews, flow_reviews
            $user = User::where('email','=',$get_offer->email)->first();
            if ($user) {
                $has_subscription = UserSubscription::where('user_id','=',$user->user_id)
                    ->where('type','=','tradiereview')
                    ->first();

                if ($has_subscription) {
                    return redirect('auth/login');
                }
            }

            Session::put('signup_user',[
                'name' => $get_offer->name,
                'email' => $get_offer->email,
                'verified' => true,
                'password_set' => $user ? true : false
            ]);

            UserRegisterQueue::where('email','=',$get_offer->email)
                ->where('type','=','tradiereview')
                ->delete();

            $model = new UserRegisterQueue();
            $model->name = $get_offer->name;
            $model->email = $get_offer->email;
            $model->verify_code = null;
            $model->type = 'tradiereview';
            $model->save();

            if ($user) {
                return redirect('free-trial/step/1');
            }
        }

        return redirect('register/set/password');
    }

    public function handleEarlyAccessSignup($id)
    {
        $early_access = EarlyAccessUser::where('type','=','tradiereview')
            ->where('signup_code','=',$id)
            ->first();

        if ($early_access) {
            $special_page_offer = SpecialOfferPagePurchase::where('email','=',$early_access->email)
                ->where('status','=','paid')
                ->first();

            if ($special_page_offer) {
                return redirect('auth/login');
            }

            $user = User::select('user.user_id','user_subscription.user_subscription_id')
                ->leftJoin('user_subscription',function($query){
                    $query
                        ->on('user_subscription.user_id','=','user.user_id')
                        ->where('user_subscription.type','=','tradiereview');
                })
                ->where('user.email','=',$early_access->email)
                ->first();

            if ($user && $user->user_subscription_id) {
                return redirect('auth/login');
            }

            $model = new UserRegisterQueue();
            $model->email = $early_access->email;
            $model->verify_code = null;
            $model->type = 'tradiereview';
            $model->save();

            Session::put('signup_user',[
                'email' => $early_access->email,
                'verified' => true,
                'password_set' => false
            ]);

            return redirect('register/set/password');
        }

        return redirect('free-trial');
    }

    public function completeReferralQueue($id)
    {
        $user_queue = UserRegisterQueue::where('type','=','tradiereview')
            ->where('code','=',$id)
            ->first();

        if ($user_queue) {
            Session::put('signup_user',[
                'email' => $user_queue->email,
                'verified' => true,
                'password_set' => $user_queue->password ? true : false,
                'ref' => $user_queue->referral_code
            ]);

            if ($user_queue->password) {
                return redirect('free-trial/step/1');
            }

            return redirect('register/set/password');
        }

        return redirect('free-trial');
    }
}
