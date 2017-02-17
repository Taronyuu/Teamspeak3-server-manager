<?php

namespace App\Helpers;

use App\Models\Server;
use App\Models\Token;

class TeamspeakHelper
{
    private $server;
    private $instance;

    public function __construct()
    {
        $this->instance = \TeamSpeak3::factory("serverquery://" . env('TS_USERNAME') .":" . env('TS_PASSWORD') . "@" . env('TS_SERVER_IP') . ":" . env('TS_SERVER_PORT'));
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function server(Server $server){
        return \TeamSpeak3::factory("serverquery://" . env('TS_USERNAME') .":" . env('TS_PASSWORD') . "@" . env('TS_SERVER_IP') . ":" . env('TS_SERVER_PORT') . "/?server_port=" . $server->port . "&use_offline_as_virtual=1");
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

    public function startServer(Server $server)
    {
        $result = $this->instance->serverStart([
            'sid' => $server->sid
        ]);

        return $result;
    }

    public function stopServer(Server $server)
    {
        $result = $this->instance->serverStop([
            'sid' => $server->sid
        ]);

        return $result;
    }

    public function resetToken(Server $server, $channel = "Server Admin")
    {
        $virtualServer = $this->server($server);
        $arr_ServerGroup = $virtualServer->serverGroupGetByName("Server Admin");
        $token = $arr_ServerGroup->privilegeKeyCreate();
        return $token;
    }

    public function deleteToken(Server $server, Token $token)
    {
        $virtualServer = $this->server($server);
        return $virtualServer->privilegeKeyDelete($token->token);
    }

    public function updateConfiguration(Server $server, $data)
    {
        $server = $this->server($server);
        return $server->modify($data);
    }

    public function getOnlineUsers(Server $server)
    {
        $server = $this->server($server);
        return $server->clientCount();
    }

    public function getServer($server)
    {
        $server = $this->server($server);
        return $server;
    }
}
