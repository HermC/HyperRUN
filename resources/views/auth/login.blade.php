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
                <form id="login_option" class="option-body" role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <div class="flex-column{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="text" name="email" class="flex-column-item" placeholder="Username..." value="{{ old('email') }}"
                               data-toggle="popover" data-content="{{ $errors->has('email') ? $errors->first('email') : '' }}"/>
                    </div>

                    @if ($errors->has('email'))
                        <script>
                            $(function() {
                                $("#email").popover({
                                    trigger: 'manual',
                                    placement: 'left'
                                });
                                $("#email").popover('show');
                                $("#email").on("focus", function() {
                                    $(this).popover('destroy');
                                });
                            });
                        </script>
                    @endif

                    <div class="flex-column{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" name="password" class="flex-column-item" placeholder="Password..."
                               data-toggle="popover" data-content="{{ $errors->has('password') ? $errors->first('password') : '' }}"/>
                    </div>

                    @if ($errors->has('password'))
                        <script>
                            $(function() {
                                $("#password").popover({
                                    html: '{{ $errors->first('password') }}',
                                    trigger: 'manual',
                                    placement: 'left'
                                });
                                $("#password").popover('show');
                                $("#password").on("focus", function() {
                                    $(this).popover('destroy');
                                });
                            });
                        </script>
                    @endif

                    <div class="flex-column">
                        <div class="flex-column-item u1of4 flex-column">
                            <input type="checkbox" name="remember">&nbsp;记住我
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div class="flex-column-item flex-column">
                            <button type="submit" class="flex-column-item">登录</button>
                        </div>
                    </div>
                    <div>
                        Do not have an account? <a id="to_register" href="{{ url('/register') }}">Sign up</a> please!
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