<?php namespace App\Http\Controllers;

use App\User;
use App\Premise;
use App\Building;
use App\Meeting;
use App\Http\Controllers\Controller;
class UnregblankController extends Controller
{
    function ShowAll()
    {
        if (\Auth::guest()) {
            $building = Building::all();
            return view('unregblank', ['building' => $building]);
        } else {
            return view('auth/login');
        }
    }
}