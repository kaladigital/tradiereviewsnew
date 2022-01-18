<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**Auth for regular users*/
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/forgot-password', 'Auth\AuthController@getPasswordReset');
Route::post('auth/forgot-password', 'Auth\AuthController@postPasswordReset');
Route::get('auth/forgot-password/verify', 'Auth\AuthController@verifyPassword');
Route::post('auth/forgot-password/verify', 'Auth\AuthController@checkPasswordVerificationCode');
Route::get('auth/reset-password', 'Auth\AuthController@resetPassword');
Route::post('auth/saveNewPassword', 'Auth\AuthController@saveNewPassword');
Route::get('get/product/{code}','Auth\AuthController@getProduct');

/**Landing Pages*/
Route::get('/', 'LandingPageController@index');
Route::get('free-demo','LandingPageController@demo');
Route::get('dashboard', 'DashboardController@index');
Route::get('contact-us','LandingPageController@contactUs');
Route::post('contact-us','LandingPageController@handleContactUs');
Route::get('privacy-policy','LandingPageController@privacyPolicy');
Route::get('terms','LandingPageController@terms');
Route::get('cookies','LandingPageController@cookies');
Route::post('newsletter/subscribe','LandingPageController@subscribe');
Route::get('newsletter/subscribed','LandingPageController@setSubscriberDetails');
Route::get('industries','LandingPageController@industries');


/**Public Checkout*/
Route::any('checkout/process','LandingPageController@processCheckout');

/**Early Access*/
//Route::get('early-access/{type?}','LandingPageController@earlyAccess');
//Route::post('early-access/purchase','LandingPageController@purchaseEarlyAccess');
Route::get('register/verify','Auth\AuthController@verifyRegister');
Route::post('register/verify/check','Auth\AuthController@verifyRegisterCheck');
Route::get('register/set/password','Auth\AuthController@setRegisterPassword');
Route::post('register/set/password','Auth\AuthController@registerSavePassword');

/**Free Trial*/
Route::get('free-trial','Auth\AuthController@register');
Route::post('free-trial','Auth\AuthController@postRegister');
Route::get('free-trial/step/1','Auth\AuthController@registerStep1');
Route::post('free-trial/step/1','Auth\AuthController@registerProcessStep1');
Route::get('free-trial/step/2','Auth\AuthController@registerStep2');
Route::post('free-trial/step/2','Auth\AuthController@registerProcessStep2');
Route::get('free-trial/step/3','Auth\AuthController@registerStep3');
Route::post('free-trial/step/3','Auth\AuthController@registerProcessStep3');
Route::get('complete/registration/{id}','Auth\AuthController@completeSpecialOfferRegistration');
Route::get('join','Auth\AuthController@tradieDigitalJoin');
//Route::get('early-access/complete/{id}','Auth\AuthController@handleEarlyAccessSignup');

/**Referrals*/
Route::get('referrals/{code}','Auth\AuthController@referral');
Route::post('referral/process','Auth\AuthController@processReferral');
Route::get('refer-friend','LandingPageController@referFriend');
Route::post('refer/check','LandingPageController@checkReferAuth');
Route::post('send/refer-friend','LandingPageController@sendReferFriendInvitations');
Route::get('setup/tradiereviews','SettingsController@setupTradieReviews');
Route::get('complete/referral/signup/{id}','Auth\AuthController@completeReferralQueue');

/**Admin Users*/
Route::get('admin/user','AdminController@users');
Route::get('admin/impersonate/{id}','AdminController@impersonate');

/**Reviews*/
Route::get('rate/job/{id}','LandingPageController@rateJob');
Route::post('rate/job','LandingPageController@postReview');
Route::get('reviews','ReviewsController@index');
Route::post('reviews/filter','ReviewsController@filter');
Route::post('reviews/send/invite','ReviewsController@sendInvite');
Route::get('rate/{id}','LandingPageController@reviewInvite');
Route::post('reviews/business/logo','ReviewsController@uploadBusinessLogo');
Route::post('reviews/remove/logo','ReviewsController@removeBusinessLogo');
Route::get('review/{id}','LandingPageController@addPublicReview');
Route::get('send-review','ReviewsController@sendReview');
Route::get('send-review/setup','ReviewsController@setupSendReview');
Route::post('send-review/setup','ReviewsController@saveReviewSetup');
Route::post('reviews/google/sheet','ReviewsController@handleGoogleSheetReviews');

