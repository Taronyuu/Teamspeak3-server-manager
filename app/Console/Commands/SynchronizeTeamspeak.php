<?php

namespace App\Console\Commands;

use App\Models\Token;
use App\Models\Server;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Helpers\TeamspeakHelper;

class SynchronizeTeamspeak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teamspeak:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Teamspeak 3 servers with your instance and database.';

    protected $teamspeak;

    /**
     * Create a new command instance.
     *
     * @param \App\Console\Commands\TeamspeakHelper $teamspeak
     */
    public function __construct(TeamspeakHelper $teamspeak)
    {
        parent::__construct();
        $this->teamspeak = $teamspeak;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $serverInstance = $this->teamspeak->getInstance();
        foreach ($serverInstance as $key => $virtualServer) {
            /* @var $virtualServer \TeamSpeak3_Node_Server */

            $server = Server::whereSid($virtualServer['virtualserver_id'])->first();


            /*
             * If the server does not exist in our database.
             */
            if (!$server) {
                $slots = 0;
                $created = Carbon::now();
                $tokens = [];

                try {
                    $slots = $virtualServer['virtualserver_maxclients'];
                    $created = array_get($virtualServer->getInfo(), 'virtualserver_created');

                    foreach ($virtualServer->privilegeKeyList() as $key => $item) {
                        $tokens[$key]['token'] = (string)$item['token'];
                        $tokens[$key]['created_at'] = date('Y-m-d H:i:s', $item['token_created']);
                    }
                } catch (\Exception $exception) {
                }

                $server = Server::create([
                    'sid' => $virtualServer['virtualserver_id'],
                    'name' => $virtualServer['virtualserver_name'],
                    'port' => $virtualServer['virtualserver_port'],
                    'slots' => $slots,
                    'ip' => env('TS_SERVER_IP'),
                ]);

                $server->created_at = $created;
                $server->updated_at = $created;
                $server->save();

                foreach ($tokens as $token) {
                    $createToken = $server->tokens()->create([
                        'token' => $token['token']
                    ]);

                    $createToken->created_at = $token['created_at'];
                    $createToken->updated_at = $token['created_at'];
                    $createToken->save();
                }

                /*
                 * Server exists so update it
                 */
            } else {
                $slots = 0;

                $tokens = [];

                try {
                    $slots = $virtualServer['virtualserver_maxclients'];

                    foreach ($virtualServer->privilegeKeyList() as $key => $item) {
                        $tokens[$key]['token'] = (string)$item['token'];
                        $tokens[$key]['created_at'] = date('Y-m-d H:i:s', $item['token_created']);
                    }
                } catch (\Exception $exception) {

                }

                $server->update([
                    'name' => $virtualServer['virtualserver_name'],
                    'port' => $virtualServer['virtualserver_port'],
                    'slots' => $slots,
                    'ip' => env('TS_SERVER_IP'),
                ]);

                foreach ($tokens as $token) {
                    $createToken = $server->tokens()->firstOrCreate([
                        'token' => $token['token']
                    ]);

                    if ($createToken->wasRecentlyCreated) {
                        $createToken->created_at = $token['created_at'];
                        $createToken->updated_at = $token['created_at'];
                        $createToken->save();
                    }
                }
            }
        }
    }
}
