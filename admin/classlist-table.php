<?php

include '../includes/common.php';
if ($islogin == 1) {
} else {
exit('<script language="javascript">window.location.href="./login.php";</script>');
}
adminpermission('shop', 1);
$numrows = $DB->getColumn('SELECT count(*) from shua_class');

// 引入Layer组件
echo '<script type="text/javascript" src="//cdn.bootcdn.net/ajax/libs/layer/3.5.1/layer.js"></script>';

// 添加pid字段到分类表（如果不存在）
$column_exists = $DB->getColumn('SHOW COLUMNS FROM shua_class LIKE \'pid\'');
if(!$column_exists){
	$DB->exec('ALTER TABLE shua_class ADD COLUMN pid int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'父分类ID，0表示一级分类\' AFTER `zid`');
}

// 获取所有分类，包括一级和二级
$rs = $DB->query('SELECT * FROM shua_class WHERE 1 order by sort asc');
$classes = [];
$subClasses = [];
while ($res = $rs->fetch()) {
	if ($res['pid'] == 0) {
		$classes[] = $res; // 一级分类
	} else {
		$subClasses[$res['pid']][] = $res; // 二级分类，按父分类ID分组
	}
}

// 获取所有一级分类列表，用于添加二级分类时选择父分类
$parentClasses = $DB->query('SELECT cid, name FROM shua_class WHERE pid = 0 order by sort asc');
$parentClassOptions = '';
while ($parent = $parentClasses->fetch()) {
	$parentClassOptions .= "<option value='{$parent['cid']}'>{$parent['name']}</option>";
}

?>
<script>
function addSubClass(parentId) {
	layer.prompt({
		formType: 0,
		title: '请输入子分类名称：',
		area: ['400px', '100px'] // 宽高
	}, function(name, index) {
		if (name && name.trim() != '') {
			var loading = layer.load(2);
			$.ajax({
				url: 'ajax_class.php?act=addClass',
				data: {name: name, pid: parentId},
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					layer.close(loading);
					layer.close(index);
					if (data.code == 0) {
						layer.msg(data.msg, {icon: 1});
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						layer.msg(data.msg, {icon: 2});
					}
				},
				error: function() {
					layer.close(loading);
					layer.close(index);
					layer.msg('添加失败，请重试', {icon: 2});
				}
			});
		}
	});
}
function sort(cid, type) {
	var loading = layer.load(2);
	$.ajax({
		type: 'GET',
		url: './ajax_class.php?act=setClassSort&cid=' + cid + '&sort=' + type,
		data: {},
		dataType: 'json',
		success: function(data) {
			layer.close(loading);
			if (data.code == 0) {
				layer.msg(data.msg, {icon: 1});
				setTimeout(function() {
					location.reload();
				}, 1000);
			} else {
				layer.msg(data.msg, {icon: 2});
			}
		},
		error: function() {
			layer.close(loading);
			layer.msg('操作失败，请重试', {icon: 2});
		}
	});
}

function editClass(cid) {
	layer.prompt({
		formType: 0,
		title: '请输入新的分类名称：',
		area: ['400px', '100px'] // 宽高
	}, function(name, index) {
		if (name && name.trim() != '') {
			// 对于子分类，移除前缀
			if (name.indexOf('┗━ ') === 0) {
				name = name.substring(3);
			}
			var loading = layer.load(2);
			$.ajax({
				type: 'POST',
				url: './ajax_class.php?act=editClass&cid=' + cid,
				data: {
					name: name
				},
				dataType: 'json',
				success: function(data) {
					layer.close(loading);
					layer.close(index);
					if (data.code == 0) {
						layer.msg('修改成功', {icon: 1});
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						layer.msg(data.msg, {icon: 2});
					}
				},
				error: function() {
					layer.close(loading);
					layer.close(index);
					layer.msg('操作失败，请重试', {icon: 2});
				}
			});
		}
	});
}

function setActive(cid, type) {
	var loading = layer.load(2);
	$.ajax({
		type: 'GET',
		url: './ajax_class.php?act=setClass',
		data: {
			cid: cid,
			active: type
		},
		dataType: 'json',
		success: function(data) {
			layer.close(loading);
			if (data.code == 0) {
				layer.msg(data.msg, {icon: 1});
				setTimeout(function() {
					location.reload();
				}, 1000);
			} else {
				layer.msg(data.msg, {icon: 2});
			}
		},
		error: function() {
			layer.close(loading);
			layer.msg('操作失败，请重试', {icon: 2});
		}
	});
}

