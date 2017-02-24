<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipate;
use Illuminate\Http\Request;

use App\Http\Requests;

class ActivityController extends Controller
{
    /**
     * Show all activity dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex() {
        $activitys = \DB::table('activity')
                        ->join('users', 'activity.ownerid', '=', 'users.id')
                        ->select('users.name', 'activity.*')
                        ->orderBy('activity.start', 'DESC')
                        ->paginate(10);

        return view('activity/activity_all', ['activitys' => $activitys]);
    }

    /**
     * Show my activity dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMy() {
        $userid = \Auth::user()->id;

        $my_activitys = \DB::table('activity')
                        ->join('users', 'activity.ownerid', '=', 'users.id')
                        ->select('users.name', 'activity.*')
                        ->where('activity.ownerid', $userid)
                        ->orderBy('activity.start', 'DESC')
                        ->paginate(10);

        $in_activitys = \DB::table('activity')
                        ->join('users', 'activity.ownerid', '=', 'users.id')
                        ->join('activity_participate', 'activity.id', '=', 'activity_participate.activityid')
                        ->select('users.name', 'activity.*')
                        ->where('activity_participate.userid', $userid)
                        ->paginate(10);

        return view('activity/activity_my', ['my_activitys' => $my_activitys, 'in_activitys' => $in_activitys]);
    }

    /**
     * Show new activity dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew() {
        return view('activity/activity_new');
    }

    /**
     * Add new activity dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postActivity(Request $request) {
        $userid = \Auth::user()->id;

        $all = $request->all();

        $activity = new Activity();

        $activity->ownerid = $userid;
        $activity->title = $all['activity_title'];
        $activity->place = $all['activity_place'];
        $activity->start = $all['activity_time'];
        $activity->participant_num = $all['activity_participate'];
        $activity->type = $all['activity_type'];
        $activity->detail = $all['activity_detail'];

        $inserted = $activity->save();

        if($inserted==true){
            $result = \AjaxResponseService::success($all);
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail('');
            return response()->json($result);
        }
    }

    /**
     * Delete activity.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function deleteActivity($id) {
        ActivityParticipate::where('activityid', $id)->delete();
        $deleted = Activity::destroy($id);

        if($deleted==1){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail('');
            return response()->json($result);
        }
    }

    /**
     * Get activity details.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getInfo($id) {
        $userid = \Auth::user()->id;

        $detail = Activity::find($id);
        $participants = \DB::table('activity_participate')
                        ->join('users', 'activity_participate.userid', '=', 'users.id')
                        ->select('users.id', 'users.name', 'users.portrait')
                        ->where('activity_participate.activityid', $id)
                        ->get();
        $num = \DB::select('select count(userid) as `sum` from activity_participate where activityid = ?', [$id]);

        $isIn = true;

        $test = \DB::table('activity_participate')
                    ->select('*')
                    ->where('activityid', $id)
                    ->where('userid', $userid)
                    ->get();

        if(sizeof($test)==0){
            $isIn = false;
        }

        if($detail->ownerid==$userid){
            $isIn = true;
        }

        return view('activity/activity_info', [
            'detail' => $detail,
            'participants' => $participants,
            'num' => $num[0],
            'isIn' => $isIn
        ]);
    }

    /**
     * Add participant dashboard.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function putParticipant($id) {
        $userid = \Auth::user()->id;

        $act = new ActivityParticipate();
        $act->activityid = $id;
        $act->userid = $userid;

        $inserted = $act->save();

        if($inserted==true){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail('');
            return response()->json($result);
        }
    }

    /**
     * Delete participant dashboard.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function deleteParticipant($id) {
        $userid = \Auth::user()->id;

        $deleted = ActivityParticipate::where('activityid', $id)
                                    ->where('userid', $userid)->delete();

        if($deleted==1){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail();
            return response()->json($result);
        }
    }
}
