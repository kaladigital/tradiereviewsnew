<?php

namespace App\Console\Commands;

use App\Helpers\Constant;
use App\Helpers\NotificationHelper;
use App\Models\ReviewInvite;
use App\Models\ReviewInviteQueue;
use App\Models\UserReferralMonthQueue;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class ReviewInviteQueueHandleEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'review_invite_queue_handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Review invite queue handle engine';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(60 * 60 * 5);
        ReviewInviteQueue::with('User')
            ->where('type','=','tradiereview')
            ->chunk(1000,function($items){
                foreach ($items as $item) {
                    if ($item->User && $item->User->active) {
                        try{
                            /**Create Invitation*/
                            $model = new ReviewInvite();
                            $model->user_id = $item->user_id;
                            $model->type = 'email';
                            $model->target = $item->email;
                            $model->status = 'pending';
                            $model->unique_code = md5($item->user_id.'review_invite'.uniqid());
                            $model->save();

                            /**Send Email*/
                            NotificationHelper::sendLeaveReviewEmail($model->unique_code, $item->User, $item->email);
                        }
                        catch (\Exception $e) {

                        }
                    }

                    /**Remove record*/
                    $item->delete();
                }
            });
    }
}