function delClass(cid) {
	layer.confirm('确定要删除该分类吗？删除后将无法恢复！', {
		btn: ['确定', '取消'],
		icon: 3
	}, function(index) {
		layer.close(index);
		var loading = layer.load(2);
		$.ajax({
			type: 'POST',
			url: './ajax_class.php?act=delClass&cid=' + cid,
			data: {},
			dataType: 'json',
			success: function(data) {
				layer.close(loading);
				if (data.code == 0) {
					layer.msg(data.msg, {icon: 1});
					setTimeout(function() {
						location.reload();
					}, 1000);
				} else {
					layer.msg(data.msg, {icon: 2});
				}
			},
			error: function() {
				layer.close(loading);
				layer.msg('操作失败，请重试', {icon: 2});
			}
		});
	});
}

function saveAll() {
	var sortData = {};
	var nameData = {};
	
	$('input[name^="sort"]').each(function() {
		var cid = $(this).attr('name').match(/\d+/)[0];
		sortData[cid] = $(this).val();
	});
	
	$('input[name^="name"]').each(function() {
		var cid = $(this).attr('name').match(/\d+/)[0];
		var name = $(this).val();
		// 对于子分类，移除前缀
		if (name.indexOf('┗━ ') === 0) {
			name = name.substring(3);
		}
		nameData[cid] = name;
	});
	
	var loading = layer.load(2);
	$.ajax({
		type: 'POST',
		url: './ajax_class.php?act=editClassAll',
		data: {
			sort: sortData,
			name: nameData
		},
		dataType: 'json',
		success: function(data) {
			layer.close(loading);
			if (data.code == 0) {
				layer.msg('保存成功', {icon: 1});
				setTimeout(function() {
					location.reload();
				}, 1000);
			} else {
				layer.msg(data.msg, {icon: 2});
			}
		},
		error: function() {
			layer.close(loading);
			layer.msg('操作失败，请重试', {icon: 2});
		}
	});
}

function addClass() {
	var name = $('input[name="addname"]').val();
	if (name && name.trim() != '') {
		var loading = layer.load(2);
		$.ajax({
			type: 'POST',
			url: './ajax_class.php?act=addClass',
			data: {
				name: name,
				pid: 0
			},
			dataType: 'json',
			success: function(data) {
				layer.close(loading);
				if (data.code == 0) {
					layer.msg(data.msg, {icon: 1});
					setTimeout(function() {
						location.reload();
					}, 1000);
				} else {
					layer.msg(data.msg, {icon: 2});
				}
			},
			error: function() {
				layer.close(loading);
				layer.msg('添加失败，请重试', {icon: 2});
			}
		});
	} else {
		layer.msg('分类名称不能为空', {icon: 2});
	}
}

function setBlockPay(cid) {
	// 跳转到设置禁用支付方式页面或打开模态框
	layer.msg('设置禁用支付方式功能暂未实现', {icon: 2});
}

function setClass(cid) {
	// 跳转到设置不可售地区页面或打开模态框
	layer.msg('设置不可售地区功能暂未实现', {icon: 2});
}
</script>

<form name="classlist" id="classlist">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead><tr><th>排序操作</th><th style="min-width:150px">名称（<?php echo $numrows;?>）</th><th>分类类型</th><th>操作</th></tr></thead>
      <tbody id="classlisttbody">
