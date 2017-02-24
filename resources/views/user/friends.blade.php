<div class="friend-list-wrapper">
    @foreach($friends as $friend)
        <div class="media friend-item">
            <a class="media-left">
                <img class="user-img img-circle" src="{{ url($friend->portrait) }}"/>
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a>{{ $friend->name }}</a> <span class="label label-info hidden-xs">等级{{ $friend->level }}</span></h4>
                <p class="user-content">{{ $friend->synopsis }}</p>
            </div>
            <div class="media-right">
                <button type="button" class="edit-button delete-button">删除</button>
            </div>
        </div>
    @endforeach
    <br>
    <nav class="pagination-wrapper">
        {!! $friends->render() !!}
    </nav>

    <script type="text/javascript">
        var user_list = {!! $friendsJSON !!}['data'];

        var a_list = document.querySelectorAll(".pagination-wrapper a");
        var href_list = [];
        var delete_button_list = document.querySelectorAll(".friend-list-wrapper .delete-button");

        var friend_item_list = document.querySelectorAll("#friend_list .friend-item");

        for(var i=0;i<a_list.length;i++){
            href_list.push($(a_list[i]).attr("href"));
        }

        $(".pagination-wrapper a").on("click", function() {
            var index = -1;
            for(var i=0;i<a_list.length;i++){
                if(this==a_list[i]){
                    index = i;
                    break;
                }
            }
            $.ajax({
                type: "get",
                url: href_list[index],
                dataType: "html",
                success: function(data) {
                    $("#friend_list").html(data);
                },
                error: function() {
                    $("#friend_list").html("暂无数据");
                }
            });
        });
        $(".pagination-wrapper a").removeAttr("href");
        $(".friend-list-wrapper .delete-button").bind("click", function(e) {
            e.stopPropagation();

            var index = -1;
            for(var i=0;i<delete_button_list.length;i++){
                if(this==delete_button_list[i]){
                    index = i;
                    break;
                }
            }

            $.ajax({
                type: 'delete',
                url: 'user/friends/'+user_list[index].id,
                dataType: 'json',
                success: function(data) {
                    if(data.success==true){
                        searchMyFriend();
                    }else{
                        $("#delete_alert_message").html(data.message);
                        $("#delete_alert").show();
                    }
                },
                error: function() {
                    $("#delete_alert_message").html("未能删除好友，请检查网络连接或重试");
                    $("#delete_alert").show();
                }
            });
        });
        $("#friend_list .friend-item").bind("click", function(e) {
            var index = -1;
            for(var i=0;i<friend_item_list.length;i++){
                if(this==friend_item_list[i]){
                    index = i;
                    break;
                }
            }

            window.location.href = 'user/info/'+user_list[index].id;
        });
    </script>
</div>