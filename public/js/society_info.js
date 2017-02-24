/**
 * Created by Hermit on 2016/10/19.
 */

var replyid;

var subject_list;
var object_list;
var replier_input_list;
var asker_input_list;
window.onload = function() {
    subject_list = document.querySelectorAll(".subject");
    object_list = document.querySelectorAll(".object");
    replier_input_list = document.querySelectorAll(".replier-input");
    asker_input_list = document.querySelectorAll(".asker-input");

    initListener();
};

function initListener() {
    $("#comment").on("click", function() {
        replyid = authorid;
        $(".comment-input-wrapper").slideDown();
    });
    $("#comment_submit").on("click", function() {
        var content = $("#comment_input").val();

        $.ajax({
            type: 'post',
            url: '/society/comment',
            data: 'content=' + content + '&replyid=' + replyid +'&dynamicid=' + dynamicid,
            dataType: 'json',
            success: function(data) {
                if(data.success==true){
                    window.location.reload();
                }else{
                    alert("网络错误");
                }
            },
            error: function() {
                alert("网络错误");
            }
        });
    });
    $("#comment_input").bind('input propertychange', function() {
        var content = $(this).val();
        if(content==undefined||content==null||content==""){
            $("#comment_submit").attr("disabled", true);
        }else{
            $("#comment_submit").attr("disabled", false);
        }
    });
    $(".subject").on("click", function() {
        var index = -1;

        for(var i=0;i<subject_list.length;i++){
            if(this==subject_list[i]){
                index = i;
                break;
            }
        }

        // console.log($(replier_input_list[index]).val());
        replyid = $(replier_input_list[index]).val();
        $(".comment-input-wrapper").slideDown();
    });
    $(".object").on("click", function() {
        var index = -1;

        for(var i=0;i<object_list.length;i++){
            if(this==object_list[i]){
                index = i;
                break;
            }
        }

        // console.log($(asker_input_list[index]).val());
        replyid = $(asker_input_list[index]).val();
        $(".comment-input-wrapper").slideDown();
    });
    $("#thumbs").on("click", function() {
        $.ajax({
            type: 'put',
            url: '/society/thumb/' + dynamicid,
            dataType: 'json',
            success: function(data) {
                if(data.success==true){
                    window.location.reload();
                }else{
                    alert("网络错误");
                }
            },
            error: function() {
                alert("网络错误");
            }
        });
    });
    $("#thumbs_down").on("click", function() {
        $.ajax({
            type: 'delete',
            url: '/society/thumb/' + dynamicid,
            dataType: 'json',
            success: function(data) {
                if(data.success==true){
                    window.location.reload();
                }else{
                    alert("网络错误");
                }
            },
            error: function() {
                alert("网络错误");
            }
        });
    });
}