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
                <form id="register_option" class="option-body" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}
                    <div class="flex-column{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input id="name" type="text" name="name" class="flex-column-item" placeholder="Name..." value="{{ old('name') }}"
                               data-toggle="popover" data-content="{{ $errors->has('name') ? $errors->first('name') : '' }}"/>
                    </div>
                    @if ($errors->has('email'))
                        <script>
                            $(function() {
                                $("#name").popover({
                                    trigger: 'manual',
                                    placement: 'left'
                                });
                                $("#name").popover('show');
                                $("#name").on("focus", function() {
                                    $(this).popover('destroy');
                                });
                            });
                        </script>
                    @endif
                    <div class="flex-column{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="text" name="email" class="flex-column-item" placeholder="Email..." value="{{ old('email') }}"
                               data-toggle="popover" data-content="{{ $errors->has('email') ? $errors->first('email') : '' }}"/>
                    </div>
                    @if ($errors->has('email'))
                        <script>
                            $(function() {
                                $("#name").popover({
                                    trigger: 'manual',
                                    placement: 'left'
                                });
                                $("#name").popover('show');
                                $("#name").on("focus", function() {
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
                    <div class="flex-column{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input id="confirm_password" type="password" name="password_confirmation" class="flex-column-item" placeholder="Confirm Password..."
                               data-toggle="popover" data-content="{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}"/>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <script>
                            $(function() {
                                $("#confirm_password").popover({
                                    trigger: 'manual',
                                    placement: 'left'
                                });
                                $("#confirm_password").popover('show');
                                $("#confirm_password").on("focus", function() {
                                    $(this).popover('destroy');
                                });
                            });
                        </script>
                    @endif
                    <div class="flex-column">
                        <button type="submit" class="flex-column-item">注册</button>
                    </div>
                    <div>
                        Already have an account?
                        <a id="to_login" href="{{ url('/login') }}">Sign in</a> instead!
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>