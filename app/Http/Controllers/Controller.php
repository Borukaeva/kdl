<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function home()
    {
        $users = DB::table('users')->get();
//        $users ="12345";
        //Controller::sendMessage("Hello World");

        return view('welcome', ['users' => $users]);
    }

    public function sendMessage($messaggio)
    {
//    echo "sending message to " . $chatid . "\n";
        $token = "5286191231:AAENFqH6stIHQXXfZ3Hz2idSr3tj7bzLU7Y";
        $chatid = "-666725564";

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatid;
        $url = $url . "&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
