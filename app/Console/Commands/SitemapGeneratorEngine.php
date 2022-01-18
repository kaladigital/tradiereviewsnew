<?php

namespace App\Console\Commands;

use App\Helpers\Constant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap;

class SitemapGeneratorEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate_sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now_obj = Carbon::now();
        /**Add Sitemap for TradieReviews*/
        $app_url = env('APP_TRADIE_REVIEWS_URL');
        Sitemap::create()
            ->add(Url::create($app_url.'/')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1))
            ->add(Url::create($app_url.'/#about')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/#faqs')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/#pricing')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/#integrations')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/free-trial')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->writeToFile(public_path('sitemap_tradiereviews.xml'));

        /**Add Sitemap for ReviewsBoost*/
        $app_url = env('APP_GET_REVIEW_BOOST_URL');
        Sitemap::create()
            ->add(Url::create($app_url.'/')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1))
            ->add(Url::create($app_url.'/#about')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/#faqs')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/#pricing')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/#integrations')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->add(Url::create($app_url.'/free-trial')
                ->setLastModificationDate($now_obj)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8))
            ->writeToFile(public_path('sitemap_get_boost_reviews.xml'));
    }
}
