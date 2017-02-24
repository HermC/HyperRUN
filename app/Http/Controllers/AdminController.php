<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{

    public function deleteUser($id) {

        $user = User::find($id);
        $user->delete();

        $result = \AjaxResponseService::success();

        return response()->json($result);
    }
}
