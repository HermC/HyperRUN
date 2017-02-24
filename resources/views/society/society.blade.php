@extends('layouts.society_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/css/society.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/js/society.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-社区</title>
    <script type="text/javascript">
        var nav_focus = 3;
        var society_focus = 0;

        var thumbs = {!! json_encode($thumbs) !!};
        console.log(thumbs);
    </script>
@endsection

@section('society_content')
    <div class="col-sm-8 col-xs-12 container content-right">
        <div class="content">
            <div class="title">
                <h3>最新动态</h3>
            </div>
            <div id="society_list">
                <div class="society-list-wrapper">
                    @foreach($societys as $society)
                        <div class="media society-item">
                            <input class="id-input" name="dynamicid" type="hidden" value="{{ $society->dynamicid }}"/>
                            <div class="media-left">
                                <img class="user-portrait" src="{{ $society->portrait }}"/>
                                <span class="label label-info">等级{{ $society->level }}</span>
                            </div>
                            <div class="media-body">
                                <div class="media-heading">
                                    <a class="media-title" href="/society/info/{{ $society->dynamicid }}">{{ $society->title }}</a>
                                </div>
                                <div class="user-time">
                                    <a>{{ $society->name }}</a>, 发布于 <span>{{ $society->created_at }}</span>
                                </div>
                                <div class="user-content">
                                    {!! $society->content !!}
                                    <span>...</span>
                                </div>
                                <div class="media-bottom">
                                    <a class="society-comment"><i class="fa fa-comment-o"></i> 评论(<span>{{ $society->comment_num }}</span>)</a>&nbsp;&nbsp;
                                    <a class="society-like"><i class="fa fa-thumbs-o-up"></i> 点赞(<span>{{ $society->thumb_num }}</span>)</a>
                                    <a class="society-dislike"><i class="fa fa-thumbs-o-down"></i> 取消点赞(<span>{{ $society->thumb_num }}</span>)</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection