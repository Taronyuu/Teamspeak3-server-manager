<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Server;
use Illuminate\Http\Request;
use App\Helpers\TeamspeakHelper;
use App\Http\Requests\ServerRequest;

class ServerController extends Controller
{
    protected $teamspeak;

    public function __construct(TeamspeakHelper $teamspeak)
    {
        $this->teamspeak = $teamspeak;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::latest()->paginate(10);

        return view('pages.servers.index', compact('servers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.servers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ServerRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServerRequest $request)
    {
        try {
            $teamspeakServer = $this->teamspeak->createServer($request);
        } catch (\Exception $exception) {
            if ($exception->getMessage() == 'virtualserver limit reached') {
                flash("You have reached the virtual server limit for your license.")->error();
            } else {
                flash("Something went wrong creating that virtual server.")->error();
            }

            return redirect()->route('servers.index');
        }

        $server = Server::create($request->all());

        $data = [
            'sid' => $teamspeakServer['sid'],
            'port' => $teamspeakServer['virtualserver_port'],
            'ip' => config('teamspeak.ip'),
        ];

        $server->update($data);

        $tokenData = [
            'server_id' => $server->id,
            'token' => $teamspeakServer['token']
        ];

        Token::create($tokenData);

        flash("Server successfully created!")->success();

        return redirect()->route('servers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Server $server
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        $virtualServer = (new TeamspeakHelper())->getServer($server);
        $viewer = $virtualServer->getViewer(new \TeamSpeak3_Viewer_Html(
            "/images/viewer/",
            "/images/flags/",
            "data:image"
        ));
        $clientCount = $virtualServer->clientCount();

        return view('pages.servers.show', compact('server', 'viewer', 'clientCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Server $server
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $server)
    {
        return view('pages.servers.edit', compact('server'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ServerRequest $request
     * @param  Server $server
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ServerRequest $request, Server $server)
    {
        $server->update($request->all());

        $this->teamspeak->updateServer($server);

        flash("Server has been edited.")->success();

        return redirect()->route('servers.show', $server);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Server $server
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        // @TODO - We can remove this check? We stop and delete the server anyway...
        if ($server->status) {
            flash("Can't delete your server when it is running.")->error();

            return back();
        }

        $this->teamspeak->stopServer($server);
        $this->teamspeak->deleteServer($server);
        $server->delete();

        flash("Server has been deleted.")->success();

        return redirect()->route('servers.index');
    }

    public function start(Server $server)
    {
        if ($server->status) {
            flash("Server is already running.")->error();

            return back();
        }

        (new TeamspeakHelper())->startServer($server);

        flash("Server has been started.")->success();

        return back();
    }

    public function restart(Server $server)
    {
        $teamspeak = new TeamspeakHelper;

        if ($server->status) {
            $teamspeak->stopServer($server);
        }

        $teamspeak->startServer($server);

        flash("Server has been started.")->success();

        return back();
    }

    public function stop(Server $server)
    {
        if (! $server->status) {
            flash("Server is already stopped.")->error();

            return back();
        }

        (new TeamspeakHelper())->stopServer($server);

        flash("Server has been stopped")->success();

        return back();
    }

    public function resetToken(Server $server)
    {
        $token = (new TeamspeakHelper())->resetToken($server);
        $data = [
            'server_id' => $server->id,
            'token' => $token,
        ];
        $token = Token::create($data);

        flash()->overlay("<kbd>{$token->token}</kbd>", 'Token Generated!');

        return redirect()->route('servers.show_tokens', $server);
    }

    public function showTokens(Server $server)
    {
        return view('pages.servers.tokens', compact('server'));
    }

    public function deleteToken(Server $server, Token $token)
    {
        (new TeamspeakHelper())->deleteToken($server, $token);

        $token->delete();

        flash("Token has been deleted.")->success();

        return back();
    }

    public function showConfigure(Server $server)
    {
        $virtualServer = (new TeamspeakHelper())->getServer($server);

        $serverData = [
            'virtualserver_name' => (string)$virtualServer['virtualserver_name'],
            'virtualserver_welcomemessage' => (string)$virtualServer['virtualserver_welcomemessage'],
            'virtualserver_password' => "",
            'virtualserver_hostbanner_url' => (string)$virtualServer['virtualserver_hostbanner_url'],
            'virtualserver_hostbanner_gfx_url' => (string)$virtualServer['virtualserver_hostbanner_gfx_url'],
            'virtualserver_hostbutton_tooltip' => (string)$virtualServer['virtualserver_hostbutton_tooltip'],
            'virtualserver_hostbutton_gfx_url' => (string)$virtualServer['virtualserver_hostbutton_gfx_url'],
            'virtualserver_hostbutton_url' => (string)$virtualServer['virtualserver_hostbutton_url'],
        ];

        return view('pages.servers.configure', compact('server', 'virtualServer', 'serverData'));
    }

    public function postConfigure(Request $request, Server $server)
    {
        $data = $request->except('_token');

        // Laravel sets empty inputs as null so we need empty string for TS3.
        // @TODO This best? I would remove the middleware but it's good to have.
        $data = array_map(function ($value) {
            return (is_null($value) ? '' : $value);
        }, $data);

        (new TeamspeakHelper())->updateConfiguration($server, $data);

        flash("Server settings updated successfully.")->success();

        return redirect()->route('servers.show', $server);
    }
}