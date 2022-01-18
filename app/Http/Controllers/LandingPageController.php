<?php

namespace App\Http\Controllers;
use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use App\Models\ClientReview;
use App\Models\ClientValue;
use App\Models\Country;
use App\Models\EarlyAccessUser;
use App\Models\EmailSubscription;
use App\Models\FAQ;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\ReviewInvite;
use App\Models\SpecialOfferPagePurchase;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserGiveawayReferral;
use App\Models\UserReferralCode;
use App\Models\UserReferralEmailSentLog;
use App\Models\UserReferralMonthQueue;
use App\Models\UserReferralSentDaily;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionLog;
use App\Models\UserTwilioPhone;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cookie;
use Illuminate\Support\Facades\Config;
use Session;
use DB;

class LandingPageController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $auth_user = request()->user();
        $has_subscribed = Cookie::get('has_subscribed');
        if (!$has_subscribed && $auth_user) {
            $has_subscribed = EmailSubscription::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
        }

        $pre_tagline = 'The Easiest Way To Grow Your';
        $tagline = 'Trade, Contracting Or Home Improvement Business';
        $app_cdn_url = env('APP_CDN_URL');
        $currency = Config::get('user_geo_country') == 'AU' ? 'aud' : 'usd';
        return view('landing.index',compact(
            'auth_user',
            'has_subscribed',
            'pre_tagline',
            'tagline',
            'app_cdn_url',
            'currency'
        ));
    }

    public function landingPageFor(Request $request)
    {
        $auth_user = Auth::user();
        $has_subscribed = Cookie::get('has_subscribed');
        if (!$has_subscribed && $auth_user) {
            $has_subscribed = EmailSubscription::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
        }

        $url = str_replace('/','',$request->getRequestUri());
        $url = explode('?',$url)['0'];

        $tagline_items = Helper::getLandingPageTaglineOptions();
        if (!isset($tagline_items[$url])) {
            return redirect('/');
        }

        $pre_tagline = $tagline_items[$url]['headline'].' ';
        $tagline = $tagline_items[$url]['tagline'];

        return view('landing.index',compact(
            'auth_user',
            'has_subscribed',
            'pre_tagline',
            'tagline'
        ));
    }

    public function demo()
    {
        $auth_user = Auth::user();
        $app_cdn_url = env('APP_CDN_URL');
        return view('landing.demo',compact(
            'auth_user',
            'app_cdn_url'
        ));
    }

    public function contactUs()
    {
        $auth_user = request()->user();
        return view('landing.contact_us',compact(
            'auth_user'
        ));
    }

    public function handleContactUs(Request $request)
    {
        if (!Helper::validateRecaptcha($request['recaptcha_token'])) {
            return response()->json([
                'status' => false,
                'error' => 'Captcha is wrong'
            ]);
        }

        if (!isset($request['name']) || !isset($request['email']) || !isset($request['message'])) {
            return response()->json([
                'status' => false,
                'error' => 'Please fill out all fields'
            ]);
        }

        if (!filter_var($request['email'],FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => false,
                'error' => 'Please type valid email'
            ]);
        }

        NotificationHelper::contactUsRequest($request);
        return response()->json([
            'status' => true
        ]);
    }

    public function privacyPolicy()
    {
        $auth_user = Auth::user();
        $has_subscribed = Cookie::get('has_subscribed');
        if (!$has_subscribed && $auth_user) {
            $has_subscribed = EmailSubscription::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
        }

        return view('landing.privacy_policy',compact(
            'auth_user',
            'has_subscribed'
        ));
    }

    public function terms()
    {
        $auth_user = Auth::user();
        $has_subscribed = Cookie::get('has_subscribed');
        if (!$has_subscribed && $auth_user) {
            $has_subscribed = EmailSubscription::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
        }

        return view('landing.terms',compact(
            'auth_user',
            'has_subscribed'
        ));
    }

    public function cookies()
    {
        $auth_user = Auth::user();
        $has_subscribed = Cookie::get('has_subscribed');
        if (!$has_subscribed && $auth_user) {
            $has_subscribed = EmailSubscription::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
        }

        return view('landing.cookies',compact(
            'auth_user',
            'has_subscribed'
        ));
    }

    public function subscribe(Request $request)
    {
        if (!filter_var($request['email'],FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => false,
                'error' => 'Email not valid'
            ]);
        }

        $has_subscribed = false;
        $auth_user = Auth::user();
        $user_subscription = EmailSubscription::where('email','=',$request['email'])->where('product','=','tradiereview')->first();
        if ($user_subscription) {
            if (!$user_subscription->user_id && $auth_user) {
                $user_subscription->user_id = $auth_user->user_id;
                $user_subscription->update();
            }
        }
        else{
            $model = new EmailSubscription();
            $model->user_id = ($auth_user) ? $auth_user->user_id : null;
            $model->email = $request['email'];
            $model->product = 'tradiereview';
            $model->save();

            /**Create ActiveCampaign Log*/
            Helper::addActiveCampaignQueueItem($model->user_id,$model->email,'email_subscriber');

            /**Send out email confirmation*/
            NotificationHelper::emailSubscriptionSubscribed($user_subscription->User->email);
            $has_subscribed = true;
        }

        Session::put('email_subscribed',true);
        Session::save();

        return response()->json([
            'status' => true,
            'subscribed' => $has_subscribed
        ]);
    }

    public function setSubscriberDetails()
    {
        $has_subscribed = Session::get('email_subscribed');
        if ($has_subscribed) {
            Cookie::queue('has_subscribed', true, 60 * 60 * 24 * 365);
            Session::forget('email_subscribed');
        }

        return redirect()
            ->back();
    }

    public function postReview(Request $request)
    {
        $allow_add_review = false;
        if (!Helper::validateRecaptcha($request['recaptcha_token'])) {
            return response()->json([
                'status' => false,
                'error' => 'Captcha is wrong'
            ]);
        }

        $user = null;
        $model = new ClientReview();
        switch ($request['type']) {
            case 'invite':
                $review_invite = ReviewInvite::with('User')
                    ->where('unique_code','=',$request['code'])
                    ->first();

                if ($review_invite->status == 'pending') {
                    $review_invite->status = 'completed';
                    $review_invite->update();

                    $allow_add_review = true;

                    $model->user_id = $review_invite->user_id;
                    $model->has_invited = '1';
                    $user = $review_invite->User;
                }
                else{
                    return response()->json([
                        'status' => false,
                        'error' => 'You have already posted a review',
                        'reload' => true
                    ]);
                }
            break;
            case 'public':
                $user = User::where('public_reviews_code','=',$request['code'])->first();
                if ($user) {
                    $allow_add_review = true;
                    $model->user_id = $user->user_id;
                    $model->is_public_review = '1';
                }
                //check subscription too
            break;
        }

        $current_subscription = UserSubscription::where('user_id', $user->user_id)
            ->where('active', '=', '1')
            ->where('type','=','tradiereview')
            ->latest()
            ->first();

        if (!$current_subscription || ($current_subscription && $current_subscription->subscription_plan_code == 'trial' && ClientReview::where('user_id','=',$user->user_id)->count())) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'reload' => true
            ]);
        }

        if ($allow_add_review) {
            /**Email Validation*/
            if (!filter_var($request['email'],FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'status' => false,
                    'error' => 'Please provide valid email'
                ]);
            }

            /**Phone Country Validation*/
            $phone_country = Country::where('is_twilio','=','1')
                ->where('code','=',$request['phone_country'])
                ->first();

            if (!$phone_country) {
                return response()->json([
                    'status' => false,
                    'error' => 'Country not supported'
                ]);
            }

            $model->rate = $request['rate'];
            $model->reviewer_name = $request['name'];
            $model->reviewer_email = $request['email'];
            $model->reviewer_phone = $phone_country->number.preg_replace('/[^0-9.]+/', '', $request['phone']);
            $model->reviewer_phone_country = $request['phone_country'];
            $model->reviewer_phone_format = $request['phone'];
            $model->description = $request['review'];
            $model->save();

            if ($current_subscription->subscription_plan_code == 'trial') {
                /**Update Subscription Expire Message For User*/
                $user->tradiereview_subscription_expire_message = '0 free review request remaining of your free trial';
                $user->update();

                $padding_period = Constant::GET_FINAL_SUBSCRIPTION_EXPIRY_DAYS();
                $current_subscription->final_expiry_date_time = Carbon::now()->addDays($padding_period)->format('Y-m-d H:i:s');
                $current_subscription->update();

                /**Popup Notifications*/
                if (!$current_subscription->last_popup_notification_date || ($current_subscription->last_popup_notification_date && $current_subscription->last_popup_notification_date != Carbon::now()->format('Y-m-d'))) {
                    Helper::handlePopupNotifications($padding_period, $current_subscription);
                }

                NotificationHelper::freeTrialExpiredNotification($user->name, $user->is_boost_reviews_user, $user->email);
            }

            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false,
            'error' => 'Link has been expired, please try again later'
        ]);
    }

    public function addPublicReview($id)
    {
        $user = User::where('public_reviews_code','=',$id)
            ->first();

        if (!$user) {
            return redirect('/');
        }

        $current_subscription = UserSubscription::where('user_id', $user->user_id)
            ->where('active', '=', '1')
            ->where('type','=','tradiereview')
            ->latest()
            ->first();

        if (!$current_subscription || ($current_subscription && $current_subscription->subscription_plan_code == 'trial' && ClientReview::where('user_id','=',$user->user_id)->count())) {
            return view('landing.leave_review_deprecated',compact(
                'user'
            ));
        }

        $client = [];
        $review_invite = [];
        $phone_countries = Country::where('is_twilio','=','1')->pluck('number','code');
        $user_twilio_phone = UserTwilioPhone::where('user_id','=',$user->user_id)->where('status','=','active')->first();
        $rate_points = Constant::GET_RATE_SCORE_POINTS();
        $rate = 5;
        $app_cdn_url = env('APP_CDN_URL');
        return view('landing.leave_review',compact(
            'rate',
            'client',
            'phone_countries',
            'user_twilio_phone',
            'id',
            'rate_points',
            'review_invite',
            'user',
            'app_cdn_url'
        ));
    }

    public function reviewInvite(Request $request, $id)
    {
        $review_invite = ReviewInvite::with('User')
            ->where('unique_code','=',$id)
            ->first();

        if (!$review_invite || !$review_invite->User) {
            return redirect('/');
        }

        $client = [];
        $phone_countries = Country::where('is_twilio','=','1')->pluck('number','code');
        $user_twilio_phone = UserTwilioPhone::where('user_id','=',$review_invite->user_id)->where('status','=','active')->first();
        $rate_points = Constant::GET_RATE_SCORE_POINTS();
        $review_rates = Constant::GET_REVIEW_RATE_SCORES();
        $rate = array_key_exists($request['r'],$review_rates) ? $review_rates[$request['r']] : 5;
        $user = $review_invite->User;
        return view('landing.leave_review',compact(
            'rate',
            'client',
            'phone_countries',
            'user_twilio_phone',
            'id',
            'rate_points',
            'review_invite',
            'user'
        ));
    }

    public function earlyAccess($subscription_type = null)
    {
        $auth_user = Auth::user();
        if ($auth_user) {
            return redirect('settings/account');
        }

        if ($subscription_type && !in_array($subscription_type,['monthly','yearly'])) {
            return redirect('early-access');
        }

        $subscription_type = $subscription_type ? $subscription_type : 'monthly';

        $has_subscribed = Cookie::get('has_subscribed');
        if (!$has_subscribed && $auth_user) {
            $has_subscribed = EmailSubscription::where('user_id','=',$auth_user->user_id)->where('product','=','tradiereview')->count();
        }

        if (Config::get('user_geo_country') == 'AU') {
            $currency = 'aud';
            $currency_label = 'AUD ';
        }
        else{
            $currency = 'usd';
            $currency_label = '$';
        }

        $subscription_plans = SubscriptionPlan::whereIn('plan_code',['pro','yearly'])->where('type','=','tradiereview')->get();
        $subscription_plan_data = [];
        foreach ($subscription_plans as $item) {
            $price = ($currency == 'aud') ? $item->price_aud : $item->price_usd;
            $item['price'] = $price;
            $item['discounted_price'] = sprintf('%.2f',$price / 2);
            $item['gst_discount_price'] = sprintf('%.2f',$item['discounted_price'] / 10);
            $item['gst_price'] = sprintf('%.2f',$item['price'] / 10);
            $item['total_price'] = sprintf('%.2f',$item['discounted_price'] + $item['gst_discount_price']);
            $subscription_plan_data[$item->plan_code] = $item;
        }

        $selected_plan = ($subscription_type == 'yearly') ? $subscription_plan_data['yearly'] : $subscription_plan_data['pro'];
        $app_cdn_url = env('APP_CDN_URL');
        return view('landing.early_access',compact(
            'auth_user',
            'has_subscribed',
            'selected_plan',
            'subscription_type',
            'app_cdn_url',
            'currency',
            'currency_label',
            'subscription_plan_data'
        ));
    }

    public function purchaseEarlyAccess(Request $request)
    {
        $auth_user = Auth::user();
        if ($auth_user) {
            return response()
                ->json([
                    'status' => false,
                    'error' => 'Please logout to purchase a new plan'
                ]);
        }

        if (!$request['email'] || !filter_var($request['email'],FILTER_VALIDATE_EMAIL) || !$request['token']) {
            return response()->json([
                'status' => false,
                'error' => 'Email is not valid'
            ]);
        }

        $has_purchased = EarlyAccessUser::where('email','=',$request['email'])
            ->where('type','=','tradiereview')
            ->first();
        if ($has_purchased) {
            return response()->json([
                'status' => false,
                'error' => 'You have already purchased a '.($has_purchased->subscription_plan_code == 'pro' ? 'monthly' : 'yearly').' subscription for this email'
            ]);
        }

        /**Detect currency*/
        $currency = ($request['currency'] == 'usd') ? 'usd' : 'aud';

        /**Has account*/
        $user = User::where('email','=',$request['email'])->first();
        $has_old_subscription = false;
        if ($user) {
            /**Check for TradieReviews Subscription*/
            $had_tradiereviews_subscription = UserSubscription::where('user_id','=',$user->user_id)
                ->where('type','=','tradiereview')
                ->first();

            if ($had_tradiereviews_subscription) {
                /**Check if is expired or trial*/
                $had_paid_subscription = UserSubscription::where('user_id','=',$user->user_id)
                    ->where('subscription_plan_code','!=','trial')
                    ->where('type','=','tradiereview')
                    ->first();

                if ($had_paid_subscription) {
                    return response()->json([
                        'status' => false,
                        'error' => 'You already have an account created, please login to upgrade subscription'
                    ]);
                }

                $has_old_subscription = true;
            }

            if ($currency !== $user->currency) {
                return response()->json([
                    'status' => false,
                    'currency' => $user->currency,
                    'error' => 'You have already purchased a TradieReviews account and payed for it in '.$user->currency.'. Therefore, we can only process your payment in '.$user->currency.'. Please click on the Checkout button to complete your payment!'
                ]);
            }
        }

        $subscription_plan = SubscriptionPlan::where('plan_code','=',$request['plan'] == 'yearly' ? 'yearly' : 'pro')
            ->where('type','=','tradiereview')
            ->first();

        if ($currency == 'aud') {
            $subscription_plan_amount = $request['discount'] ? $subscription_plan->price_aud / 2 : $subscription_plan->price_aud;
        }
        else{
            $subscription_plan_amount = $request['discount'] ? $subscription_plan->price_usd / 2 : $subscription_plan->price_usd;
        }

        $subscription_plan_amount = sprintf('%.2f',$subscription_plan_amount);
        $gst_amount = sprintf('%.2f',$subscription_plan_amount / 10);
        $subscription_plan_amount += $gst_amount;
        $subscription_plan_amount = sprintf('%.2f',$subscription_plan_amount);

        /**Create Stripe Customer*/
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $stripe_card = null;
            if ($user && $user->stripe_customer_id) {
                $stripe_card = $stripe->customers->createSource(
                    $user->stripe_customer_id,
                    ['source' => $request['token']]
                );

                /**Set Default Card*/
                $stripe->customers->update(
                    $user->stripe_customer_id,
                    ['default_source' => $stripe_card->id]
                );

                $stripe_customer = new \stdClass();
                $stripe_customer->id = $user->stripe_customer_id;
            }
            else{
                $stripe_customer = $stripe->customers->create([
                    'email' => $request['email'],
                    'description' => 'Customer early access '.$request['email'],
                    'source' => $request['token']
                ]);
            }

            /**Process Charge*/
            if (isset($stripe_customer->id) && $stripe_customer->id) {
                $charge_account = true;
                if ($stripe_card) {
                    $stripe_charge = $stripe->charges->create([
                        'amount' => $subscription_plan_amount * 100,
                        'currency' => $currency,
                        'customer' => $user->stripe_customer_id,
                        'description' => 'Charge for TradiewReviews early access ' . $request['email'],
                    ]);

                    if (isset($stripe_charge->id) && $stripe_charge->id) {
                        $charge_account = false;
                        $get_all_cards = $stripe->customers->allSources(
                            $stripe_customer->id,
                            ['object' => 'card', 'limit' => 3]
                        );

                        /**Delete old cards*/
                        foreach ($get_all_cards as $item) {
                            if ($item->id !== $stripe_card->id) {
                                $stripe->customers->deleteSource(
                                    $stripe_customer->id,
                                    $item->id,
                                    []
                                );
                            }
                        }
                    }
                    else{
                        $stripe->customers->deleteSource(
                            $stripe_customer->id,
                            $stripe_card->id,
                            []
                        );

                        return response()->json([
                            'status' => false,
                            'error' => 'Payment failed, please try a different card or try again later'
                        ]);
                    }
                }

                if ($charge_account) {
                    $stripe_charge = $stripe->charges->create([
                        'amount' => $subscription_plan_amount * 100,
                        'currency' => $currency,
                        'customer' => $stripe_customer->id,
                        'description' => 'Charge for early access ' . $request['email'],
                    ]);
                }

                if (isset($stripe_charge->id)) {
                    /**Create User*/
                    $model = new EarlyAccessUser();
                    $model->email = $request['email'];
                    $model->amount = $subscription_plan_amount;
                    $model->payment_details = json_encode($stripe_charge);
                    $model->stripe_charge_id = $stripe_charge->id;
                    $model->stripe_customer_id = $stripe_customer->id;
                    $model->subscription_plan_id = $subscription_plan->subscription_plan_id;
                    $model->subscription_plan_code = $subscription_plan->plan_code;
                    $model->type = 'tradiereview';
                    $model->has_discount_accepted = ($request['discount']) ? '1' : '0';
                    $model->signup_code = md5($model->email.uniqid());
                    $model->currency = $currency;
                    $model->gst_amount = $gst_amount;
                    $model->save();

                    /**Send Out Email Confirmation*/
                    if ($model->subscription_plan_code == 'pro') {
                        $expiry_date_format = Carbon::now()->addMonth()->format('F j, Y');
                        $expiration_date_time = Carbon::now()->copy()->addMonth(1)->format('Y-m-d H:i:s');
                    }
                    else{
                        $expiry_date_format = Carbon::now()->addYear()->format('F j, Y');
                        $expiration_date_time = Carbon::now()->copy()->addYear(1)->format('Y-m-d H:i:s');
                    }

                    /**Create New Subscription*/
                    if ($has_old_subscription) {
                        $user_subscriptions = UserSubscription::where('user_id','=',$user->user_id)
                            ->where('type','=','tradiereview')
                            ->get();

                        $insert_data = [];
                        $item_delete_ids = [];
                        foreach ($user_subscriptions as $item) {
                            $insert_data[] = $item->toArray();
                            $item_delete_ids[] = $item->user_subscription_id;
                        }

                        UserSubscriptionLog::insert($insert_data);
                        UserSubscription::whereIn('user_subscription_id',$item_delete_ids)->delete();

                        $model = new UserSubscription();
                        $model->active = '1';
                        $model->is_extendable = '1';
                        $model->type = 'tradiereview';
                        $model->user_id = $user->user_id;
                        $model->subscription_plan_id = $subscription_plan->subscription_plan_id;
                        $model->subscription_plan_name = $subscription_plan->name;
                        $model->subscription_plan_code = $subscription_plan->plan_code;
                        $model->expiry_date_time = $expiration_date_time;
                        $model->price = ($currency == 'usd') ? $subscription_plan->price_usd : $subscription_plan->price_aud;
                        $model->gst_amount = $gst_amount;
                        $model->currency = $currency;
                        $model->discount_code = 'early_access';
                        $model->discounted_price = $subscription_plan_amount;
                        $model->discount_pay_expiry_date = Carbon::createFromFormat('Y-m-d H:i:s',$expiration_date_time)->addDay('-1')->format('Y-m-d');
                        $model->save();

                        /**Update Stripe*/
                        $user->stripe_customer_id = $stripe_customer->id;
                        $user->update();
                    }

                    /**If Existing User*/
                    if ($stripe_card) {
                        NotificationHelper::earlyAccessPurchasedExistingUserNotification($subscription_plan_amount, $currency, $subscription_plan->name, $expiry_date_format, $request['email']);
                    }
                    else{
                        NotificationHelper::earlyAccessPurchasedNotification($model->signup_code, $subscription_plan_amount, $currency, $subscription_plan->name, $expiry_date_format, $request['email']);
                    }
                    return response()->json([
                        'status' => true,
                        'login_redirect' => $has_old_subscription
                    ]);
                }
            }
        } catch (\Exception $e) {

        }

        return response()->json([
            'status' => false,
            'error' => 'Payment failed, please try a different card or try again later'
        ]);
    }

    public function referFriend()
    {
        $auth_user = Auth::user();
        $has_limit_reached = false;
        $app_url = config('APP_URL');
        $app_cdn_url = env('APP_CDN_URL');
        $referral_code = null;
        $max_allowed_send_referrals = 10;
        if ($auth_user) {
            $user_referral_code = UserReferralCode::where('user_id','=',$auth_user->user_id)->where('type','=','tradiereview')->first();
            $referral_code = $user_referral_code->referral_code;

            $total_allowed_daily = Constant::GET_TOTAL_REFERRALS_SEND_LIMIT();
            $get_daily_send_referrals = UserReferralSentDaily::where('user_id','=',$auth_user->user_id)
                ->where(DB::raw('DATE(created_at)'),'=',Carbon::now()->format('Y-m-d'))
                ->where('type','=','tradiereview')
                ->first();

            if ($get_daily_send_referrals) {
                if ($get_daily_send_referrals->total_sent == $total_allowed_daily) {
                    $has_limit_reached = true;
                    $max_allowed_send_referrals = 0;
                }
                else{
                    $remaining_items = $total_allowed_daily - $get_daily_send_referrals->total_sent;
                    $max_allowed_send_referrals = $remaining_items > 10 ? 10 : $remaining_items;
                }
            }
        }

        return view('landing.refer_friend',compact(
            'auth_user',
            'app_cdn_url',
            'has_limit_reached',
            'app_url',
            'referral_code',
            'max_allowed_send_referrals'
        ));
    }

    public function checkReferAuth(Request $request)
    {
        $auth_user = Auth::user();
        if ($auth_user) {
            $user_referral_code = UserReferralCode::where('user_id','=',$auth_user->user_id)->where('type','=','tradiereview')->first();
            return response()->json([
                'status' => true,
                'code' => $user_referral_code->referral_code
            ]);
        }
        else{
            $check_user = UserSubscription::select('user.user_id')
                ->leftJoin('user','user.user_id','=','user_subscription.user_id')
                ->where('user_subscription.type','=','tradiereview')
                ->where('user.email','=',$request['email'])
                ->first();

            if ($check_user) {
                $user_referral_code = UserReferralCode::where('user_id','=',$check_user->user_id)->where('type','=','tradiereview')->first();
                return response()->json([
                    'status' => true,
                    'code' => $user_referral_code->referral_code,
                    'check' => true
                ]);
            }
        }

        return response()->json([
            'status' => false
        ]);
    }

    public function sendReferFriendInvitations(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            $user = UserSubscription::select('user.user_id')
                ->leftJoin('user','user.user_id','=','user_subscription.user_id')
                ->where('user_subscription.type','=','tradiereview')
                ->where('user.email','=',$request['email'])
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => 'Please login in order to send referrals'
                ]);
            }
        }

        $aiming_to_send = count($request['data']);
        if ($aiming_to_send > 10) {
            return response()->json([
                'status' => false,
                'error' => 'You can send max 10 invites at a time'
            ]);
        }

        $emails = [];
        foreach ($request['data'] as $item) {
            if (!filter_var($item['email'],FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'status' => false,
                    'error' => 'Provided email '.$item['email'].' is not valid email'
                ]);
            }

            if (in_array($item['email'],$emails)) {
                return response()->json([
                    'status' => false,
                    'error' => 'Provided email '.$item['email'].' exists multiple time in list'
                ]);
            }

            $emails[] = $item['email'];
        }

        $total_allowed_daily = Constant::GET_TOTAL_REFERRALS_SEND_LIMIT();
        $daily_send_model = UserReferralSentDaily::where('user_id','=',$user->user_id)
            ->where(DB::raw('DATE(created_at)'),'=',Carbon::now()->format('Y-m-d'))
            ->where('type','=','tradiereview')
            ->first();

        if ($daily_send_model) {
            $remaining_to_send = $total_allowed_daily - $daily_send_model->total_sent;
            if ($remaining_to_send <= 0) {
                return response()->json([
                    'status' => false,
                    'limit_reached' => true,
                    'error' => 'You have already reached daily 100 referrals sending limit'
                ]);
            }

            if ($aiming_to_send > $remaining_to_send) {
                return response()->json([
                    'status' => false,
                    'limit_reached' => true,
                    'error' => 'You can send '.$remaining_to_send.' but already listed '.$aiming_to_send.' emails'
                ]);
            }

            $daily_send_model->total_sent += $aiming_to_send;
            $daily_send_model->update();
        }
        else{
            $daily_send_model = new UserReferralSentDaily();
            $daily_send_model->user_id = $user->user_id;
            $daily_send_model->type = 'tradiereview';
            $daily_send_model->total_sent = $aiming_to_send;
            $daily_send_model->save();
        }

        $user_referral_code = UserReferralCode::where('user_id','=',$user->user_id)->where('type','=','tradiereview')->first();
        $referral_send_model = UserReferralEmailSentLog::where('user_id','=',$user->user_id)->where('type','=','tradiereview')->first();
        if ($referral_send_model) {
            $referral_send_model->total_sent += $aiming_to_send;
            $referral_send_model->save();
        }
        else{
            $referral_send_model = new UserReferralEmailSentLog();
            $referral_send_model->user_id = $user->user_id;
            $referral_send_model->type = 'tradiereview';
            $referral_send_model->total_sent += $aiming_to_send;
            $referral_send_model->save();
        }

        foreach ($request['data'] as $item) {
            NotificationHelper::sendReferFriendEmail($user->name, $user_referral_code->referral_code, $item['name'], $item['email']);
        }

        $total_remaining = $total_allowed_daily - $daily_send_model->total_sent;
        $max_allowed_send_referrals = $total_remaining > 10 ? 10 : $total_remaining;

        return response()->json([
            'status' => true,
            'limit_reached' => $max_allowed_send_referrals == 0,
            'max_allowed_send_referrals' => $max_allowed_send_referrals
        ]);
    }

    public function processCheckout(Request $request)
    {
//        file_put_contents('data.txt',$request->all());die;
//        var_dump($request->all());die;
    }
}
