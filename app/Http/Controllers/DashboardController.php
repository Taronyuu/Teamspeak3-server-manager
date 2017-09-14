<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $server_count = Server::count();
        $slots_count = Server::sum('slots');

        return view('home', compact('server_count', 'slots_count'));
    }
}
