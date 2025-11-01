<?php
if(!defined('IN_CRONLITE'))exit();
$zid = $conf['zid'];
$site_info=$DB->getRow("select appurl from pre_site where zid='$zid' limit 1");
if (empty($site_info['appurl'])) {
  $xr=$conf['appurl'];
} else {
  $xr=$site_info['appurl'];
}
// 从XHY-00获取的配置
$chdsn_cn_zuocew = $conf['chdsn_cn_zuocew']?$conf['chdsn_cn_zuocew']:'https://s3.ax1x.com/2021/01/01/rxImKe.png';
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
  <title><?php echo $conf['sitename']?><?php echo $conf['title']?></title>
  <meta name="keywords" content="<?php echo $conf['keywords']?>">
  <meta name="description" content="<?php echo $conf['description']?>">
  <?php if(!empty($conf['favicon'])){?>
  <link rel="icon" href="<?php echo $cdnserver?>/<?php echo $conf['favicon']?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo $cdnserver?>/<?php echo $conf['favicon']?>" type="image/x-icon" />
  <?php }else{?>
  <link rel="icon" href="<?php echo $cdnserver?>assets/img/favicon/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo $cdnserver?>assets/img/favicon/favicon.ico" type="image/x-icon" />
  <?php }?>
  
  <!-- 预加载关键资源 - 来自CX-NEW1 -->
  <link rel="preload" href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2?v=4.7.0" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.7/fonts/glyphicons-halflings-regular.woff2" as="font" type="font/woff2" crossorigin>
  
  <!-- 关键CSS优先加载 - 结合CX-NEW1和XHY-00 -->
  <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/simple/css/oneui.css">
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/css/common.css?ver=<?php echo VERSION ?>">
  
  <!-- 非关键JavaScript异步加载 -->
  <script src="https://cdn.bootcdn.net/ajax/libs/modernizr/2.8.3/modernizr.min.js" async></script>
  <!--[if lt IE 9]>
    <script src="https://cdn.bootcdn.net/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <!-- 关键JavaScript立即加载 -->
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdn.bootcdn.net/ajax/libs/layer/2.3/layer.js"></script>
  <script src="assets/js/main.js?ver=<?php echo VERSION ?>"></script>
  
  <!-- 全局错误处理 - 来自CX-NEW1 -->
  <script>
  window.addEventListener('error', function(e) {
      console.error('全局JavaScript错误:', e.error);
      return false;
  });
  </script>
  
  <!-- 分类点击功能优化 - 来自CX-NEW1 -->
  <script>
  $(document).ready(function(){
      // 立即绑定分类点击事件，不等待其他资源加载
      $(document).on('click', '.goodTypeChange', function(e){
          e.preventDefault();
          e.stopPropagation();
          
          var id = $(this).data('id');
          console.log('分类点击事件触发，ID:', id);
          
          // 立即响应，不等待AJAX
          $("#cid").val(id);
          $("#goodType").hide('fast');
          $("#goodTypeContent").show('fast');
          
          // 异步加载商品数据
          setTimeout(function(){
              $("#cid").trigger('change');
          }, 100);
          
          return false;
      });
      
      // 返回按钮
      $(document).on('click', '.backType', function(e){
          e.preventDefault();
          e.stopPropagation();
          $("#goodType").show('fast');
          $("#goodTypeContent").hide('fast');
          return false;
      });
      
      console.log('关键JavaScript已加载完成');
  });
  </script>
  
  <!-- 合并CX-NEW1和XHY-00的样式 -->
  <style type="text/css">
  /* CX-NEW1的样式 */
  #submit_cart_shop {
      background: linear-gradient(to right,#00FFFF,#02C874);
      border-radius: 25px 0 0 25px;
  }
  #submit_buy {
      background: linear-gradient(to right,#84C1FF,#66B3FF);
      border-radius: 0 25px 25px 0;
  }
  
  /* 优化分类点击区域 */
  .goodTypeChange {
      pointer-events: auto !important;
      cursor: pointer !important;
      position: relative !important;
      z-index: 10 !important;
  }
  
  .goodTypeChange:hover {
      opacity: 0.8;
  }
  
  /* 确保分类容器正常显示 */
  #goodType {
      display: block !important;
      visibility: visible !important;
      opacity: 1 !important;
  }
  
  /* 优化加载性能 */
  .widget {
      pointer-events: auto !important;
  }
  
  .btn {
      pointer-events: auto !important;
  }
  
  /* 减少动画时间 */
  .animated {
      animation-duration: 0.5s !important;
  }
  
  /* 优化图片加载 */
  img {
      max-width: 100%;
      height: auto;
  }
  
  /* XHY-00的样式 */
  .form-control {
      color: #646464;
      border: 1px solid #f8f8f8;
      border-radius: 3px;
      -webkit-box-shadow: none;
      box-shadow: none;
      -webkit-transition: all 0.15s ease-out;
      transition: all 0.15s ease-out;
  }
  .block{
      margin-bottom:10px;
      background-color:#fff;
      -webkit-box-shadow:0 2px 17px 2px rgb(222,223,241);
      box-shadow:0 2px 17px 2px rgb(222,223,241);
      font-weight:400
  }
  ul.ft-link{
      margin:0;
      padding:0
  }
  ul.ft-link li{
      border-right:1px solid #E6E7EC;
      display:inline-block;
      line-height:30px;
      margin:8px 0;
      text-align:center;
      width:24%
  }
  ul.ft-link li a{
      color:#74829c;
      text-transform:uppercase;
      font-size:12px
  }
  ul.ft-link li a:hover,ul.ft-link li.active a{
      color:#58c9f3
  }
  ul.ft-link li:last-child{
      border-right:none
  }
  ul.ft-link li a i{
      display:block
  }
  .well {
      min-height: 20px;
      padding: 19px;
      margin-bottom: 15px;
      background-color: #f9f9f9;
      border: 1px solid #e3e3e3;
      border-radius: 4px;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
  }
  .input-group-addon {
      color: #646464;
      background-color: #f9f9f9;
      border-color: #f9f9f9;
      border-radius: 3px;
  }
  .panel-primary {
      border-color: #ffffff;
  }
  ::-webkit-scrollbar-thumb {
      -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1), inset 0 -1px 0 rgba(0,0,0,.07);
      background-clip: padding-box;
      background-color: #1bc74c;
      min-height: 40px;
      padding-top: 100px;
      border-radius: 4px;
  }
  .panel-primary {
      border-color: #ffffff;
  }
  .block > .nav-tabs > li.active > a, .block > .nav-tabs > li.active > a:hover, .block > .nav-tabs > li.active > a:focus {
      color: #646464;
      background-color: #f9f9f9;
      border-color: transparent;
  }
  .btn-info{
      color:#ffffff;
      background-color:#4098f2;
      border-color:#ffffff
  }
  .btn{
      font-weight:100;
      -webkit-transition:all 0.15s ease-out;
      transition:all 0.15s ease-out
  }
  .btn-sm,.btn-group-sm > .btn{
      padding:5px 10px;
      font-size:12px;
      line-height:1.5;
      border-radius:3px
  }
  .btn-primary{
      color:#ffffff;
      background-color:rgb(64,152,242);
      border-color:rgb(64,152,242)
  }
  .bg-image {
      background-color: #ffffff;
      background-position: center center;
      background-repeat: no-repeat;
      -webkit-background-size: cover;
      background-size: cover;
  }
  
  /* 确保标签页正常显示 */
  .tab-content {
      display: block !important;
      visibility: visible !important;
  }
  </style>
