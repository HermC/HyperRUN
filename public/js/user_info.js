/**
 * Created by Hermit on 2016/10/20.
 */
var user_info_nav_list;
var content_list;

window.onload = function() {
    user_info_nav_list = document.querySelectorAll(".nav-list>li>a");
    content_list = document.querySelectorAll(".content");

    initListener();
};

function initListener() {
    $(".nav-list>li>a").on("click", function() {
        var index = -1;

        for(var i=0;i<user_info_nav_list.length;i++){
            if(user_info_nav_list[i]==this){
                index = i;
                break;
            }
        }

        $(user_info_nav_list).removeClass("active");
        $(user_info_nav_list[index]).addClass("active");
        $(content_list).hide();
        $(content_list[index]).show();
    });
}