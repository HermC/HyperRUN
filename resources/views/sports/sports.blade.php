@extends('layouts.app')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/sports.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/echarts.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/sports.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-健康</title>
    <script type="text/javascript">
        var nav_focus = 1;

        var userid = {!! Auth::user() ->id!!};
        var weight_list;
        var target_weight;
        var sports_list;
        var sports_history_list;
        var sleep_list;
        var sleep_history_list;
        var actual = 0;
        var surplus = 1;
        var sports_target;

        @if ($weight_list != null)
            weight_list = {!! $weight_list !!};
        @else
            weight_list = null;
        @endif

        @if ($target_weight != null)
            target_weight = {!! $target_weight !!};
        @else
            target_weight = 0;
        @endif

        @if ($sports_list != null)
            sports_list = {!! $sports_list !!};
        @else
            sports_list = null;
        @endif

        @if ($sports_history_list != null)
            sports_history_list = {!! $sports_history_list !!};
        @else
            sports_history_list = null;
        @endif

        @if ($sleep_list != null)
            sleep_list = {!! $sleep_list !!};
        @else
            sleep_list = null;
        @endif

        @if ($sleep_history_list != null)
            sleep_history_list = {!! $sleep_history_list !!};
        @else
            sleep_history_list = null;
        @endif

        @if ($sports_target != null)
            sports_target = {!! $sports_target !!};
        @else
            sports_target = null;
        @endif

        surplus = {!! $surplus !!};
        actual = {!! $actual !!};
    </script>
@endsection