/**Referrals*/
Route::get('referrals','ReferralsController@index');
Route::post('referrals/send/invite','ReferralsController@referralInvite');

/**Settings Pages*/
Route::get('settings', 'SettingsController@index');
Route::get('settings/calendar', 'SettingsController@calendar');
Route::patch('settings/calendar', 'SettingsController@updateCalendar');
Route::get('settings/account', 'SettingsController@account');
Route::patch('settings/account', 'SettingsController@updateAccount');
Route::get('settings/invoices', 'SettingsController@invoice');
Route::patch('settings/invoices', 'SettingsController@updateInvoice');
Route::get('settings/security', 'SettingsController@security');
Route::patch('settings/security', 'SettingsController@updateSecurity');
Route::get('settings/subscriptions','SettingsController@subscriptions');
Route::post('settings/update/card','SettingsController@updateCard');
Route::post('settings/update/subscription', 'SettingsController@updateSubscription');
Route::post('settings/remove/user/card','SettingsController@removeUserCard');
Route::post('settings/cancel/renewal','SettingsController@cancelRenewal');
Route::post('settings/subscriptions/discount','SettingsController@checkDiscountCode');
Route::get('settings/skip/{type}','SettingsController@skipOnboarding');
Route::post('settings/check/subscription','SettingsController@checkSubscription');
Route::get('settings/reviews','ReviewsController@setup');
Route::patch('settings/reviews','ReviewsController@update');

/**Admin*/
Route::get('admin','AdminController@dashboard');
Route::get('admin/generate','AdminController@generate');
Route::post('admin/generate','AdminController@processLeadGeneration');
Route::get('admin/referrals','AdminController@referrals');
Route::post('admin/referrals','AdminController@sendReferral');
Route::get('accept/referral/{id}','LandingPageController@acceptAdminReferralOffer');
Route::get('reject/referral/{id}','LandingPageController@rejectAdminReferralOffer');
Route::get('admin/verification-codes','AdminController@verificationCodes');

/**Other*/
Route::post('dashboard/notifications', 'DashboardController@getNotifications');
Route::get('test','TestController@index');
Route::get('test/google','TestController@google');
Route::get('mobile/iframe/{code}','Auth\AuthController@loadIframeSync');


/**Landing Page*/
Route::get('tradiecrm','LandingPageController@landingPageFor');
Route::get('tradiesoftware','LandingPageController@landingPageFor');
Route::get('crmfortradies','LandingPageController@landingPageFor');
Route::get('crmfortradesmen','LandingPageController@landingPageFor');
Route::get('tradesmencrm','LandingPageController@landingPageFor');
Route::get('tradesmensoftware','LandingPageController@landingPageFor');
Route::get('builderscrm','LandingPageController@landingPageFor');
Route::get('contractorscrm','LandingPageController@landingPageFor');
Route::get('electricianscrm','LandingPageController@landingPageFor');
Route::get('plumberscrm','LandingPageController@landingPageFor');
Route::get('handymancrm','LandingPageController@landingPageFor');
Route::get('contractorsoftware','LandingPageController@landingPageFor');
Route::get('electriciansoftware','LandingPageController@landingPageFor');
Route::get('plumberssoftware','LandingPageController@landingPageFor');
Route::get('hanydmansoftware','LandingPageController@landingPageFor');
Route::get('bestappforbuilders','LandingPageController@landingPageFor');
Route::get('bestcontractorapp','LandingPageController@landingPageFor');
Route::get('bestappfortradies','LandingPageController@landingPageFor');
Route::get('invoiceappforcontractors','LandingPageController@landingPageFor');
Route::get('invoiceappforbuilders','LandingPageController@landingPageFor');
Route::get('invoiceappfortradies','LandingPageController@landingPageFor');
Route::get('electricianapp','LandingPageController@landingPageFor');
Route::get('plumbersapp','LandingPageController@landingPageFor');
Route::get('handymanapp','LandingPageController@landingPageFor');
Route::get('decoratorssoftware','LandingPageController@landingPageFor');
