<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Admin;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DateTime;

class LoginAPIController extends Controller
{
    //
    public function isAdmin($req){
        $admin = Admin::where('email',$req->email)->where('password',$req->password)->first();
        if($admin){
            return true;
        }
    }
    public function login(Request $req){
        if($this->isAdmin($req)){
            return 'admin';
        }
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
                $req->session()->put('APIHitCount', 1);
                $req->session()->put('ClientEmail', $client->email);
                Client::where('email', $client->email)
                    ->update(['ip_address' => $myIp]);
                    return $token;
            }
            return 'Invalid username or password';
        }
        return "No user found";
    }
    public function logout(Request $req){
        $token = Token::where('token',$req->Token)->first();
        $token->expired_at = new DateTime();
        Session()->forget('ClientEmail');
        Session()->forget('APIHitCount');
        Session()->forget('MyIpAddress');
        $token->save();
    }
}
