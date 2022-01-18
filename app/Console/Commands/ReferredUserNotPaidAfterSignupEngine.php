<?php

namespace App\Console\Commands;

use App\Helpers\Constant;
use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Models\UserReferralMonthQueue;
use App\Models\UserRegisterQueue;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class ReferredUserNotPaidAfterSignupEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referred_user_not_paid_after_hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If they do not pay for the service in an hour after completing the registration, then we send them an email';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(60 * 60 * 5);
        $current_date_time = Carbon::now()->addHours(-1)->format('Y-m-d H:i:s');
        UserReferralMonthQueue::select('user_referral_month_queue.*','sender_user.name as sender_user_name','receiver_user.is_boost_reviews_user','receiver_user.email')
            ->leftJoin('user as sender_user','sender_user.user_id','=','user_referral_month_queue.sent_user_id')
            ->leftJoin('user as receiver_user','receiver_user.user_id','=','user_referral_month_queue.received_user_id')
            ->leftJoin('user_subscription as receiver_subscription',function($query){
                $query->on('receiver_subscription.user_id','=','receiver_user.user_id')
                    ->where('receiver_subscription.type','=','tradiereview')
                    ->where('receiver_subscription.active','=','1')
                    ->where('receiver_subscription.subscription_plan_code','!=','trial');
            })
            ->where('user_referral_month_queue.status','=','pending')
            ->where('user_referral_month_queue.type','=','tradiereview')
            ->whereNotNull('receiver_subscription.user_subscription_id')
            ->where('receiver_user.created_at','<=',$current_date_time)
            ->where('user_referral_month_queue.has_receiver_pay_email_sent','=','0')
            ->where('has_admin_sent','=','0')
            ->groupBy('user_referral_month_queue.user_referral_month_queue_id')
            ->chunk(1000,function($items){
                foreach ($items as $item) {
                    /**Update State*/
                    $item->has_receiver_pay_email_sent = '1';
                    $item->update();

                    /**Send out email*/
                    NotificationHelper::remindReferredUserToPayAfterSignup($item->sender_user_name, $item->is_boost_reviews_user, $item->email);
                }
            });
    }
}
