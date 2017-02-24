@extends('layouts.app')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/Jcrop-0.9.12/css/jquery.Jcrop.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/user.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/account.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/plugins/Jcrop-0.9.12/js/jquery.Jcrop.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/jquery.form.min.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-{{ Auth::user()->name }}</title>
    <script type="text/javascript">
        var nav_focus = -2;

        console.log({!! $a !!});
    </script>
@endsection

@section(('content'))
    <div class="container">
        <div class="row main-content">
            <div class="col-xs-12 col-sm-4 content-left">
                <div class="widget">
                    <div class="title">
                        <h3>操作</h3>
                    </div>
                    <ul class="nav-list">
                        <li>
                            <a class="active">用户账户信息</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <div class="col-xs-12 col-sm-8 content-right">
                <div class="content">
                    @foreach($users as $user)
                        @if($user->id != Auth::user()->id)
                            <div class="account-list">
                                <input class="user-hidden-id" type="hidden" value="{{ $user->id }}"/>
                                <div class="media friend-item">
                                    <a class="media-left">
                                        <img class="user-img img-circle" src="{{ $user->portrait }}"/>
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a>{{ $user->name }}</a> <span class="label label-info hidden-xs"></span></h4>
                                        <p class="user-content">{{ $user->synopsis }}</p>
                                    </div>
                                    <div class="media-right">
                                        <button type="button" class="edit-button delete-button">删除</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <script>
                    var input_list = document.querySelectorAll(".user-hidden-id");
                    var delete_button_list = document.querySelectorAll(".delete-button");

                    $(".delete-button").on("click", function() {
                        var index = -1;
                        for(var i=0;i<delete_button_list.length;i++){
                            if(this==delete_button_list[i]){
                                index = i;
                                break;
                            }
                        }

                        var userid = $(input_list[index]).val();

                        $.ajax({
                            type: 'delete',
                            url: '/admin/user/' + userid,
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                            },
                            error: function() {

                            }
                        });
                    })
                </script>
            </div>
        </div>
    </div>
@endsection