<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = "tokens";
    protected $fillable = [
        'server_id',
        'token'
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
