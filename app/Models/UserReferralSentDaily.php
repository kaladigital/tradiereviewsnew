<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserReferralSentDaily extends Model
{
    public $timestamps = true;

    protected $table = 'user_referral_sent_daily';
    protected $primaryKey = 'user_referral_sent_daily_id';

    protected $fillable = [
        'user_id',
        'type',
        'total_sent'
    ];
    protected $guarded = [];
}


