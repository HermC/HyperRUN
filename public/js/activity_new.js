/**
 * Created by Hermit on 2016/10/19.
 */

window.onload = function() {

    initListener();
    initSelectTools();
    initDateTools();
};

function initListener() {
    $("#activity_submit").on("click", function() {
        $("#submit_alert").hide();
        $(".form-group").removeClass("has-error");

        var activity_title = $("#activity_title").val();
        var activity_place = $("#activity_place").val();
        var activity_time = $("#activity_time").val();
        var activity_participate = $("#activity_participate").val();
        var activity_type = $("#activity_type").val();

        if(activity_title==undefined||activity_title==null||activity_title==""){
            $($("#activity_title").parent()).parent().addClass("has-error");
            return;
        }
        if(activity_place==undefined||activity_place==null||activity_place==""){
            $($("#activity_place").parent()).parent().addClass("has-error");
            return;
        }
        if(activity_time==undefined||activity_time==null||activity_time==""){
            $($("#activity_time").parent()).parent().addClass("has-error");
            return;
        }
        if(activity_participate==undefined||activity_participate==null||activity_participate==""){
            $($("#activity_participate").parent()).parent().addClass("has-error");
            return;
        }
        if(activity_type==undefined||activity_type==null||activity_type==""){
            $($("#activity_type").parent()).parent().addClass("has-error");
            return;
        }

        var data = $("#activity__form").serialize();

        $.ajax({
            type: 'post',
            url: '/activity/activity',
            data: data,
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                if(data.success==true){
                    window.location.href = "/activity";
                }else{
                    $("#submit_alert").slideDown();
                }
            },
            error: function() {
                $("#submit_alert").slideDown();
            }
        });
    });
}

function initSelectTools() {
    $("#activity_type").select2({
        tags: true
    });
}

function initDateTools() {
    var today = getNowFormatDate();

    $(".form-datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:mm:ss',
        autoclose: true,
        todayBtn: true
    });

    $(".form-datetime").datetimepicker("setStartDate", today);
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