@extends('layouts.app')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/Jcrop-0.9.12/css/jquery.Jcrop.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/user.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/plugins/Jcrop-0.9.12/js/jquery.Jcrop.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/jquery.form.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/user.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-{{ Auth::user()->name }}</title>
    <script type="text/javascript">
        var nav_focus = -1;
    </script>
@endsection

@section(('content'))
    <div class="container">
        <div class="row main-content">
            <div class="col-xs-12 col-sm-4 content-left">
                <div class="widget">
                    <div class="title">
                        <h3>个人设置</h3>
                    </div>
                    <ul class="nav-list">
                        <li>
                            <a class="active">基本信息</a>
                            <ul id="basic_list">
                                <li class=""><a href="#basic">详细数据</a></li>
                                <li class=""><a href="#portrait">更改头像</a></li>
                            </ul>
                        </li>
                        <li>
                            <a>我的好友</a>
                        </li>
                        <li>
                            <a>好友请求</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <div class="col-xs-12 col-sm-8 content-right">
                <div class="content">
                    <a name="basic"></a>
                    <div class="title">
                        <h3>基本信息</h3>
                    </div>
                    <form id="user_info" class="form-horizontal form-user-info" role="form" action="user/info" method="post">
                        {{--{!! csrf_field() !!}--}}
                        <h4>个人资料</h4>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">用户名</label>
                            <div class="col-sm-7">
                                <p class="form-control-static">{{ Auth::user()->email }} <span class="label label-info">等级{{ Auth::user()->level }}</span></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">昵称</label>
                            <div class="col-sm-7 has-feedback">
                                <input id="user_nickname" name="user_nickname" type="text" class="form-control" value="{{ Auth::user()->name }}"
                                        data-toggle='popover'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">简介</label>
                            <div class="col-sm-7">
                                <textarea id="user_synopsis" name="user_synopsis" class="form-control" rows="3">{{ Auth::user()->synopsis }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">性别</label>
                            <div class="col-sm-7 sex-radio">
                                <label>
                                    <input type="radio" name="sex" id="sex_female" {{ Auth::user()->sex=='female' ? 'checked' : '' }} value="female"/> 女性 <i class="fa fa-venus"></i>
                                </label>
                                &nbsp;&nbsp;
                                <label>
                                    <input type="radio" name="sex" id="sex_male" {{ Auth::user()->sex=='male' ? 'checked' : '' }} value="male"/> 男性 <i class="fa fa-mars"></i>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">出生日期</label>
                            <div class="input-group col-sm-7 date-wrapper">
                                <input id="user_birthday" name="user_birthday" class="form-control form-datetime" type="text" readonly value="{{ Auth::user()->birthday }}">
                                <div class="input-group-addon"><i class="glyphicon glyphicon-th"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                                <button id="save_user_info" class="edit-button" type="button">保存</button>
                            </div>
                        </div>
                        <div id="info_submit_error" class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label hidden-xs"></label>
                            <div class="col-sm-7">
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <span>网络错误，请重新尝试</span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <form id="user_password" class="form-horizontal form-user-info" role="form">
                        <h4>修改密码</h4>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">密码</label>
                            <div class="col-sm-7">
                                <input id="user_password_input" name="password" type="password" class="form-control" placeholder="Password"
                                    data-toggle="popover" data-content="密码不能为空">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">确认密码</label>
                            <div class="col-sm-7">
                                <input id="user_password_confirm" type="password" class="form-control" placeholder="Password"
                                    data-toggle="popover" data-content="两次密码必须一致">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                                <button id="save_new_password" class="edit-button" type="button">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content">
                    <a name="portrait"></a>
                    <div class="title">
                        <h3>更改头像</h3>
                    </div>
                    <div id="img_alert_success" class="alert alert-success" style="display: none"><strong>图片已成功提交!</strong></div>
                    <div id="img_alert_error" class="alert alert-danger" style="display: none"></div>
                    <form id="img_form">
                        <img id="view_img"/>
                        <input id="change_img" style="display: none" type="file" name="img_file"/>
                        <input type="hidden" id="x" name="x"/>
                        <input type="hidden" id="y" name="y"/>
                        <input type="hidden" id="w" name="w"/>
                        <input type="hidden" id="h" name="h"/>
                        <input type="hidden" id="realW" name="realW"/>
                        <input type="hidden" id="realH" name="realH"/>
                    </form>
                    <button id="choose_file" class="edit-button" type="button"><i class="fa fa-plus"></i> 选择文件</button>
                    <button id="confirm_file" class="edit-button" type="button"><i class="fa fa-check"></i> 确认更改</button>
                    <!--                <label id="file_state" class="change-failed"></label>-->
                    <img id="cut_img"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 content-right" style="display: none">
                <div class="content">
                    <div class="title">
                        <h3>添加好友</h3>
                    </div>
                    <div class="search-wrapper">
                        <input id="friend_search_input" class="search-input" type="text"/>
                        <button id="friend_search_button" type="button" class="edit-button">搜索</button>
                    </div>
                    <br>
                    <div id="add_alert" class="alert alert-warning alert-dismissible" role="alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Warning!</strong> <span id="add_alert_message"></span>
                    </div>
                    <div id="search_list">

                    </div>
                </div>
                <div class="content">
                    <div class="title">
                        <h3>好友列表</h3>
                    </div>
                    <div class="search-wrapper">
                        <input id="my_friend_search_input" class="search-input" type="text"/>
                        <button id="my_friend_search_button" type="button" class="edit-button">搜索</button>
                    </div>
                    <br>
                    <div id="delete_alert" class="alert alert-warning alert-dismissible" role="alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Warning!</strong> <span id="delete_alert_message"></span>
                    </div>
                    <div id="friend_list">
                        您还没有好友！
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 content-right" style="display: none">
                <div class="content">
                    <div class="title">
                        <h3>好友请求</h3>
                    </div>
                    <div id="request_alert" class="alert alert-warning alert-dismissible" role="alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Warning!</strong> <span id="request_alert_message"></span>
                    </div>
                    <div id="request_friend" class="friend-list-wrapper">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection