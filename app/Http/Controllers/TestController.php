<?php

namespace App\Http\Controllers;


use App\Console\Commands\ActiveCampaignQueueEngine;
use App\Console\Commands\EmailQueueProcessEngine;
use App\Console\Commands\ReferralFreeMonthReceiveEngine;
use App\Console\Commands\ReferredUserNotPaidAfterSignupEngine;
use App\Console\Commands\ReferredUserNotSignupTenMinutesEngine;
use App\Console\Commands\RemoveTempQuoteImages;
use App\Console\Commands\ReviewInviteQueueHandleEngine;
use App\Console\Commands\SitemapGeneratorEngine;
use App\Console\Commands\SubscriptionExpireMessageEngine;
use App\Console\Commands\SubscriptionHandleEngine;
use App\Console\Commands\TrialExpireBeforeOneDayAdminAlertEngine;
use App\Console\Commands\TrialExpireNotificationsEngine;
use App\Console\Commands\TwilioAccessTokenExpiryEngine;
use App\Console\Commands\UserFormQueueProcessEngine;
use App\Console\Commands\XeroInvoicePaidStatusEngine;
use App\Helpers\ActiveCampaignHelper;
use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use App\Helpers\XeroHelper;
use App\Models\CallHistory;
use App\Models\Client;
use App\Models\ClientPhone;
use App\Models\ClientReview;
use App\Models\ClientValue;
use App\Models\Country;
use App\Models\Event;
use App\Models\Industry;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\SubscriptionPlan;
use App\Models\TextMessage;
use App\Models\TextMessageMedia;
use App\Models\User;
use App\Models\UserActiveCampaignContact;
use App\Models\UserForm;
use App\Models\UserFormData;
use App\Models\UserGiveawayReferral;
use App\Models\UserGoogleToken;
use App\Models\UserOnboarding;
use App\Models\UserReferralCode;
use App\Models\UserReferralMonthQueue;
use App\Models\UserSubscription;
use App\Models\UserTwilioPhone;
use App\Models\UserXeroAccount;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use DB;
use phpseclib3\File\ASN1\Maps\OrganizationName;
use Dompdf\Dompdf;
class TestController extends Controller
{
    protected function decodeJWTRequest($string)
    {
        try {
            return JWT::decode($string, env('MOBILE_API_KEY'), array('HS256'));
        } catch (\Exception $e) {
            exit('wrong jwt encoding');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
//        $t = new ReferredUserNotPaidAfterSignupEngine();
//        var_dump($t->handle());die;
//        $t = new ActiveCampaignQueueEngine();
//        var_dump($t->handle());die;
//        $user = User::where('email','=','qido.js@gmail.com')->first();
//        NotificationHelper::resetPassword($user);
//
//        die;
//        $t = new ActiveCampaignQueueEngine();
//        $t->handle();
//        die('done');
//        $t = new ActiveCampaignHelper();
// get contact by email
//        var_dump($t->getContactByEmail('qido.js@gmail.com'));die;

//        $data = [
//            'contact' => [
//                'email' => 'qido.js@gmail.com',
//                'firstName' => 'System',
//                'lastName' => 'Test'
//            ]
//        ];
//        $add_contact = $t->addContact($data);
//        var_dump($add_contact);die;

//        $stages = $t->getStages();
//        var_dump($stages);die;

        //api/3/contacts/id

        var_dump($t->getContactDetails('59120'));die;

        $pipeline_details = $t->pipeLineUsers(24);
        var_dump($pipeline_details);die;

        //59120

//        $data = [
//            'deal' => [
//                'title' => 'dummy title',
//                'contact' => '59120',
//                'description' => 'custom deal',
//                'currency' => 'usd',
//                'value' => '0',
//                'group' => '24',//fixed
//                'owner' => '14',//fixed,
////                'stage' => '2'
//            ]
//        ];
//        $add_contact = $t->addDeal($data);
//        var_dump($add_contact);die;




//        var_dump(file_get_contents('https://docs.google.com/spreadsheets/d/1xBFPThOCYzJI4cNm-73xOBbDqjl8wVkozwZNnbDhgxs/export?format=csv'));die;
//        $client = new \Google_Client();
//        $client->setAuthConfig(base_path('google_credentials.json'));
//        $client->addScope([
//            'https://www.googleapis.com/auth/calendar',
//            'https://www.googleapis.com/auth/calendar.events',
//            'https://www.googleapis.com/auth/contacts',
//            'https://mail.google.com'
//        ]);
//        $client->setRedirectUri(config('APP_URL').'/test/google');
//        $client->setAccessType('offline');
//        $client->setPrompt("consent");
//        $client->setIncludeGrantedScopes(true);   // incremental auth
//        $auth_url = $client->createAuthUrl();
//        return redirect($auth_url);
//
//        $google_token = UserGoogleToken::first();
//
//        $client = new \Google_Client();
//        $client->setAuthConfig(base_path('google_credentials.json'));
//        $client->addScope([
//            'https://www.googleapis.com/auth/calendar',
//            'https://www.googleapis.com/auth/calendar.events',
//            'https://www.googleapis.com/auth/contacts',
//            'https://mail.google.com'
//        ]);
//
//        $client->setRedirectUri(config('APP_URL').'/test/google');
//        $client->setAccessType('offline');
//        $client->setPrompt("consent");
//        $client->setIncludeGrantedScopes(true);   // incremental auth
////
//        $get_access_token = $client->fetchAccessTokenWithRefreshToken($google_token->refresh_token);
////        var_dump($get_access_token);die;
//
//        $service = new \Google_Service_Gmail($client);
//
//        /**Get Single Thread*/
//        $threads = $service->users_threads->get('me', '179c9db5f9f4e4f6');
//        foreach ($threads as $item) {
//            $messagePayload = $item->getPayload();
//
//            $parts = $messagePayload->getParts();
//
//            foreach ($parts as $p_item) {
//
//                foreach ($p_item as $p) {
//                    if ($p->getBody()->data) {
//                        $message = base64_decode($p->getBody()->data);
//                        echo $message.' <br><br>';
//                    }
//                }
//
////                echo $message.'<br><br>';
//            }
//
////            var_dump($item->getPayload());die;
////            $date_obj = Carbon::createFromTimestamp($item->internalDate);
////            echo $date_obj->format('Y-m-d H:i:s').' '.$item->snippet.'<br><br>';
//        }
//        var_dump(count($thread));die;
//die('1234');
//        $optParams = [];
//        $optParams['maxResults'] = 10; // Return Only 5 Messages
//        $optParams['labelIds'] = 'INBOX'; // Only show messages in Inbox
////        $optParams['pageToken'] = '14699020300933339166';
////        $threads->nextPageToken
//        $threads = $service->users_threads->listUsersThreads('me', $optParams);
////        var_dump($threads->resultSizeEstimate);die;
////        foreach ($threads as $item){
////            echo $item->id.'__'.$item->historyId.'__'.$item->snippet.'<br><br><br><br>';
////        }
//
//        die;
////
////        $optParams = [];
////        $optParams['maxResults'] = 2; // Return Only 5 Messages
////        $optParams['labelIds'] = 'INBOX'; // Only show messages in Inbox
////        $messages = $service->users_messages->listUsersMessages('me',$optParams);
////        $list = $messages->getMessages();
////
////        $message_id = $list['0']->getId();
////
////        $optParamsGet = [];
////        $optParamsGet['format'] = 'full'; // Display message in payload
////        $message = $service->users_messages->get('me',$message_id,$optParamsGet);
////        $messagePayload = $message->getPayload();
//////        var_dump($messagePayload->getBody());die;
////        $headers = $messagePayload->getHeaders();
////        $parts = $messagePayload->getParts();
////
////        foreach ($parts as $item) {
////            $message = base64_decode($parts['0']->getBody()->data);
////            echo $message.'<br><br>';
////        }

//        die;


//        var_dump(base64_decode($message));die;

//        var_dump(count($list));die;


//        var_dump($service->users);die;

//        $user = 'me';
//        $results = $service->users_labels->listUsersLabels($user);
//
//        var_dump($results);die;


        /**Contacts API*/
//        $people_service = new \Google_Service_PeopleService($client);
        /**Find By Email*/
//        $res = $people_service->people->searchContacts([
//            'query' => 'cool_php@mail.ru',
//            'readMask' => 'names,emailAddresses,addresses'
//        ]);
//        $total_found = count($res->results);

        /**Get All*/
//        $people = $people_service->people_connections->listPeopleConnections(
//            'people/me', array('personFields' => 'names,emailAddresses,addresses,clientData,organizations'));
////
//        foreach ($people as $item) {
//            //$item->names
//            if (isset($item->emailAddresses['0']) && $item->emailAddresses['0']->value == 'cool_php@mail.ru') {
////                var_dump($item->resourceName);die;
//
//            }
//        }

//        die('1');

//        $people_obj = new \Google_Service_PeopleService_Person();
//        $name1 = new \Google_Service_People_Name();
//        $name1->displayName = 'John Doe';
//        $name1->familyName = 'Doe';
//        $name1->givenName = 'John';
//
//        $people_obj->setNames($name1);
//
//        $people_email = new \Google_Service_People_EmailAddress();
//        $people_email->value = 'cool_php@mail.ru';
//        $people_obj->setEmailAddresses([$people_email]);
//
//        $orgs = new \Google_Service_People_Organization();
//        $orgs->title = 'Codebonapp';
//        $people_obj->setOrganizations([$orgs]);

//
//        $contact_api = $people_service->people->createContact($people_obj);
          //resourceName
//        var_dump($contact_api);die;
//        die('not found');

//        var_dump($people);die;



//        /**Calendar & Events*/
//        $service = new \Google_Service_Calendar($client);

        // Print the next 10 events on the user's calendar.
//        $calendarId = 'primary';
//        $optParams = array(
//            'maxResults' => 10,
//            'orderBy' => 'startTime',
//            'singleEvents' => true,
//            'timeMin' => Carbon::createFromFormat('Y-m-d H:i:s','2021-06-18 00:00:00')->format('c'),
//            'timeMax' => Carbon::createFromFormat('Y-m-d H:i:s','2021-06-18 23:59:00')->format('c'),
//        );
//        $results = $service->events->listEvents($calendarId, $optParams);
//        $events = $results->getItems();

//        foreach ($events as $item) {
////            var_dump($item->getStart());die;
//            echo $item->getSummary()."<br>";
//////            $event_id = $item->getId();
//////            var_dump($event_id);die;
////            //name $item->getSummary()
//////            var_dump($item->status, $item->getSummary(), $item->getDescription() ? $item->getDescription() : ' no description');
//////            var_dump($item->getSummary().' '.$item->getId());
//        }
////
//        die;

//
//        $event = new \Google_Service_Calendar_Event(array(
//            'summary' => 'Best Meeting some test test test 1234',
//            'description' => 'no desc',
//            'start' => [
//                'dateTime' => '2021-06-18T09:00:00-07:00',
////                'timeZone' => 'America/Los_Angeles',
//            ],
//            'end' => [
//                'dateTime' => '2021-06-18T09:00:00-07:00',
////                'timeZone' => 'America/Los_Angeles',
//            ],
////            'end' =>   Carbon::now()->format('c'),
//        ));
//
//        $calendarId = 'primary';
//        $event = $service->events->insert($calendarId, $event);
//        var_dump($event);die;
//
//
////        $event = $service->events->get('primary', '52qina3iq30484ufefktu9nugu');
////        $event->setSummary('Another cool title here');
////        $updatedEvent = $service->events->update('primary', $event->getId(), $event);
////        die('done');


//        die;
//        var_dump($get_access_token['access_token'],$events);die;
    }

    public function google(Request $request)
    {
        $client = new \Google_Client();
        $client->setAuthConfig(base_path('google_credentials.json'));
        $client->addScope([
            'https://www.googleapis.com/auth/calendar',
            'https://www.googleapis.com/auth/calendar.events',
            'https://www.googleapis.com/auth/contacts',
            'https://mail.google.com'
        ]);
        $client->setRedirectUri(config('APP_URL').'/test/google');
        $client->setAccessType('offline');
        $client->setPrompt("consent");
//        $client->setApprovalPrompt("force");
//        $client->setAccessType('offline');
//        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->authenticate($request['code']);
        $token_obj = $client->getAccessToken();
        $user_token = UserGoogleToken::where('user_id','=','4')
            ->first();

        if (!$user_token) {
            $user_token = new UserGoogleToken();
            $user_token->user_id = '4';
        }

        $user_token->access_token = $token_obj['access_token'];
        $user_token->refresh_token = $token_obj['refresh_token'];
        $user_token->save();
        die('done');
    }
}
