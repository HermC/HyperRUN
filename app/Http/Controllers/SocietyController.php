<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Society;
use App\Models\Thumb;
use Illuminate\Http\Request;

use App\Http\Requests;

class SocietyController extends Controller
{
    /**
     * Show society dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex() {
        $societys = \DB::table('society')
                    ->join('users', 'society.userid', '=', 'users.id')
                    ->select('society.*', 'users.id', 'users.name', 'users.portrait', 'users.level')
                    ->orderBy('society.created_at', 'DESC')
                    ->paginate(10);

        $thumbs = Thumb::all();

        $thumbs_list = array();
        for($i=0;$i<sizeof($thumbs);$i++){
            array_push($thumbs_list, $thumbs[$i]->dynamicid);
        }

        return view('society/society', ['societys' => $societys, 'thumbs' => $thumbs_list]);
    }

    /**
     * Show new dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew() {
        return view('society/society_new');
    }

    /**
     * Add new dynamics.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postNew(Request $request) {
        $useid = \Auth::user()->id;

        $all = $request->all();

        $content = $all['content'];
        $title = $all['title'];

        $society = new Society();
        $society->userid = $useid;
        $society->title = $title;
        $society->content = $content;
        $society->comment_num = 0;
        $society->thumb_num = 0;

        $inserted = $society->save();

        if($inserted==true){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail('');
            return response()->json($result);
        }
    }

    /**
     * Show details.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getInfo($id) {
        $society = \DB::table('society')
                        ->join('users', 'society.userid', '=', 'users.id')
                        ->select('society.*', 'users.name', 'users.id')
                        ->where('society.dynamicid', $id)
                        ->first();

        $comments = \DB::select('select c.*, u1.name replier, u1.id replier_id, u2.name asker, u2.id asker_id
                    from comments c, users u1, users u2
                    where c.replier = u1.id and c.asker = u2.id and c.dynamicid = ?', [$id]);

        return view('society/society_info', ['society' => $society, 'comments' => $comments]);
    }

    /**
     * Give thumbs.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function putThumb($id) {
        $userid = \Auth::user()->id;

        $thumb_up = Thumb::where('dynamicid', $id)
                            ->where('userid', $userid)
                            ->get();

        if(sizeof($thumb_up)==0){
            $thumb_up = new Thumb();
            $thumb_up->dynamicid = $id;
            $thumb_up->userid = $userid;
            $thumb_up->save();

            $society = Society::find($id);
            $society->thumb_num++;
            $inserted = $society->save();

            if($inserted==true){
                $result = \AjaxResponseService::success();
                return response()->json($result);
            }else{
                $result = \AjaxResponseService::fail('');
                return response()->json($result);
            }
        }

        $result = \AjaxResponseService::success();
        return response()->json($result);
    }

    /**
     * Ungive thumbs.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function deleteThumb($id) {
        $userid = \Auth::user()->id;

        $thumb_up = Thumb::where('dynamicid', $id)
            ->where('userid', $userid)
            ->delete();

        if($thumb_up!=0){
            $society = Society::find($id);
            $society->thumb_num--;
            $inserted = $society->save();

            if($inserted==true){
                $result = \AjaxResponseService::success();
                return response()->json($result);
            }else{
                $result = \AjaxResponseService::fail('');
                return response()->json($result);
            }
        }

        $result = \AjaxResponseService::success();
        return response()->json($result);
    }

    /**
     * Comment.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postComment(Request $request) {
        $userid = \Auth::user()->id;

        $all = $request->all();
        $content = $all['content'];
        $replyid = $all['replyid'];
        $dynamicid = $all['dynamicid'];

        $comment = new Comment();
        $comment->dynamicid = $dynamicid;
        $comment->asker = $replyid;
        $comment->replier = $userid;
        $comment->content = $content;

        $inserted = $comment->save();

        if($inserted==true){
            $society = Society::find($dynamicid);
            $society->comment_num++;
            $society->save();

            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail('');
            return response()->json($result);
        }
    }
}
