<?php

namespace App\Http\Controllers;

use App\Models\Sports;
use Illuminate\Http\Request;

use App\Http\Requests;

class SportsDataController extends Controller
{

    /**
     * Update sports data.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $all = $request->all();

        $data = $all['data'];

        $inserted = false;

        for($i=0;$i<sizeof($data);$i++){
            $item = $data[$i];

            $tmp = new Sports();
            $tmp->userid = $id;
            $tmp->time = $item['time'];
            $tmp->steps = $item['steps'];
            $tmp->distance = $item['distance'];
            $tmp->calorie = $item['calorie'];

            $inserted = $tmp->save();
        }

        if($inserted==true) {
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("保存失败，请稍后再试");
            return response()->json($result);
        }
    }

    /**
     * Show sports data.
     *
     * @param $id
     * @param null $date
     * @return \Illuminate\Http\Response
     */
    public function show($id, $date = null) {
        if($date==null){
            $sports_list = Sports::where('userid', $id)->get();
            $result = \AjaxResponseService::success($sports_list);
            return response()->json($result);
        }else{
            $sports_list = Sports::where('userid', $id)->whereRaw('date(time) = ?', [$date])->get();
            $result = \AjaxResponseService::success($sports_list);
            return response()->json($result);
        }
    }
}
