<?php

include "../includes/common.php";
$title = "批量对接商品";
include "./head.php";
if ($islogin == 1) {
} else {
	exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?><div class="col-sm-12 col-md-10 center-block" style="float: none;">
    <?php 
adminpermission("shop", 1);
$act = isset($_GET["act"]) ? $_GET["act"] : null;
$rs = $DB->query("SELECT * FROM pre_class WHERE active=1 order by sort asc");
$classselect = "<option value=\"0\">未分类</option>";
while ($res = $rs->fetch()) {
	$classselect .= "<option value=\"" . $res["cid"] . "\">" . $res["name"] . "</option>";
}
$rs = $DB->query("SELECT * FROM pre_shequ order by id asc");
$shequselect = "";
while ($res = $rs->fetch()) {
	$getInfo = \lib\Plugin::getConfig("third_" . $res["type"]);
	if ($getInfo["batchgoods"] == true) {
		$shequselect .= "<option value=\"" . $res["id"] . "\" type=\"" . $res["type"] . "\" domain=\"" . $res["url"] . "\">[<font color=blue>" . $getInfo["title"] . "</font>] " . $res["url"] . ($res["remark"] ? " (" . $res["remark"] . ")" : "") . "</option>";
	}
}
$rs = $DB->query("SELECT * FROM pre_price order by id asc");
$priceselect = "<option value=\"0\">不使用加价模板</option>";
while ($res = $rs->fetch()) {
	$kind = $res["kind"] == 1 ? "元" : "倍";
	$priceselect .= "<option value=\"" . $res["id"] . "\" kind=\"" . $res["kind"] . "\" p_2=\"" . $res["p_2"] . "\" p_1=\"" . $res["p_1"] . "\" p_0=\"" . $res["p_0"] . "\" >" . $res["name"] . "(" . $res["p_2"] . $kind . "|" . $res["p_1"] . $kind . "|" . $res["p_0"] . $kind . ")</option>";
}
if ($act == "data") {
	$shequ = intval($_GET["shequ"]);
	$row = $DB->getRow("select * from pre_shequ where id='" . $shequ . "' limit 1");
	$result = third_call($row["type"], $row, "class_list");
	$third_classlist = "";
	foreach ($result as $res) {
		$third_classlist .= "<option value=\"" . $res["cid"] . "\">" . $res["name"] . "</option>";
	}
	?>        <div class="block">
            <div class="block-title"><h3 class="panel-title">批量对接商品</h3></div>
            <div class="">
                <form action="?" role="form">
                    <input type="hidden" name="shequ" value="<?php echo $shequ;?>"/>
                    <div class="form-group">
                        <div class="input-group"><div class="input-group-addon">当前对接站点</div>
                            <input class="form-control" value="<?php echo $row["url"];?>" disabled><span class="input-group-btn"><a href="./batchgoods.php" class="btn btn-default">重新选择</a></span>
                        </div></div>
                    <div class="form-group">
                        <div class="input-group"><div class="input-group-addon">选择对接站点商品分类</div>
                            <select class="form-control" id="cid"><option value="-1">--请选择分类--</option><?php echo $third_classlist;?></select>
                        </div></div>
                    <table class="table table-bordered table-vcenter table-hover" id="shoptable">
                        <tbody id="shoplist">
                        </tbody>
                    </table>
                    <div class="form-group">
                        <div class="input-group"><div class="input-group-addon">选择保存到本站的分类</div>
                            <select class="form-control" id="mcid"><option value="-1">--请选择分类--</option><option value="new">新建同名分类</option><?php echo $classselect;?></select>
                        </div></div>
                    <div class="form-group">
                        <div class="input-group"><div class="input-group-addon">选择使用的加价模板</div>
                            <select class="form-control" id="prid"><option value="-1">--请选择加价模板--</option><?php echo $priceselect;?></select><span class="input-group-btn"><a href="./price.php" class="btn btn-default">加价模板管理</a></span>
                        </div></div>
                    <p><input type="button" name="submit" value="确定添加/更新选中商品" class="btn btn-primary btn-block" id="add_submit"/></p>
                </form>
            </div>
        </div>
<?php 
} else {
	?>    <div class="block">
        <div class="block-title"><h3 class="panel-title">批量对接商品</h3></div>
        <div class="">
            <div class="alert alert-info">
                并非支持所有的对接系统，仅支持同系统对接系统。使用此功能可以快速添加/更新本站对接的商品。
            </div>
            <form action="?" method="GET" role="form">
                <input type="hidden" name="act" value="data"/>
                <div class="form-group">
                    <div class="input-group"><div class="input-group-addon">选择对接站点</div>
                        <select class="form-control" name="shequ"><?php echo $shequselect;?></select>
                    </div></div>
                <p><input type="submit" name="submit" value="获取商品分类" class="btn btn-primary btn-block"/></p>
            </form>
        </div>
    </div>
    <?php 
}
?>    <script src="<?php echo $cdnpublic;?>layer/3.1.1/layer.js"></script>
    <script>
        function SelectAll(chkAll) {
            var items = $('.shop');
            for (i = 0; i < items.length; i++) {
                if (items[i].id.indexOf("tid") != -1 && items[i].type == "checkbox") {
                    items[i].checked = chkAll.checked;
                }
            }
        }
        var shoplist;
        $(document).ready(function(){
            $("#add_submit").click(function () {
                var shequ = $("input[name='shequ']").val();
                var mcid = $("#mcid").val();
                var prid = $("#prid").val();
                if(mcid == -1){
                    layer.alert('请选择保存到本站的分类');return false;
                }
                if(prid == -1){
                    layer.alert('请选择使用的加价模板');return false;
                }
                var newshoplist = new Array();
                var items = $('.shop');
                for (i = 0; i < items.length; i++) {
                    if (items[i].id.indexOf("tid") != -1 && items[i].type == "checkbox" && items[i].checked == true) {
                        var tid = items[i].value;
                        newshoplist.push(shoplist[tid]);
                    }
                }
                if(newshoplist.length <= 0){
                    layer.alert('请至少选中一个商品');return false;
                }
                var ii = layer.load(2, {shade:[0.1,'#fff']});
                $.ajax({
                    type : "POST",
                    url : "ajax_shop.php?act=batchaddgoods",
                    dataType : 'json',
                    data : {shequ:shequ, mcid:mcid, prid:prid, list:newshoplist, cname:$("#cid option:selected").text(), cimg:$("#cid option:selected").attr('data-shopimg')},
                    success : function(data) {
                        layer.close(ii);
                        if(data.code == 0){
                            layer.alert(data.msg, {icon:1}, function(){window.location.reload()});
                        }else{
                            layer.alert(data.msg, {icon:2});
                        }
                    },
                    error:function(data){
                        layer.msg('加载失败，请刷新重试');
                        return false;
                    }
                });
            });
            $("#cid").change(function () {
                var cid = $(this).val();
                var shequ = $("input[name='shequ']").val();
                if(cid==-1)return;
                var ii = layer.load(2, {shade:[0.1,'#fff']});
                shoplist = new Array();
                $("#shoplist").empty();
                $("#shoplist").append('<tr><td><label class="csscheckbox csscheckbox-primary">全选<input type="checkbox" onclick="SelectAll(this)"><span></span></label>&nbsp;ID</td><td>商品名称</td><td>成本价</td><td>状态</td></tr>');
                $.ajax({
                    type : "POST",
                    url : "ajax_shop.php?act=goodslistbycid",
                    dataType : 'json',
                    data : {shequ:shequ, cid:cid},
                    success : function(data) {
                        layer.close(ii);
                        if(data.code == 0){
                            var num = 0;
                            $.each(data.data, function (i, item) {
                                shoplist[item.tid] = JSON.stringify(item);
                                $("#shoplist").append('<tr><td><label class="csscheckbox csscheckbox-primary"><input name="tid[]" type="checkbox" class="shop" id="tid" value="'+item.tid+'"><span></span>&nbsp;'+item.tid+'<label></label></label></td><td>'+item.name+'</td><td>'+item.price+'</td><td>'+(item.close==1?'<span class="label label-warning">已下架</span>':'<span class="label label-success">上架中</span>')+'</td></tr>');
                                num++;
                            });
                            if(num==0)layer.msg('该分类下没有商品', {icon:0, time:800});
                            else $("#newclass").html("--新建分类【"+$("#cid option:selected").html()+"】--");
                        }else{
                            layer.alert(data.msg, {icon:2});
                        }
                    },
                    error:function(data){
                        layer.msg('加载失败，请刷新重试');
                        return false;
                    }
                });
            });
        })
    </script>
    </body>
    </html>