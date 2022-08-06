<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DateTime;

class LoginAPIController extends Controller
{
    //
    public function login(Request $req){
        $client = Client::where('email',$req->email)->where('password',$req->password)->first();
        if($client){
            $api_token = Str::random(64);
            $token = new Token();
            $token->name = $client->name;
            $token->token = $api_token;
            $token->last_used_at = new DateTime();
            $token->save();
            if($token){
                $myIp = $req->ip();
                $req->session()->put('MyIpAddress', $myIp);
                $req->session()->put('APIHitCount', 0);
                echo "Hit Count". Session()->get('APIHitCount');
                $client = Client::where('email',$req->email )->first();
                Client::where('client_id', $client->client_id)
                    ->update(['ip_address' => $myIp, 'status' => 'active']);
                return $myIp;
            }
            return $token;
        }
        return "No user found";
    }
}
