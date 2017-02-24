<?php

namespace App\Http\Controllers;

use App\Models\FriendRequestsRelation;
use App\Models\FriendsRelation;
use App\User;
use Illuminate\Http\Request;
use App\Facades\AjaxResponseFacade;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{

    /**
     * Show user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex() {
        return view('user/user');
    }

    /**
     * Operate user info change.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postInfo(Request $request) {
        if($request->isMethod('get')) {
            abort(404);
        }

        $all = $request->all();
        $userid = \Auth::user()->id;
        $user = User::find($userid);

        $user->name = $all['user_nickname'];
        $user->synopsis = $all['user_synopsis'];
        $user->sex = $all['sex'];
        $user->birthday = $all['user_birthday'];

        if($user->save()){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("更新出错");
            return response()->json($result);
        }
    }

    /**
     * Operate user password change.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postPassword(Request $request) {
        if($request->isMethod('get')) {
            abort(404);
        }

        $all = $request->all();
        $userid = \Auth::user()->id;
        $user = User::find($userid);

        $user->password = \Hash::make($all['password']);

        if($user->save()){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("更新出错");
            return response()->json($result);
        }
    }

    /**
     * Check user nickname change.
     *
     * @param $nickname
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function getNickname($nickname) {
        $user = User::where('name', '=', $nickname)->get();
        if(sizeof($user)==0){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("昵称已存在", []);
            return response()->json($result);
        }
    }

    /**
     * Search users.
     *
     * @param $keyword
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function getSearch($keyword = null) {
        if($keyword==null){
            $keyword = '%%';
        }else{
            $keyword = $keyword.'%';
        }

        $userid = \Auth::user()->id;
        $users = \DB::table('users')
                    ->select('users.*')
                    ->whereRaw('id <> ? and (email like ? or name like ?) and id not in (
                        select f.friendid from friends as f
                        where f.userid = ?
                    )', [$userid, $keyword, $keyword, $userid])
                    ->simplePaginate(5);

        $already_requests = \DB::table('friend_requests')
                                ->select('userid')
                                ->where('friendid', '=', $userid)
                                ->get();

        $id_list = [];

        for($i=0;$i<sizeof($already_requests);$i++){
            array_push($id_list, intval($already_requests[$i]->userid));
        }

        return view('user/friend_search', [
            'users' => $users,
            'usersJSON' => json_encode($users),
            'already_requests' => $id_list,
        ]);
    }

    /**
     * Request friends.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function putFriends($id) {
        $userid = \Auth::user()->id;

        $tmp = FriendRequestsRelation::where('userid', $id)
                            ->where('friendid', $userid)->get();

        if(sizeof($tmp)==0){
            $friendRequestsRelation = new FriendRequestsRelation();

            $friendRequestsRelation->userid = $id;
            $friendRequestsRelation->friendid = $userid;

            $inserted = $friendRequestsRelation->save();

            if($inserted==true){
                $result = \AjaxResponseService::success();
                return response()->json($result);
            }else{
                $result = \AjaxResponseService::fail("申请失败，请重试");
                return response()->json($result);
            }
        }else{
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }
    }

    /**
     * Get my friends.
     *
     * @param $keyword
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function getFriends($keyword = null) {
        if($keyword==null){
            $keyword = '%%';
        }else{
            $keyword = $keyword.'%';
        }

        $userid = \Auth::user()->id;
        $friends = \DB::table('friends')
                    ->join('users', 'friends.friendid', '=', 'users.id')
                    ->select('users.*')
                    ->whereRaw('friends.userid = ? and (users.email like ? or users.name like ?)', array($userid, $keyword, $keyword))
                    ->paginate(8);

        return view('user/friends', ['friends' => $friends, 'friendsJSON' => json_encode($friends)]);
    }

    /**
     * Delete my friend.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function deleteFriends($id) {
        $userid = \Auth::user()->id;
        $deleted = FriendsRelation::where('userid', $userid)
                                ->where('friendid', $id)->delete();

        if($deleted==1){
            $result = \AjaxResponseService::success();
        }else{
            $result = \AjaxResponseService::fail("未找到该用户，请重试");
        }

        return response()->json($result);
    }

    /**
     * Operate friend requests.
     *
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function getRequests() {
        $userid = \Auth::user()->id;
        $friend_requests = \DB::table('friend_requests')
                                ->join('users', 'friend_requests.friendid', '=', 'users.id')
                                ->select('users.*')
                                ->where('friend_requests.userid', '=', $userid)->get();

        return view('user/friend_requests', ['requests' => $friend_requests, 'requestsJSON' => json_encode($friend_requests)]);
    }

    /**
     * Accept friend requests.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function putRequests($id)
    {
        $userid = \Auth::user()->id;

        $inserted = true;

        $tmp = FriendsRelation::where('userid', $userid)
            ->where('friendid', $id)->get();

        if (sizeof($tmp) == 0) {
            $friendsRelation = new FriendsRelation();
            $friendsRelation->userid = $userid;
            $friendsRelation->friendid = $id;

            $inserted = $friendsRelation->save();
        }

        $tmp = FriendsRelation::where('userid', $id)
            ->where('friendid', $userid)->get();

        if (sizeof($tmp) == 0) {
            $friendsRelation = new FriendsRelation();
            $friendsRelation->userid = $id;
            $friendsRelation->friendid = $userid;

            $inserted = $friendsRelation->save();
        }

        if ($inserted == true) {
            $deleted = FriendRequestsRelation::where('userid', $userid)
                                            ->where('friendid', $id)->delete();
            $result = \AjaxResponseService::success();
            return response()->json($result);
        } else {
            $result = \AjaxResponseService::fail("更新失败，请重试");
            return response()->json($result);
        }
    }

    /**
     * Refuse friend requests.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function deleteRequests($id) {
        $userid = \Auth::user()->id;

        $deleted = FriendRequestsRelation::where('userid', $userid)
                                        ->where('friendid', $id)->delete();

        if($deleted==1){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("更新失败，请重试");
            return response()->json($result);
        }
    }

    /**
     * Get user info.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function getInfo($id) {
        $user = User::find($id);

        return view("user/user_info", ['user' => $user]);
    }

    /**
     * Get user's portrait.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function postPortrait(Request $request){
        $all = $request->all();

        $x = $all['x'];
        $y = $all['y'];
        $w = $all['w'];
        $h = $all['h'];
        $realW = $all['realW'];
        $realH = $all['realH'];

        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('img_file')){
            return response()->json('fail');
        }
        $file = $request->file('img_file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
//            exit('文件上传出错！');
            return response()->json('fail');
        }

        $img = Image::make($file);

        $width = $img->width();
        $height = $img->height();

        $w_scale = $width / $realW;
        $h_scale = $height / $realH;

        $x1 = $x * $w_scale;
        $y1 = $y * $h_scale;
        $w1 = $w * $w_scale;
        $h1 = $h * $h_scale;

        $img->crop(intval($w1), intval($h1), intval($x1), intval($y1));

        $newFileName = \Auth::user()->id.'.'.$file->getClientOriginalExtension();
        $savePath = 'img/users/img'.$newFileName;
        $bytes = Storage::disk('public')->put(
            $savePath,
            $img->encode($file->getClientOriginalExtension())
        );
        if(!Storage::disk('public')->exists($savePath)){
            return response()->json('fail save');
        }

        header("Content-Type: ".Storage::disk('public')->mimeType($savePath));

        return response()->json('storage/'.$savePath);
    }


    /**
     * Update user's portrait path.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function putPortrait(Request $request) {
        $all = $request->all();

        $portrait_path = $all['portrait_path'];

        $userid = \Auth::user()->id;
        $user = User::find($userid);
        $user->portrait = url($portrait_path);

        $updated = $user->save();

        if($updated==1){
            $result = \AjaxResponseService::success();
            return response()->json($result);
        }else{
            $result = \AjaxResponseService::fail("");
            return response()->json($result);
        }
    }
}
