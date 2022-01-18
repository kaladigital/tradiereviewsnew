<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use App\Helpers\XeroHelper;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Country;
use App\Models\DiscountCode;
use App\Models\Notification;
use App\Models\SubscriptionPlan;
use App\Models\TextMessage;
use App\Models\User;
use App\Http\Requests\InvoiceSettingsRequest;
use App\Models\UserForm;
use App\Models\UserFormPage;
use App\Models\UserFormPageForm;
use App\Models\UserNotification;
use App\Models\UserOnboarding;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionLog;
use App\Models\UserXeroAccount;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Count;
use Session;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        if ($user_onboarding->status == 'pending') {
            $auth_user->onboarding_state = Helper::caclulateUserOnboardingState($auth_user, $user_onboarding);
        }

        return view('settings.index',compact(
            'auth_user',
            'user_onboarding'
        ));
    }

    public function account()
    {
        $auth_user = Auth::user();
        $countries = Helper::getCountryList();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        if ($user_onboarding->status == 'pending') {
            if (!$user_onboarding->account) {
                $user_onboarding->account = '1';
                $user_onboarding->update();
            }
            $auth_user->onboarding_state = Helper::caclulateUserOnboardingState($auth_user, $user_onboarding);
        }

        if (!$user_onboarding->first_onboarding_passed) {
            $user_onboarding->first_onboarding_passed = '1';
            $user_onboarding->update();
        }

        return view('settings.account', compact(
            'auth_user',
            'countries',
            'user_onboarding'
        ));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $auth_user = Auth::user();
        /**Check Email*/
        if (!filter_var($auth_user->email, FILTER_VALIDATE_EMAIL)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors('Email is not valid');
        }

        $email_taken = User::where('email', '=', $auth_user->email)->where('user_id', '!=', $auth_user->user_id)->count();
        if ($email_taken) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors('Email is already taken');
        }

        if (!Country::find($request['country_id'])) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors('Country is required');
        }

        $request['name_initials'] = Helper::generateInitials($request['name']);
        if (!$auth_user->gmail_token) {
            $request['gmail_token'] = md5($auth_user->user_id.env('APP_KEY').'_gmail'.uniqid());
        }

        $request['is_reviews_display_name'] = ($request['is_reviews_display_name']) ? '1' : '0';
        $auth_user->update($request->only([
            'name',
            'name_initials',
            'email',
            'website_url',
            'country_id',
            'zip_code',
            'reviews_company_name',
            'website_url',
            'is_reviews_display_name'
        ]));
        return $this->skipOnboarding('account');
    }

    public function skipOnboarding($type)
    {
        $user_onboarding = Helper::getUserOnboarding(request()->user());
        switch ($type) {
            case 'account':
                if ($user_onboarding->status == 'pending') {
                    if ($user_onboarding->account) {
                        if (!$user_onboarding->reviews) {
                            return redirect('settings/reviews');
                        }
                        elseif(!$user_onboarding->subscriptions) {
                            return redirect('settings/subscriptions');
                        }
                        else {
                            return redirect('settings/security');
                        }
                    }
                    else{
                        $user_onboarding->account = '1';
                        $user_onboarding->update();
                        return redirect('settings/reviews');
                    }
                }
                else{
                    return redirect('settings/account')
                        ->with('success', 'Account updated successfully');
                }
            break;
            case 'reviews':
                if ($user_onboarding->status == 'pending') {
                    if ($user_onboarding->reviews) {
                        if (!$user_onboarding->account) {
                            return redirect('settings/account');
                        }
                        elseif(!$user_onboarding->subscriptions) {
                            return redirect('settings/subscriptions');
                        }
                        else {
                            return redirect('settings/security');
                        }
                    }
                    else{
                        $user_onboarding->reviews = '1';
                        $user_onboarding->update();
                        return redirect('settings/reviews');
                    }
                }
                else{
                    return redirect('settings/reviews');
                }
            break;
            case 'subscriptions':
                if ($user_onboarding->status == 'pending') {
                    if ($user_onboarding->subscriptions) {
                        if (!$user_onboarding->account) {
                            return redirect('settings/account');
                        }
                        elseif(!$user_onboarding->reviews) {
                            return redirect('settings/reviews');
                        }
                        else {
                            return redirect('settings/security');
                        }
                    }
                    else{
                        $user_onboarding->subscriptions = '1';
                        $user_onboarding->update();
                        return redirect('settings/reviews');
                    }
                }
                else{
                    return redirect('settings/subscriptions');
                }
            break;
        }
    }

    public function subscriptions()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        if ($user_onboarding->status == 'pending') {
            if (!$user_onboarding->subscriptions) {
                $user_onboarding->subscriptions = '1';
                $user_onboarding->update();
            }
            $auth_user->onboarding_state = Helper::caclulateUserOnboardingState($auth_user, $user_onboarding);
        }

        if (!$user_onboarding->first_onboarding_passed) {
            $user_onboarding->first_onboarding_passed = '1';
            $user_onboarding->update();
        }

        $current_subscription = UserSubscription::where('user_id', $auth_user->user_id)
            ->where('active', '=', '1')
            ->where('type','=','tradiereview')
            ->latest()
            ->first();

        $upcoming_subscription = [];
        $old_subscription = [];

        if ($current_subscription) {
            $upcoming_subscription = UserSubscription::where('user_id', $auth_user->user_id)
                ->where('type','=','tradiereview')
                ->where('user_subscription_id', '>', $current_subscription->user_subscription_id)
                ->first();
        } else {
            $old_subscription = UserSubscription::where('user_id', $auth_user->user_id)
                ->where('type','=','tradiereview')
                ->latest()
                ->first();
        }

        /**Check Payment Methods*/
        $card_details = [
            'card_type' => 'N/A',
            'last_digits' => '....'
        ];

        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $payment_methods = $stripe->paymentMethods->all([
                'customer' => $auth_user->stripe_customer_id,
                'type' => 'card',
            ]);

            $card_details = [
                'card_type' => isset($payment_methods->data['0']->card->brand) ? strtolower($payment_methods->data['0']->card->brand) : null,
                'last_digits' => isset($payment_methods->data['0']->card->last4) ? $payment_methods->data['0']->card->last4 : null
            ];

            $has_payment_method = count($payment_methods) ? true : false;
        } catch (\Exception $e) {
            $has_payment_method = false;
        }

        /**Update Notifications*/
        UserNotification::where('user_id','=',request()->user()->user_id)
            ->where('has_read','=','0')
            ->where('product','=','tradiereview')
            ->whereIn('type',['subscription','success_payment','fail_payment'])
            ->update(['has_read' => '1']);

        /**Get Subscription Prices*/
        $get_subscription_plans = SubscriptionPlan::select('price_usd','price_aud','plan_code','name')
            ->where('type','=','tradiereview')
            ->get();

        $subscription_plans = [];
        foreach ($get_subscription_plans as $item) {
            $subscription_plans[$item->plan_code] = [
                'price_usd' => $item->price_usd,
                'price_aud' => $item->price_aud,
                'name' => $item->name
            ];
        }

        /**Get TradieFlow Subscription*/
        $tradieflow_current_subscription = UserSubscription::where('user_id', $auth_user->user_id)
            ->where('active', '=', '1')
            ->where('type','=','tradieflow')
            ->latest()
            ->first();

        $tradieflow_old_subscription = [];

        if (!$tradieflow_current_subscription) {
            $tradieflow_old_subscription = UserSubscription::where('user_id', $auth_user->user_id)
                ->where('type','=','tradieflow')
                ->latest()
                ->first();
        }

        $actual_subscription = $upcoming_subscription ? $upcoming_subscription : $current_subscription;
        return view('settings.subscriptions', compact(
            'auth_user',
            'current_subscription',
            'upcoming_subscription',
            'has_payment_method',
            'old_subscription',
            'user_onboarding',
            'subscription_plans',
            'card_details',
            'tradieflow_current_subscription',
            'tradieflow_old_subscription',
            'actual_subscription'
        ));
    }

    public function updateCard(Request $request)
    {
        $auth_user = Auth::user();
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $stripe_response = $stripe->customers->update(
                $auth_user->stripe_customer_id,
                ['source' => $request['token']]
            );

            if (isset($stripe_response->id) && $stripe_response->id) {
                return response()->json([
                    'status' => true
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function updateSubscription(Request $request)
    {
        $auth_user = Auth::user();
        $new_subscription = SubscriptionPlan::where('plan_code', '=', $request['subscription'])->where('type','=','tradiereview')->first();

        if ($new_subscription) {
            $current_subscription = UserSubscription::where('user_id', $auth_user->user_id)
                ->where('active', '=', '1')
                ->where('type','=','tradiereview')
                ->latest()
                ->first();

            $upcoming_subscription = [];

            if ($current_subscription) {
                $upcoming_subscription = UserSubscription::where('user_id', $auth_user->user_id)
                    ->where('type','=','tradiereview')
                    ->where('user_subscription_id', '>', $current_subscription->user_subscription_id)
                    ->first();
            }

            /**Check Discount Code First*/
            $price_to_charge = ($auth_user->currency == 'usd') ? $new_subscription->price_usd : $new_subscription->price_aud;
            $discount_code_obj = null;
            if ($request['discount_code']) {
                $discount_code = DiscountCode::where('type','=','tradiereview')
                    ->where('code','=',$request['discount_code'])
                    ->first();

                if ($discount_code) {
                    $price_to_charge -= $price_to_charge * $discount_code->discount_percentage / 100;
                    $price_to_charge = sprintf('%.2f',$price_to_charge);
                    $discount_code_obj = $discount_code;
                }
            }

            /**Add GST to the price*/
            $price_to_charge = sprintf('%.2f',$price_to_charge);
            $gst_amount = sprintf('%.2f',$price_to_charge / 10);
            $price_to_charge += $gst_amount;
            $price_to_charge = sprintf('%.2f',$price_to_charge);

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            if ($request['token']) {
                /**Check if User exists or no*/
                if (!$auth_user->stripe_customer_id) {
                    $stripe_customer = $stripe->customers->create([
                        'email' => $auth_user->email,
                        'name' => $auth_user->name,
                        'description' => 'TradieReviews Customer',
                    ]);

                    /**Process Charge*/
                    if (isset($stripe_customer->id) && $stripe_customer->id) {
                        $auth_user->stripe_customer_id = $stripe_customer->id;
                        $auth_user->update();
                    }
                    else{
                        Helper::addUserNotification($auth_user->user_id, 'Payment Failed', 'We could not process your payment. Please try again!', null, 'fail_payment', 'fail');
                        $get_notifications = Helper::getNotificationItems($auth_user);
                        return response()->json([
                            'status' => false,
                            'error' => 'Unable to process your payment, please contact support',
                            'open_notifications' => true,
                            'notifications' => $get_notifications['unread_notifications'],
                            'has_more_items' => $get_notifications['has_more_items']
                        ]);
                    }
                }

                /**Update User Card*/
                try {
                    $stripe_response = $stripe->customers->update(
                        $auth_user->stripe_customer_id,
                        ['source' => $request['token']]
                    );

                    if (!$stripe_response->id) {
                        Helper::addUserNotification($auth_user->user_id, 'Payment Failed', 'We could not process your payment. Please try again!', null, 'fail_payment', 'fail');
                        $get_notifications = Helper::getNotificationItems($auth_user);
                        return response()->json([
                            'status' => false,
                            'open_notifications' => true,
                            'notifications' => $get_notifications['unread_notifications'],
                            'has_more_items' => $get_notifications['has_more_items']
                        ]);
                    }
                } catch (\Exception $e) {
                    Helper::addUserNotification($auth_user->user_id, 'Payment Failed', 'We could not process your payment. Please try again!', null, 'fail_payment', 'fail');
                    $get_notifications = Helper::getNotificationItems($auth_user);
                    return response()->json([
                        'status' => false,
                        'error' => $e->getMessage(),
                        'open_notifications' => true,
                        'notifications' => $get_notifications['unread_notifications'],
                        'has_more_items' => $get_notifications['has_more_items']
                    ]);
                }
            }

            /**Charge User*/
            try {
                $charge = $stripe->charges->create([
                    'amount' => $price_to_charge * 100,
                    'currency' => $auth_user->currency,
                    'customer' => $auth_user->stripe_customer_id,
                    'description' => 'Charge for ' . $new_subscription->name,
                ]);

                if (!isset($charge->id)) {
                    Helper::addUserNotification($auth_user->user_id, 'Payment Failed', 'We could not process your payment. Please try again!', null, 'fail_payment', 'fail');
                    $get_notifications = Helper::getNotificationItems($auth_user);
                    return response()->json([
                        'status' => false,
                        'open_notifications' => true,
                        'notifications' => $get_notifications['unread_notifications'],
                        'has_more_items' => $get_notifications['has_more_items']
                    ]);
                }
            } catch (\Exception $e) {
                Helper::addUserNotification($auth_user->user_id, 'Payment Failed', 'We could not process your payment. Please try again!', null, 'fail_payment', 'fail');
                $get_notifications = Helper::getNotificationItems($auth_user);
                return response()->json([
                    'status' => false,
                    'open_notifications' => true,
                    'notifications' => $get_notifications['unread_notifications'],
                    'has_more_items' => $get_notifications['has_more_items']
                ]);
            }

            $model = new UserSubscription();
            $model->active = '0';
            $model->is_extendable = '1';
            $model->type = 'tradiereview';
            $model->gst_amount = $gst_amount;

            if ($discount_code_obj) {
                $model->discount_code = $discount_code_obj->code;
                $model->discounted_price = $price_to_charge;
                $model->discount_code_id = $discount_code_obj->discount_code_id;
            }

            if ($upcoming_subscription) {
                $exp_date_obj = Carbon::createFromFormat('Y-m-d H:i:s', $upcoming_subscription->expiry_date_time);
                $payment_success_description = 'You have paid for '.$new_subscription->name;
            } else {
                /**Handle old subscription*/
                if (!$current_subscription || $current_subscription->subscription_plan_code == 'trial' || !$current_subscription->active || !$current_subscription->is_extendable) {
                    UserSubscription::where('user_id','=',$auth_user->user_id)
                        ->where('type','=','tradiereview')
                        ->chunk(1000,function($items){
                            $insert_data = [];
                            $item_delete_ids = [];
                            foreach ($items as $item) {
                                $insert_data[] = $item->toArray();
                                $item_delete_ids[] = $item->user_subscription_id;
                            }

                            UserSubscriptionLog::insert($insert_data);
                            UserSubscription::whereIn('user_subscription_id',$item_delete_ids)->delete();
                        });

                    $exp_date_obj = Carbon::now();
                    $model->active = '1';
                    $model->payment_response = json_encode($charge);

                    /**Mark old subscription as non active*/
                    if ($current_subscription) {
                        $current_subscription->active = '0';
                        $current_subscription->update();
                    }

                    /**Create ActiveCampaign Log*/
                    Helper::addActiveCampaignQueueItem($auth_user->user_id,$auth_user->email,'purchase_tag');

                    /**Email admin about first payment*/
                    if (!$current_subscription || $current_subscription->subscription_plan_code == 'trial') {
                        NotificationHelper::emailAdminFirstPaymentNotification($auth_user, $price_to_charge, $new_subscription->name);
                    }

                    $payment_success_description = 'You have just switched to a '.$new_subscription->name;
                } else {
                    $exp_date_obj = Carbon::createFromFormat('Y-m-d H:i:s', $current_subscription->expiry_date_time);
                    $payment_success_description = 'You have paid for '.$new_subscription->name;
                }
            }

            if ($new_subscription->plan_code == 'pro') {
                $expiration_date_time = $exp_date_obj->copy()->addMonth(1)->format('Y-m-d H:i:s');
                /**If discount make it discount to pay for 12 months*/
                if ($model->discount_code) {
                    $model->discount_pay_expiry_date = $exp_date_obj->copy()->addMonth(11)->addDays(Constant::GET_FINAL_SUBSCRIPTION_EXPIRY_DAYS())->format('Y-m-d H:i:s');
                }
            } else {
                $expiration_date_time = $exp_date_obj->copy()->addYear(1)->format('Y-m-d H:i:s');
            }

            /**Set new plan*/
            $model->user_id = $auth_user->user_id;
            $model->subscription_plan_id = $new_subscription->subscription_plan_id;
            $model->subscription_plan_name = $new_subscription->name;
            $model->subscription_plan_code = $new_subscription->plan_code;
            $model->expiry_date_time = $expiration_date_time;
            $model->price = ($auth_user->currency == 'usd') ? $new_subscription->price_usd : $new_subscription->price_aud;
            $model->currency = $auth_user->currency;
            $model->save();

            /**Update message*/
            $auth_user->tradiereview_subscription_expire_message = null;
            $auth_user->update();

            Helper::addUserNotification($auth_user->user_id, 'Successful Payment', $payment_success_description, null, 'success_payment', 'success');

            /**Send out notifications*/
            try {
                $expiry_date_format = Carbon::createFromFormat('Y-m-d H:i:s',$expiration_date_time)->format('F j, Y');
                NotificationHelper::subscriptionPaymentSuccessful($model->subscription_plan_name, $expiry_date_format, $auth_user->is_boost_reviews_user, $auth_user->email);
            }
            catch (\Exception $e) {

            }

            $get_notifications = Helper::getNotificationItems($auth_user);
            return response()->json([
                'status' => true,
                'open_notifications' => true,
                'notifications' => $get_notifications['unread_notifications'],
                'has_more_items' => $get_notifications['has_more_items']
            ]);
        }

        $get_notifications = Helper::getNotificationItems($auth_user);
        return response()->json([
            'status' => false,
            'open_notifications' => true,
            'error' => 'Something went wrong',
            'notifications' => $get_notifications['unread_notifications'],
            'has_more_items' => $get_notifications['has_more_items']
        ]);
    }

    public function removeUserCard(Request $request)
    {
        $auth_user = Auth::user();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        try {
            $payment_methods = $stripe->paymentMethods->all([
                'customer' => $auth_user->stripe_customer_id,
                'type' => 'card',
            ]);

            if ($payment_methods && $payment_methods->data) {
                $delete_subscription = $stripe->customers->deleteSource(
                    $auth_user->stripe_customer_id,
                    $payment_methods->data['0']->id,
                    []
                );

                if ($delete_subscription) {
                    UserSubscription::where('user_id', '=', $auth_user->user_id)
                        ->where('type','=','tradiereview')
                        ->where('is_extendable', '=', '1')
                        ->update(['is_extendable' => '0']);
                }
            }

        } catch (\Exception $e) {

        }

        return response()->json([
            'status' => true
        ]);
    }

    public function cancelRenewal(Request $request)
    {
        UserSubscription::where('user_id', '=', request()->user()->user_id)
            ->where('type','=','tradiereview')
            ->where('is_extendable', '=', '1')
            ->update(['is_extendable' => '0']);

        return response()->json([
            'status' => true
        ]);
    }

    public function security()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        return view('settings.security', compact(
            'auth_user',
            'user_onboarding'
        ));
    }

    public function updateSecurity(Request $request)
    {
        $auth_user = Auth::user();
        if (Hash::check($request['current_password'], $auth_user->password)) {
            $auth_user->password = bcrypt($request['new_password']);
            $auth_user->twilio_password = $request['new_password'];
            $auth_user->update();
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Current password is wrong');
        }

        return redirect('settings/security')
            ->with('success', 'Password updated successfully');
    }

    public function checkSubscription()
    {
        $auth_user = request()->user();
        $current_subscription = UserSubscription::where('user_id', $auth_user->user_id)
            ->where('active', '=', '1')
            ->where('type','=','tradiereview')
            ->latest()
            ->first();

        $upcoming_subscription = [];

        if ($current_subscription) {
            $upcoming_subscription = UserSubscription::where('user_id', $auth_user->user_id)
                ->where('type','=','tradiereview')
                ->where('user_subscription_id', '>', $current_subscription->user_subscription_id)
                ->first();
        }

        $expired = false;
        if (!$upcoming_subscription && (!$current_subscription || ($current_subscription->subscription_plan_code == 'trial' || !$current_subscription->is_extendable))) {
            $expired = true;
        }

        return response()->json([
            'status' => true,
            'expired' => $expired
        ]);
    }

    public function setupTradieReviews()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        if ($user_onboarding->status == 'pending') {
            if (!$user_onboarding->account) {
                return redirect('settings/account');
            }

            if (!$user_onboarding->reviews) {
                return redirect('settings/reviews');
            }

            if (!$user_onboarding->subscriptions) {
                return redirect('settings/subscriptions');
            }
        }

        return redirect()
            ->back();
    }

    public function onboarding()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        return view('settings.onboarding',compact(
            'auth_user',
            'user_onboarding'
        ));
    }

    public function onboardingDemo()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        return view('settings.onboarding_demo',compact(
            'auth_user',
            'user_onboarding'
        ));
    }

    public function checkDiscountCode(Request $request)
    {
        $discount_code = DiscountCode::where('type','=','tradiereview')
            ->where('code','=',$request['code'])
            ->first();

        if ($discount_code) {
            return response()->json([
                'status' => true,
                'percentage' => $discount_code->discount_percentage
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}
