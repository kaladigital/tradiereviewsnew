<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SubscriptionHandleEngine::class,
        \App\Console\Commands\SubscriptionExpireMessageEngine::class,
        \App\Console\Commands\TrialExpireNotificationsEngine::class,
        \App\Console\Commands\SitemapGeneratorEngine::class,
        \App\Console\Commands\ReferralFreeMonthReceiveEngine::class,
        \App\Console\Commands\ReviewInviteQueueHandleEngine::class,
        \App\Console\Commands\ActiveCampaignQueueEngine::class,
        \App\Console\Commands\ClearSendReviewLogsEngine::class,
        \App\Console\Commands\TrialExpireBeforeOneDayAdminAlertEngine::class,
        \App\Console\Commands\ReferredUserNotSignupTenMinutesEngine::class,
        \App\Console\Commands\ReferredUserNotPaidAfterSignupEngine::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('subscription_handle_engine')
            ->everyFourHours()
            ->withoutOverlapping();

        $schedule->command('subscription_expire_message_engine')
            ->hourly()
            ->withoutOverlapping();

        $schedule->command('trial_expire_popup_notifications')
            ->hourly()
            ->withoutOverlapping();

        $schedule->command('referral_free_month_receive_engine')
            ->hourly()
            ->withoutOverlapping();

        $schedule->command('generate_sitemap')
            ->everyTwoHours();

        $schedule->command('review_invite_queue_handle')
            ->everyTenMinutes()
            ->withoutOverlapping();

        $schedule->command('active_campaign_queue_process_engine')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule->command('clear_send_review_logs')
            ->everyFifteenMinutes()
            ->withoutOverlapping();

        $schedule->command('trial_expire_before_one_day_admin_alert')
            ->daily()
            ->withoutOverlapping();

        $schedule->command('referred_user_not_signup_ten_minutes')
            ->everyTwoMinutes()
            ->withoutOverlapping();

        $schedule->command('referred_user_not_paid_after_hour')
            ->everyFifteenMinutes()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
