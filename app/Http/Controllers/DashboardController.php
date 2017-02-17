<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $server_count = Server::count();
        $slots_count = Server::sum('slots');

        return view('pages.dashboard', compact('server_count', 'slots_count'));
    }
}
