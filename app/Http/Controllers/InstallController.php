<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function __construct()
    {
        if (User::count()) {
            return redirect()
                ->action('DashboardController@index')
                ->with('error', 'There is already an existing user. Can\'t reinitate install');
        }
    }

    public function index()
    {
        return view('install');
    }

    public function install(Requests\PostInstallationRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()
            ->action('DashboardController@index')
            ->with('success', 'Installation has been completed');
    }
}
