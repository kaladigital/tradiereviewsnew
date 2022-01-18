<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserSignupIP extends Model
{
    public $timestamps = true;

    protected $table = 'user_signup_ip';
    protected $primaryKey = 'user_signup_ip_id';

    protected $fillable = [
        'user_id',
        'ip',
        'product'
    ];
    protected $guarded = [];
}