@section(('content'))
    <div class="container">
        <div class="row main-content">
            <div class="col-xs-12 col-sm-4 content-left">
                <div class="widget">
                    <div class="title">
                        <h3>健康管理</h3>
                    </div>
                    <ul class="nav-list">
                        <li>
                            <a class="active">身体管理</a>
                            <ul id="body_list">
                                <li class=""><a href="#detail">详细数据</a></li>
                                <li class=""><a href="#weight_change">体重变化</a></li>
                            </ul>
                        </li>
                        <li>
                            <a>健身追踪器</a>
                        </li>
                        <li>
                            <a>睡眠分析</a>
                        </li>
                    </ul>
                    <hr class="visible-xs">
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <div class="col-xs-12 col-sm-8 content-right">
                <div class="content">
                    <a name="detail"></a>
                    <div class="title">
                        <h3>详细数据</h3>
                    </div>
                    <div id="body_form_error" class="alert alert-warning alert-dismissible" role="alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <span id="body_form_error_message">网络错误，请重新尝试</span>
                    </div>
                    <form id="body_form" class="form-horizontal form-user-info" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">身高(cm)</label>
                            <div class="col-sm-4">
                                <input id="user_height" name="user_height" type="text" class="form-control" onkeyup="if(isNaN(value))execCommand('undo')"
                                    value="{{ $body_info['height'] }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">体重(kg)</label>
                            <div class="col-sm-4">
                                <input id="user_weight" name="user_weight" type="text" class="form-control" onkeyup="if(isNaN(value))execCommand('undo')"
                                    value="{{ $body_info['weight'] }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">走路步长(cm)</label>
                            <div class="col-sm-4">
                                <input id="user_walk" name="user_walk" type="text" class="form-control" onkeyup="if(isNaN(value))execCommand('undo')"
                                    value="{{ $body_info['walk_step'] }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">跑步步长(cm)</label>
                            <div class="col-sm-4">
                                <input id="user_run" name="user_run" type="text" class="form-control" onkeyup="if(isNaN(value))execCommand('undo')"
                                    value="{{ $body_info['run_step'] }}"/>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tips:</h3>
                        </div>
                        <div class="panel-body">
                            @if ($tips != null)
                                你的BMI(身体质量指数)为 <strong>{!! $tips['value'] !!}</strong> ,
                                理想体重为 <strong>{!! $tips['target_weight'] !!}</strong> kg,
                                属于 <strong>{!! $tips['tips'] !!}</strong> 体重范畴
                            @endif
                        </div>
                    </div>
                </div>
                <div class="content">
                    <a name="weight_change"></a>
                    <div class="title">
                        <h3>体重变化</h3>
                    </div>
                    <div id="weight_chart">

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 content-right">
                <div class="content">
                    <div class="title">
                        <h3>健身追踪</h3>
                    </div>
                    <div class="user-target">
                        <label>日目标</label>&nbsp;&nbsp;
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="target_options" id="option1" value="steps" autocomplete="off" checked>步数
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="target_options" id="option2" value="distance" autocomplete="off">距离
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="target_options" id="option3" value="calorie" autocomplete="off">卡路里
                            </label>
                        </div>
                    </div>
                    <form id="steps_target_form" class="target-input">
                        <label>步&nbsp;&nbsp;&nbsp;数</label>&nbsp;&nbsp;
                        <input type="hidden" name="type" value="steps">
                        <input id="foot_step" class="target-input-value" name="value" type="text" onkeyup="if(isNaN(value))execCommand('undo')"
                               value=""/>&nbsp;
                        <label>步</label>&nbsp;&nbsp;
                        <button id="steps_target_button" type="button" class="edit-button">保存</button>
                        <span id="steps_target_alert" style="color: red; display: none">&nbsp;&nbsp;请输入目标！</span>
                    </form>
                    <form id="distance_target_form" class="target-input" style="display: none">
                        <label>距&nbsp;&nbsp;&nbsp;离</label>&nbsp;&nbsp;
                        <input type="hidden" name="type" value="distance">
                        <input id="distance" class="target-input-value" name="value" type="text" onkeyup="if(isNaN(value))execCommand('undo')"
                               value=""/>&nbsp;
                        <label>km</label>&nbsp;&nbsp;
                        <button id="distance_target_button" type="button" class="edit-button">保存</button>
                        <span id="distance_target_alert" style="color: red; display: none;">&nbsp;&nbsp;请输入目标！</span>
                    </form>
                    <form id="calorie_target_form" class="target-input" style="display: none">
                        <label>卡路里</label>&nbsp;&nbsp;
                        <input type="hidden" name="type" value="calorie">
                        <input id="calorie" class="target-input-value" name="value" type="text" onkeyup="if(isNaN(value))execCommand('undo')"
                               value=""/>&nbsp;
                        <label>大卡</label>&nbsp;&nbsp;
                        <button id="calorie_taget_button" type="button" class="edit-button">保存</button>
                        <span id="calorie_target_alert" style="color: red; display: none">&nbsp;&nbsp;请输入目标！</span>
                    </form>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            日期:&nbsp;&nbsp;
                            <div class="input-group date-wrapper">
                                <input id="target_datepicker" class="form-control sport-datepicker" type="text" readonly>
                                <div class="input-group-addon"><i class="glyphicon glyphicon-th"></i></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <h4>运动状况</h4>
                            <div class="target-complete-wrapper">
                                <div class="chart-wrapper">
                                    <div id="target_complete_chart" class="">

                                    </div>
                                </div>
                                <div>
                                    <h3>运动目标完成</h3>
                                    <h1 id="target_h1">
                                        @if (($actual+$surplus) != 0)
                                            {{ intval(($actual / ($actual + $surplus)) * 100) }}%
                                        @else
                                            0%
                                        @endif
                                    </h1>
                                </div>
                            </div>
                            <br>
                            <div class="btn-group change-chart" data-toggle="buttons">
                                <label class="btn btn-default active">
                                    <input type="radio" name="chart_options" id="to_step_chart" autocomplete="off" checked>步数
                                </label>
                                <label class="btn btn-default">
                                    <input type="radio" name="chart_options" id="to_distance_chart" autocomplete="off">距离
                                </label>
                                <label class="btn btn-default">
                                    <input type="radio" name="chart_options" id="to_calorie_chart" autocomplete="off">卡路里
                                </label>
                            </div>
                            <br>
                            <br>
                            <h4>运动曲线图</h4>
                            <br>
                            <div id="daily_sports_chart">

                            </div>
                            <h4>历史数据</h4>
                            <br>
                            <div id="history_sports_chart">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 content-right">
                <div class="content">
                    <div class="title">
                        <h3>睡眠分析</h3>
                    </div>
                    <div class="flex-column">
                        <label>日期:</label>&nbsp;&nbsp;
                        <div class="input-group date-wrapper flex-column-item">
                            <input id="sleep_datepicker" class="form-control sport-datepicker" type="text" readonly>
                            <div class="input-group-addon"><i class="glyphicon glyphicon-th"></i></div>
                        </div>
                    </div>
                    <br>
                    <h4>睡眠状况</h4>
                    <br>
                    {{--<div class="target-complete-wrapper">--}}
                        {{--<div class="chart-wrapper">--}}
                            {{--<div id="sleep_complete_chart" class="">--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<h3>睡眠有效率</h3>--}}
                            {{--<h1>75%</h1>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <br>
                    <div id="daily_sleep_chart">

                    </div>
                    <br>
                    <h4>历史数据</h4>
                    <br>
                    <div id="history_sleep_chart">

                    </div>
                    {{--<div class="panel panel-info">--}}
                        {{--<div class="panel-heading">--}}
                            {{--<h3 class="panel-title">Tips</h3>--}}
                        {{--</div>--}}
                        {{--<div class="panel-body">--}}
                            {{--<p>一起睡个好觉吧~</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection