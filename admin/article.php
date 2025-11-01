<?php

include "../includes/common.php";
$title = "文章管理";
include "./head.php";
if ($islogin == 1) {
} else {
	exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?>    <div class="col-sm-12 col-md-10 center-block" style="float: none;">
<?php 
adminpermission("article", 1);
$my = isset($_GET["my"]) ? $_GET["my"] : null;
if ($my == "add") {
	?><div class="block">
<div class="block-title"><h3 class="panel-title">添加文章</h3></div>
<div class="">
  <form action="./article.php?my=add_submit" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-2 control-label">文章标题</label>
	  <div class="col-sm-10"><input type="text" name="title" value="" class="form-control"/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">SEO关键词</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="" class="form-control" placeholder="可留空"/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">SEO描述</label>
	  <div class="col-sm-10"><textarea id="description" class="form-control" name="description" rows="2" placeholder="可留空"></textarea></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">文章内容</label>
	  <div class="col-sm-10"><textarea id="editor_id" class="form-control" name="content" rows="8" style="width:100%;"></textarea></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">是否置顶</label>
	  <div class="col-sm-10"><select class="form-control" name="top"><option value="0">否</option><option value="1">是</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">发布时间</label>
	  <div class="col-sm-10"><input type="date" name="addtime" value="<?php echo date("Y-m-d", strtotime("+1 years"));?>" class="form-control"/></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="发布" class="btn btn-primary btn-block"/><br/>
	 </div>
	</div>
  </form>
  <br/><a href="./article.php">>>返回文章列表</a>
</div>
</div>
<script charset="utf-8" src="../assets/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="../assets/kindeditor/zh-CN.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id', {
					resizeType : 1,
					allowUpload : false,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat','formatblock','hr', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link','unlink', 'code', '|','fullscreen','source','preview']
				});
        });
</script>
<?php 
} elseif ($my == "edit") {
	$id = $_GET["id"];
	$row = $DB->getRow("select * from pre_article where id='" . $id . "' limit 1");
	?><div class="block">
<div class="block-title"><h3 class="panel-title">修改文章</h3></div>
<div class="">
  <form action="./article.php?my=edit_submit&id=<?php echo $id;?>" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-2 control-label">文章标题</label>
	  <div class="col-sm-10"><input type="text" name="title" value="<?php echo $row["title"];?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">SEO关键词</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $row["keywords"];?>" class="form-control" placeholder="可留空"/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">SEO描述</label>
	  <div class="col-sm-10"><textarea id="description" class="form-control" name="description" rows="2" placeholder="可留空"><?php echo $row["description"];?></textarea></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">文章内容</label>
	  <div class="col-sm-10"><textarea id="editor_id" class="form-control" name="content" rows="8" style="width:100%;"><?php echo htmlspecialchars($row["content"]);?></textarea></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">是否置顶</label>
	  <div class="col-sm-10"><select class="form-control" name="top" default="<?php echo $row["top"];?>"><option value="0">否</option><option value="1">是</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">发布时间</label>
	  <div class="col-sm-10"><input type="date" name="addtime" value="<?php echo $row["addtime"];?>" class="form-control"/></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="发布" class="btn btn-primary btn-block"/><br/>
	 </div>
	</div>
  </form>
  <br/><a href="./article.php">>>返回文章列表</a>
</div>
</div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>
<script charset="utf-8" src="../assets/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="../assets/kindeditor/zh-CN.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id', {
					resizeType : 1,
					allowUpload : false,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat','formatblock','hr', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link','unlink', 'code', '|','fullscreen','source','preview']
				});
        });
</script>
<?php 
} elseif ($my == "add_submit") {
	$title = daddslashes($_POST["title"]);
	$keywords = daddslashes($_POST["keywords"]);
	$description = daddslashes($_POST["description"]);
	$content = daddslashes($_POST["content"]);
	$type = intval($_POST["type"]);
	$addtime = $_POST["addtime"];
	if ($title == NULL || $content == NULL) {
		showmsg("保存错误,请确保每项都不为空!", 3);
	} else {
		$rows = $DB->getRow("select * from pre_article where type='" . $type . "' and title='" . $title . "' limit 1");
		if ($rows) {
			showmsg("文章标题已存在！", 3);
		}
		$sql = "insert into `pre_article` (`title`,`keywords`,`description`,`content`,`top`,`addtime`,`active`) values ('" . $title . "','" . $keywords . "','" . $description . "','" . $content . "','" . $top . "','" . $addtime . "','1')";
		if ($DB->exec($sql) !== false) {
			showmsg("添加文章成功！<br/><br/><a href=\"./article.php\">>>返回文章列表</a>", 1);
		} else {
			showmsg("添加文章失败！" . $DB->error(), 4);
		}
	}
} elseif ($my == "edit_submit") {
	$id = $_GET["id"];
	$rows = $DB->getRow("select * from pre_article where id='" . $id . "' limit 1");
	if (!$rows) {
		showmsg("当前记录不存在！", 3);
	}
	$title = daddslashes($_POST["title"]);
	$keywords = daddslashes($_POST["keywords"]);
	$description = daddslashes($_POST["description"]);
	$content = daddslashes($_POST["content"]);
	$type = intval($_POST["type"]);
	$addtime = $_POST["addtime"];
	if ($title == NULL || $content == NULL) {
		showmsg("保存错误,请确保每项都不为空!", 3);
	} else {
		if ($DB->exec("UPDATE `pre_article` SET `title`='" . $title . "',`keywords`='" . $keywords . "',`description`='" . $description . "',`content`='" . $content . "',`top`='" . $top . "',`addtime`='" . $addtime . "' WHERE `id`='" . $id . "'") !== false) {
			showmsg("修改文章成功！<br/><br/><a href=\"./article.php\">>>返回文章列表</a>", 1);
		} else {
			showmsg("修改文章失败！" . $DB->error(), 4);
		}
	}
} elseif ($my == "delete") {
	$id = $_GET["id"];
	$sql = "DELETE FROM pre_article WHERE id='" . $id . "'";
	if ($DB->exec($sql) !== false) {
		showmsg("删除成功！<br/><br/><a href=\"./article.php\">>>返回文章列表</a>", 1);
	} else {
		showmsg("删除失败！" . $DB->error(), 4);
	}
} else {
	if (isset($_GET["kw"])) {
		$kw = trim(daddslashes($_GET["kw"]));
		$sql = " title LIKE '%" . $kw . "%'";
		$numrows = $DB->getColumn("SELECT count(*) from pre_article where" . $sql);
		$con = "包含 <b>" . $kw . "</b> 的共有 <b>" . $numrows . "</b> 个文章";
		$link = "&kw=" . $kw;
	} else {
		$sql = " 1";
		$numrows = $DB->getColumn("SELECT count(*) from pre_article");
		$con = "系统共有 <b>" . $numrows . "</b> 个文章";
	}
	?><div class="block">
<div class="block-title clearfix">
<h2><?php echo $con;?></h2>
</div>
<form action="article.php" method="GET" class="form-inline">
 <a href="./article.php?my=add" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;添加文章</a>
  <div class="form-group">
    <input type="text" class="form-control" name="kw" placeholder="请输入文章标题">
  </div>
  <button type="submit" class="btn btn-info">搜索</button>&nbsp;<a href="./set.php?mod=rewrite" class="btn btn-default"><i class="fa fa-cog"></i>&nbsp;伪静态配置</a>
</form>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>文章标题</th><th>发布时间</th><th>浏览量</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php 
	$pagesize = 30;
	$pages = ceil($numrows / $pagesize);
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
	$offset = $pagesize * ($page - 1);
	$rs = $DB->query("SELECT * FROM pre_article WHERE" . $sql . " order by id desc limit " . $offset . "," . $pagesize);
	while ($res = $rs->fetch()) {
		echo "<tr><td><b>" . $res["id"] . "</b></td><td>" . $res["title"] . "</td><td>" . $res["addtime"] . "</td><td>" . $res["count"] . "</td><td>" . ($res["active"] == 1 ? "<span class=\"btn btn-xs btn-success\" onclick=\"setActive(" . $res["id"] . ",0)\">显示</span>" : "<span class=\"btn btn-xs btn-warning\" onclick=\"setActive(" . $res["id"] . ",1)\">隐藏</span>") . "</td><td><a class=\"btn btn-xs btn-success\" href=\"../?mod=article&id=" . $res["id"] . "\" target=\"_blank\">查看</a>&nbsp;<a href=\"./article.php?my=edit&id=" . $res["id"] . "\" class=\"btn btn-info btn-xs\">编辑</a>&nbsp;<a href=\"./article.php?my=delete&id=" . $res["id"] . "\" class=\"btn btn-xs btn-danger\" onclick=\"return confirm('你确实要删除此记录吗？');\">删除</a></td></tr>";
	}
	?>          </tbody>
        </table>
      </div>
<ul class="pagination"><?php 
	$first = 1;
	$prev = $page - 1;
	$next = $page + 1;
	$last = $pages;
	if ($page > 1) {
		echo "<li><a href=\"article.php?page=" . $first . $link . "\">首页</a></li>";
		echo "<li><a href=\"article.php?page=" . $prev . $link . "\">&laquo;</a></li>";
	} else {
		echo "<li class=\"disabled\"><a>首页</a></li>";
		echo "<li class=\"disabled\"><a>&laquo;</a></li>";
	}
	$start = $page - 10 > 1 ? $page - 10 : 1;
	$end = $page + 10 < $pages ? $page + 10 : $pages;
	for ($i = $start; $i < $page; $i++) {
		echo "<li><a href=\"article.php?page=" . $i . $link . "\">" . $i . "</a></li>";
	}
	echo "<li class=\"disabled\"><a>" . $page . "</a></li>";
	for ($i = $page + 1; $i <= $end; $i++) {
		echo "<li><a href=\"article.php?page=" . $i . $link . "\">" . $i . "</a></li>";
	}
	if ($page < $pages) {
		echo "<li><a href=\"article.php?page=" . $next . $link . "\">&raquo;</a></li>";
		echo "<li><a href=\"article.php?page=" . $last . $link . "\">尾页</a></li>";
	} else {
		echo "<li class=\"disabled\"><a>&raquo;</a></li>";
		echo "<li class=\"disabled\"><a>尾页</a></li>";
	}
	?></ul><?php 
}
?>    </div>
  </div>
</div>
<script src="<?php echo $cdnpublic;?>layer/2.3/layer.js"></script>
<script src="assets/js/article.js?ver=<?php echo VERSION;?>"></script>
</body>
</html>