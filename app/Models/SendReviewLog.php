<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SendReviewLog extends Model
{
    public $timestamps = true;

    protected $table = 'send_review_log';
    protected $primaryKey = 'send_review_log_id';

    protected $fillable = [
        'user_id',
        'target'
    ];

    protected $guarded = [];
}
