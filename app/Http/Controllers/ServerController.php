<?php

namespace App\Http\Controllers;

use App\Helpers\TeamspeakHelper;
use App\Models\Server;
use App\Models\Token;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServerController extends Controller
{

    protected $teamspeak;

    public function __construct(TeamspeakHelper $teamspeak){
        $this->teamspeak = $teamspeak;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::all();

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PostAndPutCreateServerRequest $request)
    {
        $server = Server::create($request->all());
        $teamspeakServer = $this->teamspeak->createServer($server);

        $data = [
            'sid'   => $teamspeakServer['sid'],
            'port'  => $teamspeakServer['virtualserver_port'],
            'ip'    => env('TS_SERVER_IP')
        ];
        $server->update($data);

        $tokenData = [
            'server_id' => $server->id,
            'token'     => $teamspeakServer['token']
        ];
        Token::create($tokenData);

        return redirect()->action('ServerController@index')->with('success', 'Message successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
