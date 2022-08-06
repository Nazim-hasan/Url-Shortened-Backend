<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\ProcessPodcast;
use App\Models\Client;

class ShortUrlAPIController extends Controller
{
    
    //
    public function shortUrl(Request $req){
        $mainUrl = $req->mainUrl;
        if ($mainUrl){
            $MyIpAddress = $req->ip(); //get myIP
            $hitCount = Session()->get('APIHitCount');  //get previous spam count
            echo "HitCount = ". $hitCount . '</br>';
            if($this->isAlreadyExist($mainUrl, $MyIpAddress)){
                $req->session()->put('APIHitCount', $hitCount+1);
                //incrementing counter for already exist shorten link for same IP's
            }
            $client = Client::where('ip_address',$MyIpAddress)->first();
            if($hitCount > 4 || $client->status == 'DeActive'){
                
                $this->setStatusClientDeActive($client);
                $activeNow = $this->setStatusClientActive($client);
                if($activeNow){
                    $req->session()->put('APIHitCount', 0);
                }
                ProcessPodcast::dispatch($activeNow)->delay(now()->addMinutes(1));
                return 'You are blocked';
            }
            if($client->status === 'active'){
                return $this->saveToDB($mainUrl, $MyIpAddress);
            }
            else{
                return 'User Blocked!!!';
            }
        }
    }
    public function setStatusClientDeActive($client){
        Client::where('client_id', $client->client_id)->update(['status' => 'DeActive']);
        return true;
    }
    public function setStatusClientActive($client){
        Client::where('client_id', $client->client_id)->update(['status' => 'active']);
        return true;
    }
    public function isAlreadyExist($mainUrl, $MyIpAddress){
        $alreadyExist = Url::where('main_url',$mainUrl)->where('client_ip_address',$MyIpAddress)->first();
        return true;
    }
    public function makeShort(){
        $shortUrl = Str::random(6);
        return $shortUrl;
    }
    public function saveToDB($mainUrl, $MyIpAddress){
        $url = new Url();
            $url->main_url = $mainUrl;
            $url->client_id = 1;
            $url->client_ip_address = $MyIpAddress;
            $url->converted_url = $this->makeShort();
            $url->save();
            return $url->converted_url;
    }
    public function getShortenedUrl(Request $req){
        $url = Url::where('converted_url',$req->shortUrl)->first();
        return $url->main_url;
    }
    
}
