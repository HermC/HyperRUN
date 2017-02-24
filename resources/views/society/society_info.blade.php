@extends('layouts.society_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/society.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/js/society_info.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-社区</title>
    <script type="text/javascript">
        var nav_focus = 3;
        var society_focus = -1;

        var dynamicid = {!! $society->dynamicid !!};
        var authorid = {!! $society->userid !!};
        var userid = {!! Auth::user()->id !!};
    </script>
@endsection

@section('society_content')
    <div class="col-sm-8 col-xs-12 container content-right">
        <div class="content">
            <div class="title">
                <h3>{{ $society->title }}</h3>
            </div>
            <div class="user-time">
                作者: <span>{{ $society->name }}</span> • <span>{{ $society->created_at }}</span>
            </div>
            <br>
            <div class="detail-content">
                {!! $society->content !!}
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="operation-wrapper">
                        <span id="comment"><i class="fa fa-comment-o"></i> 评论(<span>{{ $society->comment_num }}</span>)</span>
                        &nbsp;&nbsp;&nbsp;
                        <span id="thumbs"><i class="fa fa-thumbs-o-up"></i> 点赞(<span>{{ $society->thumb_num }}</span>)</span>
                        <span id="thumbs_down"><i class="fa fa-thumbs-o-down"></i> 取消点赞(<span>{{ $society->thumb_num }}</span>)</span>
                    </div>
                    <div class="flex-column comment-input-wrapper" style="display: none">
                        <input id="comment_input" name="content_input" type="text" class="flex-column-item"/>
                        <button id="comment_submit" type="button" class="edit-button" disabled>发送</button>
                    </div>
                    <br>
                    <div class="comment-wrapper">
                        @foreach($comments as $comment)
                            <div class="comment-item media">
                                <div class="media-left">
                                    <input class="replier-input" type="hidden" value="{{ $comment->replier_id }}"/>
                                    <span class="subject">{{ $comment->replier }}</span>
                                    <strong>回复</strong>
                                    <input class="asker-input" type="hidden" value="{{ $comment->asker_id }}"/>
                                    <span class="object">{{ $comment->asker }}</span>
                                    <strong>:</strong>
                                </div>
                                <div class="media-body">
                                    <p>{!! $comment->content !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection