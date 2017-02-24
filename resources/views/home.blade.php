@extends('layouts.app')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/css/index.css') }}"/>
@endsection

@section('extra_js')
    {{--<script type="text/javascript" rel="script" src="{{ url('') }}"></script>--}}
@endsection

@section('title')
    <title>HyperRUN-主页</title>
    <script type="text/javascript">
        var nav_focus = 0;
    </script>
@endsection

@section('content')
    <div class="container">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row main-content">
            <div class="col-sm-4 hidden-xs content-left">
                <div class="widget">
                    <div class="title">
                        <h4>用户</h4>
                    </div>
                    <img class="user-img img-thumbnail" src="{{ Auth::user()->portrait }}" alt="..."/>
                    <div class="user-wrapper">
                        <a href="{{ url('/user') }}" target="_self">{{ Auth::user()->name }}</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <div class="col-sm-8 col-xs-12 container content-right">
                <div class="content">
                    <div class="title">
                        <h3>总体运动情况</h3>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-4 info-wrapper">
                            <div class="info">
                                <h2>已走过</h2>
                                @if ($sum != null)
                                    <h1>{!! $sum->steps_sum < 10000 ? $sum->steps_sum:(intval($sum->steps_sum/10000).' 万') !!}</h1>
                                @endif
                                <p>步</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 info-wrapper">
                            <div class="info">
                                <h2>共燃烧</h2>
                                @if ($sum != null)
                                    <h1>{!! $sum->calorie_sum < 1000 ? $sum->calorie_sum:(intval($sum->calorie_sum/1000).' 千') !!}</h1>
                                @endif
                                <p>卡</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 info-wrapper">
                            <div class="info">
                                <h2>累计里程</h2>
                                @if ($sum != null)
                                    <h1>{!! $sum->distance_sum < 1000 ? $sum->distance_sum:(intval($sum->distance_sum/1000).' 千') !!}</h1>
                                @endif
                                <p>公里</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection