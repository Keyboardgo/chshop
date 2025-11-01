<?php
if(!defined('IN_CRONLITE'))exit();
@header('Content-Type: text/html; charset=UTF-8');

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$scriptpath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = (is_https() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$scriptpath.'/';

$admin_cdnpublic = 1;
if($admin_cdnpublic==1){
	$cdnpublic = '//lib.baomitu.com/';
}elseif($admin_cdnpublic==2){
	$cdnpublic = 'https://cdn.bootcdn.net/ajax/libs/';
}elseif($admin_cdnpublic==4){
	$cdnpublic = '//s1.pstatp.com/cdn/expire-1-M/';
}else{
	$cdnpublic = '//cdn.staticfile.org/';
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="renderer" content="webkit"/>
  <meta name="force-rendering" content="webkit"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title><?php echo $title ?></title>
  <?php if(!empty($conf['favicon'])){echo '<link rel="icon" href="'.htmlspecialchars($conf['favicon']).'" type="image/x-icon" />';}?>
  <link href="<?php echo $cdnpublic?>twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="<?php echo $cdnpublic?>font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../assets/appui/css/main.css">
  <link rel="stylesheet" href="../assets/appui/css/themes.css">
  <link id="theme-link" rel="stylesheet" href="<?php echo $_COOKIE['optionThemeColor']?$_COOKIE['optionThemeColor']:'../assets/appui/css/themes/flat-2.4.css';?>">
  <!-- 原admin-custom.css文件不存在，修复引用路径错误 -->
  <script src="<?php echo $cdnpublic?>jquery/2.1.4/jquery.min.js"></script>
  <script src="<?php echo $cdnpublic?>twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="../assets/appui/js/plugins.js"></script>
  <script src="../assets/appui/js/app2.js"></script>
  <!--[if lt IE 9]>
    <script src="<?php echo $cdnpublic?>html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="<?php echo $cdnpublic?>respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body<?php if(basename($_SERVER['SCRIPT_NAME'])=='login.php') echo ' class="login-page"'; ?>>
<div class="admin-bg-img"></div>
<!-- BTPanel风格全局应用，保留原有PHP逻辑和内容输出区域 -->
<?php if($islogin==1){?>
<div class="bg"></div>
<div id="root">
<!-- 后台内容区开始 -->
    <div id="page-wrapper">
        <div id="page-container" class="header-fixed-top sidebar-visible-lg-full enable-cookies">
<div id="sidebar-alt" tabindex="-1" aria-hidden="true">
<a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>
<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 888px;"><div id="sidebar-scroll-alt" style="overflow: hidden; width: auto; height: 888px;">
<div class="sidebar-content">
<div class="sidebar-section">
<style>
h4{font-family:"微软雅黑",Georgia,Serif;}
/* 新拟态主题样式类 */
.themed-background-neumorphic { background-color: #e0e5ec !important; }
.themed-background-dark-neumorphic { background-color: #374249 !important; }
</style>
<h4 class="text-light">框架变色(New)</h4>
<br>
<ul class="sidebar-themes clearfix">
<li class="">
<a href="javascript:void(0)" class="themed-background-default" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/themes-2.2.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-default"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-classy" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/classy-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-classy"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-social" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/social-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-social"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-flat" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/flat-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-flat"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-amethyst" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/amethyst-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-amethyst"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-creme" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/creme-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-creme"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-passion" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/passion-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-passion"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-neumorphic" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/neumorphic-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="" data-original-title="">
<span class="section-side themed-background-dark-neumorphic"></span>
<span class="section-content"></span>
</a>
<br>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-classy" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/classy-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-social" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/social-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-flat" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/flat-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-amethyst" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/amethyst-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-creme" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/creme-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-passion" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/passion-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-neumorphic" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/neumorphic-2.4.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light" data-original-title="">
<span class="section-side"></span>
<span class="section-content"></span>
</a>
</li>

<li class="">
<a href="javascript:void(0)" class="themed-background-classy" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/classy-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-classy"></span>
<span class="section-content"></span>
</a>
<br>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-social" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/social-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-social"></span>
<span class="section-content"></span>
</a>
</li>
<li>
<a href="javascript:void(0)" class="themed-background-flat" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/flat-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-flat"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-amethyst" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/amethyst-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-amethyst"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-creme" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/creme-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-creme"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-passion" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/passion-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-passion"></span>
<span class="section-content"></span>
</a>
</li>
<li class="">
<a href="javascript:void(0)" class="themed-background-neumorphic" data-toggle="tooltip" title="" data-theme="../assets/appui/css/themes/neumorphic-2.4.css" data-theme-navbar="navbar-default" data-theme-sidebar="" data-original-title="">
<span class="section-header"></span>
<span class="section-side themed-background-dark-neumorphic"></span>
<span class="section-content"></span>
</a>
</li>
</ul>
</div>
</div>
</div><div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 888px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 1; z-index: 90; right: 1px;"></div></div>
</div>
            <div id="sidebar">
                <div id="sidebar-brand" class="themed-background">
				<a href="./" class="sidebar-title">
                    <i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide">管理后台</span>
                </a>
				</div>
                <div id="sidebar-scroll">
                    <div class="sidebar-content">
                        <ul class="sidebar-nav">

<li>
	<a class="<?php echo checkIfActive('index,')?>" href="./">
		<i class="fa fa-home sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">后台首页</span>
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive('list,export')?>" href="./list.php">
		<i class="fa fa-list sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">订单管理</span>
	</a>
</li>

<li class="<?php echo checkIfActive('classlist,shoplist,shopedit,price,shoprank,cardlist')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-shopping-cart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">商品管理</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("classlist") ?>" href="./classlist.php">
		分类列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("shoplist,shopedit,shoprank") ?>" href="./shoplist.php">
		商品列表
	</a>
</li>

<li>
	<a class="<?php echo checkIfActive("price") ?>" href="./price.php">
		加价模板
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("toollogs") ?>" href="./toollogs.php">
		上架日志
	</a>
</li>
<?php if($conf['iskami']==1){?><li>
	<a class="<?php echo checkIfActive("cardlist") ?>" href="./cardlist.php">
		兑换卡密
	</a>
</li><?php }?>
	</ul>
</li>

<li class="<?php echo checkIfActive('fakalist,fakakms,mailcon')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-th sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">发卡管理</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("fakalist") ?>" href="./fakalist.php">
		库存管理
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("fakakms") ?>" href="./fakakms.php?my=add">
		添加卡密
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("mailcon") ?>" href="./set.php?mod=mailcon">
		发信模板
	</a>
</li>
	</ul>
</li>
<li class="<?php echo checkIfActive('sitelist,mj,tixian,record,rank,userlist,message,workorder,siteprice,kmlist')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-sitemap sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">分站管理</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("1,siteprice") ?>" href="./sitelist.php?mod=1">
		分站列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("mj") ?>" href="./sitelist.php?mod=mj">
		密价用户
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("workorder") ?>" href="./workorder.php">
		工单列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("userlist") ?>" href="./userlist.php">
		用户列表
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("record") ?>" href="./record.php">
		收支明细
	</a>
</li>
<?php if($conf['fenzhan_tixian']==1){?>
<li>
	<a class="<?php echo checkIfActive("tixian") ?>" href="./tixian.php">
		余额提现
	</a>
</li>
<?php }?>
<li>
	<a class="<?php echo checkIfActive("rank") ?>" href="./rank.php">
		分站排行
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("message") ?>" href="./message.php">
		站内通知
	</a>
</li>
	</ul>
</li>

<li>
	<a class="<?php echo checkIfActive('article,rewrite')?>" href="./article.php">
		<i class="fa fa-book sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">文章管理</span>
	</a>
</li>

<li class="<?php echo checkIfActive('shequlist,pricejk,log,clone,cloneset,shequ,orderjk,batchgoods')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cubes sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">对接设置</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("shequlist") ?>" href="./shequlist.php">
		对接站点管理
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("pricejk") ?>" href="./pricejk.php">
		价格监控
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("orderjk") ?>" href="./orderjk.php">
		订单状态监控
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("log") ?>" href="./log.php">
		对接日志
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("clone,cloneset") ?>" href="./clone.php">
		克隆站点
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("batchgoods") ?>" href="./batchgoods.php">
		批量对接商品
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("cx-synchronization") ?>" href="./cx-synchronization.php">
		自动同步设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("set_autoreorder") ?>" href="./set_autoreorder.php">
		自动补单设置
	</a>
</li>
	</ul>
</li>

<li class="<?php echo checkIfActive('site,gonggao,mail,pay,template,template2,upimg,upbgimg,clean,cleanbom,defend,proxy,copygg,mailtest,epay,captcha,fenzhan,cron,oauth,update,beautify,chat,set_domain_landing,set_wall_guide')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cog sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">系统设置</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("site") ?>" href="./set.php?mod=site">
		网站信息配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("fenzhan") ?>" href="./set.php?mod=fenzhan">
		分站相关配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("gonggao,copygg") ?>" href="./set.php?mod=gonggao">
		网站公告配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("mail") ?>" href="./set.php?mod=mail">
		邮箱与提醒配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("pay,epay") ?>" href="./set.php?mod=pay">
		支付接口配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("template,template2") ?>" href="./set.php?mod=template">
		首页模板设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("oauth") ?>" href="./set.php?mod=oauth">
		快捷登录配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("captcha") ?>" href="./set.php?mod=captcha">
		验证与IP配置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("defend") ?>" href="./set.php?mod=defend">
		防CC攻击设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("upimg,upbgimg") ?>" href="./set.php?mod=upimg">
		Logo与背景设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("cron") ?>" href="./set.php?mod=cron">
		计划任务设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("clean") ?>" href="./clean.php">
		系统数据清理
    </a>
</li>
<li>
	<a class="<?php echo checkIfActive("update") ?>" href="./update.php">
		检查版本更新
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive('beautify') ?>" href="./set.php?mod=beautify">
		网站美化
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive('chat') ?>" href="./set.php?mod=chat">
		客服系统设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive('set_domain_landing') ?>" href="./set_domain_landing.php">
		域名落地页
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive('set_wall_guide') ?>" href="./set_wall_guide.php">
		防墙引导页
	</a>
</li>
	</ul>
</li>

<li class="<?php echo checkIfActive('qiandao,invite,dwz,choujiang,invitelog,datamove,appCreate')?>">
	<a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cogs sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">其它组件</span></a>
	<ul>
<li>
	<a class="<?php echo checkIfActive("qiandao") ?>" href="./set.php?mod=qiandao">
		每日签到设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("invite,invitelog") ?>" href="./set.php?mod=invite">
		推广链接设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("choujiang") ?>" href="./choujiang.php">
		抽奖商品设置
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("dwz") ?>" href="./set.php?mod=dwz">
		防红接口设置
	</a>
</li>

	</ul>
</li>

<li>
	<a class="<?php echo checkIfActive('account')?>" href="./account.php">
		<i class="fa fa-user-circle-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">员工管理</span>
	</a>
</li>
<?php
                            $stockrows = $DB->getAll('SELECT `tid` FROM `pre_tools` WHERE `active` = 1 AND `close` = 0 AND `is_curl` = 4');
                            $count = 0;
                            foreach ($stockrows as $stockrow) {

                                $stockTotal = $DB->getColumn('SELECT count(`tid`) FROM `pre_faka` WHERE `orderid` = 0 AND `tid` = :tid', [
                                    ':tid' => $stockrow['tid'],
                                ]);

                                if ($stockTotal < 1) {
                                    $count++;
                                }
                            }
                            $count2 = $DB->getColumn("SELECT count(*) from pre_workorder WHERE status=0 or status=1");
                            $count3 = $DB->getColumn("SELECT count(*) from pre_tools where goods_sid != 0 and audit_status=0");
                            ?>
                            <li class="<?php echo checkIfActive('suplist,suptixian,suprecord,supshoplist,sup,supshoplist2')?>">
                                <a href="javascript:void(0)" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-sitemap sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">供货管理</span> <span class="label label-danger"><?php echo $count3?></span></a>
                                <ul>
                                    <li>
                                        <a class="<?php echo checkIfActive("sup") ?>" href="./set.php?mod=sup">
                                            供货商相关配置
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo checkIfActive("suplist,siteprice") ?>" href="./suplist.php">
                                            供货商列表
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo checkIfActive("supshoplist2") ?>" href="./supshoplist2.php">
                                            商品列表
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo checkIfActive("supshoplist") ?>" href="./supshoplist.php">
                                            审核商品 <span class="label label-danger"><?php echo $count3?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo checkIfActive("suprecord") ?>" href="./suprecord.php">
                                            收支明细
                                        </a>
                                    </li>

                                    <li>
                                        <a class="<?php echo checkIfActive("suptixian") ?>" href="./suptixian.php">
                                            余额提现
                                        </a>
                                    </li>

                                    <!--                                    <li>-->
                                    <!--                                        <a class="--><?php //echo checkIfActive("workorder") ?><!--" href="./workorder.php">-->
                                    <!--                                            工单列表-->
                                    <!--                                        </a>-->
                                    <!--                                    </li>-->
                                    <!--                                    <li>-->
                                    <!--                                        <a class="--><?php //echo checkIfActive("message") ?><!--" href="./message.php">-->
                                    <!--                                            站内通知-->
                                    <!--                                        </a>-->
                                    <!--                                    </li>-->
                                </ul>
                            </li>
<li>
	<a class="<?php echo checkIfActive('stock_notice')?>" href="./stock_notice.php">
		<i class="fa fa-bullhorn sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">库存告急</span>
        <span class="label label-danger"><?php echo $count?></span>
	</a>
</li>
<li>
	<a class="<?php echo checkIfActive("workorder2") ?>" href="./workorder2.php">
		<i class="fa fa-bullhorn sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">网盘失效</span>
        <span class="label label-danger"><?php echo $count2?></span>
	</a>
</li>

<li>
	<a class="<?php echo checkIfActive('chatwork') ?>" href="./chatwork.php">
		<i class="fa fa-headphones sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">客服工作台</span>
	</a>
</li>

<li>
	<a class="" href="donate.php">
		<i class="fa fa-heart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">赞赏作者</span>
	</a>
</li>

<li>
	<a class="<?php echo checkIfActive('devdoc')?>" href="devdoc.php">
		<i class="fa fa-book sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">开发文档</span>
	</a>
</li>
                        </ul>
                    </div>
                </div>
                <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
<div class="progress progress-mini push-bit">
<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
</div>
<div class="text-center">
<small><span id="year-copy">2018</span> © <a href="#"><?php echo $conf['sitename']?></a></small>
</div>
</div>
            </div>
            <div id="main-container">
                <header class="navbar navbar-inverse navbar-fixed-top">
 
<ul class="nav navbar-nav-custom">
 
<li>
<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
<i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
<i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>菜单
</a>
</li>
<li>
<a href="javascript:void(0)" onclick="javascript:history.go(-1);">
<i class="fa fa-reply fa-fw animation-fadeInRight"></i> 返回
</a>
</li>
 
</ul>
 
 
<ul class="nav navbar-nav-custom pull-right">
<li>
<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">
<i class="fa fa-wrench sidebar-nav-icon"></i>
</a>
</li>
<li class="dropdown">
<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
<img src="<?php echo ($conf['kfqq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$conf['kfqq'].'&src_uin='.$conf['kfqq'].'&fid='.$conf['kfqq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'../assets/img/user.png'?>" alt="avatar">
</a>
<ul class="dropdown-menu dropdown-menu-right">
<li class="dropdown-header text-center">
<strong>管理员用户</strong>
</li>
<li>
<a href="set.php?mod=bind">
<i class="fa fa-qrcode fa-fw pull-right"></i>
扫码登录
</a>
</li>
</li>
<li>
<a href="set.php?mod=account">
<i class="fa fa-pencil-square fa-fw pull-right"></i>
密码修改
</a>
</li>
<li>
<a href="../">
<i class="fa fa-home fa-fw pull-right"></i>
网站首页
</a>
</li>
<li class="divider">
</li>
<li>
<li>
<a href="login.php?logout">
<i class="fa fa-power-off fa-fw pull-right"></i>
退出登录
</a>
</li>
</ul>
</li>
</ul>
</header>
<div id="page-content">
<div class="main-bg-img"></div>
			<div class="main pjaxmain">
				<div class="content-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="header-section">
                                    <h1><?php echo $title ?></h1>
                                </div>
                            </div>
                        </div>
				</div>
<div class="row">
<?php }?>
