<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class ProxyController extends Controller
{
    protected $proxy = array(
        'register' => array(
            'basic' => array(
                'proxy_url' => "https://api.github.com/user"
            )
        )
    );

    public function user(Request $request){

      $client = new Client();
      $res = $client->request('GET', $this->proxy['register']['basic']['proxy_url'], [
          'headers'  => ['Accept' => 'application/vnd.github.v3+json', 'Content-Type' => 'application/json'],
          'auth' => [$request->input('username'), $request->input('access_token')]
      ]);

      return response()->json(['result' => json_decode($res->getBody())], $res->getStatusCode());

    }
}
