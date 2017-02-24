@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row main-content">
            <div class="col-sm-4 content-left">
                <div class="widget hidden-xs">
                    <div class="title">
                        <h4>用户</h4>
                    </div>
                    <img class="user-img img-thumbnail" src="{{ Auth::user()->portrait }}" alt="..."/>
                    <div class="user-wrapper">
                        <a href="/user" target="_self">{{ Auth::user()->name}}</a>
                    </div>
                </div>
                <div class="widget">
                    <div class="title">
                        <h4>动态</h4>
                    </div>
                    <ul class="nav-list">
                        <li><a href="/society">最新动态</a></li>
                        <li><a href="/society/new">发布动态</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <script type="text/javascript">
                if(society_focus!=undefined&&society_focus!=null&&society_focus!=-1){
                    var society_nav_list = document.querySelectorAll(".nav-list>li>a");

                    $(society_nav_list[society_focus]).addClass("active");
                }
            </script>
            @yield('society_content')
        </div>

    </div>
@endsection