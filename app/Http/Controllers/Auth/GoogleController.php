<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use PulkitJalan\Google\Client;
use PulkitJalan\Google\Facades\Google;
use App\Http\Controllers\Controller;

use App\GoogleAuth;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        $client = Google::getClient();

        $state = mt_rand();
        $client->setState($state);
        $request->session()->set('state', $state);

        return redirect($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $client = Google::getClient();

        if (empty($request->get('code')) || $request->get('state') != $request->session()->get('state')) {
            $state = mt_rand();
            $request->session()->set('state', $state);
            $client->setState($state);

            return redirect($client->createAuthUrl());
        }

        $client->setState($request->session()->get('state'));

        $token = $client->authenticate($request->get('code'));

        if (empty($token) || !empty($token['error'])) {
            return redirect($client->createAuthUrl());
        }

        $request->session()->set('token', $token);

        return redirect()->action('Admin\VideosController@index');
    }
}
