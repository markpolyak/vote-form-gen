<?php namespace App\Http\Controllers;

use App\Meeting;
use App\Http\Controllers\Controller;

class DatmetController extends Controller {
    function GetMet(){
        //if (Request::ajax()){
            $id_build=$_POST['id_build'];
            $meetings = Meeting::where('id_building', $id_build)->get();
            return view('datmet', ['mets' => $meetings]);
        //}
    }

}