<?php echo $background_css?>
</head>
<body>
<?php if($background_image){?>
<img src="<?php echo $background_image;?>" alt="Full Background" class="full-bg full-bg-bottom animated pulse " ondragstart="return false;" oncontextmenu="return false;">
<?php }else{?>
<img src="https://api.suyanw.cn/api/comic" alt="Full Background" class="full-bg full-bg-bottom animated pulse " ondragstart="return false;" oncontextmenu="return false;">
<?php }?>
<div style="padding-top:6px;">
<div class="col-xs-12 col-sm-10 col-md-8 col-lg-4 center-block" style="float: none;">
<!--弹出公告-->
<div class="modal fade" align="left" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $conf['sitename']?></h4>
       </div>
        <div class="modal-body">
         	<?php echo $conf['modal']?>
  	    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">知道啦</button>
      </div>
    </div>
  </div>
</div>
<!--弹出公告-->
<!--公告-->
<div class="modal fade" align="left" id="mustsee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">公告</h4>
      </div>
	  <div class="modal-body">
	  <?php echo $conf['anounce']?>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
 </div>
<!--公告-->
<!--顶部导航 - 来自XHY-00的美化设计-->
<div class="block block-link-hover3" href="javascript:void(0)">
  <div class="block-content block-content-full text-center bg-image" style="background-image: url('<?php echo $chdsn_cn_zuocew?>');background-size: 100% 100%;">
    <div>
      <div>
        <img class="img-avatar img-avatar80 img-avatar-thumb animated zoomInDown"
        src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $conf['kfqq']?>&spec=100">
      </div>
    </div>
  </div>
  <div class="panel-body text-center">
    <ul class="ft-link">
      <li>
        <a href="#mustsee" data-toggle="modal" class="">
          <h5>
            <i class="fa fa-envelope-open-o">
              公告
            </i>
          </h5>
      </li>
      </a>
      <li>
        <a href="/user" data-toggle="modal" class="">
          <h5>
            <i class="fa fa-cogs">
              后台
            </i>
          </h5>
      </li>
      <li>
        <a href="#about" data-toggle="modal" class="">
          <h5>
            <i class="fa fa-user-o">
              售后
            </i>
          </h5>
      </li>
      <li>
        <a href="/?mod=invite" data-toggle="modal" class="">
          <h5>
            <i class="fa fa-heartbeat">
              领赞
            </i>
          </h5>
    </ul>
  </div>
</div>
<!-TAB标签-->
<a href="./user/regsite.php"><img src="https://ftp.bmp.ovh/imgs/2020/01/a0e42112bae39699.gif"width="100%"></a><br/>
<!-TAB标签-->
		
<!--查单说明开始 - 融合CX-NEW1和XHY-00的说明-->
<div class="modal fade" align="left" id="cxsm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">查询内容是什么？该输入什么？</h4>
      </div>
      <li class="list-group-item"><font color="red">请在右侧的输入框内输入您下单时，在第一个输入框内填写的信息</font></li>
      <li class="list-group-item">例如您购买的是预留的手机号或者QQ号，输入下单的手机号或者QQ号即可查询订单</li>
      <li class="list-group-item">例如您购买的是邮箱类商品，需要输入您的邮箱号，输入QQ号是查询不到的</li>
      <li class="list-group-item"><font color="red">如果您不知道下单账号是什么，可以不填写，直接点击查询，则会根据浏览器缓存查询</font></li>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 主体内容区域 - 来自CX-NEW1 -->
<div class="tab-content">
<div class="block" style="margin-top:15px;font-size:15px;padding:1px;border-radius:15px;background-color: white;">

        <ul class="nav nav-tabs btn btn-block animated zoomInLeft btn-rounded" data-toggle="tabs">
        <style>
        /* 确保分站按钮不会被 tab 系统影响 */
        .fenzhan-jump {
            pointer-events: auto !important;
            cursor: pointer !important;
        }
        .fenzhan-jump:hover {
            text-decoration: none !important;
        }
        </style>
            <li style="width: 25%;" align="center" class="active"><a href="#shop" data-toggle="tab"><span style="font-weight:bold"><img border="0" width="22" src="https://pan.suyanw.cn/view.php/a4c308fe41a57c4751b133d9189161b4.gif"><font color="#0000FF">下单</font></span></a></li>
            <li style="width: 25%;" align="center"><a href="#search" data-toggle="tab" id="tab-query"><span style="font-weight:bold"><i class="fa fa-search"></i> <font color="#8B008B">查单</font></span></a></li>
		<li style="width: 25%;" align="center"><a href="./user/regsite.php" target="_blank" class="fenzhan-jump"><font color="#FF4000"><i class="fa fa-location-arrow fa-spin"></i> <b>分站</b></font></a></li>
	
		<li style="width: 25%;" align="center"><a href="#more" data-toggle="tab"><span style="font-weight:bold"><i class="fa fa-folder-open"></i> <font color="#FF8C00">更多</font></span></a></li>
        </ul>
        


