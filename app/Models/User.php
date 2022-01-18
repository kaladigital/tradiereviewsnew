<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    public $timestamps = true;

    protected $table = 'user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'name_initials',
        'email',
        'password',
        'otp_code',
        'otp_created_date',
        'phone',
        'has_email_verified',
        'mobile_login_key',
        'active',
        'mon',
        'mon_start',
        'mon_end',
        'tue',
        'tue_start',
        'tue_end',
        'wed',
        'wed_start',
        'wed_end',
        'thu',
        'thu_start',
        'thu_end',
        'fri',
        'fri_start',
        'fri_end',
        'sat',
        'sat_start',
        'sat_end',
        'sun',
        'sun_start',
        'sun_end',
        'remember_token',
        'role',
        'country_id',
        'zip_code',
        'city',
        'state',
        'address',
        'website_url',
        'invoice_email',
        'invoice_country_id',
        'invoice_zip_code',
        'invoice_city',
        'invoice_state',
        'invoice_address',
        'invoice_vat',
        'invoice_registration_number',
        'invoice_eu_vat_id',
        'invoice_bank_number',
        'invoice_bank_iban',
        'invoice_bank_name',
        'invoice_swift_code',
        'email_font_type',
        'email_signature',
        'company_user_id',
        'stripe_customer_id',
        'gmail_username',
        'gmail_password',
        'gmail_token',
        'is_lead',
        'twilio_password',
        'twilio_address_sid',
        'onboarding_state',
        'tradieflow_subscription_expire_message',
        'tradiereview_subscription_expire_message',
        'facebook_reviews_url',
        'mobile_first_login_date_time',
        'desktop_first_login_date_time',
        'reviews_logo',
        'public_reviews_code',
        'reviews_company_name',
        'google_review_place_id',
        'google_review_address',
        'google_review_url',
        'first_onboarding_passed',
        'mobile_onboarding_completed',
        'mobile_walkthrough_completed',
        'is_reviews_display_name',
        'is_boost_reviews_user'
    ];

    protected $guarded = [];
    protected $hidden = ['password','remember_token'];

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function Country()
    {
        return $this->belongsTo('App\Models\Country','country_id','country_id');
    }

    public function InvoiceCountry()
    {
        return $this->belongsTo('App\Models\Country','invoice_country_id','country_id');
    }
}
