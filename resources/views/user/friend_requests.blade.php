<div class="friend-list-wrapper">
    @forelse($requests as $re)
        <div class="media friend-item">
            <a class="media-left">
                <img class="user-img img-circle" src="{{ url($re->portrait) }}"/>
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a>{{ $re->name }}</a> <span class="label label-info hidden-xs">等级{{ $re->level }}</span></h4>
                <p class="user-content">{{ $re->synopsis }}</p>
            </div>
            <div class="media-right">
                <button type="button" class="edit-button agree">同意</button>
                <button type="button" class="edit-button refuse">拒绝</button>
            </div>
        </div>
    @empty
        <p>暂无好友请求</p>
    @endforelse

    <script type="text/javascript">
        var user_request_list = {!! $requestsJSON !!};

        var agree_button_list = document.querySelectorAll('.friend-list-wrapper .agree');
        var refuse_button_list = document.querySelectorAll('.friend-list-wrapper .refuse');
        $(".friend-list-wrapper .agree").on("click", function() {
            var index = -1;
            for(var i=0;i<agree_button_list.length;i++){
                if(this==agree_button_list[i]){
                    index = i;
                    break;
                }
            }

            $.ajax({
                type: 'put',
                url: 'user/requests/'+user_request_list[index].id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.success==true){
                        searchFriendRequests();
                        searchMyFriend();
                    }else{
                        $("#request_alert_message").html(data.message);
                        $("#request_alert").show();
                    }
                },
                error: function() {
                    $("#request_alert_message").html("操作失败，请检查网络连接");
                    $("#request_alert").show();
                }
            });
        });
        $(".friend-list-wrapper .refuse").on("click", function() {
            var index = -1;
            for(var i=0;i<refuse_button_list.length;i++){
                if(this==refuse_button_list[i]){
                    index = i;
                    break;
                }
            }

            $.ajax({
                type: 'delete',
                url: 'user/requests/'+user_request_list[index].id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.success==true){
                        searchFriendRequests();
                    }else{
                        $("#request_alert_message").html(data.message);
                        $("#request_alert").show();
                    }
                },
                error: function() {
                    $("#request_alert_message").html("操作失败，请检查网络连接");
                    $("#request_alert").show();
                }
            });
        });
    </script>
</div>