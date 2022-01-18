<?php

namespace App\Helpers;
use App\Models\NotificationLog;
use App\Models\UserTwilioPhone;

class NotificationHelper
{

    private static $toEmail = '';
    private static $toSubject = '';

    public static function SendEmailMessage($template, $emails, $subject, $args)
    {
        $log = new NotificationLog();
        $log->notification_type = 'email';
        $log->target = implode(', ',$emails);
        $log->subject = $subject;


        $log_args = $args;
        $log->body = 'Template=' . $template . ' - Args=' . json_encode($log_args);

        try {
            foreach ($emails as $item) {
                if (!filter_var($item, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception('Wrong email');
                }
            }

            self::$toEmail = $emails['0'];
            self::$toSubject = strip_tags($subject);

            \Mail::send('emails.' . $template, $args, function ($message) use ($emails) {
                $message
                    ->to(self::$toEmail)
                    ->subject(self::$toSubject)
                    ->from(env('MAIL_FROM_EMAIL'), env('MAIL_FROM_NAME'));

                if (count($emails) > 1) {
                    $other_cc = array_slice($emails, 1);
                    $message->cc($other_cc);
                }
            });

            $log->status = 'success';
            $log->save();
            return 'success';
        } catch (\Exception $err) {
            $log->status = 'Error: ' . $err->getMessage();
            $log->save();
            return $err->getMessage();
        }
    }

    public static function SendRawHtmlEmailMessage($subject, $body, $email)
    {
        $log = new NotificationLog();
        $log->notification_type = 'email';
        $log->target = $email;
        $log->subject = $subject;
        $log->body = 'Template=' . $body . ' - Args=' . $email;

        try {
            \Mail::send([], [], function ($message) use ($subject, $body, $email) {
                $message->to($email)
                    ->subject(strip_tags($subject))
                    ->from(env('MAIL_FROM_EMAIL'), env('MAIL_FROM_NAME'))
                    ->setBody($body, 'text/html');
            });

            $log->status = 'success';
            $log->save();
            return 'success';
        } catch (\Exception $err) {
            $log->status = 'Error: ' . $err->getMessage();
            $log->save();
            return $err->getMessage();
        }
    }

    public static function sendEmailFromVariables($template, $subject, $message, $variables, $emails)
    {
        foreach ($variables as $key => $value) {
            $subject = str_replace($key, $value, $subject);
            $message = str_replace($key, $value, $message);
        }
        static::SendEmailMessage($template, $emails, $subject, ['body' => $message, 'other_parameters' => $variables]);
    }

    public static function sendLeaveReviewEmail($id, $auth_user, $email)
    {
        $name_obj = explode(' ',$auth_user->name);
        $email_variables = [
            'app_url' => config('APP_URL'),
            'display_name' => $auth_user->name,
            'first_name' => $name_obj['0'],
            'url' => config('APP_URL').'/rate/'.$id,
            'logo' => $auth_user->reviews_logo
        ];

        if (!$auth_user->is_reviews_display_name && $auth_user->reviews_company_name) {
            $email_variables['display_name'] = $email_variables['first_name'] = $auth_user->reviews_company_name;
        }

        self::sendEmailFromVariables('leave_review','Review work done', '', $email_variables, [$email]);
    }

    public static function resetPassword($user)
    {
        $email_variables = [
            'app_url' => config('APP_URL'),
            'name' => $user->name,
            'code' => $user->otp_code
        ];

        self::sendEmailFromVariables('forgot_password','Password Recovery', '', $email_variables, [$user->email]);
    }

    public static function registerVersionVerify($notification, $code, $email)
    {
        $emails = [$email];
        $email_variables = [
            'app_url' => config('APP_URL'),
            'code' => $code
        ];

        if (env('APP_ENV') !== 'local') {
            $emails[] = 'carl@tradiedigital.co';
            $emails[] = 'admin@kaladigital.com.au';
        }

        self::sendEmailFromVariables('register_version_confirm_account',$notification->subject, null, $email_variables, $emails);
    }

    public static function freeTrialExpiredNotification($name, $is_boost_reviews_user, $email)
    {
        $app_url = $is_boost_reviews_user ? env('APP_GET_REVIEW_BOOST_URL') : env('APP_TRADIE_REVIEWS_URL');
        $email_variables = [
            'name' => $name,
            'subscription_page_url' => $app_url.'/settings/subscriptions',
            'app_url' => $app_url
        ];

        self::sendEmailFromVariables('free_trial_expired','Free Trial Expired',null, $email_variables, [$email]);
    }

    public static function emailSubscriptionSubscribed($email)
    {
        $email_variables = [
            'app_url' => config('APP_URL')
        ];

        self::sendEmailFromVariables('email_subscription_subscribed',' Newsletter Sign Up ',null, $email_variables, [$email]);
    }

    public static function subscriptionPaymentSuccessful($plan_name, $expiry_date_format, $is_boost_reviews_user, $email)
    {
        $email_variables = [
            'app_url' => $is_boost_reviews_user ? env('APP_GET_REVIEW_BOOST_URL') : env('APP_TRADIE_REVIEWS_URL'),
            'plan_name' => $plan_name,
            'expiry_date_format' => $expiry_date_format
        ];

        self::sendEmailFromVariables('subscription_payment_success',' Payment Success',null, $email_variables, [$email]);
    }

    public static function signupAdminAlert($user_name, $user_email, $company, $phone, $industry, $help_business)
    {
        $email_variables = [
            'app_url' => config('APP_URL'),
            'name' => $user_name,
            'email' => $user_email,
            'company_name' => $company,
            'phone' => $phone,
            'industry' => $industry,
            'help_business' => $help_business,
            'ip' => $_SERVER['REMOTE_ADDR']
        ];

        $admin_emails = explode(',',env('CONTACT_US_EMAILS'));
        if (env('APP_ENV') != 'local') {
            $admin_emails[] = 'admin@kaladigital.com.au';
        }
        self::sendEmailFromVariables('user_register_admin_notification','New user signup', '', $email_variables, $admin_emails);
    }

    public static function earlyAccessPurchasedNotification($signup_code, $amount, $currency, $plan_name, $expiry_date_format, $email)
    {
        $emails = [$email];
        $app_url = config('APP_URL');
        $email_variables = [
            'app_url' => $app_url,
            'amount' => $amount,
            'plan_name' => $plan_name,
            'expiry_date_format' => $expiry_date_format,
            'complete_signup_url' => $app_url.'/early-access/complete/'.$signup_code
        ];

        if (env('APP_ENV') !== 'local') {
            $emails[] = 'carl@tradiedigital.co';
        }

        self::sendEmailFromVariables('early_access_purchase','Payment Successful', '', $email_variables, $emails);
    }

    public static function earlyAccessPurchasedExistingUserNotification($amount, $currency, $plan_name, $expiry_date_format, $email)
    {
        $emails = [$email];
        $app_url = config('APP_URL');
        $email_variables = [
            'app_url' => $app_url,
            'amount' => $amount,
            'plan_name' => $plan_name,
            'expiry_date_format' => $expiry_date_format,
            'login_url' => $app_url.'/auth/login'
        ];

        if (env('APP_ENV') !== 'local') {
            $emails[] = 'carl@tradiedigital.co';
        }

        self::sendEmailFromVariables('early_access_existing_user_purchase','Payment Successful', '', $email_variables, $emails);
    }

    public static function sendSignupReferralEmailInvite($user, $email, $code)
    {
        $email_variables = [
            'user_name' => $user->name,
            'app_url' => config('APP_URL'),
            'code' => $code
        ];

        self::sendEmailFromVariables('send_signup_referral_invite','Signup Referral Received', '', $email_variables, [$email]);
    }

    public static function sendReferFriendEmail($sender_name, $code, $invite_user_name, $email)
    {
        $email_variables = [
            'sender_name' => $sender_name,
            'app_url' => config('APP_URL'),
            'code' => $code
        ];

        self::sendEmailFromVariables('refer_friend','Referral From '.$invite_user_name.' Received', '', $email_variables, [$email]);
    }

    public static function contactUsRequest($request)
    {
        $email_variables = [
            'app_url' => config('APP_URL'),
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'ip' => $_SERVER['REMOTE_ADDR']
        ];

        self::sendEmailFromVariables('contact_us_request','Contact Us Enquiry', '', $email_variables, explode(',',env('CONTACT_US_EMAILS')));
    }

    public static function emailAdminFirstPaymentNotification($user, $paid_amount, $subscription_plan)
    {
        $email_variables = [
            'app_url' => config('APP_URL'),
            'user_name' => $user->name,
            'amount' => (($user->currency == 'usd') ? '$' : 'AUD').' '.$paid_amount,
            'subscription_plan_name' => $subscription_plan
        ];

        self::sendEmailFromVariables('notify_admin_for_first_payment','Payment Received', '', $email_variables, explode(',',env('CONTACT_US_EMAILS')));
    }

    public static function sendAdminSubscriptionPreExpireAlert($user, $days_padding)
    {
        $email_variables = [
            'app_url' => $user->is_boost_reviews_user ? env('APP_GET_REVIEW_BOOST_URL') : env('APP_TRADIE_REVIEWS_URL'),
            'user_name' => $user->name,
            'email' => $user->email,
            'padding_days' => $days_padding,
            'company' => $user->reviews_company_name,
        ];

        self::sendEmailFromVariables('notify_admin_for_pre_expire_trial','Subscription Expiry', '', $email_variables, explode(',',env('CONTACT_US_EMAILS')));
    }

    public static function sendAdminSubscriptionFullExpireAlert($user)
    {
        $email_variables = [
            'app_url' => Helper::getAppUrlFor($user->is_boost_reviews_user),
            'user_name' => $user->name,
            'email' => $user->email,
            'company' => $user->reviews_company_name
        ];

        self::sendEmailFromVariables('notify_admin_for_full_expire_trial','Subscription Expiry', '', $email_variables, explode(',',env('CONTACT_US_EMAILS')));
    }

    public static function remindReferredUserToCompleteSignup($invite_from_name, $is_boost_reviews_user, $code, $email)
    {
        $app_url = Helper::getAppUrlFor($is_boost_reviews_user);
        $email_variables = [
            'app_url' => $app_url,
            'user_name' => $invite_from_name,
            'complete_signup_url' => $app_url.'/complete/referral/signup/'.$code
        ];

        self::sendEmailFromVariables('referrals_complete_sign_up_alert','Complete your sign-up', '', $email_variables, [$email]);
    }

    public static function remindReferredUserToPayAfterSignup($invite_from_name, $is_boost_reviews_user, $email)
    {
        $app_url = Helper::getAppUrlFor($is_boost_reviews_user);
        $email_variables = [
            'app_url' => $app_url,
            'user_name' => $invite_from_name,
            'subscriptions_url' => $app_url.'/settings/subscriptions'
        ];

        self::sendEmailFromVariables('referrals_pay_to_get_free_month_alert','Subscribe to get your free month!', '', $email_variables, [$email]);
    }
}
