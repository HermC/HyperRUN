@extends('layouts.activity_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/css/activity.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/js/activity_my.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-活动</title>
    <script type="text/javascript">
        var nav_focus = 2;
        var activity_nav_focus = 1;
    </script>
@endsection

@section('activity_content')
    <div id="activity_my" class="col-xs-12 col-sm-8 content-right">
        <div class="content">
            <a name="my_start"></a>
            <div class="title">
                <h3>我发起的</h3>
            </div>
            <div id="activity_my_list" class="activity-list-wrapper">
                <div class="activity-list">
                    @foreach($my_activitys as $activity)
                        <a class="row activity" href="/activity/info/{{ $activity->id }}">
                            <div class="qa-rank">
                                <div class="type">
                                    {{ $activity->type }}
                                </div>
                                <div class="time">
                                    {{ substr($activity->start, 0, 10) }}
                                </div>
                            </div>
                            <div class="summary">
                                <ul class="author list-inline">
                                    <li>
                                        发起者: <span>{{ $activity->name }}</span>
                                    </li>
                                </ul>
                                <h4 class="activity-title"><span>{{ $activity->title }}</span></h4>
                            </div>
                        </a>
                    @endforeach
                    <br>
                    <nav class="pagination-wrapper">
                        {!! $my_activitys->render() !!}
                    </nav>
                </div>
            </div>
        </div>
        <div class="content">
            <a name="my_join"></a>
            <div class="title">
                <h3>我参与的</h3>
            </div>
            <div id="activity_join_list" class="activity-list-wrapper">
                <div class="activity-list">
                    @foreach($in_activitys as $activity)
                        <a class="row activity" href="/activity/info/{{ $activity->id }}">
                            <div class="qa-rank">
                                <div class="type">
                                    {{ $activity->type }}
                                </div>
                                <div class="time">
                                    {{ substr($activity->start, 0, 10) }}
                                </div>
                            </div>
                            <div class="summary">
                                <ul class="author list-inline">
                                    <li>
                                        发起者: <span>{{ $activity->name }}</span>
                                    </li>
                                </ul>
                                <h4 class="activity-title"><span>{{ $activity->title }}</span></h4>
                            </div>
                        </a>
                    @endforeach
                    <br>
                    <nav class="pagination-wrapper">
                        {!! $in_activitys->render() !!}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection