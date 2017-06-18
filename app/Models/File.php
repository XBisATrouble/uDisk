<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table='files';

    protected $fillable=['path','fileName','code','times','private','user_id','ip'];

    protected $dates = ['delete_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() > Carbon::parse($date)->addDays(3)) {
            return Carbon::parse($date);
        }
        return Carbon::parse($date)->diffForHumans();
    }

    public function scopeRecent()
    {
        return $this->where('created_at','>=',Carbon::now()->subDays(5));
    }

    public function scopeEnable()
    {
        return $this->where('enable',true);
    }
}
