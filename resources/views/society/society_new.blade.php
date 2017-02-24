@extends('layouts.society_nav')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/plugins/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ url('/css/society.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/plugins/Trumbowyg-master/dist/trumbowyg.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/plugins/Trumbowyg-master/dist/langs/zh_cn.min.js') }}"></script>
    <script type="text/javascript" rel="script" src="{{ url('/js/society_new.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-社区</title>
    <script type="text/javascript">
        var nav_focus = 3;
        var society_focus = 1;
    </script>
@endsection

@section('society_content')
    <div class="col-sm-8 col-xs-12 container content-right">
        <div class="content">
            <div class="title">
                <h3>发布动态</h3>
            </div>
            <div class="theme">
                <h4>主题</h4>&nbsp;&nbsp;&nbsp;
                <input id="title" name="title" type="text" class="flex-column-item"/>
            </div>
            <input id="file_channel" type="file" style="display: none"/>
            <div class="editor-wrapper">
                <textarea id="trumbowyg_editor" name="content"></textarea>
            </div>
            <div>
                <button id="upload" type="button" class="edit-button">发布</button>
            </div>
        </div>
    </div>
@endsection