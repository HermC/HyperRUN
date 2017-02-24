@extends('layouts.app')

@section('extra_css')
    <link type="text/css" rel="stylesheet" href="{{ url('/css/user_info.css') }}"/>
@endsection

@section('extra_js')
    <script type="text/javascript" rel="script" src="{{ url('/js/user_info.js') }}"></script>
@endsection

@section('title')
    <title>HyperRUN-{{ $user->name }}</title>
    <script type="text/javascript">
        var nav_focus = -1;
    </script>
@endsection

@section('content')
    <div class="container">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row main-content">
            <div class="col-sm-4 content-left">
                <div class="widget hidden-xs">
                    <div class="title">
                        <h4>用户</h4>
                    </div>
                    <img class="user-img img-thumbnail" src="{{ url($user->portrait) }}" alt="..."/>
                    <div class="user-wrapper">
                        <span>HermC</span>
                    </div>
                    <div class="level-wrapper flex-column">
                        <span class="flex-column-item">等级</span>
                        <span class="flex-column-item">1</span>
                    </div>
                    <div class="level-wrapper flex-column">
                        <span class="flex-column-item">经验</span>
                        <span class="flex-column-item">1/100</span>
                    </div>
                </div>
                <div class="widget">
                    <div class="title">
                        <h4>用户信息</h4>
                    </div>
                    <ul class="nav-list">
                        <li>
                            <a class="active">个人信息</a>
                        </li>
                        <li>
                            <a>个人动态</a>
                        </li>
                        <li>
                            <a>参加活动</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">

            </div>
            <div class="col-sm-8 col-xs-12 container content-right">
                <div class="content">
                    <div class="title">
                        <h3>个人信息</h3>
                    </div>
                    <div class="form-horizontal form-user-info">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">用户名</label>
                            <div class="col-sm-7">
                                <div class="form-control-static">HermC</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal form-user-info">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">性别</label>
                            <div class="col-sm-7">
                                <div class="form-control-static">男 <i class="fa fa-mars"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal form-user-info">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">出生日期</label>
                            <div class="col-sm-7">
                                <div class="form-control-static">2016-10-20</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal form-user-info">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">个人简介</label>
                            <div class="col-sm-7">
                                <div class="form-control-static">
                                    现代三角琴上的中间踏板是保持音踏板（某百科给说成重音踏板是什么鬼），先弹一个或几个音，再踩下这个踏板，这一个/几个音的止音器会额外抬起，这几个音也会一直保持。在这期间手离开琴键弹其他的音，用另外两个踏板，包括换右踏板都不会影响，这几个音的止音器会一直保持抬起，这几个音也会保持到消失为止。当然，在此期间也可以再弹一下这几个音，或者其中某几个音。
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content" style="display: none">
                    <div class="title">
                        <h3>个人动态</h3>
                    </div>
                    <div id="society_list">
                        <div class="society-list-wrapper">
                            <div class="media society-item">
                                <div class="media-left">
                                    <img class="user-portrait" src="/img/default.jpg"/>
                                    <span class="label label-info">等级4</span>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a class="media-title">今天去仙林跑步了</a>
                                    </div>
                                    <div class="user-time">
                                        <a>HermC</a>, 发布于 <span>2016-06-12 12:23:02</span>
                                    </div>
                                    <div class="user-content">
                                        <p>假如我们通过某种方式了解到，<img src="/img/default.jpg"/>某种金融产品有60%的概率赚钱，40%的概率亏钱，但是我们不知道实际上结果是赚是亏，我的收益有波动，这种波动就是风险！
                                            通常我们用方差（或者标准差）来衡量风险（就是收益的波动）的大小，那么怎么降低风险呢？那就是“把鸡蛋放在多个篮子里”，通过不同的金融产品进行风险的对冲！
                                            这里所说的不同的篮子不是随便 选的，也不是选的越多越好。这些篮子应当相互之间尽量相互独立甚至有反向关系（一个涨的时候另一个跌），这样风险就减小了。
                                            著作权归作者所有，转载请联系作者获得授权。
                                        </p>
                                        <span>...</span>
                                    </div>
                                    <div class="media-bottom">
                                        <a class="society-comment"><i class="fa fa-comment-o"></i> 评论(<span>100</span>)</a>&nbsp;&nbsp;
                                        <a class="society-like"><i class="fa fa-thumbs-o-up"></i> 点赞(<span>100</span>)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content" style="display: none">
                    <div class="title">
                        <h3>参加活动</h3>
                    </div>
                    <div id="activity_list" class="activity-list-wrapper">
                        <div class="activity-list">
                            <div class="row table-title">
                                <div class="qa-rank">
                                    <div class="type">
                                        类型
                                    </div>
                                    <div class="time">
                                        日期
                                    </div>
                                </div>
                                <div class="summary">

                                </div>
                            </div>
                            <a class="row activity" href="activity_info.php">
                                <div class="qa-rank">
                                    <div class="type">
                                        跑步
                                    </div>
                                    <div class="time">
                                        2016-12-23
                                    </div>
                                </div>
                                <div class="summary">
                                    <ul class="author list-inline">
                                        <li>
                                            发起者: <span>iamnothalsey</span>
                                        </li>
                                    </ul>
                                    <h4 class="activity-title"><span>南大约跑，体育场</span></h4>
                                </div>
                            </a>
                            <a class="row activity">
                                <div class="qa-rank">
                                    <div class="type">
                                        跑步
                                    </div>
                                    <div class="time">
                                        2016-12-23
                                    </div>
                                </div>
                                <div class="summary">
                                    <ul class="author list-inline">
                                        <li>
                                            发起者: <span>iamnothalsey</span>
                                        </li>
                                    </ul>
                                    <h4 class="activity-title"><span style="overflow: hidden">南大约跑，体育场fsdafasfasdfdsafasdfasfsdafdsf</span></h4>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection