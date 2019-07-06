<?php

namespace App\Http\Controllers;

use App\msUserArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MsUserAreaController extends Controller
{
    public function add(Request $request) {
        $username = $request->username;
        $idArea = $request->id_area;

        $userarea = new msUserArea;
        $userarea->username = $username;
        $userarea->id_area = $idArea;

        if ($userarea->save()) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'failed'];
        }
        return $result;
    }

    public function checkArea(Request $request) {
        $username = $request->username;

        $area = DB::table('ms_user_areas')
            ->select('ms_user_areas.id_area AS id_area','ms_areas.nama')
            ->where('ms_user_areas.username','=',$username)
            ->join('ms_areas','ms_areas.id','=','ms_user_areas.id_area')
            ->get();
        return $area->toJson();
    }
}
