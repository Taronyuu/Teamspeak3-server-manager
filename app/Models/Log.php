<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "logs";

    protected $fillable = [
        'server_id',
        'action'
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
