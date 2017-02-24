/**
 * Created by Hermit on 2016/10/17.
 */
var sports_nav_list;
var content_list;
var target_list;
var change_chart_list;

var target_type = ['steps', 'distance', 'calorie'];

window.onload = function() {
    sports_nav_list = document.querySelectorAll(".nav-list>li>a");
    content_list = document.querySelectorAll(".content-right");
    target_list = document.querySelectorAll(".user-target input");
    change_chart_list = document.querySelectorAll(".change-chart input");

    initListener();
    initDateTools();
    initSportsChartsData();
    initSleepData();
    initCharts();

    $(content_list).hide();
    $(content_list[0]).show();

    if(sports_target != null){
        var type = sports_target['type'];

        var target_input_list = $(".target-input");
        var user_target_list = $(".user-target input");

        var index = 0;

        for(var i=0;i<target_type.length;i++){
            if(target_type[i]==type){
                index = i;
                break;
            }
        }

        $(target_input_list[index]).find(".target-input-value").val(sports_target['target']);
        // $(target_input_list).hide();
        // $(target_input_list[index]).show();
        $(user_target_list[index]).click();
    }
};

var sports_chart_index = 0;
function initListener() {
    $(".nav-list>li>a").on("click", function() {
        var index = -1;
        for(var i=0;i<sports_nav_list.length;i++){
            if(this==sports_nav_list[i]){
                index = i;
                break;
            }
        }

        if(index==0){
            $("#body_list").show();
        }else{
            $("#body_list").hide();
        }

        $(sports_nav_list).removeClass("active");
        $(sports_nav_list[index]).addClass("active");
        $(content_list).hide();
        $(content_list[index]).show();
    });
    $("#body_list>li>a").on("click", function() {
        $("#body_list>li>a").removeClass("active");
        $(this).addClass("active");
    });
    $(".user-target input").on("change", function() {
        var index = -1;
        for(var i=0;i<target_list.length;i++){
            if(this==target_list[i]){
                index = i;
                break;
            }
        }

        var target_input = $(".target-input");
        $(target_input).hide();
        $(target_input[index]).show();
    });
    $(".change-chart input").on("change", function() {
        if(this==document.getElementById("to_step_chart")){
            sports_chart_index = 0;
            changeChartType("步数(步)", steps_yAxis, steps_histroy_yAxis, "步");
        }else if(this==document.getElementById("to_distance_chart")){
            sports_chart_index = 1;
            changeChartType("距离(km)", distance_yAxis, distance_history_yAxis, "km");
        }else if(this==document.getElementById("to_calorie_chart")){
            sports_chart_index = 2;
            changeChartType("卡路里(大卡)", calorie_yAxis, calorie_history_yAxis, "大卡");
        }
    });
    $("#user_height").on("blur", function() {
        updateBodyInfo();
    });
    $("#user_weight").on("blur", function() {
        updateBodyInfo();
    });
    $("#user_walk").on("blur", function() {
        updateBodyInfo();
    });
    $("#user_run").on("blur", function() {
        updateBodyInfo();
    });
    $("#steps_target_button").on("click", function() {
        $("#steps_target_alert").hide();

        var value = $("#foot_step").val();

        if(value==undefined||value==null||value==""){
            $("#steps_target_alert").show();
            return;
        }

        $.ajax({
            type: 'post',
            url: '/sports/target',
            data: $("#steps_target_form").serialize(),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.success==true){
                    // console.log("保存成功");
                    window.location.reload();
                }else{
                    alert("保存失败！");
                }
            },
            error: function() {
                alert("保存失败！");
            }
        });
    });
    $("#distance_target_button").on("click", function() {
        $("#distance_target_alert").hide();

        var value = $("#distance").val();

        if(value==undefined||value==null||value==""){
            $("#distance_target_alert").show();
            return;
        }

        console.log($("#distance_target_form").serialize());

        $.ajax({
            type: 'post',
            url: '/sports/target',
            data: $("#distance_target_form").serialize(),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.success==true){
                    // console.log("保存成功");
                    window.location.reload();
                }else{
                    alert("保存失败！");
                }
            },
            error: function() {
                alert("保存失败！");
            }
        });
    });
    $("#calorie_target_button").on("click", function() {
        $("#calorie_target_alert").hide();

        var value = $("#calorie").val();

        if(value==undefined||value==null||value==""){
            $("#calorie_target_alert").show();
            return;
        }

        $.ajax({
            type: 'post',
            url: '/sports/target',
            data: $("#calorie_target_form").serialize(),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.success==true){
                    // console.log("保存成功");
                    window.location.reload();
                }else{
                    alert("保存失败！");
                }
            },
            error: function() {
                alert("保存失败！");
            }
        });
    });
}

function initDateTools() {
    var today = getNowFormatDate();

    $(".sport-datepicker").datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: "month",
        todayBtn: true
    });

    $(".sport-datepicker").datetimepicker("update", today);
    $(".sport-datepicker").datetimepicker("setEndDate", today);

    $("#target_datepicker").datetimepicker().on("changeDate", function(ev) {
        var date = getDate(ev.date.valueOf());
        $.ajax({
            type: 'get',
            url: '/api/sports/' + userid + '/date/' + date,
            dataType: 'json',
            success: function(data) {
                changeSportsDate(data.result);
            },
            error: function() {

            }
        });

        $.ajax({
            type: 'post',
            url: '/sports/sportsdate',
            data: 'date=' + date,
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                if(data.success==true){
                    changeTargetDate(data.result);
                }
            },
            error: function() {

            }
        });
    });

    $("#sleep_datepicker").datetimepicker().on("changeDate", function(ev) {
        var date = getDate(ev.date.valueOf());
        $.ajax({
            type: 'get',
            url: '/api/sleep/' + userid + '/date/' + date,
            dateType: 'json',
            success: function(data) {
                changeSleepDate(data.result);
            },
            error: function() {

            }
        });
    });

    // console.log($("#sleep_datepicker").val());
    var today = $("#sleep_datepicker").val();
    $.ajax({
        type: 'get',
        url: '/api/sports/' + userid + '/date/' + today,
        dataType: 'json',
        success: function(data) {
            changeSportsDate(data.result);
        },
        error: function() {

        }
    });
    $.ajax({
        type: 'post',
        url: '/sports/sportsdate',
        data: 'date=' + today,
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            if(data.success==true){
                changeTargetDate(data.result);
            }
        },
        error: function() {

        }
    });
    $.ajax({
        type: 'get',
        url: '/api/sleep/' + userid + '/date/' + today,
        dateType: 'json',
        success: function(data) {
            changeSleepDate(data.result);
        },
        error: function() {

        }
    });
}

function updateBodyInfo() {
    $("#body_form_error").hide();
    var data = $("#body_form").serialize();
    $.ajax({
        type: 'post',
        url: 'sports/bodyinfo',
        data: data,
        dataType: 'json',
        success: function(data) {
            if(data.success!=true){
                $("#body_form_error_message").html(data.message);
                $("#body_form_error").slideDown();
            }
        },
        error: function() {
            $("#body_form_error_message").html("网络错误，请重新尝试");
            $("#body_form_error").slideDown();
        }
    });
}

function initCharts() {
    initWeightChart();
    initTargetCompleteChart();
    initDailySportChart();
    initHistorySportChart();
    // initSleepCompleteChart();
    initDailySleepChart();
    initHistorySleepChart();
}

var weight_chart;
function initWeightChart() {
    var weight_xAxis = ['无'];
    var weight_yAxis = [];

    if(weight_list != null){
        weight_xAxis = [];
        weight_yAxis = [];

        var i;
        for(i=0;i<weight_list.length;i++){
            var item = weight_list[i];
            weight_xAxis.push(item['time'].substring(0, 10));
            weight_yAxis.push(item['actual']);
        }
    }

    weight_chart = echarts.init(document.getElementById("weight_chart"));
    var option = {
        title: {
            text: '体重变化'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['实际体重','预期体重']
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: weight_xAxis
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} kg'
            },
            min: 'dataMin'
        },
        dataZoom: [
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 50,      // 左边在 50% 的位置。
                end: 100         // 右边在 100% 的位置。
            }
        ],
        series: [
            {
                name:'实际体重',
                type:'line',
                data: weight_yAxis,
                markLine: {
                    label: {
                        normal: {
                            formatter: '{c}'
                        }
                    },
                    data: [
                        {name: '目标体重', yAxis: target_weight}
                    ]
                }
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    weight_chart.setOption(option);
}

var target_complete_chart;
function initTargetCompleteChart() {
    target_complete_chart = echarts.init(document.getElementById("target_complete_chart"));

    var option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        series: [
            {
                name:'运动目标',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                hoverAnimation: false,
                // silent: true,
                label: {
                    normal: {
                        show: true,
                        position: 'outside',
                        formatter: '{b}: {d}'
                    },
                    emphasis: {
                        show: false,
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: true
                    }
                },
                data:[
                    {value: actual, name:'已完成'},
                    {value: surplus, name:'未完成'}
                ]
            }
        ]
    };

    target_complete_chart.setOption(option);
}

