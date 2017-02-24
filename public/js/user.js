/**
 * Created by Hermit on 2016/10/15.
 */

var jcropApi;
var nav_list;
var content_list;

var user_nickname;
var user_nickname_valid = true;

var portrait_path;

window.onload = function() {
    nav_list = document.querySelectorAll(".nav-list>li>a");
    content_list = document.querySelectorAll(".content-right");

    user_nickname = $("#user_nickname").val();

    initListener();
    initDateTools();

    searchMyFriend();
    searchFriendRequests();
};

function initListener() {
    $(".nav-list>li>a").on("click", function() {
        var index = -1;
        for(var i=0;i<nav_list.length;i++){
            if(this==nav_list[i]){
                index = i;
                break;
            }
        }

        if(index==0){
            $("#basic_list").show();
        }else{
            $("#basic_list").hide();
        }

        $(".nav-list>li>a").removeClass("active");
        $(this).addClass("active");
        $(content_list).hide();
        $(content_list[index]).show();
    });
    $("#basic_list>li>a").on("click", function() {
        $("#basic_list>li>a").removeClass("active");
        $(this).addClass("active");
    });
    $("#change_img").on("change", function() {
        if(jcropApi!=undefined){
            jcropApi.destroy();
        }

        var f = document.getElementById("change_img").files[0];
        var src = window.URL.createObjectURL(f);
        $("#view_img").css({
            width: "auto",
            height: "auto"
        });
        $("#view_img").attr("src", src);
        $("#cut_img").attr("src", src);
        $("#view_img").Jcrop({
            aspectRatio: 1,
            onSelect: function() {
                var imgScale = jcropApi.tellScaled();
                var imgWH = jcropApi.getWidgetSize();
                $("#x").val(imgScale.x);
                $("#y").val(imgScale.y);
                $("#w").val(imgScale.w);
                $("#h").val(imgScale.h);
                $("#realW").val(imgWH[0]);
                $("#realH").val(imgWH[1]);
                console.log($("#img_form").serialize());
                var option = {
                    type: "post",
                    url: "user/portrait",
                    cache: false,
                    dataType: 'json',
                    contentType: "application/json; charset=utf-8",
                    success: function(data) {
                        var url = data+"?rnd="+Math.random();
                        console.log(url);
                        $("#cut_img").attr('src', url);
                        portrait_path = url;
                    }
                };
                $("#img_form").ajaxSubmit(option);
            }
        }, function(){
            jcropApi = this;
            var imgWH = jcropApi.getWidgetSize();
            jcropApi.animateTo([0, 0, imgWH[0], imgWH[1]]);
        });
    });
    $("#choose_file").on("click", function() {
        $("#img_alert_error").hide();
        $("#change_img").click();
    });
    $("#confirm_file").on("click", function() {
        var file = $("#change_img").val();
        if(file==undefined||file==null||file==""){
            // $("#file_state").html("请选择一个文件");
            $("#img_alert_error").html("<i class='fa fa-close'></i> <strong>请选择一个文件!</strong>");
            $("#img_alert_error").slideDown();
            return;
        }
        $.ajax({
            type: 'put',
            url: 'user/portrait',
            data: 'portrait_path='+portrait_path,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.success==true){
                    window.location.reload();
                }
            },
            error: function() {

            }
        });
    });
    $("#save_user_info").on("click", submitUserInfo);
    $("#save_new_password").on("click", submitUserPassword);
    $("#user_nickname").on("blur", function() {
        if($(this).val()!=user_nickname){
            var nickname = $(this).val();
            $.ajax({
                type: 'get',
                url: "user/nickname/"+nickname,
                dataType: 'json',
                success: function(data) {
                    if(data.success!=true){
                        $("#user_nickname").parent().addClass('has-error');
                        $("#user_nickname").attr('data-content', data.message);
                        if(document.body.clientWidth>=768){
                            $("#user_nickname").popover({
                                trigger: 'manual',
                                placement: 'left'
                            });
                        }else{
                            $("#user_nickname").popover({
                                trigger: 'manual',
                                placement: 'top'
                            });
                        }
                        $("#user_nickname").popover('show');
                        $("#user_nickname").on("focus", function() {
                            $(this).parent().removeClass('has-error');
                            $(this).popover('destroy');
                            $(this).off("focus");
                        });
                    }
                },
                error: function() {

                }
            });
        }
    });
    $("#my_friend_search_button").on("click", searchMyFriend);
    $("#friend_search_button").on("click", searchUsers);
}


function initDateTools() {
    $(".form-datetime").datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: "month"
    });
}

function submitUserInfo() {
    $("#info_submit_error").hide();
    var data = $("#user_info").serialize();

    $.ajax({
        type: 'post',
        url: 'user/info',
        data: data,
        dataType: 'json',
        success: function(data) {
            if(data.success==true){
                window.location.reload();
            }else{

            }
        },
        error: function() {
            $("#info_submit_error").show();
        }
    });
}

function submitUserPassword() {
    var password = $("#user_password_input").val();
    var confirm = $("#user_password_confirm").val();

    if(password==undefined||password==null||password==""){
        $("#user_password_input").parent().addClass('has-error');
        if(document.body.clientWidth>=768){
            $("#user_password_input").popover({
                trigger: 'manual',
                placement: 'left'
            });
        }else{
            $("#user_password_input").popover({
                trigger: 'manual',
                placement: 'top'
            });
        }
        $("#user_password_input").popover('show');
        $("#user_password_input").on("focus", function() {
            console.log(1);
            $(this).parent().removeClass('has-error');
            $(this).popover('destroy');
            $(this).off("focus");
        });
        return "";
    }

    if(password!=confirm){
        $("#user_password_confirm").parent().addClass('has-error');
        if(document.body.clientWidth>=768){
            $("#user_password_confirm").popover({
                trigger: 'manual',
                placement: 'left'
            });
        }else{
            $("#user_password_confirm").popover({
                trigger: 'manual',
                placement: 'top'
            });
        }
        $("#user_password_confirm").popover('show');
        $("#user_password_confirm").on("focus", function() {
            $(this).parent().removeClass('has-error');
            $(this).popover('destroy');
            $(this).off("focus");
        });
        return "";
    }

    $.ajax({
        type: 'post',
        url: 'user/password',
        data: $("#user_password").serialize(),
        dataType: 'json',
        success: function(data) {
            if(data.success==true){
                window.location.reload();
            }
        }
    });
}

function searchUsers() {
    $("#search_list").html("");
    var keyword = $("#friend_search_input").val();

    $.ajax({
        type: 'get',
        url: 'user/search/'+keyword,
        dataType: 'html',
        success: function(data) {
            // console.log(data);
            $("#search_list").html(data);
        },
        error: function() {

        }
    });
}

function searchMyFriend() {
    $("#friend_list").html("");
    var keyword = $("#my_friend_search_input").val();

    $.ajax({
        type: 'get',
        url: 'user/friends/'+keyword,
        dataType: 'html',
        success: function(data) {
            // console.log(data);
            $("#friend_list").html(data);
        },
        error: function() {
            $("#friend_list").html("网络错误，暂无数据");
        }
    });
}

function searchFriendRequests() {
    $.ajax({
        type: 'get',
        url: 'user/requests',
        dataType: 'html',
        success: function(data) {
            // console.log(data);
            $("#request_friend").html(data);
        },
        error: function() {
            $("#request_friend").html("网络错误，暂无数据");
        }
    });
}

function submitPortraitCut() {

}