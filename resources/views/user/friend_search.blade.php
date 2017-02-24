<div class="friend-list-wrapper">
    @forelse($users as $user)
        <div class="media friend-item">
            <a class="media-left">
                <img class="user-img img-circle" src="{{ url($user->portrait) }}"/>
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a>{{ $user->name }}</a> <span class="label label-info hidden-xs">等级{{ $user->level }}</span></h4>
                <p class="user-content">{{ $user->synopsis }}</p>
            </div>
            <div class="media-right">
                <button type="button" class="edit-button add-button" {{ in_array($user->id, $already_requests) ? 'disabled' : '' }}>添加</button>
            </div>
        </div>
    @empty
        <p>查找到0个用户</p>
    @endforelse

    <script type="text/javascript">
        var user_search_list = {!! $usersJSON !!}['data'];

        var add_button_list = document.querySelectorAll(".friend-list-wrapper .add-button");

        $(".friend-list-wrapper .add-button").on("click", function() {
            var index = -1;
            for(var i=0;i<add_button_list.length;i++){
                if(this==add_button_list[i]){
                    index = i;
                    break;
                }
            }

            $.ajax({
                type: 'put',
                url: 'user/friends/'+user_search_list[index].id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.success==true){
                        searchUsers();
                    }else{
                        $("#add_alert_message").html(data.message);
                        $("#add_alert").show();
                    }
                },
                error: function() {
                    $("#add_alert_message").html("未能发送好友请求，请检查网络连接或重试");
                    $("#add_alert").show();
                }
            });
        });
    </script>
</div>