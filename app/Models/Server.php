<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Helpers\TeamSpeakHelper;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use Filterable;

    protected $fillable = [
        'sid',
        'name',
        'ip',
        'port',
        'slots',
    ];

    protected $perPage = 20;

    private $status;

    public function getStatusAttribute()
    {
        if (is_null($this->status)) {
            $this->status = $this->getStatus();
        }

        return $this->status;
    }

    public function getStatus()
    {
        $ts3 = new TeamspeakHelper;
        $result = $ts3->getStatus($this);
        $this->status = $result;

        return $result;
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
