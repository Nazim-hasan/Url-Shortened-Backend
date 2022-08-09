<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PendingUser;
use Illuminate\Http\Request;
use DateTime;
class RegisterAPIController extends Controller
{
    //
    public function registration(Request $request){

        $user = new Client();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->status = 'active';
        $user->created_at = new DateTime();
        $user->updated_at = new DateTime();
        $user->save();
        return 'registered';
    }
}