<div style="background-color:#333;border-radius: 25px;box-shadow: 0px 0px 5px #f200ff;padding:5px;margin-top: 10px;margin-bottom:0px;">
    <center><span style="color: rgb(194, 79, 74)"><i class="fa fa-check"></i><b><font color="#D2B48C">【平台所有商品全天24小时自动发货】</font><i class="fa fa-check"></i></b></span></center>
    <center><span style="font-size:10px;"><strong><span><span style="color:#E53333;">下单步骤<span style="color:#E53333;"> &gt; <span><span style="color:#E8E8E8;">选择分类</span></span> &gt; <span style="color:#009900;">选择商品<span style="color:#E53333;"> &gt; </span></span><span></span><span style="color:#EE33EE;">填写信息<span style="color:#E53333;"> &gt; </span><span style="color:#F08080;">下单成功</span></span></span></span></strong></span>
</center></div>
    
    <div class="block-content tab-content">
<!--TAB标签-->
<!--在线下单-->

    <div class="tab-pane active" id="shop">
<?php include ROOT.'user/shop.inc.php'; ?>
	</div>
   
<!--在线下单-->
<marquee>
    	<b id="nr">诚信经营,价格最低,货源最全,卡密问题质保可退换,放心下单即可!!!</b>
    </marquee>
<!--查询订单-->
			
					<div class="tab-pane fade fade-up" id="search">
						<ul class="list-group animated bounceIn">
      <li class="list-group-item">
        <div class="media">
							<span class="pull-left thumb-sm"><img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $conf['kfqq']?>&spec=100" class="img-circle img-thumbnail img-avatar"></span>
								<div class="pull-left push-10-t">
							<div class="font-w600 push-5">🚀运营站长 QQ:<?php echo $conf['kfqq']?></div>
							 <div class="text-muted">
              <script>var online = new Array();</script>
							<div class="text-muted"><h8><b>️售后问题请联系网站客服解决！️</b></h8></div>
					</div>
          </div>
        </div>
      </li>
    </ul>
					<div class="col-xs-12 well well-sm animation-pullUp">
					<font color="#0000FF">付款未收到卡密,请自己查单补单<br>
-------------最简单的查单方式--------------</font><br>
<font color="#DC143C">什么浏览器购买的，直接用什么浏览器打开，什么也别填写，直接点立即查询。在手机QQ打开的购买的，用手机QQ打开网址点立即查询~！</font><br>				</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
								<select class="form-control" id="searchtype" style="padding: 6px 4px;width:90px"><option value="0">下单账号</option><option value="1">17位单号</option></select>
							</div>
							<input type="text" name="qq" id="qq3" value="" class="form-control" placeholder="请输入要查询的内容（留空则显示最新订单）" required="">
							<span class="input-group-btn"><a href="#cxsm" data-toggle="modal" class="btn btn-warning">说明</a></span>
						</div>
					</div>
							<input type="submit" id="submit_query" class="btn btn-default btn-block btn-rounded" style="background-image: url(https://pan.suyanw.cn/view.php/6240ef859a11d3a31a7b3ccb0358dc02.jpg);font-weight:bold" value="立即查询">

						<font color="red">
							<i class="">
							</i>
						</font>
						<font color="red">
				查单号:请输入您购买时候填写的手机号，如果填写的时候忘记手机号请点击立即查询即可！
				
						</font>					
					<br>
					<div id="result2" class="form-group" style="display:none;">
						<center>
							<small>
								<font color="#ff0000">
									手机用户可以左右滑动
								</font>
							</small>
						</center>
						<div class="table-responsive">
							<table class="table table-vcenter table-condensed table-striped">
								<thead>
									<tr>
										<th class="hidden-xs">
											下单账号
										</th>
										<th>
											商品名称
										</th>
										<th>
											数量
										</th>
										<th class="hidden-xs">
											购买时间
										</th>
										<th>
											状态
										</th>
										<th>
											操作
										</th>
									</tr>
								</thead>
								<tbody id="list">
								</tbody>
							</table>
						</div>
					</div>
				</div>
<!--查询订单-->
<!--开通分战-->
    <div class="tab-pane" id="Substation">
	<table class="table table-borderless animated bounceIn" style="text-align: center;">
    <tbody>
      <tr class="active">
        <td>
          <h4>
            <span style="font-weight:bold">
              <font color="#FF8000">搭</font>
              <font color="#EC6D13">建</font>
              <font color="#D95A26">属</font>
              <font color="#C64739"></font>
              <font color="#A0215F">自</font>
              <font color="#8D0E72">己</font>
              <font color="#5400AB">的</font>
              <font color="#4100BE">货</font>
              <font color="#2E00D1">源</font>
              <font color="#1B00E4">站</font></span>
          </h4>
        </td>
      </tr>
      <tr class="active">
        <td>学生/上班族/创业/休闲挣￥必备工具</td></tr>
      <tr class="active">
        <td>
          <strong>
            网站轻轻松松推广日挣上千￥不是梦</strong></td>
      </tr>
            <tr class="active">
        <td><span class="glyphicon glyphicon-magnet"></span>&nbsp;快加入我们成为大家庭中的一员吧<hr> <a href="#userjs" data-toggle="modal" class="btn btn-effect-ripple  btn-info btn-sm" style="float:left;overflow: hidden; position: relative;">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;网站详情介绍</a>
          <a href="./user/regsite.php" target="_blank" class="btn btn-effect-ripple  btn-success btn-sm" style="float:right;overflow: hidden; position: relative;">
            <span class="glyphicon glyphicon-share-alt"></span>&nbsp;开通网站</a></td></tr>
      <tr>
    </tbody>
  </table>
	</div>
<!--开通分战-->
<!--抽奖-->
    <div class="tab-pane" id="gift">
		<div class="panel-body text-center">
		<div id="roll">点击下方按钮开始</div>
		<hr>
		<p>
		<a class="btn btn-info" id="start" style="display:block;">开始</a>
		<a class="btn btn-danger" id="stop" style="display:none;">停止</a>
		</p> 
		<div id="result"></div><br/>
		<div class="giftlist" style="display:none;"><strong>最近记录</strong><ul id="pst_1"></ul></div>
		</div>
	</div>
<!--抽奖-->
<!--更多-->
				<div class="tab-pane fade fade-right" id="more">
					<div class="col-xs-6 col-sm-4 col-lg-4">
						<a class="block block-link-hover2 text-center" href="./user/" target="_blank">
							<div class="block-content block-content-full bg-city">
								<i class="fa fa-certificate fa-3x text-white">
								</i>
								<div class="font-w600 text-white-op push-15-t">
									后宫禁地
								</div>
							</div>
						</a>
					</div>
					<div class="col-xs-6 col-sm-4 col-lg-4 hide">
						<a class="block block-link-hover2 text-center btn btn-block animated zoomInLeft btn-rounded"
						data-toggle="modal" href="#lqq">
							<div class="block-content block-content-full bg-primary">
								<i class="fa fa-circle-o fa-3x text-white">
								</i>
								<div class="font-w600 text-white-op push-15-t">
									免.费.卡.密
								</div>
							</div>
						</a>
					</div>
	</div>
	</div>
<!--更多-->
</div>
</div>

<script>
// 修复页面显示问题
$(document).ready(function(){
    // 确保所有标签页内容正确加载
    $('.tab-content').show();
    
    // 初始化页面时检查URL中的锚点，并激活对应的标签页
    var hash = window.location.hash;
    if (hash) {
        $('.nav-tabs a[href="' + hash + '"]').tab('show');
    }
    
    // 修复标签页切换问题
    $('.nav-tabs a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // 确保分类按钮可以正常点击
    $('.goodTypeChange').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var id = $(this).data('id');
        console.log('分类点击事件触发，ID:', id);
        
        // 立即响应，不等待AJAX
        $("#cid").val(id);
        $("#goodType").hide('fast');
        $("#goodTypeContent").show('fast');
        
        // 异步加载商品数据
        setTimeout(function(){
            $("#cid").trigger('change');
        }, 100);
        
        return false;
    });
});
</script>
<script type="text/javascript">
var isModal = <?php echo empty($conf['modal']) ? 'false' : 'true'; ?> ;
var homepage = true;
var hashsalt = <?php echo $addsalt_js ?> ;
</script>
</body>
</html>