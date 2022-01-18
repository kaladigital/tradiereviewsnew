<?php

namespace App\Console\Commands;

use App\Helpers\Constant;
use App\Models\UserReferralMonthQueue;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class ReferralFreeMonthReceiveEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referral_free_month_receive_engine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive Free Months When Both Parties Paid';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(60 * 60 * 5);
        UserReferralMonthQueue::select('user_referral_month_queue.*')
            ->leftJoin('user as sender_user','sender_user.user_id','=','user_referral_month_queue.sent_user_id')
            ->leftJoin('user_subscription as sender_subscription',function($query){
                $query->on('sender_subscription.user_id','=','sender_user.user_id')
                    ->where('sender_subscription.type','=','tradiereview')
                    ->where('sender_subscription.active','=','1')
                    ->where('sender_subscription.subscription_plan_code','!=','trial');
            })
            ->leftJoin('user as receiver_user','receiver_user.user_id','=','user_referral_month_queue.received_user_id')
            ->leftJoin('user_subscription as receiver_subscription',function($query){
                $query->on('receiver_subscription.user_id','=','receiver_user.user_id')
                    ->where('receiver_subscription.type','=','tradiereview')
                    ->where('receiver_subscription.active','=','1')
                    ->where('receiver_subscription.subscription_plan_code','!=','trial');
            })
            ->where('user_referral_month_queue.status','=','pending')
            ->where('user_referral_month_queue.type','=','tradiereview')
            ->whereNotNull('sender_subscription.user_subscription_id')
            ->whereNotNull('receiver_subscription.user_subscription_id')
            ->groupBy('user_referral_month_queue.user_referral_month_queue_id')
            ->orderBy('user_referral_month_queue.created_at','desc')
            ->chunk(1000,function($items){
                foreach ($items as $item) {
                    /**Add Free Month to sender*/
                    try{
                        $sender_latest_subscription = UserSubscription::with('User')
                            ->where('user_id','=',$item->sent_user_id)
                            ->where('type','=','tradiereview')
                            ->orderBy('created_at','desc')
                            ->take('1')
                            ->first();

                        $sender_latest_subscription->final_expiry_date_time = null;
                        $sender_latest_subscription->expiry_date_time = Carbon::createFromFormat('Y-m-d H:i:s',$sender_latest_subscription->expiry_date_time)->addDays(Constant::GET_REFERRAL_RECEIVED_FREE_DAYS())->format('Y-m-d H:i:s');
                        $sender_latest_subscription->update();

                        /**Remove subscription expire popup if any*/
                        $sender_latest_subscription->User->tradiereview_subscription_expire_message = null;
                        $sender_latest_subscription->update();
                    }
                    catch (\Exception $e) {
                        //
                    }

                    /**Add Free Month to receiver*/
                    try{
                        $receiver_latest_subscription = UserSubscription::with('User')
                            ->where('user_id','=',$item->received_user_id)
                            ->where('type','=','tradiereview')
                            ->orderBy('created_at','desc')
                            ->take('1')
                            ->first();

                        $receiver_latest_subscription->final_expiry_date_time = null;
                        $receiver_latest_subscription->expiry_date_time = Carbon::createFromFormat('Y-m-d H:i:s',$receiver_latest_subscription->expiry_date_time)->addDays(Constant::GET_REFERRAL_RECEIVED_FREE_DAYS())->format('Y-m-d H:i:s');
                        $receiver_latest_subscription->update();

                        /**Remove subscription expire popup if any*/
                        $receiver_latest_subscription->User->tradiereview_subscription_expire_message = null;
                        $receiver_latest_subscription->update();
                    }
                    catch (\Exception $e) {
                        //
                    }

                    $item->status = 'completed';
                    $item->update();
                }
            });
    }
}
