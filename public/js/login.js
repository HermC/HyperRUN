/**
 * Created by Hermit on 2016/10/19.
 */

window.onload = function() {

    // initListener();
};

function initListener() {
    $("#to_register").on("click", function() {
        $("#login_option").hide();
        $("#register_option").show();
    });
    $("#to_login").on("click", function() {
        $("#login_option").show();
        $("#register_option").hide();
    });
}