<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlAPIController extends Controller
{
    
    //
    public function shortUrl(Request $req){
        if ($req->mainUrl){
            $url = new Url();
            $url->main_url = $req->mainUrl;
            $url->client_id = 1;
            $shortUrl = Str::random(6);
            $url->converted_url = $shortUrl;
            $url->save();
            return $url;
        }
    }
    public function getShortenedUrl(Request $req){
        $url = Url::where('converted_url',$req->shortUrl)->first();
        return $url->main_url;
    }
    
}
