<?php

namespace App\Http\Controllers;

use AjaxResponseService;
use App\Models\Admin;
use App\Models\Sports;
use App\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userid = \Auth::user()->id;

        $isAdmin = Admin::where('userid', $userid)->get();

        if(sizeof($isAdmin)){
            $users = User::all();
            return view('user/admin', ['users' => $users, 'a' => json_encode($isAdmin)]);
        }

        $sum = \DB::select('select userid, sum(steps) as steps_sum, sum(distance) as distance_sum,
                sum(calorie) as calorie_sum from sports where userid = ?', [$userid]);

        $result = null;

        if(sizeof($sum)!=0){
            $result = $sum[0];
        }

        return view('home', ['sum' => $result]);
    }
}
