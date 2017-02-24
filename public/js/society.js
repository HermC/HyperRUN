/**
 * Created by Hermit on 2016/11/28.
 */

var comment_list;
var thumb_list;
var down_list;
var id_list;
window.onload = function() {
    comment_list = document.querySelectorAll('.society-comment');
    thumb_list = document.querySelectorAll('.society-like');
    down_list = document.querySelectorAll('.society-dislike');
    id_list = document.querySelectorAll('.id-input');

    for(var i=0;i<id_list.length;i++){
        var id = $(id_list[i]).val();
        var isIn = false;
        for(var j=0;j<thumbs.length;j++){
            console.log(thumbs[j]);
            console.log(id);
            if(thumbs[j]==id){
                isIn = true;
                break;
            }
        }
        if(isIn){
            $(thumb_list[i]).hide();
        }else{
            $(down_list[i]).hide();
        }
    }

    initListener();
};

function initListener() {
    $(".society-comment").on("click", function() {
        var index = -1;

        for(var i=0;i<comment_list.length;i++){
            if(this==comment_list[i]){
                index = i;
                break;
            }
        }

        var id = $(id_list[index]).val();

        window.location.href = "/society/info/" + id;
    });
    $(".society-like").on("click", function() {
        var index = -1;

        for(var i=0;i<thumb_list.length;i++){
            if(this==thumb_list[i]){
                index = i;
                break;
            }
        }

        var id = $(id_list[index]).val();

        $.ajax({
            type: 'put',
            url: '/society/thumb/' + id,
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
    $(".society-dislike").on("click", function() {
        var index = -1;

        for(var i=0;i<down_list.length;i++){
            if(this==down_list[i]){
                index = i;
                break;
            }
        }

        var id = $(id_list[index]).val();

        $.ajax({
            type: 'delete',
            url: '/society/thumb/' + id,
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