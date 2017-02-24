@extends('layouts.activity_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/css/activity.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/js/activity_info.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-活动</title>
    <script type="text/javascript">
        var nav_focus = 2;
        var activity_nav_focus = -1;

        var id = {!! $detail->id !!};
    </script>
@endsection

@section('activity_content')
    <div class="col-xs-12 col-sm-8 content-right">
        <div class="content activity-info row">
            <div class="title">
                <h3 style="display: inline;">{{ $detail->title }}</h3>
                @if ($detail->ownerid==Auth::user()->id)
                    <button id="delete_activity" type="button"><i class="fa fa-close"></i>删除活动</button>
                @endif
            </div>
            <div class="form-horizontal">
                <div class="flex-column media col-xs-12 col-sm-6">
                    <span class="group-mark"><i class="fa fa-clock-o"></i> 时间</span>
                    <p class="form-control-static flex-column-item">{{ $detail->start }}</p>
                </div>
                <div class="flex-column media col-xs-12 col-sm-6">
                    <span class="group-mark"><i class="fa fa-users"></i> 人数</span>
                    <p class="form-control-static flex-column-item">
                        {{ $num->sum ? $num->sum:0 }}/{{ $detail->participant_num }}&nbsp;&nbsp;
                        @if ((!$isIn) && $num->sum < $detail->participant_num)
                            <button id="join_in_button" type="button">参加</button>
                        @endif
                        @if ($isIn && $detail->ownerid != Auth::user()->id)
                            <button id="exit_button" type="button">退出</button>
                        @endif
                    </p>
                </div>
                <div class="flex-column media col-xs-12 col-sm-12">
                    <span class="group-mark"><i class="fa fa-map-marker"></i> 地点</span>
                    <p class="form-control-static flex-column-item">{{ $detail->place }}</p>
                </div>
                <div class="media detail col-xs-12 col-sm-12">
                    <div class="media-left">
                        <span class="group-mark"><i class="fa fa-square"></i> 详情</span>
                    </div>
                    <div class="media-body">
                        <p>{{ $detail->detail }}</p>
                    </div>
                </div>
                <div class="media detail col-xs-12 col-sm-12">
                    <div class="media-left">
                        <span class="group-mark"><i class="fa fa-navicon"></i> 成员</span>
                    </div>
                    <div class="media-body">
                        @foreach($participants as $participant)
                            <div class="join-item">
                                <img class="user-portrait" src="{{ $participant->portrait }}"/>
                                <a>{{ $participant->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection