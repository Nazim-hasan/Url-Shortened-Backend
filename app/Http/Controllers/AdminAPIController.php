<?php

namespace App\Http\Controllers;
use App\Models\Admin;

use Illuminate\Http\Request;

class AdminAPIController extends Controller
{
    public function spammingLimit(Request $req){
        Admin::where('id', 1)->update(['spamming_limit' => $req->limit]);
        return "updated Limit";
        //this will update for all other admins too
    }
    public function waitingTime(Request $req){
        Admin::where('id', 1)->update(['waiting_time' => $req->time]);
        return "updated Limit";
        //this will update for all other admins too
    }
    public function getSpammingLimit(){
        $admin = Admin::where('id', 1)->first();
        return $admin->spamming_limit;
    }
    public function getWaitingTime(){
        $admin = Admin::where('id', 1)->first();
        return $admin->waiting_time;
    }
}
