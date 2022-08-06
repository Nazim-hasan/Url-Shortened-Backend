<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Client;

use Illuminate\Support\Carbon;

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
                echo "Already exist!!!";
                $req->session()->put('APIHitCount', $hitCount+1);
                echo "HitCount = ". $hitCount . '</br>';
                //incrementing counter for already exist shorten link for same IP's
            }
            else if(!$this->isAlreadyExist($mainUrl, $MyIpAddress)){
                $this->saveToDB($mainUrl, $MyIpAddress);
                return 'Saved';
            }
            $client = Client::where('ip_address',$MyIpAddress)->first();
            
            
            
            
            if($hitCount > 4){
                $waitingTimeByAdmin = 1; //in minutes
                $isBLocked = $this->setStatusClientDeActive($client, $waitingTimeByAdmin);
                if($isBLocked){
                    return 'block done';
                }
                else{
                    $this->setStatusClientActive($client);
                    $req->session()->put('APIHitCount', 0);
                    return $this->saveToDB($mainUrl, $MyIpAddress);
                }
            }
            
            else if($client->status === 'active' || ($hitCount >= 0 && $hitCount<5)){
                return $this->saveToDB($mainUrl, $MyIpAddress);
            }
        }
    }
    public function isWaitingTimeOver($unblockTime){
        $currentTime = Carbon::now()->tz('Asia/Dhaka');
        if($currentTime->gt($unblockTime)){
            echo "User can be unblock now";
            return true;
        }
    }
    public function setStatusClientDeActive($client, $time){
        if($this->isWaitingTimeOver($client->unblock_time)){
            return false;
        }
        $unblockTime = Carbon::now()->tz('Asia/Dhaka')->addMinutes($time);
        echo $unblockTime;
        Client::where('client_id', $client->client_id)->update(['status' => 'DeActive']);
        Client::where('client_id', $client->client_id)->update(['unblock_time' => $unblockTime]);
        return true;
    }
    public function setStatusClientActive($client){
        Client::where('client_id', $client->client_id)->update(['status' => 'active', 'unblock_time' => NULL ]);
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
            $url->user_id = 1;
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
