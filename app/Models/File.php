<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table='files';

    protected $fillable=['path','code','times','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