<?php 
// 显示一级分类及其子分类
foreach ($classes as $res) {
	// 一级分类行
	$activeBtn = $res['active'] == 1 ? '<span class="btn btn-sm btn-success" onclick="setActive('.$res['cid'].',0)">显示</span>' : '<span class="btn btn-sm btn-warning" onclick="setActive('.$res['cid'].',1)">隐藏</span>';
	$classBlockBtn = $conf['classblock'] > 0 ? '<li><a href="javascript:setClass('.$res['cid'].')">设置不可售地区</a></li>' : '';
	
	// 输出一级分类
	 echo '<tr data-cid="' . $res['cid'] . '" class="primary-class">
	<td>
		<a class="btn btn-xs sort_btn" title="移到顶部" onclick="sort('.$res['cid'].',0)"><i class="fa fa-long-arrow-up"></i></a>
		<a class="btn btn-xs sort_btn" title="移到上一行" onclick="sort('.$res['cid'].',1)"><i class="fa fa-chevron-circle-up"></i></a>
		<a class="btn btn-xs sort_btn" title="移到下一行" onclick="sort('.$res['cid'].',2)"><i class="fa fa-chevron-circle-down"></i></a>
		<a class="btn btn-xs sort_btn" title="移到底部" onclick="sort('.$res['cid'].',3)"><i class="fa fa-long-arrow-down"></i></a>
		<a class="btn btn-xs sort_drag" title="拖动排序"><i class="fa fa-sort"></i></a>
		<input type="hidden" name="sort['.$res['cid'].']" value="' . $res['sort'] . '">
	</td>
	<td><input type="text" class="form-control input-sm" name="name['.$res['cid'].']" value="' . $res['name'] . '" placeholder="分类名称" required></td>
	<td><span class="label label-primary">一级分类</span></td>
	<td>
		<span class="btn btn-primary btn-sm" onclick="editClass('.$res['cid'].')">修改</span>&nbsp;' . $activeBtn . '&nbsp;<a href="./shoplist.php?cid='.$res['cid'].'" class="btn btn-info btn-sm">商品</a>&nbsp;
		<span class="btn btn-sm btn-danger" onclick="delClass('.$res['cid'].')">删除</span>&nbsp;
		<span class="btn btn-sm btn-default" onclick="addSubClass('.$res['cid'].')">添加子分类</span>&nbsp;
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多 <span class="caret"></span></button>
			<ul class="dropdown-menu dropdown-menu-right text-left">
				<li><a href="./list.php?cid='.$res['cid'].'">查看该分类的订单</a></li>
				<li><a href="javascript:setBlockPay('.$res['cid'].')">设置禁用支付方式</a></li>
				' . $classBlockBtn . '
			</ul>
		</div>
	</td>
  </tr>';
  
  // 显示子分类（如果有）
  if (isset($subClasses[$res['cid']])) {
    foreach ($subClasses[$res['cid']] as $subRes) {
	    $subActiveBtn = $subRes['active'] == 1 ? '<span class="btn btn-sm btn-success" onclick="setActive('.$subRes['cid'].',0)">显示</span>' : '<span class="btn btn-sm btn-warning" onclick="setActive('.$subRes['cid'].',1)">隐藏</span>';
	    $subClassBlockBtn = $conf['classblock'] > 0 ? '<li><a href="javascript:setClass('.$subRes['cid'].')">设置不可售地区</a></li>' : '';
	    
	    // 输出子分类
	    echo '<tr data-cid="' . $subRes['cid'] . '" class="sub-class" style="background-color:#f9f9f9;">
		<td style="padding-left:40px;">
			<a class="btn btn-xs sort_btn" title="移到顶部" onclick="sort('.$subRes['cid'].',0)"><i class="fa fa-long-arrow-up"></i></a>
			<a class="btn btn-xs sort_btn" title="移到上一行" onclick="sort('.$subRes['cid'].',1)"><i class="fa fa-chevron-circle-up"></i></a>
			<a class="btn btn-xs sort_btn" title="移到下一行" onclick="sort('.$subRes['cid'].',2)"><i class="fa fa-chevron-circle-down"></i></a>
			<a class="btn btn-xs sort_btn" title="移到底部" onclick="sort('.$subRes['cid'].',3)"><i class="fa fa-long-arrow-down"></i></a>
			<a class="btn btn-xs sort_drag" title="拖动排序"><i class="fa fa-sort"></i></a>
			<input type="hidden" name="sort['.$subRes['cid'].']" value="' . $subRes['sort'] . '">
		</td>
		<td style="padding-left:40px;"><input type="text" class="form-control input-sm" name="name['.$subRes['cid'].']" value="┗━ ' . $subRes['name'] . '" placeholder="子分类名称" required></td>
		<td><span class="label label-success">二级分类</span></td>
		<td>
			<span class="btn btn-primary btn-sm" onclick="editClass('.$subRes['cid'].')">修改</span>&nbsp;' . $subActiveBtn . '&nbsp;<a href="./shoplist.php?cid='.$subRes['cid'].'" class="btn btn-info btn-sm">商品</a>&nbsp;
			<span class="btn btn-sm btn-danger" onclick="delClass('.$subRes['cid'].')">删除</span>&nbsp;
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多 <span class="caret"></span></button>
				<ul class="dropdown-menu dropdown-menu-right text-left">
					<li><a href="./list.php?cid='.$subRes['cid'].'">查看该分类的订单</a></li>
					<li><a href="javascript:setBlockPay('.$subRes['cid'].')">设置禁用支付方式</a></li>
					' . $subClassBlockBtn . '
				</ul>
			</div>
		</td>
      </tr>';
    }
  }
}?><tr><td><span class="btn btn-primary btn-sm" onclick="saveAll()"><i class="fa fa-floppy-o"></i> 保存全部</span></td><td><input type="text" class="form-control input-sm" name="addname" placeholder="分类名称" required></td><td colspan="3"><span class="btn btn-success btn-sm" onclick="addClass()"><span class="glyphicon glyphicon-plus"></span> 添加分类</span>&nbsp;&nbsp;<a href="./classlist.php?my=classimg" class="btn btn-info btn-sm"><i class="fa fa-picture-o"></i> 修改分类图片</a></td></tr>
          </tbody>
        </table>
      </div>
	</form>