function changeTargetDate(data) {
    var act = data.actual;
    var sur = data.surplus;

    if((act + sur) != 0){
        var per = (act / (act + sur)) * 100;
        $("#target_h1").html(per.toFixed(0) + "%");
    }

    target_complete_chart.setOption({
        series: [
            {
                name:'运动目标',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                hoverAnimation: false,
                // silent: true,
                label: {
                    normal: {
                        show: true,
                        position: 'outside',
                        formatter: '{b}: {d}'
                    },
                    emphasis: {
                        show: false,
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: true
                    }
                },
                data:[
                    {value: data.actual, name:'已完成'},
                    {value: data.surplus, name:'未完成'}
                ]
            }
        ]
    });
}

var daily_sports_chart;
function initDailySportChart() {
    daily_sports_chart = echarts.init(document.getElementById("daily_sports_chart"));

    var option = {
        title: {
            text: '步数'
        },
        tooltip: {
            trigger: 'axis',
            formatter: '时间: {b}<br>步数: {c}'
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: sports_xAxis,
            axisLabel: {
                formatter: '{value}'
            }
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} 步'
            },
            min: 'dataMin'
        },
        series: [
            {
                name: '步数',
                type: 'bar',
                data: steps_yAxis
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    daily_sports_chart.setOption(option);
}

var history_sports_chart;
function initHistorySportChart() {
    history_sports_chart = echarts.init(document.getElementById("history_sports_chart"));

    var option = {
        title: {
            text: '步数'
        },
        tooltip: {
            trigger: 'axis',
            formatter: '时间: {b}<br>步数: {c}'
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: sports_history_xAxis,
            axisLabel: {
                formatter: '{value}'
            }
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} 步'
            },
            min: 'dataMin'
        },
        dataZoom: [
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 50,      // 左边在 50% 的位置。
                end: 100         // 右边在 100% 的位置。
            }
        ],
        series: [
            {
                name: '步数',
                type: 'line',
                data: steps_histroy_yAxis
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    history_sports_chart.setOption(option);
}

var sleep_complete_chart;
function initSleepCompleteChart() {
    sleep_complete_chart = echarts.init(document.getElementById("sleep_complete_chart"));

    var option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        series: [
            {
                name:'运动目标',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                hoverAnimation: false,
                // silent: true,
                label: {
                    normal: {
                        show: true,
                        position: 'outside',
                        formatter: '{b}: {d}'
                    },
                    emphasis: {
                        show: false,
                        textStyle: {
                            fontSize: '30',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: true
                    }
                },
                data:[
                    {value: 75, name:'有效'},
                    {value: 25, name:'无效'}
                ]
            }
        ]
    };

    sleep_complete_chart.setOption(option);
}

var sleep_xAxis = ['无'];
var sleep_yAxis = [];
var sleep_history_xAxis = ['无'];
var sleep_history_yAxis = [];
function initSleepData() {
    var i;
    if(sleep_list != null){
        sleep_xAxis = [];
        for(i=0;i<sleep_list.length;i++){
            var item = sleep_list[i];

            sleep_xAxis.push(item['time']);
            sleep_yAxis.push(item['value']);
        }
    }

    if(sleep_history_list != null){
        sleep_history_xAxis = [];
        for(i=0;i<sleep_history_list.length;i++){
            var item = sleep_history_list[i];

            sleep_history_xAxis.push(item['date']);
            sleep_history_yAxis.push(parseFloat(item['value_min']));
        }
    }
}

function changeSleepDate(data_list) {
    var i;
    if(data_list != null && data_list.length != 0){
        sleep_xAxis = [];
        sleep_yAxis = [];
        for(i=0;i<data_list.length;i++){
            var item = data_list[i];

            sleep_xAxis.push(item['time']);
            sleep_yAxis.push(item['value']);
        }
    }else{
        sleep_xAxis = ['无'];
        sleep_yAxis = [];
    }

    daily_sleep_chart.setOption({
        xAxis: {
            data: sleep_xAxis
        },
        series: [{
            data: sleep_yAxis
        }]
    });
}

var daily_sleep_chart;
function initDailySleepChart() {
    daily_sleep_chart = echarts.init(document.getElementById("daily_sleep_chart"));

    var option = {
        title: {
            text: '睡眠质量'
        },
        tooltip: {
            trigger: 'axis'
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: sleep_xAxis,
            axisLabel: {
                formatter: '{value}'
            }
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value}'
            },
            min: 'dataMin'
        },
        series: [
            {
                name: '睡眠状况',
                type: 'line',
                data: sleep_yAxis,
                markPoint: {
                    data: [
                        {type: 'max', name: '最不佳'},
                        {type: 'min', name: '最佳'}
                    ]
                },
                markLine: {
                    label: {
                        normal: {
                            formatter: '{b}: {c}'
                        }
                    },
                    data: [
                        {name: '深睡', yAxis: 3.3},
                        {name: '浅睡', yAxis: 16.6}
                    ]
                }
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    daily_sleep_chart.setOption(option);
}

var history_sleep_chart;
function initHistorySleepChart() {
    history_sleep_chart = echarts.init(document.getElementById("history_sleep_chart"));

    var option = {
        title: {
            text: '质量'
        },
        tooltip: {
            trigger: 'axis'
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: sleep_history_xAxis,
            axisLabel: {
                formatter: '{value}'
            }
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value}'
            },
            min: 'dataMin'
        },
        dataZoom: [
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 50,      // 左边在 50% 的位置。
                end: 100         // 右边在 100% 的位置。
            }
        ],
        series: [
            {
                name: '质量',
                type: 'line',
                data: sleep_history_yAxis,
                markLine: {
                    label: {
                        normal: {
                            formatter: '{b}: {c}'
                        }
                    },
                    data: [
                        {name: '深睡', yAxis: 3.3},
                        {name: '浅睡', yAxis: 16.6}
                    ]
                }
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    history_sleep_chart.setOption(option);
}

var sports_xAxis = ['无'];
var sports_history_xAxis = ['无'];
var steps_yAxis = [];
var steps_histroy_yAxis = [];
var distance_yAxis = [];
var distance_history_yAxis = [];
var calorie_yAxis = [];
var calorie_history_yAxis = [];
function initSportsChartsData() {
    var i;
    if(sports_history_list != null && sports_history_list.length != 0){
        sports_history_xAxis = [];
        for(i=0;i<sports_history_list.length;i++){
            var item = sports_history_list[i];

            sports_history_xAxis.push(item['date']);
            steps_histroy_yAxis.push(parseInt(item['steps_sum']));
            distance_history_yAxis.push(parseFloat(item['distance_sum']));
            calorie_history_yAxis.push(parseFloat(item['calorie_sum']));
        }
    }

    if(sports_list != null && sports_list.length != 0){
        sports_xAxis = [];
        for(i=0;i<sports_list.length;i++){
            var item = sports_list[i];

            sports_xAxis.push(item['time']);
            steps_yAxis.push(item['steps']);
            distance_yAxis.push(item['distance']);
            calorie_yAxis.push(item['calorie']);
        }
    }
}

function changeChartType(title, data, history_data, dimension) {
    var option = {
        title: {
            text: title
        },
        tooltip: {
            trigger: 'axis',
            formatter: '时间: {b}<br>' + title + ': {c}'
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: sports_xAxis
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} ' + dimension
            },
            min: 'dataMin'
        },
        series: [
            {
                name: title,
                type: 'bar',
                data: data
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    var history_option = {
        title: {
            text: title
        },
        tooltip: {
            trigger: 'axis',
            formatter: '时间: {b}<br>' + title + ': {c}'
        },
        toolbox: {
            show: false,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: sports_history_xAxis
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} ' + dimension
            },
            min: 'dataMin'
        },
        dataZoom: [
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 50,      // 左边在 50% 的位置。
                end: 100         // 右边在 100% 的位置。
            }
        ],
        series: [
            {
                name: title,
                type: 'line',
                data: history_data
            }
        ],
        textStyle: {
            fontWeight: 'lighter'
        }
    };

    daily_sports_chart.setOption(option);
    history_sports_chart.setOption(history_option);
}

function changeSportsDate(data_list) {
    var i;

    if(data_list != null && data_list.length != 0){
        sports_xAxis = [];
        steps_yAxis = [];
        distance_yAxis = [];
        calorie_yAxis = [];
        for(i=0;i<data_list.length;i++){
            var item = data_list[i];

            sports_xAxis.push(item['time']);
            steps_yAxis.push(item['steps']);
            distance_yAxis.push(item['distance']);
            calorie_yAxis.push(item['calorie']);
        }
    }else{
        sports_xAxis = ['无'];
        steps_yAxis = [];
        distance_yAxis = [];
        calorie_yAxis = [];
    }

    var yAxis = null;
    switch (sports_chart_index) {
        case 0: yAxis = steps_yAxis;break;
        case 1: yAxis = distance_yAxis;break;
        case 2: yAxis = calorie_yAxis;break;
        default: yAxis = steps_yAxis;break;
    }

    daily_sports_chart.setOption({
        xAxis: {
            data: sports_xAxis
        },
        series: [{
            data: yAxis
        }]
    });
}

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
        + " " + date.getHours() + seperator2 + date.getMinutes()
        + seperator2 + date.getSeconds();
    return currentdate;
}

function getDate(tm){
    var date = new Date(parseInt(tm));
    var seperator1 = "-";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;
    return currentdate;
}