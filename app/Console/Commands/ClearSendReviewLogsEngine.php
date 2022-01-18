<?php

namespace App\Console\Commands;

use App\Helpers\Constant;
use App\Models\SendReviewLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class ClearSendReviewLogsEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear_send_review_logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Send Review Logs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(60 * 60 * 5);
        SendReviewLog::where(DB::raw('date(created_at)'),'!=',Carbon::now()->format('Y-m-d'))
            ->delete();
    }
}
