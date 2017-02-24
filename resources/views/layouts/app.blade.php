<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="sports 运动 健康 社交">
    <meta name="description" content="HyperRUN运动社交平台"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/bootstrap-3.3.5/dist/css/bootstrap.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/common.css') }}"/>
    @yield('extra_css')

    <script type="text/javascript" rel="script" src="{{ url('/js/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript" rel="script" src="{{ url('/plugins/bootstrap-3.3.5/dist/js/bootstrap.min.js') }}"></script>
    @yield('extra_js')

    @yield('title')

</head>
<body>
<header class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">HyperRUN</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav need-hide">
                <li><a href="{{ url('/home') }}">首页</a></li>
                <li><a href="{{ url('/sports') }}">健康</a></li>
                <li><a href="{{ url('/activity') }}">活动</a></li>
                <li><a href="{{ url('/society') }}">社区</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> 用户({{ Auth::user()->name }}) <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="need-hide"><a href="{{ url('/user') }}"><i class="fa fa-pencil"></i> &nbsp;个人设置</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-power-off"></i> &nbsp;退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        if(nav_focus!=undefined&&nav_focus!=null&&nav_focus!=-1){
            var navbar_nav_list = $(".navbar-nav").find("li");
            $(navbar_nav_list[nav_focus]).addClass("active");
        }
        if(nav_focus==-2){
            var navbar_nav_list = $(".need-hide");
            $(navbar_nav_list).hide();
        }
    </script>
</header>

@yield('content')

<footer>
    <div class="container">
        <p class="text-muted">Designed By HermC, Copyright &copy; HermC</p>
    </div>
</footer>
</body>
</html>
