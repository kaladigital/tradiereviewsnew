<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserRegisterQueue extends Model
{
    public $timestamps = true;

    protected $table = 'user_register_queue';
    protected $primaryKey = 'user_register_queue_id';

    protected $fillable = [
        'name',
        'company',
        'email',
        'verify_code',
        'type',
        'password',
        'country_id',
        'referral_code',
        'referral_signup_email_sent',
        'code'
    ];
    protected $guarded = [];

    public function Country()
    {
        return $this->belongsTo('App\Models\Country','country_id','country_id');
    }
}
