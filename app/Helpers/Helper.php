<?php
namespace App\Helpers;

use App\Models\ActiveCampaignQueue;
use App\Models\CallHistory;
use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Country;
use App\Models\EmailQueue;
use App\Models\Notification;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserFormPage;
use App\Models\UserFormPageForm;
use App\Models\UserGiveawayReferral;
use App\Models\UserNotification;
use App\Models\UserOnboarding;
use App\Models\UserSubscription;
use App\Models\UserTwilioPhone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class Helper
{
    public static function generateUniqueFourDigits()
    {
        do {
            $four_digits = rand(pow(10, 3), pow(10, 4)-1);
            $has_taken = User::where('otp_code','=',$four_digits)
                ->count();

            if (!$has_taken) {
                return $four_digits;
            }
        }
        while ($has_taken);
    }

    public static function getBase64Data($file_data)
    {
        return [
            'file_data' => substr($file_data, strpos($file_data, ',') + 1),
            'extension' => explode('/', explode(':', substr($file_data, 0, strpos($file_data, ';')))[1])[1]
        ];
    }

    public static function getCountryList()
    {
        return Country::pluck('name', 'country_id');
    }

    public static function calculateEstimateTime($date_time_format)
    {
        $expiration_date_time_obj = Carbon::createFromFormat('Y-m-d H:i:s',$date_time_format);
        $now_time_obj = Carbon::now();

        if ($now_time_obj->copy()->timestamp > $expiration_date_time_obj->copy()->timestamp) {
            $hours_format = '';
        }
        else{
            $diff_obj = $now_time_obj->copy()->diff($expiration_date_time_obj);
            $hours_format = $diff_obj->days ? $diff_obj->days.' days ' : '';
            $hours_format .= $diff_obj->h ? $diff_obj->h.' hours' : '';
        }

        return $hours_format;
    }

    public static function calculateEstimateFullTime($date_time_format)
    {
        $expiration_date_time_obj = Carbon::createFromFormat('Y-m-d H:i:s',$date_time_format);
        $diff_obj = (Carbon::now())->diff($expiration_date_time_obj);
        $items = [];
        if ($diff_obj->days) {
            $items[] = $diff_obj->days.' days';
        }

        if ($diff_obj->h) {
            $items[] = $diff_obj->h.' hours';
        }

        if ($diff_obj->i) {
            $items[] = $diff_obj->i.' minutes';
        }

        return $items ? implode(' ',$items) : '0 minutes';
    }

    public static function generateInitials($name)
    {
        $name_obj = explode(' ',$name);
        $initials = $name_obj['0']['0'];
        if (isset($name_obj['1'])) {
            $initials .= $name_obj['1']['0'];
        }

        return strtoupper($initials);
    }

    public static function addUserNotification($user_id, $title, $description, $url, $type, $status)
    {
        $model = new UserNotification();
        $model->user_id = $user_id;
        $model->title = $title;
        $model->description = $description;
        $model->url = $url;
        $model->type = $type;
        $model->status = $status;
        $model->product = 'tradiereview';
        $model->save();
    }

    public static function getLandingPageTaglineOptions()
    {
        return [
            'tradiecrm' => [
                'headline' => 'Best',
                'tagline' => 'CRM for Tradies'
            ],
            'tradiesoftware' => [
                'headline' => 'Best',
                'tagline' => 'Tradie Software'
            ],
            'crmfortradies' => [
                'headline' => 'Best',
                'tagline' => 'CRM For Tradies'
            ],
            'crmfortradesmen' => [
                'headline' => 'Best',
                'tagline' => 'CRM For Tradesmen'
            ],
            'tradesmencrm' => [
                'headline' => 'Best',
                'tagline' => 'Tradesmen CRM'
            ],
            'tradesmensoftware' => [
                'headline' => 'Best',
                'tagline' => 'Tradesman Software'
            ],
            'builderscrm' => [
                'headline' => 'Best',
                'tagline' => 'Builders CRM'
            ],
            'contractorscrm' => [
                'headline' => 'Best',
                'tagline' => 'Contractors CRM'
            ],
            'electricianscrm' => [
                'headline' => 'Best',
                'tagline' => 'Electrician CRM'
            ],
            'plumberscrm' => [
                'headline' => 'Best',
                'tagline' => 'Plumbers CRM'
            ],
            'handymancrm' => [
                'headline' => 'Best',
                'tagline' => 'Handyman CRM'
            ],
            'contractorsoftware' => [
                'headline' => 'Best',
                'tagline' => 'Contractor Software'
            ],
            'electriciansoftware' => [
                'headline' => 'Best',
                'tagline' => 'Electrician Software'
            ],
            'plumberssoftware' => [
                'headline' => 'Best',
                'tagline' => 'Plumbers Software'
            ],
            'hanydmansoftware' => [
                'headline' => 'Best',
                'tagline' => 'Handyman Software'
            ],
            'bestappforbuilders' => [
                'headline' => 'Best',
                'tagline' => 'App for Builders'
            ],
            'bestcontractorapp' => [
                'headline' => 'Best',
                'tagline' => 'App for Contractors'
            ],
            'bestappfortradies' => [
                'headline' => 'Best',
                'tagline' => 'App for Tradies'
            ],
            'invoiceappforcontractors' => [
                'headline' => 'Best',
                'tagline' => 'Invoice App for Contractors'
            ],
            'invoiceappforbuilders' => [
                'headline' => 'Best',
                'tagline' => 'Invoice App for Builders'
            ],
            'invoiceappfortradies' => [
                'headline' => 'Best',
                'tagline' => 'Invoice App for Tradies'
            ],
            'electricianapp' => [
                'headline' => 'Best',
                'tagline' => 'App for Electricians'
            ],
            'plumbersapp' => [
                'headline' => 'Best',
                'tagline' => 'Plumbers App'
            ],
            'handymanapp' => [
                'headline' => 'Best',
                'tagline' => 'Handyman App'
            ],
            'decoratorssoftware' => [
                'headline' => 'Best',
                'tagline' => 'Decorators Software'
            ]
        ];
    }

    public static function caclulateUserOnboardingState($user, $user_onboarding)
    {
        //$user_onboarding->security
        $total_items = $user_onboarding->account + $user_onboarding->reviews + $user_onboarding->subscriptions;
        $user->onboarding_state = $total_items ? ceil($total_items / 3 * 100)  : 0;
        if ($total_items == 3) {
            $user_onboarding->status = 'completed';
            $user_onboarding->update();
        }

        return $user->onboarding_state;
    }

    public static function handlePopupNotifications($days, $user_subscription)
    {
        $user_subscription->last_popup_notification_date = Carbon::now()->format('Y-m-d');
        $user_subscription->update();

        $model = new UserNotification();
        switch ($user_subscription->subscription_plan_code) {
            case 'trial':
                $model->title = 'Free Trial';
                if ($days == 1) {
                    $model->description = 'Your Free Trial will expire in 24 hours. If you do not switch to a Pro Subscription you will lose your phone number.';
                }
                else{
                    $model->description = 'Your Free Trial will expire in '.$days.' days. If yo do not switch to a Pro Subscription you will lose your phone number.';
                }
            break;
            case 'pro':
                $model->title = 'Payment Failed';
                if ($days == 1) {
                    $model->description = 'Your Monthly Subscription will expire in 24 hours. If you do not renew it, you will lose your phone number.';
                }
                else{
                    $model->description = 'Your Monthly Subscription will expire in '.$days.' days. If you do not renew it, you will lose your phone number.';
                }
            break;
            case 'yearly':
                $model->title = 'Payment Failed';
                if ($days == 1) {
                    $model->description = 'Your Yearly Subscription will expire in 24 hours. If you do not renew it, you will lose your phone number.';
                }
                else{
                    $model->description = 'Your Yearly Subscription will expire in '.$days.' days. If you do not renew it, you will lose your phone number.';
                }
            break;
        }

        $model->user_id = $user_subscription->user_id;
        $model->url = '/settings/subscriptions';
        $model->type = 'subscription';
        $model->status = 'fail';
        $model->product = 'tradiereview';
        $model->save();
    }

    public static function clientHistoryEventDateFormat($start_date_time, $end_date_time)
    {
        $start_date_time_obj = Carbon::createFromFormat('Y-m-d H:i:s',$start_date_time);
        $end_date_time_obj = Carbon::createFromFormat('Y-m-d H:i:s',$end_date_time);

        if ($start_date_time_obj->copy()->format('Y-m-d') == $end_date_time_obj->copy()->format('Y-m-d')) {
            return $start_date_time_obj->copy()->format('F j, Y H:i').' - '.$end_date_time_obj->copy()->format('H:i');
        }
        else{
            return $start_date_time_obj->copy()->format('F j, Y H:i').' - '.$end_date_time_obj->copy()->format('F j, Y H:i');
        }
    }

    public static function convertDateToFriendlyFormat($date_time, $show_full = false)
    {
        $diff = Carbon::now()->diff($date_time);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $period_options = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        foreach ($period_options as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            }
            else {
                unset($period_options[$k]);
            }
        }

        if (!$show_full) {
            $period_options = array_slice($period_options, 0, 1);
        }
        return $period_options ? implode(', ', $period_options) . ' ago' : 'just now';
    }

    public static function generateReviewSendTextMessage($user, $id)
    {
        return 'Hey,'."\r\n".'Thanks for choosing '.$user->name.' as your provider. Please review the service at this link: '.config('APP_URL').'/rate/'.$id."\r\n".'Best,'.$user->name;
    }

    public static function validateRecaptcha($recaptcha_response)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                'secret' => env('GOOGLE_RECAPTCHA_SITE_SECRET'),
                'response' => $recaptcha_response
            )
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return (isset($response->success) && $response->success) ? true : false;
    }

    public static function generateSignupReferralSendTextMessage($user, $referral_code = null)
    {
        return $user->name.' just sent you a referral and a 1-month premium subscription for free on TradieFlow.'."\r\n".
            'TradieFlow handles your leads, schedules quotes, books in your jobs, sends invoices, and collects payment, all from the very same app. If you subscribe to TradieFlow, you and '.$user->name.' will get a 1-month premium subscription for free, and everybody wins!'."\r\n".
            'Join TradieFlow now on the following link: '.config('APP_URL').'/register/?ref='.$referral_code;
    }

    public static function getUserOnboarding($user)
    {
        return UserOnboarding::where('user_id','=',$user->user_id)
            ->where('type','=','tradiereview')
            ->first();
    }

    public static function GET_GEO_COUNTRY_IP()
    {
        $get_geo_data = null;
        try{
            $get_geo_data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
        }
        catch (\Exception $e) {

        }

        return $get_geo_data;
    }

    public static function addActiveCampaignQueueItem($user_id, $email, $action)
    {
        $model = new ActiveCampaignQueue();
        $model->user_id = $user_id;
        $model->email = $email;
        $model->action = $action;
        $model->type = 'tradiereview';
        $model->status = 'pending';
        $model->save();
    }

    public static function getAppUrlFor($is_boost_reviews_user)
    {
        return $is_boost_reviews_user ? env('APP_GET_REVIEW_BOOST_URL') : env('APP_TRADIE_REVIEWS_URL');
    }

    public static function getNotificationItems($user)
    {
        $unread_notifications = UserNotification::select([
            'user_notification_id',
            'title',
            'description',
            'url',
            'type',
            'status',
            'created_at as created_date_format'
        ])
            ->where('user_id','=',$user->user_id)
            ->where('has_read','=','0')
            ->where('product','=','tradiereview')
            ->orderBy('created_at','desc')
            ->take(6)
            ->get()
            ->toArray();

        $notifications_data = [];
        $has_more_items = count($unread_notifications) > 5 ? true : false;
        $unread_notifications = array_slice($unread_notifications,0,5);
        foreach ($unread_notifications as &$item) {
            $item['timeframe'] = Helper::calculateEstimateFullTime($item['created_date_format']);
            $notifications_data[] = $item;
            unset($item['created_date_format']);
        }

        return [
            'has_more_items' => $has_more_items,
            'unread_notifications' => $unread_notifications
        ];
    }
}
