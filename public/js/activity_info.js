/**
 * Created by Hermit on 2016/11/28.
 */

window.onload = function() {
    initListener();
};

function initListener() {
    $("#delete_activity").on("click", function() {
        $.ajax({
            type: 'delete',
            url: '/activity/activity/' + id,
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data.success==true){
                    window.location.href = '/activity'
                }else{
                    alert("网络错误");
                }
            },
            error: function() {
                alert("网络错误");
            }
        });
    });
    $("#join_in_button").on("click", function() {
        $.ajax({
            type: 'put',
            url: '/activity/participant/' + id,
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
    $("#exit_button").on("click", function() {
        $.ajax({
            type: 'delete',
            url: '/activity/participant/' + id,
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