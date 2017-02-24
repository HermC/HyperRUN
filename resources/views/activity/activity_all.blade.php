@extends('layouts.activity_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/css/activity.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/js/activity_all.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-活动</title>
    <script type="text/javascript">
        var nav_focus = 2;
        var activity_nav_focus = 0;

        {{--console.log({!! $activitys !!});--}}
    </script>
@endsection

@section('activity_content')
    <div id="activity_all" class="col-xs-12 col-sm-8 content-right">
        <div class="content">
            <div class="title">
                <h3>活动列表</h3>
            </div>
            <div class="row table-title">
                <div class="qa-rank">
                    <div class="type">
                        类型
                    </div>
                    <div class="time">
                        日期
                    </div>
                </div>
                <div class="summary">

                </div>
            </div>
            <div id="activity_all_list" class="activity-list-wrapper">
                <div class="activity-list">
                    @foreach($activitys as $activity)
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
                        {!! $activitys->render() !!}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection