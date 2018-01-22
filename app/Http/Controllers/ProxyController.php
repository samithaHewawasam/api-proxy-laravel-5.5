<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
          'headers'  => ['Accept' => 'application/vnd.github.v3+json'],
          'auth' => [$request->input('username'), $request->input('access_token')]
      ]);

      echo $res->getBody();

    }
}
