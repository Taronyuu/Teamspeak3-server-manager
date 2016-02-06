<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = "servers";
    protected $fillable = [
        'sid',
        'user_id',
        'name',
        'ip',
        'port',
        'slots'
    ];
}
