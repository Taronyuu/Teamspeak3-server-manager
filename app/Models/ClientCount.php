<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCount extends Model
{
    protected $table = "client_count";
    protected $fillable = [
        'server_id',
        'clients'
    ];
}
