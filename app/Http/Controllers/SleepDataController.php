<?php

namespace App\Http\Controllers;

use App\Models\Sleep;
use Illuminate\Http\Request;

use App\Http\Requests;

class SleepDataController extends Controller
{
    /**
     * Update sleep data.
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

            $tmp = new Sleep();
            $tmp->userid = $id;
            $tmp->time = $item['time'];
            $tmp->value = $item['value'];

            $inserted = $tmp->save();
        }

        if($inserted==true) {
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("保存失败，请稍后再试");
            return response()->json($result);
        }
//        return response()->json($all);
    }

    /**
     * Show sleep data.
     *
     * @param $id
     * @param null $date
     * @return \Illuminate\Http\Response
     */
    public function show($id, $date = null) {
        if($date==null){
            $sleep_list = Sleep::where('userid', $id)->get();
            $result = \AjaxResponseService::success($sleep_list);
            return response()->json($result);
        }else{
            $sleep_list = Sleep::where('userid', $id)->whereRaw('date(time) = ?', [$date])->get();
            $result = \AjaxResponseService::success($sleep_list);
            return response()->json($result);
        }
    }
}
