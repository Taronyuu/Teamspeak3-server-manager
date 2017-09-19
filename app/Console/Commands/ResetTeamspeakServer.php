<?php

namespace App\Console\Commands;

use App\Models\Server;
use Illuminate\Console\Command;
use App\Helpers\TeamspeakHelper;

class ResetTeamspeakServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teamspeak:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[DANGEROUS]Removes all existing TeamSpeak 3 servers in your instance.';

    protected $teamspeak;

    /**
     * Create a new command instance.
     *
     * @param  TeamSpeakHelper $teamSpeakHelper
     * @return void
     */
    public function __construct(TeamSpeakHelper $teamSpeakHelper)
    {
        parent::__construct();

        $this->teamspeak = $teamSpeakHelper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $serverInstance = $this->teamspeak->getInstance();

        foreach ($serverInstance as $virtualServer) {
            $serverInstance->serverStop([
                'sid'   => $virtualServer['virtualserver_id'],
            ]);

            $serverInstance->serverDelete([
                'sid'   => $virtualServer['virtualserver_id'],
            ]);
        }

        Server::truncate();
    }
}
