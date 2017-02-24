<?php

namespace App\Http\Controllers;

use App\Models\BodyInfo;
use App\Models\Sleep;
use App\Models\Sports;
use App\Models\SportsTarget;
use App\Models\Weight;
use Illuminate\Http\Request;

use App\Http\Requests;

class SportsController extends Controller
{
    /**
     * Show sports dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex() {
        $userid = \Auth::user()->id;
        $body_info = BodyInfo::find($userid);
        $tips = null;
        $target_weight = 0;

        $height = $body_info['height'];
        $weight = $body_info['weight'];
        if($height!=null && $weight!=null){
            $tips = \BMI::tips($height, $weight);
            $target_weight = \BMI::targetWeight($height);
        }
        $weight_list = Weight::where('userid', $userid)->get();

        $today = date('Y-m-d');
        $sports_history_list = \DB::select('select userid, sum(steps) as steps_sum, sum(distance) as distance_sum,
                    sum(calorie) as calorie_sum, date(`time`) as `date` from sports
                    where userid = ? group by userid, date(`time`)'
            , [$userid]);
        $sports_list = Sports::where('userid', $userid)->whereRaw('date(time) = ?', [$today])->get();

        $sleep_history_list = \DB::select('select userid, min(value) as value_min, date(`time`) as `date` from sleep
                    where userid = ? group by userid, date(`time`)'
            , [$userid]);
        $sleep_list = Sleep::where('userid', $userid)->whereRaw('date(time) = ?', [$today])->get();

        $sports_target = SportsTarget::whereRaw('userid = ? and date(time) <= ?', [$userid, $today])->orderBy('time', 'DESC')->first();
        $type = null;
        $target = 0;

        $actual = 0;
        $surplus = 1;

        $tmp = null;

        if($sports_target != null){
            $type = $sports_target['type'];
            $target = $sports_target['target'];

            $actual_model = \DB::select('select userid, sum(steps) as steps_sum, sum(distance) as distance_sum,
                    sum(calorie) as calorie_sum from sports
                    where userid = ? and date(time) = ?', [$userid, $today]);

            if(sizeof($actual_model)==0){
                $actual = 0;
                $surplus = 1;
            }else{
                $tmp = $actual_model[0];
                if($type=='steps'){
                    $actual = floatval($tmp->steps_sum);
                }else if($type=='distance'){
                    $actual = floatval($tmp->distance_sum);
                }else{
                    $actual = floatval($tmp->calorie_sum);
                }

                if($actual >= $target){
                    $surplus = 0;
                }else{
                    $surplus = $target - $actual;
                }
            }
        }

        return view('sports/sports', [
            'body_info' => $body_info,
            'tips' => $tips,
            'weight_list' => json_encode($weight_list),
            'target_weight' => json_encode($target_weight),
            'sports_history_list' => json_encode($sports_history_list),
            'sports_list' => json_encode($sports_list),
            'sleep_history_list' => json_encode($sleep_history_list),
            'sleep_list' => json_encode($sleep_list),
            'surplus' => $surplus,
            'actual' => $actual,
            'sports_target' => json_encode($sports_target),
            'today' => json_encode($today)
        ]);
    }

    /**
     * Update body_info.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postBodyinfo(Request $request) {
        $all = $request->all();

        $height = floatval($all['user_height']);
        $weight = floatval($all['user_weight']);
        $walk = floatval($all['user_walk']);
        $run = floatval($all['user_run']);

        $userid = \Auth::user()->id;

        $body_info = BodyInfo::find($userid);

        if($body_info==null){
            $body_info = new BodyInfo();
            $body_info->userid = $userid;
        }

        if($height!=0){
            $body_info->height = $height;
        }
        if($weight!=0){
            $body_info->weight = $weight;

            $today = date('Y-m-d').'%';

            $weight_model = Weight::whereRaw('userid = ? and time like ?'
                , [$userid, $today])->first();

            if($weight_model==null){
                $weight_model = new Weight();

                $weight_model->userid = $userid;
                $weight_model->time = date('Y-m-d H:i:s');
                $weight_model->actual = $weight;

                $weight_model->save();
            }else{
                $affected = \DB::table('weight')->whereRaw('userid = ? and time like ?'
                    , [$userid, $today])->update(['actual' => $weight]);
            }
        }
        if($walk!=0){
            $body_info->walk_step = $walk;
        }
        if($run!=0){
            $body_info->run_step = $run;
        }

        $updated = $body_info->save();

        if($updated==true) {
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("保存失败，请稍后再试");
            return response()->json($result);
        }
    }

    /**
     * Update target.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postTarget(Request $request) {
        $userid = \Auth::user()->id;

        $all = $request->all();
        $type = $all['type'];
        $value = $all['value'];

        $today = date('Y-m-d');

        $sports_target = SportsTarget::whereRaw('userid = ? and date(time) = ?', [$userid, $today])->first();

        if($sports_target==null){
            $sports_target = new SportsTarget();

            $sports_target->userid = $userid;
            $sports_target->type = $type;
            $sports_target->time = date('Y-m-d H:i:s');
            $sports_target->target = $value;

            $inserted = $sports_target->save();

            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $affected = \DB::table('sports_target')->whereRaw('userid = ? and date(time) = ?'
                , [$userid, $today])->update(['target' => $value, 'type' => $type]);

            $result = \AjaxResponseService::success();
            return response()->json($result);
        }
    }

    /**
     * Update sports.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postSportsdate(Request $request) {
        $userid = \Auth::user()->id;

//        $result = [];
//
        $all = $request->all();
        $date = $all['date'];

        $sports_target = SportsTarget::whereRaw('userid = ? and date(time) <= ?', [$userid, $date])->first();
        $type = null;

        $actual = 0;
        $surplus = 1;

        $tmp = null;

        if($sports_target != null){
            $type = $sports_target['type'];
            $target = $sports_target['target'];

            $actual_model = \DB::select('select userid, sum(steps) as steps_sum, sum(distance) as distance_sum,
                    sum(calorie) as calorie_sum from sports
                    where userid = ? and date(time) = ?', [$userid, $date]);

            if(sizeof($actual_model)==0){
                $actual = 0;
                $surplus = 1;
            }else{
                $tmp = $actual_model[0];
                if($type=='steps'){
                    $actual = floatval($tmp->steps_sum);
                }else if($type=='distance'){
                    $actual = floatval($tmp->distance_sum);
                }else{
                    $actual = floatval($tmp->calorie_sum);
                }

                if($actual >= $target){
                    $surplus = 0;
                }else{
                    $surplus = $target - $actual;
                }
            }
        }

        $result['actual'] = $actual;
        $result['surplus'] = $surplus;

//        return response()->json(\AjaxResponseService::success($result));

        $re = \AjaxResponseService::success($result);

        return response()->json($re);
    }

    /**
     * Update body_info.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postSleepdate(Request $request) {

        return response()->json();
    }

}
