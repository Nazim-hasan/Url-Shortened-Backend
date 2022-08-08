<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Admin;
use Illuminate\Support\Carbon;

class ShortUrlAPIController extends Controller
{
    public function isLogin(){
        $clientMail = Session()->get('ClientEmail');
        $client = Client::where('email',$clientMail)->first();
        if($client == NULL){
            return false;
        }
        if($client != NULL){
            return true;
        }

    }
    public function manageAnonymousHits($anonymousIP, $mainUrl, $req){
        $AnonymousHitCount = Session()->get('anonymousHit');
                $url = Url::where('client_ip_address',$anonymousIP)->first();
                if($url == NULL){
                    $short = $this->saveToDB($mainUrl,$anonymousIP);
                    $req->session()->put('anonymousHit', 1);
                    return $short;
                }
                if($AnonymousHitCount>2){
                    return 'Please Login to use unlimited time.';
                }
                else if($url != NULL ){
                    $req->session()->put('anonymousHit', $AnonymousHitCount+1);
                    $short = $this->saveToDB($mainUrl,$anonymousIP);
                    return $short;
                }
                return 'Something wrong';
    }
    public function shortUrl(Request $req){
        $mainUrl = $req->mainUrl;
        if ($mainUrl){
            if(!$this->isLogin()){
                $anonymousIP = $req->ip();
                return $this->manageAnonymousHits($anonymousIP, $mainUrl, $req);

            }
            if($this->isLogin()){
                $MyIpAddress = $req->ip(); //get myIP
                $hitCount = Session()->get('APIHitCount');  //get previous hit count
                $duplicateUrlCounter = $this->isAlreadyExist($mainUrl, $MyIpAddress);
                if(!$duplicateUrlCounter){
                    //$this->saveToDB($mainUrl, $MyIpAddress);
                    return $this->saveToDB($mainUrl, $MyIpAddress);     //fresh Url directly stores 
                }
                if($duplicateUrlCounter){
                    $req->session()->put('APIHitCount', $hitCount+1);
                    //incrementing counter for already exist shorten link for same IP's
                }
                
                $client = Client::where('ip_address',$MyIpAddress)->first();
                $admin = Admin::where('id',1)->first();
                $waitingTimeByAdmin = $admin->waiting_time; //in minutes
                $multipleUrlMax = $admin->spamming_limit;
                if($hitCount > $multipleUrlMax-1){
                    $isBLocked = $this->setStatusClientDeActive($client, $waitingTimeByAdmin);
                    if($isBLocked){
                        return 'blocked';
                    }
                    else{
                        $this->setStatusClientActive($client);
                        $req->session()->put('APIHitCount', 1);
                        return $this->saveToDB($mainUrl, $MyIpAddress);
                    }
                }
                
                else if($client->status === 'active' || ($hitCount >= 1 && $hitCount<$multipleUrlMax)){
                    return $this->saveToDB($mainUrl, $MyIpAddress);
                }
            }
        }
    }
    public function isWaitingTimeOver($unblockTime){
        $currentTime = Carbon::now()->tz('Asia/Dhaka');
        if($currentTime->gt($unblockTime)){
            return true;
        }
    }
    public function setStatusClientDeActive($client, $time){
        if($this->isWaitingTimeOver($client->unblock_time)){
            return false;
        }
        $unblockTime = Carbon::now()->tz('Asia/Dhaka')->addMinutes($time); 
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
        if($alreadyExist){
            return true;
        }
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
            $urlHeader = 'http://127.0.0.1:8000/api/getURL/';
            $shortURL = $urlHeader.$url->converted_url;
            // $shortURL = 'http://127.0.0.1:8000/api/short/'.$url->converted_url;
            return $shortURL;
    }
    public function getShortenedUrl(Request $req){
        if($req->short){
            $url = Url::where('converted_url',$req->short)->first();
            return redirect()->to($url->main_url)->send();
        }
    }
    
}
