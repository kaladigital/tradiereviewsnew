<?php

namespace App\Console\Commands;

use App\Helpers\Constant;
use App\Helpers\NotificationHelper;
use App\Models\UserReferralMonthQueue;
use App\Models\UserRegisterQueue;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class ReferredUserNotSignupTenMinutesEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referred_user_not_signup_ten_minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If the user does not complete registration in 10 minutes, then we send them an email';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(60 * 60 * 5);
        $current_date = Carbon::now()->addMinutes(-10)->format('Y-m-d H:i:s');
        UserRegisterQueue::select('user_register_queue.*','invite_from_user.is_boost_reviews_user','invite_from_user.name as invite_from_user_name')
            ->leftJoin('user_referral_code',function($query){
                $query
                    ->on('user_referral_code.referral_code','=','user_register_queue.referral_code')
                    ->where('user_referral_code.type','=','tradiereview');
            })
            ->leftJoin('user as invite_from_user','invite_from_user.user_id','=','user_referral_code.user_id')
            ->leftJoin('user','user.email','=','user_register_queue.email')
            ->where('user_register_queue.type','=','tradiereview')
            ->where('user_register_queue.referral_signup_email_sent','=','0')
            ->whereNotNull('invite_from_user.user_id')
            ->whereNull('user.user_id')
            ->where('user_register_queue.created_at','<=',$current_date)
            ->chunk(1000,function($items) {
                foreach ($items as $item) {
                    $item->code = md5(env('APP_ENV').uniqid().$item->user_register_queue_id);
                    $item->referral_signup_email_sent = '1';
                    $item->update();

                    /**Send out email*/
                    NotificationHelper::remindReferredUserToCompleteSignup($item->invite_from_user_name, $item->is_boost_reviews_user, $item->code, $item->email);
                }
            });
    }
}
