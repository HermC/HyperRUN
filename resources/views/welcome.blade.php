<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/bootstrap-3.3.5/dist/css/bootstrap.min.css') }}"/>
    <!--<link type="text/css" rel="stylesheet" href="../css/common.css"/>-->
    <link type="text/css" rel="stylesheet" href="{{ url('/css/login.css') }}"/>

    <script type="text/javascript" rel="script" src="{{ url('/js/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/plugins/bootstrap-3.3.5/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/login.js') }}"></script>

    <title>HyperRUN</title>
</head>
<body>
<img class="background-img" src="{{ url('/img/background/background.png') }}"/>
<header class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><span>Hyper</span><span class="run">RUN</span></a>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-xs-12 hidden-xs col-md-8 jumbotron-wrapper">
            <div class="jumbotron">
                <h1><span>HyperRUN</span></h1>
                <p>&nbsp;&nbsp;<span style="font-size: 65px">人</span>生的本质就在于运动，安谧宁静就是死亡 ——帕斯卡</p>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="option-wrapper">
                <div class="option-heading">
                    <h3>Let's start exercising</h3>
                </div>
                <form id="login_option" class="option-body">
                    <div class="flex-column has-error">
                        <input type="text" class="flex-column-item" placeholder="Username..."/>
                    </div>
                    <div class="flex-column has-error">
                        <span></span>
                    </div>
                    <div class="flex-column">
                        <input type="password" class="flex-column-item" placeholder="Password..."/>
                    </div>
                    <div class="flex-column has-error">
                        <span></span>
                    </div>
                    <div class="flex-column">
                        <button type="button" class="flex-column-item">登录</button>
                    </div>
                    <div>
                        Do not have an account? <span id="to_register">Sign up</span> please!
                    </div>
                </form>
                {{--<div id="register_option" class="option-body" style="display: none">--}}
                    {{--<div class="flex-column">--}}
                        {{--<input type="text" class="flex-column-item" placeholder="Email..."/>--}}
                    {{--</div>--}}
                    {{--<div class="flex-column">--}}
                        {{--<input type="password" class="flex-column-item" placeholder="Password..."/>--}}
                    {{--</div>--}}
                    {{--<div class="flex-column">--}}
                        {{--<button type="button" class="flex-column-item">注册</button>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--Already have an account?--}}
                        {{--<span id="to_login">Sign in</span> instead!--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
</body>
</html>