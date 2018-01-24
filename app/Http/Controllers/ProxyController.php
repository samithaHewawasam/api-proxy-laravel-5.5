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
                'method' => 'GET',
                'url' => "https://api.github.com/user",
                'header' => ['Accept' => 'application/vnd.github.v3+json', 'Content-Type' => 'application/json'],
                'data' => 'auth'
            )
        ),
        'sample' => array(
            'users' => array(
                'method' => 'POST',
                'url' => "https://reqres.in/api/users",
                'header' => ['Content-Type' => 'application/json'],
                'data' => 'form_params'
            )
        )
    );

    public function handle($proxy, $data)
    {

        $client = new Client();

        $res = $client->request($proxy['method'], $proxy['url'], array(
            'headers' => $proxy['header'],
            $proxy['data'] => $data
        ));

        return response()->json(array(
            'result' => json_decode($res->getBody())
        ), $res->getStatusCode());

    }

    public function user(Request $request)
    {

        return $this->handle($this->proxy['register']['basic'], array(
            $request->input('username'),
            $request->input('access_token')
        ));

    }

    public function users(Request $request)
    {

        return $this->handle($this->proxy['sample']['users'], $request->all());

    }

}
