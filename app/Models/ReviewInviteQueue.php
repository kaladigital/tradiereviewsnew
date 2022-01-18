<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReviewInviteQueue extends Model
{
    public $timestamps = true;

    protected $table = 'review_invite_queue';
    protected $primaryKey = 'review_invite_queue_id';

    protected $fillable = [
        'user_id',
        'email',
        'type'
    ];

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','user_id');
    }
}
