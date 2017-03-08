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
        $servers = Server::latest()->paginate();

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
        $server = Server::create($request->all());
        $teamspeakServer = $this->teamspeak->createServer($server);

        $data = [
            'sid' => $teamspeakServer['sid'],
            'port' => $teamspeakServer['virtualserver_port'],
            'ip' => env('TS_SERVER_IP')
        ];

        $server->update($data);

        $tokenData = [
            'server_id' => $server->id,
            'token' => $teamspeakServer['token']
        ];

        Token::create($tokenData);

        return redirect()->action('ServerController@index')->with('success', 'Server successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $server = Server::findOrFail($id);

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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $server = Server::findOrFail($id);

        return view('pages.servers.edit', compact('server'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ServerRequest $request
     * @param  int                             $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ServerRequest $request, $id)
    {
        $server = Server::findOrFail($id);
        $server->update($request->all());
        $this->teamspeak->updateServer($server);

        return redirect()->action('ServerController@show', $server)->with('success', 'Server has been edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Server::findOrFail($id);

        if ($server->status) {
            return redirect()->back()->with('error', 'Can\'t delete your server when it is running');
        }

        $this->teamspeak->stopServer($server);
        $this->teamspeak->deleteServer($server);
        $server->delete();

        return redirect()->action('ServerController@index')->with('success', 'Server has been deleted');
    }

    public function start($id)
    {
        $server = Server::findOrFail($id);

        if ($server->status) {
            return redirect()->back()->with('error', 'Can\'t start a running server');
        }

        (new TeamspeakHelper())->startServer($server);

        return redirect()->back()->with('success', 'Server has been started');
    }

    public function restart($id)
    {
        $server = Server::findOrFail($id);
        $teamspeak = new TeamspeakHelper();

        if ($server->status) {
            $teamspeak->stopServer($server);
        }

        $teamspeak->startServer($server);


        return redirect()->back()->with('success', 'Server has been started');
    }

    public function stop($id)
    {
        $server = Server::findOrFail($id);

        if (!$server->status) {
            return redirect()->back()->with('error', 'Can\'t stop a server that isn\'t running');
        }

        (new TeamspeakHelper())->stopServer($server);

        return redirect()->back()->with('success', 'Server has been stopped');
    }

    public function resetToken($id)
    {
        $server = Server::findOrFail($id);

        $token = (new TeamspeakHelper())->resetToken($server);
        $data = [
            'server_id' => $server->id,
            'token' => $token
        ];
        $token = Token::create($data);

        return redirect()->action('ServerController@showTokens', $server)->with('success', 'Token has been created');
    }

    public function showTokens($id)
    {
        $server = Server::findOrFail($id);
        $tokens = $server->tokens;

        return view('pages.servers.tokens', compact('tokens', 'server'));
    }

    public function deleteToken($id, $token_id)
    {
        $server = Server::findOrFail($id);
        $token = Token::findOrFail($token_id);
        (new TeamspeakHelper())->deleteToken($server, $token);
        $token->delete();

        return redirect()->back()->with('success', 'Token has been deleted');
    }

    public function showConfigure($id)
    {
        $server = Server::findOrFail($id);
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

    public function postConfigure($id, Request $request)
    {
        $server = Server::findOrFail($id);
        $data = $request->all();
        if (array_key_exists('_token', $data)) {
            unset($data['_token']);
        }
        (new TeamspeakHelper())->updateConfiguration($server, $data);

        return redirect()->action('ServerController@show', $server)->with('success', 'Server successfully updated');
    }
}
