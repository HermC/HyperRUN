/**
 * Created by Hermit on 2016/10/18.
 */

window.onload = function() {

    initListener();
    initEditor();
};

function initListener() {
    $("#file_channel").on("change", function() {
        console.log($(this).val());

        $("#img_url").val($(this).val());
    });
    $("#upload").on("click", function() {
        var title = $("#title").val();

        if(title==undefined||title==null||title==""){
            $("#title").addClass("has-error");
            return;
        }

        var data = "content="+$("#trumbowyg_editor").trumbowyg('html')+"&title="+title;
        data = data.replace(/"/g, "\\\"");

        $.ajax({
            type: 'post',
            url: '/society/new',
            data: data,
            dataType: 'json',
            success: function(data) {
                if(data.success==true){
                    window.location.href = '/society';
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

function initEditor() {
    $('#trumbowyg_editor').trumbowyg({
        lang: "zh_cn",
        fullscreenable: false,
        closeable: false,
        btns: [
            ['formatting'],
            'btnGrp-semantic',
            ['superscript', 'subscript'],
            // ['link'],
            // ['insertImage'],
            ['horizontalRule'],
            ['removeformat']
        ]
    });
}