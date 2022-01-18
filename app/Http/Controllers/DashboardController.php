<?php

namespace App\Http\Controllers;
use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Models\CallHistory;
use App\Models\ClientPhone;
use App\Models\UserNotification;
use App\Models\UserTwilioPhone;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return redirect('settings/account');
    }

    public function getCallFlowToken()
    {
        $auth_user = Auth::user();

        try{
            $twilioAccountSid = env('TWILIO_ACCOUNT_SID');
            $twilioApiKey = env('TWILIO_DESKTOP_API_KEY'); //dekstop
            $twilioApiSecret = env('TWILIO_DESKTOP_API_SECRET'); //desktop
            $outgoingApplicationSid = env('TWILIO_DESKTOP_OUTGOING_APPLICATION_ID'); //desktop and mobile
            $identity = $auth_user->twilio_company_unique_name;

            $token = new \Twilio\Jwt\AccessToken(
                $twilioAccountSid,
                $twilioApiKey,
                $twilioApiSecret,
                3600 * 24,
                $identity
            );

            // Create Voice grant
            $voiceGrant = new \Twilio\Jwt\Grants\VoiceGrant();
            $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);

            // Optional: add to allow incoming calls
            $voiceGrant->setIncomingAllow(true);

            // Add grant to token
            $token->addGrant($voiceGrant);

            // render token to string
            $token = $token->toJWT();
        }
        catch (\Exception $e) {
            $token = null;
        }

        return response()->json([
            'status' => true,
            'token' => $token
        ]);
    }

    public function getNotifications(Request $request)
    {
        $auth_user = request()->user();
        $get_notifications = Helper::getNotificationItems($auth_user);
        return response()->json([
            'status' => true,
            'notifications' => $get_notifications['unread_notifications'],
            'has_more_items' => $get_notifications['has_more_items']
        ]);
    }
}
