<?php namespace App\Http\Controllers;

use App\User;
use App\Premise;
use App\Building;
use App\Meeting;
use App\Http\Controllers\Controller;
class MeetingController extends Controller
{
    function ShowAll()
    {
        if (\Auth::guest()) {
            return view('auth/login');
        }
else
        {
            $premise = Premise::where('id_premise', \Auth::user()->id_premise)->first();

            $meetings = Meeting::where('id_building', $premise->id_building)->get();

            return view('meetings', ['meetings' => $meetings]);
        }
    }
}