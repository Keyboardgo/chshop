<?php

include "../includes/common.php";
$title = "检查版本更新";
if ($islogin == 1) {
} else {
	exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
include "./head.php";
?><div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
    <div class="block">
        <div class="block-title">
            <h3 class="panel-title">检查更新</h3>
        </div>
        <div class="panel-body">
            <div id="msg" class="alert alert-info"><i class="fa fa-spinner fa-spin"></i>正在检测中</div>
            <hr/>
            <div id="update_log" class="well" style="display:none"></div>
            <a id="update_btn" class="btn btn-primary btn-block" style="display:none">立即更新</a>
        </div>
    </div>
</div>
<!--因为该示例文件以引入jquery.min.js，所以这里就不用在引入了，如果你的网站没有引入请把下方这段注释去掉-->
<!--<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>-->
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
    $(function(){
        var i = layer.load(0);
        $.ajax({
            type: 'POST',
            url: 'update.php',
            data: {'SF_Action':'check'},
            dataType: 'json',
            success: function(data) {
                layer.close(i);
                // 若返回code为0
                if(data.code == 0){
                    // code为1代表需要更新，0则不需要
                    if(data.data.code == 1){
                        // 遍历所有需要更新的版本的更新内容
                        var update_log = '更新内容<hr/>';
                        $.each(data.data.data.update_log, function(index, value){
                            update_log += value+'<br/><br/>';
                        });
                        $("#update_log").html(update_log);
                        $("#update_btn").css('display','inherit');
                        $("#update_log").css('display','inherit');
                        $("#msg").addClass('alert-warning');
                        $("#msg").html('当前最新版 V'+data.data.data.edition);
                    }else{
                        $("#msg").addClass('alert-success');
                        $("#msg").html('您当前已是最新版本!');
                    }
                }else{
                    // 错误信息
                    $("#msg").addClass('alert-danger');
                    $("#msg").html(data.msg);
                }

            },
            error: function() {
                layer.close(i);
                $("#msg").html('服务器错误！');
            }
        });

        function update(){
            var i = layer.load(0);
            $.ajax({
                type: 'POST',
                url: 'update.php',
                data: {'SF_Action':'update'},
                dataType: "json",
                success: function(data) {
                    layer.close(i);
                    if(data.code == 1){
                        layer.msg(data.msg, {icon:1});
                        setTimeout(function(){
                            location.href="./update.php"
                        }, 2000);
                    }else if(data.code == 0){
                        layer.msg(data.msg, {icon:1});
                        setTimeout(function(){
                            update();
                        }, 1000);
                    }else{
                        layer.msg(data.msg, {icon:2});
                    }

                },
                error: function() {
                    layer.close(i);
                    $("#msg").html('服务器错误！');
                }
            });
        }
        // 检测用户是否点击按钮
        $("#update_btn").click(function(){
            // 执行update函数
            update();
        });
    });
</script><?php 
function zipExtract($src, $dest)
{
	$_var_0 = new ZipArchive();
	if ($_var_0->open($src) === true) {
		$_var_0->extractTo($dest);
		$_var_0->close();
		return true;
	}
	return false;
}
function deldir($dir)
{
	if (!is_dir($dir)) {
		return false;
	}
	$_var_1 = opendir($dir);
	while ($_var_2 = readdir($_var_1)) {
		if ($_var_2 != "." && $_var_2 != "..") {
			$_var_3 = $dir . "/" . $_var_2;
			if (!is_dir($_var_3)) {
				unlink($_var_3);
			} else {
				deldir($_var_3);
			}
		}
	}
	closedir($_var_1);
	if (rmdir($dir)) {
		return true;
	} else {
		return false;
	}
}