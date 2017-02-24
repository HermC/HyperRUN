@extends('layouts.activity_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/select2-4.0.3/dist/css/select2.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/activity.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/plugins/select2-4.0.3/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/activity_new.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-活动</title>
    <script type="text/javascript">
        var nav_focus = 2;
        var activity_nav_focus = -1;
    </script>
@endsection

@section('activity_content')
    <div class="col-xs-12 col-sm-8 content-right">
        <div class="content">
            <div class="title">
                <h3>发起活动</h3>
            </div>
            <form id="activity__form" class="form-horizontal form-activity-info" role="form" method="post" action="/activity/activity">
                <div class="form-group">
                    <label class="col-sm-3 control-label">标题</label>
                    <div class="col-sm-7">
                        <input id="activity_title" name="activity_title" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">活动地点</label>
                    <div class="col-sm-7">
                        <input id="activity_place" name="activity_place" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">活动时间</label>
                    <div class="input-group col-sm-7 date-wrapper">
                        <input id="activity_time" name="activity_time" class="form-control form-datetime" type="text" readonly>
                        <div class="input-group-addon"><i class="glyphicon glyphicon-th"></i></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">人数限制</label>
                    <div class="input-group col-sm-7 date-wrapper">
                        <input id="activity_participate" name="activity_participate" class="form-control" type="text" onkeyup="if(isNaN(value))execCommand('undo')">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">活动类型</label>
                    <div class="col-sm-7">
                        <select id="activity_type" name="activity_type" class="form-control">
                            <option>跑步</option>
                            <option>篮球</option>
                            <option>足球</option>
                            <option>羽毛球</option>
                            <option>网球</option>
                            <option>乒乓球</option>
                            <option>游泳</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">简介</label>
                    <div class="col-sm-7">
                        <textarea id="activity_detail" name="activity_detail" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-7">
                        <button id="activity_submit" class="edit-button" type="button">发起活动</button>
                    </div>
                </div>
                <div id="submit_alert" class="form-group" style="display: none;">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-7">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            未能成功提交，请检查<strong>网络连接</strong>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection