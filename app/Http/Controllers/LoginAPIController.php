<?php

namespace App\Http\Controllers;
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
            return $token;
        }
        return "No user found";
    }
}
