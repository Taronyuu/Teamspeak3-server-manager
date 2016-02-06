<?php

namespace App\Helpers;

use App\Models\Server;
use Illuminate\Database\Eloquent\Model;

class TeamspeakHelper
{
    private $server;
    private $instance;

    public function __construct()
    {
        $this->instance = \TeamSpeak3::factory("serverquery://" . env('TS_USERNAME') .":" . env('TS_PASSWORD') . "@" . env('TS_SERVER_IP') . ":" . env('TS_SERVER_PORT'));
    }

    public function server(Server $server){
        return \TeamSpeak3::factor("serverquery://" . env('TS_USERNAME') .":" . env('TS_PASSWORD') . "@" . env('TS_SERVER_IP') . ":" . env('TS_SERVER_PORT') . "/?server_port=" . $server->port . "&use_offline_as_virtual=1");
    }

    public function createServer(Server $server)
    {
        $new_sid = $this->instance->serverCreate([
            'virtualserver_name'        => $server->name,
            'virtualserver_maxclients'  => $server->slots,
        ]);

        return $new_sid;
    }

    public function getStatus(Server $server)
    {
        $server = $this->server($server);
        $result = $server->getProperty("virtualserver_status");
        if($result == 'online'){
            return true;
        }
        return false;
    }

    public function deleteServer(Server $server)
    {
        $result = $this->instance->serverDelete([
            'sid'   => $server->sid
        ]);

        return $result;
    }

    public function updateServer(Server $server)
    {
        $virtualServer = $this->server($server);
        $result = $virtualServer->modify([
            'virtualserver_name'        => $server->name,
            'virtualserver_maxclients'  => $server->slots,
        ]);

        return $result;
    }

    public function startServer($server)
    {
        $result = $this->instance->serverStart([
            'sid' => $server->sid
        ]);

        return $result;
    }

    public function stopServer($server)
    {
        $result = $this->instance->serverStop([
            'sid' => $server->sid
        ]);

        return $result;
    }

    public function resetToken($server, $channel = "Server Admin")
    {
        $virtualServer = $this->server($server);
        $arr_ServerGroup = $virtualServer->serverGroupGetByName("Server Admin");
        $token = $arr_ServerGroup->privilegeKeyCreate();
        return $token;
    }

    public function deleteToken($server, $token)
    {
        $virtualServer = $this->server($server);
        return $virtualServer->privilegeKeyDelete($token->token);
    }

    public function updateConfiguration($server, $data)
    {
        $server = $this->server($server);
        return $server->modify($data);
    }

    public function getOnlineUsers($server)
    {
        $server = $this->server($server);
        return $server->clientCount();
    }
}
