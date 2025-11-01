<?php
// 客服工作台
include "../includes/common.php";
$title = "客服工作台";
include "./head.php";
if ($islogin != 1) {
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?>
<div class="col-xs-12 col-sm-12 col-lg-12 center-block" style="float: none;">
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-headphones"></i> 客服工作台</h3></div>
        <div class="panel-body" style="min-height:600px;">
            <div class="row">
                <div class="col-sm-4" id="chat-session-list">
                    <!-- 会话列表区域 -->
                    <div class="list-group" style="height:550px;overflow-y:auto;">
                        <a href="#" class="list-group-item active">会话列表加载中...</a>
                    </div>
                </div>
                <div class="col-sm-8" id="chat-message-area">
                    <!-- 消息窗口区域 -->
                    <div class="panel panel-default" style="height:550px;display:flex;flex-direction:column;">
                        <div class="panel-heading" id="chat-session-title">请选择会话</div>
                        <div class="panel-body" id="chat-message-list" style="flex:1;overflow-y:auto;background:#f9f9f9;">
                            <div class="text-center text-muted" style="margin-top:200px;">暂无会话</div>
                        </div>
                        <div class="panel-footer" id="chat-reply-box" style="display:none;">
                            <form id="chat-reply-form" class="form-inline" enctype="multipart/form-data">
                                <input type="hidden" name="session_id" value="">
                                <div class="form-group" style="width:70%;">
                                    <input type="text" class="form-control" name="content" placeholder="输入回复内容..." style="width:100%;">
                                </div>
                                <input type="file" name="image" accept="image/*" style="display:none;" id="chat-upload-image">
                                <button type="button" class="btn btn-default" onclick="$('#chat-upload-image').click();"><i class="fa fa-image"></i> 图片</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> 发送</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var currentSessionId = null;
var pollingTimer = null;

function loadSessionList() {
    $.get('ajax.php?act=chat_session_list', function(res) {
        if(res.code === 0) {
            var html = '';
            if(res.data.length === 0) {
                html = '<a href="#" class="list-group-item">暂无会话</a>';
            } else {
                res.data.forEach(function(item) {
                    html += '<a href="#" class="list-group-item'+(item.id==currentSessionId?' active':'')+'" data-id="'+item.id+'">'+
                        '<span class="badge">'+(item.unread>0?item.unread:'')+'</span>'+item.user_ip+'<br><small>'+item.last_msg_time+'</small>'+
                        (item.status==0?'<span class="label label-default pull-right">已关闭</span>':'')+
                        '</a>';
                });
            }
            $('#chat-session-list .list-group').html(html);
        }
    },'json');
}

function loadMessageList(sessionId, scrollBottom) {
    $.get('ajax.php?act=chat_message_list&session_id='+sessionId, function(res) {
        if(res.code === 0) {
            var html = '';
            res.data.forEach(function(msg) {
                if(msg.type==1) {
                    html += '<div class="'+(msg.sender=='admin'?'text-right':'text-left')+'"><img src="'+msg.content+'" style="max-width:120px;max-height:120px;border-radius:6px;"> <small>'+msg.create_time+'</small></div>';
                } else {
                    html += '<div class="'+(msg.sender=='admin'?'text-right':'text-left')+'"><span class="label label-'+(msg.sender=='admin'?'primary':'default')+'">'+(msg.sender=='admin'?'客服':'用户')+'</span> '+msg.content+' <small>'+msg.create_time+'</small></div>';
                }
            });
            if(html==='') html = '<div class="text-center text-muted" style="margin-top:200px;">暂无消息</div>';
            $('#chat-message-list').html(html);
            if(scrollBottom!==false) $('#chat-message-list').scrollTop($('#chat-message-list')[0].scrollHeight);
        }
    },'json');
}

function startPolling() {
    if(pollingTimer) clearInterval(pollingTimer);
    var interval = <?php echo intval($conf['chat_polling']??3); ?> * 1000;
    pollingTimer = setInterval(function(){
        if(currentSessionId) loadMessageList(currentSessionId, true);
        loadSessionList();
    }, interval);
}

$(function(){
    loadSessionList();
    startPolling();

    // 点击会话切换
    $('#chat-session-list').on('click', '.list-group-item', function(e){
        e.preventDefault();
        var sid = $(this).data('id');
        if(!sid) return;
        currentSessionId = sid;
        $('#chat-session-list .list-group-item').removeClass('active');
        $(this).addClass('active');
        $('#chat-reply-box').show();
        $('#chat-reply-form [name=session_id]').val(sid);
        $('#chat-session-title').text('会话ID：'+sid);
        loadMessageList(sid, true);
    });

    // 发送消息
    $('#chat-reply-form').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'ajax.php?act=chat_send_message',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res){
                if(res.code===0){
                    loadMessageList(currentSessionId, true);
                    $('#chat-reply-form [name=content]').val('');
                    $('#chat-reply-form [name=image]').val('');
                }else{
                    alert(res.msg);
                }
            }
        });
    });

    // 发送图片
    $('#chat-upload-image').change(function(){
        if(this.files.length>0){
            var formData = new FormData($('#chat-reply-form')[0]);
            $.ajax({
                url: 'ajax.php?act=chat_send_message',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res){
                    if(res.code===0){
                        loadMessageList(currentSessionId, true);
                        $('#chat-reply-form [name=image]').val('');
                    }else{
                        alert(res.msg);
                    }
                }
            });
        }
    });

    // 会话关闭
    $('#chat-session-title').on('dblclick', function(){
        if(currentSessionId && confirm('确定要关闭此会话吗？')){
            $.post('ajax.php?act=chat_close_session', {session_id:currentSessionId}, function(res){
                if(res.code===0){
                    loadSessionList();
                    $('#chat-message-list').html('<div class="text-center text-muted" style="margin-top:200px;">会话已关闭</div>');
                    $('#chat-reply-box').hide();
                }else{
                    alert(res.msg);
                }
            },'json');
        }
    });
});
</script>
<?php include "./foot.php";?> 