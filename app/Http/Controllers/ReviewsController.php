<?php

namespace App\Http\Controllers;
use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use App\Models\Country;
use App\Models\ReviewInvite;
use App\Models\ClientReview;
use App\Models\ReviewInviteQueue;
use App\Models\SendReviewLog;
use App\Models\UserSubscription;
use App\Models\UserTwilioPhone;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Gumlet\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_subscription');
    }

    public function index(Request $request)
    {
        $auth_user = Auth::user();
        if (!$auth_user->first_onboarding_passed) {
            $user_onboarding = Helper::getUserOnboarding($auth_user);
            if (!$user_onboarding->account) {
                return redirect('settings/account');
            }
            elseif(!$user_onboarding->reviews) {
                return redirect('settings/reviews');
            }
            elseif(!$user_onboarding->subscriptions) {
                return redirect('settings/subscriptions');
            }
        }

        $get_average_reviews = ClientReview::selectRaw('ifnull(avg(rate),0) as num')
            ->where('user_id','=',$auth_user->user_id);

        $total_received_reviews = ClientReview::selectRaw('count(*) as num')
            ->where('user_id','=',$auth_user->user_id);

        $total_five_star_reviews = ClientReview::selectRaw('count(*) as num')
            ->where('user_id','=',$auth_user->user_id)
            ->where('rate','=','5');

        $total_four_star_reviews = ClientReview::selectRaw('count(*) as num')
            ->where('user_id','=',$auth_user->user_id)
            ->where('rate','=','4');

        $total_three_star_reviews = ClientReview::selectRaw('count(*) as num')
            ->where('user_id','=',$auth_user->user_id)
            ->where('rate','=','3');

        $total_two_star_reviews = ClientReview::selectRaw('count(*) as num')
            ->where('user_id','=',$auth_user->user_id)
            ->where('rate','=','2');

        $total_one_star_reviews = ClientReview::selectRaw('count(*) as num')
            ->where('user_id','=',$auth_user->user_id)
            ->where('rate','=','1');

        $totals = $get_average_reviews
            ->unionAll($total_received_reviews)
            ->unionAll($total_five_star_reviews)
            ->unionAll($total_four_star_reviews)
            ->unionAll($total_three_star_reviews)
            ->unionAll($total_two_star_reviews)
            ->unionAll($total_one_star_reviews)
            ->get();

        $rate_points = Constant::GET_RATE_SCORE_POINTS();
        $avg_reviews_received = $totals['0']->num ? round($totals['0']->num,1) : 0;
        $avg_reviews_received_star = round($avg_reviews_received);
        $total_reviews_received = intval($totals['1']->num);
        $five_start_review_percentage = $total_reviews_received ? ($totals['2']->num * 100) / $total_reviews_received : 0;
        $five_start_percentage_rounded = ceil($five_start_review_percentage);
        $four_start_review_percentage = $total_reviews_received ? ($totals['3']->num * 100) / $total_reviews_received : 0;
        $four_start_percentage_rounded = ceil($four_start_review_percentage);
        $three_start_review_percentage = $total_reviews_received ? ($totals['4']->num * 100) / $total_reviews_received : 0;
        $three_start_percentage_rounded = ceil($three_start_review_percentage);
        $two_start_review_percentage = $total_reviews_received ? ($totals['5']->num * 100) / $total_reviews_received : 0;
        $two_start_percentage_rounded = ceil($two_start_review_percentage);
        $one_start_review_percentage = $total_reviews_received ? ($totals['6']->num * 100) / $total_reviews_received : 0;
        $one_start_percentage_rounded = ceil($one_start_review_percentage);
        $reviews = ClientReview::where('user_id','=',$auth_user->user_id)
            ->orderBy('created_at','desc')
            ->paginate(Constant::GET_REVIEWS_PAGE_DISPLAY_ITEMS());

        $user_twilio_phone = UserTwilioPhone::where('user_id','=',$auth_user->user_id)->first();
        $phone_countries = Country::select('number','code')
            ->where('is_twilio','=','1')
            ->pluck('number','code');

        return view('reviews.index',compact(
            'auth_user',
            'reviews',
            'rate_points',
            'avg_reviews_received',
            'totals',
            'total_reviews_received',
            'five_start_review_percentage',
            'five_start_percentage_rounded',
            'four_start_review_percentage',
            'four_start_percentage_rounded',
            'three_start_review_percentage',
            'three_start_percentage_rounded',
            'two_start_review_percentage',
            'two_start_percentage_rounded',
            'one_start_review_percentage',
            'one_start_percentage_rounded',
            'avg_reviews_received_star',
            'user_twilio_phone',
            'phone_countries'
        ));
    }

    public function filter(Request $request)
    {
        $auth_user = request()->user();
        $reviews = ClientReview::select([
            'client_review.client_id',
            'client_review.rate',
            'client_review.reviewer_name',
            'client_review.reviewer_phone',
            'client_review.reviewer_phone_format',
            'client_review.description',
            'client_review.created_at'
        ])
            ->where('client_review.user_id','=',$auth_user->user_id);

        $rates = [];

        if ($request['five_star_filter']) {
            $rates[] = 5;
        }

        if ($request['four_star_filter']) {
            $rates[] = 4;
        }

        if ($request['three_star_filter']) {
            $rates[] = 3;
        }

        if ($request['two_star_filter']) {
            $rates[] = 2;
        }

        if ($request['one_star_filter']) {
            $rates[] = 1;
        }

        if ($rates) {
            $reviews->whereIn('client_review.rate',$rates);
        }
        else{
            $reviews->where('client_review.rate','>','5');
        }

        if ($request['written_reviews']) {
            $reviews->whereNotNull('client_review.description');
        }

        if ($request['stars_only_reviews']) {
            $reviews->whereNull('client_review.description');
        }

        if ($request['sort_by_latest']) {
            $reviews->orderBy('client_review.created_at','desc');
        }

        if ($request['sort_by_oldest']) {
            $reviews->orderBy('client_review.created_at','asc');
        }

        Paginator::currentPageResolver(function () use ($request) {
            return $request->page;
        });

        $reviews = $reviews
            ->paginate(Constant::GET_REVIEWS_PAGE_DISPLAY_ITEMS())
            ->toArray();

        $review_data = [];
        if (isset($reviews['data'])) {
            foreach ($reviews['data'] as $item) {
                $item['created_at'] = Carbon::parse($item['created_at'])->format('j F, Y');
                $review_data[] = $item;
            }
        }

        return response()->json([
            'status' => true,
            'items' => $review_data,
            'total_pages' => $reviews['last_page']
        ]);
    }

    public function setup()
    {
        $auth_user = Auth::user();
        $user_onboarding = Helper::getUserOnboarding($auth_user);
        if ($user_onboarding->status == 'pending') {
            if (!$user_onboarding->reviews) {
                $user_onboarding->reviews = '1';
                $user_onboarding->update();
            }

            $auth_user->onboarding_state = Helper::caclulateUserOnboardingState($auth_user, $user_onboarding);
        }

        return view('reviews.setup',compact(
            'auth_user',
            'user_onboarding'
        ));
    }

    public function update(Request $request)
    {
        $auth_user = Auth::user();
        $request['google_business_address'] = trim($request['google_business_address']);
        $has_google_error = false;
        if (strlen($request['google_review_url'])) {
            $auth_user->google_review_place_id = null;
            $auth_user->google_review_address = null;
            $auth_user->google_review_url = $request['google_review_url'];
        }
        else{
            if (strlen($request['google_review_address']) > 0) {
                try{
                    $get_business_address = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.urlencode($request['google_review_address']).'&inputtype=textquery&fields=place_id&key='.env('GOOGLE_API_KEY')));
                    if (isset($get_business_address->candidates['0']->place_id)) {
                        $auth_user->google_review_place_id = $get_business_address->candidates['0']->place_id;
                        $auth_user->google_review_address = $request['google_review_address'];
                        $auth_user->google_review_url = null;
                    }
                    else{
                        $has_google_error = true;
                    }
                }
                catch (\Exception $e) {

                }
            }
            else{
                $auth_user->google_review_place_id = null;
                $auth_user->google_review_address = null;
            }
        }

        $auth_user->facebook_reviews_url = $request['facebook_reviews_url'] && filter_var($request['facebook_reviews_url'], FILTER_VALIDATE_URL) ? $request['facebook_reviews_url'] : null;
        $auth_user->update();

        if ($has_google_error) {
            return redirect()
                ->back()
                ->with('error','Unable to find the place '.$request['google_business_address']);
        }

        return redirect()
            ->back()
            ->with('success','Settings successfully updated');
    }

    public function sendInvite(Request $request)
    {
        $auth_user = Auth::user();
        $max_reviews_per_day = Constant::GET_MAX_REVIEW_SEND_LIMIT();
        $total_reviews_sent = SendReviewLog::where('user_id','=',$auth_user->user_id)
            ->where(DB::raw('date(created_at)'),'=',Carbon::now()->format('Y-m-d'))
            ->count();

        $reviews_remaining = $max_reviews_per_day - $total_reviews_sent;
        if (!$reviews_remaining) {
            return response()->json([
                'status' => false,
                'error' => 'Daily limit reached for sending reviews'
            ]);
        }

        if ($request['type'] == 'email') {
            $items_to_be_sent = count($request['email']);
            if ($items_to_be_sent > $reviews_remaining) {
                return response()->json([
                    'status' => false,
                    'error' => 'You can select max '.$reviews_remaining.' items for today'
                ]);
            }

            foreach ($request['email'] as $item) {
                if (!filter_var($item,FILTER_VALIDATE_EMAIL)) {
                    return response()->json([
                        'status' => false,
                        'error' => $item.' is not a valid email'
                    ]);
                }
            }

            try{
                $has_emailed = false;
                $today_date_time = Carbon::now()->format('Y-m-d H:i:s');
                $log_items = [];
                foreach ($request['email'] as $item) {
                    $has_emailed = SendReviewLog::where('user_id','=',$auth_user->user_id)
                        ->where('target','=',$item)
                        ->where(DB::raw('date(created_at)'),'=',Carbon::now()->format('Y-m-d'))
                        ->count();

                    if ($has_emailed) {
                        continue;
                    }

                    /**Create invite record*/
                    $model = new ReviewInvite();
                    $model->user_id = $auth_user->user_id;
                    $model->type = 'email';
                    $model->target = $item;
                    $model->status = 'pending';
                    $model->unique_code = md5($auth_user->user_id.'review_invite'.uniqid());
                    $model->save();
                    NotificationHelper::sendLeaveReviewEmail($model->unique_code, $auth_user, $item);

                    /**Collect Log Items*/
                    $log_items[] = [
                        'user_id' => $auth_user->user_id,
                        'target' => $item,
                        'created_at' => $today_date_time,
                        'updated_at' => $today_date_time
                    ];
                }

                /**Save Logs*/
                if ($log_items) {
                    SendReviewLog::insert($log_items);
                }
                else{
                    if ($has_emailed) {
                        return response()->json([
                            'status' => false,
                            'error' => 'Emails already been sent for this customers today'
                        ]);
                    }
                }
            }
            catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'error' => 'Unable to send emails, please try again later',
                    'reload' => true
                ]);
            }
        }
        else{
            $has_tradieflow_subscription = $user = UserSubscription::where('user_id','=',$auth_user->user_id)
                ->where('user_subscription.type','=','tradieflow')
                ->where('active','=','1')
                ->count();

            if (!$has_tradieflow_subscription) {
                return response()->json([
                    'status' => false,
                    'error' => 'Your TradieFlow subscription has expired, please upgrade it to send reviews via text',
                ]);
            }

            $phone_country = Country::where('code','=',$request['country'])
                ->where('is_twilio','=','1')
                ->first();

            if ($phone_country) {
                $target = $phone_country->number.preg_replace('/[^0-9.]+/', '', $request['phone']);
                $has_invited = SendReviewLog::where('user_id','=',$auth_user->user_id)
                    ->where('target','=',$target)
                    ->where(DB::raw('date(created_at)'),'=',Carbon::now()->format('Y-m-d'))
                    ->count();

                if ($has_invited) {
                    return response()->json([
                        'status' => false,
                        'error' => 'You have already sent invitation to this number today, please try again tomorrow',
                    ]);
                }

                $model = new ReviewInvite();
                $model->user_id = $auth_user->user_id;
                $model->phone_country_id = $phone_country->country_id;
                $model->type = 'phone';
                $model->target = $target;
                $model->status = 'pending';
                $model->unique_code = md5($auth_user->user_id.'review_invite'.uniqid());

                /**Send out Twilio Message*/
                $twilio = new \Twilio\Rest\Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
                $user_phone = UserTwilioPhone::where('user_id', '=', $auth_user->user_id)->where('status','=','active')->first();
                if (!$user_phone) {
                    $user_phone = new \stdClass();
                    $user_phone->phone = env('SMS_GLOBAL_NUMBER');
                }

                try{
                    $params = [
                        "body" => Helper::generateReviewSendTextMessage($auth_user, $model->unique_code),
                        "from" => $user_phone->phone
                    ];

                    $message = $twilio->messages
                        ->create($model->target,$params);

                    $model->twilio_sms_sid = $message->sid;
                    $model->save();

                    return response()->json([
                        'status' => true
                    ]);
                }
                catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'error' => 'Unable to send text message to that number, please double check the number or try again later'
                    ]);
                }
            }
            else{
                return response()->json([
                    'status' => false,
                    'error' => 'Not supported country'
                ]);
            }
        }

        return response()->json([
            'status' => true
        ]);
    }

    public function uploadBusinessLogo(Request $request)
    {
        if ($request->hasFile('qqfile')) {
            $file = $request->file('qqfile');
            $ext = $file->getClientOriginalExtension();
            if (in_array($ext, Constant::GET_ALLOWED_IMAGE_EXTENSIONS())) {
                if ($file->getSize() > Constant::GET_ALLOWED_UPLOAD_IMAGE_SIZE()) {
                    return response()->json([
                        'status' => false,
                        'error' => 'Please upload images less than 2mb'
                    ]);
                }

                $auth_user = Auth::user();
                if ($auth_user->reviews_logo && Storage::disk('review_logo')->exists($auth_user->reviews_logo)) {
                    Storage::disk('review_logo')->delete($auth_user->reviews_logo);
                }

                $auth_user->reviews_logo = $auth_user->user_id.uniqid() . '.' . $file->getClientOriginalExtension();
                $auth_user->update();

                Storage::disk('review_logo')->put($auth_user->reviews_logo, File::get($file));
                /**Resize Logo Step 1*/
                $image_path = public_path('review-logo/'.$auth_user->reviews_logo);
                list($image_width, $image_height) = getimagesize($image_path);

                if ($image_width > 500 || $image_height > 200) {
                    $image = new ImageResize($image_path);
                    if ($image_width >= $image_height) {
                        if ($image_width == $image_height && $image_height > 300) {
                            $image->resizeToHeight(200);
                        }
                        else{
                            $image->resizeToWidth(500);
                        }
                    }
                    else{
                        $image->resizeToHeight(200);
                    }

                    $image->save($image_path);
                }

                return response()->json([
                    'status' => true,
                    'file_name' => $auth_user->reviews_logo
                ]);
            }
            else{
                return response()->json([
                    'status' => false,
                    'error' => 'Please upload only jpg or png images'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'error' => 'File is not supported'
        ]);
    }

    public function removeBusinessLogo(Request $request)
    {
        $auth_user = Auth::user();
        if ($auth_user->reviews_logo && Storage::disk('review_logo')->exists($auth_user->reviews_logo)) {
            Storage::disk('review_logo')->delete($auth_user->reviews_logo);
        }

        $auth_user->reviews_logo = null;
        $auth_user->update();
        return response()->json([
            'status' => true
        ]);
    }

    public function sendReview()
    {
        $auth_user = Auth::user();
        if ($auth_user->facebook_reviews_url || $auth_user->google_review_place_id || $auth_user->google_review_address || $auth_user->google_review_url) {
            $get_average_reviews = ClientReview::selectRaw('ifnull(avg(rate),0) as num')
                ->where('user_id','=',$auth_user->user_id);

            $total_received_reviews = ClientReview::selectRaw('count(*) as num')
                ->where('user_id','=',$auth_user->user_id);

            $total_five_star_reviews = ClientReview::selectRaw('count(*) as num')
                ->where('user_id','=',$auth_user->user_id)
                ->where('rate','=','5');

            $total_four_star_reviews = ClientReview::selectRaw('count(*) as num')
                ->where('user_id','=',$auth_user->user_id)
                ->where('rate','=','4');

            $total_three_star_reviews = ClientReview::selectRaw('count(*) as num')
                ->where('user_id','=',$auth_user->user_id)
                ->where('rate','=','3');

            $total_two_star_reviews = ClientReview::selectRaw('count(*) as num')
                ->where('user_id','=',$auth_user->user_id)
                ->where('rate','=','2');

            $total_one_star_reviews = ClientReview::selectRaw('count(*) as num')
                ->where('user_id','=',$auth_user->user_id)
                ->where('rate','=','1');

            $totals = $get_average_reviews
                ->unionAll($total_received_reviews)
                ->unionAll($total_five_star_reviews)
                ->unionAll($total_four_star_reviews)
                ->unionAll($total_three_star_reviews)
                ->unionAll($total_two_star_reviews)
                ->unionAll($total_one_star_reviews)
                ->get();

            $rate_points = Constant::GET_RATE_SCORE_POINTS();
            $avg_reviews_received = $totals['0']->num ? round($totals['0']->num,1) : 0;
            $avg_reviews_received_star = round($avg_reviews_received);
            $total_reviews_received = intval($totals['1']->num);
            $five_start_review_percentage = $total_reviews_received ? ($totals['2']->num * 100) / $total_reviews_received : 0;
            $five_start_percentage_rounded = ceil($five_start_review_percentage);
            $four_start_review_percentage = $total_reviews_received ? ($totals['3']->num * 100) / $total_reviews_received : 0;
            $four_start_percentage_rounded = ceil($four_start_review_percentage);
            $three_start_review_percentage = $total_reviews_received ? ($totals['4']->num * 100) / $total_reviews_received : 0;
            $three_start_percentage_rounded = ceil($three_start_review_percentage);
            $two_start_review_percentage = $total_reviews_received ? ($totals['5']->num * 100) / $total_reviews_received : 0;
            $two_start_percentage_rounded = ceil($two_start_review_percentage);
            $one_start_review_percentage = $total_reviews_received ? ($totals['6']->num * 100) / $total_reviews_received : 0;
            $one_start_percentage_rounded = ceil($one_start_review_percentage);

            $user_twilio_phone = UserTwilioPhone::where('user_id','=',$auth_user->user_id)->first();
            $phone_countries = Country::select('number','code')
                ->where('is_twilio','=','1')
                ->pluck('number','code');

            $detect = new \Mobile_Detect();
            $is_android_user = $detect->isAndroidOS();
            $has_tradieflow_subscription = $user = UserSubscription::where('user_id','=',$auth_user->user_id)
                ->where('user_subscription.type','=','tradieflow')
                ->where('active','=','1')
                ->count();

            $app_url = config('APP_URL');
            return view('reviews.send_review',compact(
                'auth_user',
                'app_url',
                'rate_points',
                'avg_reviews_received',
                'totals',
                'total_reviews_received',
                'five_start_review_percentage',
                'five_start_percentage_rounded',
                'four_start_review_percentage',
                'four_start_percentage_rounded',
                'three_start_review_percentage',
                'three_start_percentage_rounded',
                'two_start_review_percentage',
                'two_start_percentage_rounded',
                'one_start_review_percentage',
                'one_start_percentage_rounded',
                'avg_reviews_received_star',
                'user_twilio_phone',
                'phone_countries',
                'is_android_user',
                'has_tradieflow_subscription'
            ));
        }

        return redirect('send-review/setup');
    }

    public function setupSendReview()
    {
        $auth_user = Auth::user();
        if ($auth_user->facebook_reviews_url || $auth_user->google_review_place_id || $auth_user->google_review_address || $auth_user->google_review_url) {
            return redirect('settings/reviews');
        }

        $app_url = config('APP_URL');
        return view('reviews.send_review_setup',compact(
            'auth_user',
            'app_url'
        ));
    }

    public function saveReviewSetup(Request $request)
    {
        $auth_user = Auth::user();
        $auth_user->facebook_reviews_url = ($request['facebook_reviews_url'] && filter_var($request['facebook_reviews_url'], FILTER_VALIDATE_URL)) ? $request['facebook_reviews_url'] : null;
        $auth_user->google_review_place_id = null;
        $auth_user->google_review_address = null;
        $auth_user->google_review_url = ($request['google_review_url'] && filter_var($request['google_review_url'], FILTER_VALIDATE_URL)) ? $request['google_review_url'] : null;
        $auth_user->update();

        $user_onboarding = Helper::getUserOnboarding($auth_user);
        if ($user_onboarding->status == 'pending' && ($auth_user->facebook_reviews_url || $auth_user->google_review_url)) {
            if (!$user_onboarding->reviews) {
                $user_onboarding->reviews = '1';
                $user_onboarding->update();
            }
        }
        return response()->json([
            'status' => true
        ]);
    }

    public function handleGoogleSheetReviews(Request $request)
    {
        preg_match('/[-\w]{25,}/', $request['google_sheet_file_url'], $matches);
        if (isset($matches['0'])) {
            try{
                $auth_user = Auth::user();
                $max_reviews_per_day = Constant::GET_MAX_REVIEW_SEND_LIMIT();
                $total_reviews_sent = SendReviewLog::where('user_id','=',$auth_user->user_id)
                    ->where(DB::raw('date(created_at)'),'=',Carbon::now()->format('Y-m-d'))
                    ->count();

                $reviews_remaining = $max_reviews_per_day - $total_reviews_sent;
                if (!$reviews_remaining) {
                    return response()->json([
                        'status' => false,
                        'error' => 'Daily limit reached for sending reviews'
                    ]);
                }

                $url_parts = explode($matches['0'],$request['google_sheet_file_url']);
                $download_csv_url = $url_parts['0'].$matches['0'].'/export?format=csv';
                $csv_content = file_get_contents($download_csv_url);
                if ($csv_content) {
                    /**Collect Valid Emails*/
                    $lines = explode("\n",$csv_content);
                    $emails = [];
                    $insert_data = [];
                    $created_date = Carbon::now()->format('Y-m-d H:i:s');
                    $review_log = [];
                    $has_emailed = false;
                    foreach ($lines as $item) {
                        $item = trim($item);
                        if (filter_var($item,FILTER_VALIDATE_EMAIL) && !in_array($item, $emails)) {
                            $has_emailed = SendReviewLog::where('user_id','=',$auth_user->user_id)
                                ->where('target','=',$item)
                                ->where(DB::raw('date(created_at)'),'=',Carbon::now()->format('Y-m-d'))
                                ->count();

                            if ($has_emailed) {
                                continue;
                            }

                            $emails[] = $item;
                            $insert_data[] = [
                                'user_id' => $auth_user->user_id,
                                'email' => $item,
                                'type' => 'tradiereview',
                                'created_at' => $created_date,
                                'updated_at' => $created_date
                            ];

                            $review_log[] = [
                                'user_id' => $auth_user->user_id,
                                'target' => $item,
                                'created_at' => $created_date,
                                'updated_at' => $created_date
                            ];
                        }
                    }

                    $items_to_be_sent = count($insert_data);
                    if ($items_to_be_sent > $reviews_remaining) {
                        return response()->json([
                            'status' => false,
                            'error' => 'You can select max '.$reviews_remaining.' items for today'
                        ]);
                    }

                    if ($has_emailed && !$insert_data) {
                        return response()->json([
                            'status' => false,
                            'error' => 'Emails already been sent for this customers today'
                        ]);
                    }

                    /**Save Queue Items*/
                    if ($insert_data) {
                        $chunks = array_chunk($insert_data, 100);
                        foreach ($chunks as $item) {
                            ReviewInviteQueue::insert($item);
                        }

                        /**Save Log*/
                        SendReviewLog::insert($review_log);

                        return response()->json([
                            'status' => true,
                            'total_items' => count($insert_data)
                        ]);
                    }
                    else{
                        return response()->json([
                            'status' => false,
                            'error' => 'No emails found in Google Sheet'
                        ]);
                    }
                }
            }
            catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'error' => 'Unable to get access to Google Sheets'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'error' => 'Unable to get access to Google Sheets'
        ]);
    }
}
