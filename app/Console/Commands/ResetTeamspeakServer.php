<?php

namespace App\Console\Commands;

use App\Helpers\TeamspeakHelper;
use App\Models\Server;
use Illuminate\Console\Command;

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
    protected $description = '[DANGEROUS]Removes all existing Teamspeak server in your instance';

    protected $teamspeak;

    /**
     * Create a new command instance.
     *
     * @return void
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
