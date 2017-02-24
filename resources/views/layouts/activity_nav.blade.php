@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row main-content">
            <div class="col-xs-12 col-sm-4 content-left">
                <div class="widget">
                    <div class="title">
                        <h4>用户</h4>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="/user" target="_blank">
                                <img class="user-img" src="{{ Auth::user()->portrait }}"/>
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading user-name"><a href="user" target="_blank">HermC</a></h3>
                            <p class="activity-level">活动经验</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ Auth::user()->exp }}" aria-valuemin="0" aria-valuemax="{{ Auth::user()->level * 100 }}"
                                        style="width: {!! intval((Auth::user()->exp/Auth::user()->level)) !!}%">
                                    <span class="ex" style="display: none;">{{ Auth::user()->exp }}／{{ Auth::user()->level * 100}}</span><span class="lev">等级{{Auth::user()->level}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="start_activity" type="button">发起活动</button>
                </div>
                <div class="widget">
                    <div class="title">
                        <h4>活动分类</h4>
                    </div>
                    <ul class="nav-list">
                        <li><a href="/activity">所有活动</a></li>
                        <li>
                            <a href="/activity/my">我的活动</a>
                            <ul id="activity_my_list" style="display: none;">
                                <li class=""><a href="#my_start">我发起的</a></li>
                                <li class=""><a href="#my_join">我参与的</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <script type="text/javascript">
                if(activity_nav_focus!=undefined&&activity_nav_focus!=null&&activity_nav_focus!=-1){
                    var activity_nav_list = document.querySelectorAll(".nav-list li a");
                    $(activity_nav_list).removeClass("active");
                    $(activity_nav_list[activity_nav_focus]).addClass("active");

                    if(activity_nav_focus==1) {
                        $("#activity_my_list").show();
                    }
                }

                var activity_my_list = document.querySelectorAll("#activity_my_list li a");

                $("#activity_my_list>li>a").on("click", function() {
                    var index = -1;
                    for(var i=0;i<activity_my_list.length;i++){
                        if(this==activity_my_list[i]){
                            index = i;
                            break;
                        }
                    }

                    $(activity_my_list).removeClass("active");
                    $(activity_my_list[index]).addClass("active");
                });
                $("#start_activity").on("click", function() {
                    window.location.href = "/activity/new";
                });
                $(".progress").on("mouseover", function() {
                    $(".lev").hide();
                    $(".ex").show();
                });
                $(".progress").on("mouseout", function() {
                    $(".lev").show();
                    $(".ex").hide();
                });
            </script>
            @yield('activity_content')
        </div>
    </div>
@endsection
