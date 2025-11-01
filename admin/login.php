<?php
/**
 * 登录
**/
$verifycode = 1;//验证码开关

if(!function_exists("imagecreate") || !file_exists('code.php'))$verifycode=0;
include("../includes/common.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	if($conf['thirdlogin_closepwd']==1 && $conf['thirdlogin_open']==1){
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('已关闭密码登录，请使用快捷登录！');history.go(-1);</script>");
	}
	$user=addslashes($_POST['user']);
	$pass=addslashes($_POST['pass']);
	$code=$_POST['code'];
	if ($verifycode==1 && (!$code || strtolower($code) != $_SESSION['vc_code'])) {
		unset($_SESSION['vc_code']);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('验证码错误！');history.go(-1);</script>");
	}elseif($user===$conf['admin_user'] && $pass===$conf['admin_pwd']) {
		unset($_SESSION['vc_code']);
		$session=md5($user.$pass.$password_hash);
		$time = time() + 259200; // 修改为3天有效期（与common.php保持一致）
		$token=authcode("0\t{$user}\t{$session}\t{$time}", 'ENCODE', SYS_KEY);
		$_SESSION['admin_token'] = $token;
		setcookie("admin_token_backup", $token, time() + 259200, '/', '', false, false); // 设置cookie备份
		saveSetting('adminlogin',$date);
		log_result('后台登录', 'IP:'.$clientip, null, 1);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('登陆管理中心成功！');window.location.href='./';</script>");
	}else {
		$userrow=$DB->getRow("SELECT * FROM pre_account WHERE username='$user' limit 1");
		if($userrow && $user===$userrow['username'] && $pass===$userrow['password']) {
			if($userrow['active']==0){
				@header('Content-Type: text/html; charset=UTF-8');
				exit("<script language='javascript'>alert('您的账号未激活！');history.go(-1);</script>");
			}
			unset($_SESSION['vc_code']);
			$session=md5($user.$pass.$password_hash);
			$time = time() + 259200; // 修改为3天有效期（与common.php保持一致）
			$token=authcode("1\t{$userrow['id']}\t{$session}\t{$time}", 'ENCODE', SYS_KEY);
			$_SESSION['admin_token'] = $token;
			setcookie("admin_token_backup", $token, time() + 259200, '/', '', false, false); // 设置cookie备份
			$DB->exec("update pre_account set lasttime='$date' where id='{$userrow['id']}'");
			log_result('后台登录', 'User:'.$user.' IP:'.$clientip, null, 1);
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('登陆管理中心成功！');window.location.href='./';</script>");
		}
		unset($_SESSION['vc_code']);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}
}elseif(isset($_GET['act']) && $_GET['act']=='qrlogin'){
	if(!checkRefererHost())exit();
	if(!$_SESSION['thirdlogin_type']||!$_SESSION['thirdlogin_uin'])exit('{"code":-4,"msg":"校验失败，请重新登录"}');
	$type = $_SESSION['thirdlogin_type'];
	$uin = $_SESSION['thirdlogin_uin'];
	if($islogin==1){
		adminpermission('set', 2);
		if($type == 'qq'){
			saveSetting('thirdlogin_qq', $uin);
			$typename = 'QQ';
		}else{
			saveSetting('thirdlogin_wx', $uin);
			$typename = '微信';
		}
		$CACHE->clear();
		unset($_SESSION['thirdlogin_type']);
		unset($_SESSION['thirdlogin_uin']);
		exit('{"code":1,"msg":"'.$typename.'绑定成功！","url":"reload"}');
	}else{
		if(!$conf['thirdlogin_open'])exit('{"code":-4,"msg":"未开启快捷登录"}');
		$typename = $type == 'qq' ? 'QQ' : '微信';
		if(isset($conf['thirdlogin_qq']) && $type == 'qq' && $uin == $conf['thirdlogin_qq'] || isset($conf['thirdlogin_wx']) && $type == 'wx' && $uin == $conf['thirdlogin_wx']){
			unset($_SESSION['thirdlogin_type']);
			unset($_SESSION['thirdlogin_uin']);
			$session=md5($conf['admin_user'].$conf['admin_pwd'].$password_hash);
			$time = time() + 259200; // 修改为3天有效期（与common.php保持一致）
			$token=authcode("0\t{$conf['admin_user']}\t{$session}\t{$time}", 'ENCODE', SYS_KEY);
			$_SESSION['admin_token'] = $token;
			setcookie("admin_token_backup", $token, time() + 259200, '/', '', false, false); // 设置cookie备份
			saveSetting('adminlogin',$date);
			log_result('后台登录', 'IP:'.$clientip, null, 1);
			exit('{"code":1,"msg":"登陆管理中心成功！","url":"./"}');
		}else{
			exit('{"code":-1,"msg":"登录失败，该'.$typename.'未绑定！"}');
		}
	}
}elseif(isset($_GET['logout'])){
	if(!checkRefererHost())exit();
	unset($_SESSION['admin_token']);
	setcookie("admin_token_backup", '', time() - 604800, '/', '', false, false); // 同时清除cookie
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='./login.php';</script>");
}elseif($islogin==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
$title='用户登录';
// [战神] 优化头部引入
include './head.php';
?>

<!-- 补充引入必要的库 -->
<script src="https://cdn.bootcdn.net/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>
<?php
if($conf['thirdlogin_open'] == 1 && $conf['thirdlogin_closepwd'] == 1){
	$mode = 3;
}elseif($conf['thirdlogin_open'] == 1){
	$mode = 2;
}else{
	$mode = 1;
}
?>

<!-- 模态框保持不变 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">找回管理员密码方法</h4>
      </div>
      <div class="modal-body">
        <p>进入数据库管理器（phpMyAdmin），点击进入当前网站所在数据库，然后查看shua_config表即可找回管理员密码。</p>
		<?php if($mode==3){?>如需开启密码登录，请执行以下SQL：UPDATE shua_config SET v='0' WHERE k='thirdlogin_closepwd';UPDATE shua_cache SET v='' WHERE k='config';<?php }?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 移除不存在的JS文件引用 -->
<!-- 后续可以根据实际需要添加正确路径的JS文件 -->

<style>/* [战神] 优化整合样式 */
/* 基础样式优化 */
.logo.text-center img{
    height: 65px;
    margin-bottom: 1.8rem;
    transition: transform 0.3s ease;
    border-radius: 8px;
}
.logo.text-center img:hover{
    transform: scale(1.05);
}
.list-inline-item .icon {
    width: 2.5rem;
    height: 2.5rem;
}
.social-list-item {
    border: none;
    transition: all 0.3s ease;
}
.social-list-item:hover {
    transform: translateY(-3px) scale(1.05);
}
.allow_login_code_captcha{display:none;}

/* 整体布局 - 左侧登录区(白底) 右侧图片区 */
.container-fluid {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background-color: #f9fafb;
}
.row.no-gutters {
    width: 100%;
    max-width: 1200px;
    border-radius: 24px !important;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: row-reverse; /* 调换左右顺序 */
    animation: fadeIn 0.6s ease forwards;
    opacity: 0;
}

/* 右侧图片区域 */
.col-xl-7.bglogo {
    width: 45%; /* 图片区宽度 */
    position: relative;
    min-height: 520px;
}
.auth-full-bg {
    position: absolute;
    top: 0;
    right: 0; /* 靠右显示 */
    width: 100%;
    height: 100%;
    padding: 0;
}
.bg-overlay {
    background: url(https://cdn.pixabay.com/photo/2021/05/24/11/56/lake-6278825_1280.jpg) no-repeat center center;
    background-size: cover;
    opacity: 1;
    height: 100%;
    width: 100%;
    transition: transform 7s ease;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
}
.col-xl-7.bglogo:hover .bg-overlay {
    transform: scale(1.05);
}
.auth-full-bg .d-flex {
    padding: 3rem;
}
.auth-full-bg h1.text-white {
    font-size: 1.8rem;
    margin-bottom: 0.8rem;
    animation: slideLeft 0.8s ease forwards;
    opacity: 0;
}
.auth-full-bg p.text-white-50 {
    font-size: 0.9rem;
    animation: slideLeft 0.8s ease 0.3s forwards;
    opacity: 0;
}

/* 左侧登录区域 - 白底突出 */
.col-xl-5 {
    width: 55%; /* 登录区宽度 */
    background-color: #ffffff; /* 白底 */
}
.auth-full-page-content {
    padding: 3.5rem;
    display: flex;
    align-items: center;
    min-height: 520px;
}
.login_right {
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
}

/* 输入框样式 - 突出显示 */
.form-control, .input-group-append, .btn {
    height: 50px;
    border-radius: 14px !important;
    transition: all 0.3s ease;
}
.form-control {
    border: 1px solid #e5e7eb;
    padding: 0 18px;
    background-color: #f9fafb; /* 输入框浅灰底突出 */
}
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    transform: translateY(-2px);
    background-color: #ffffff;
}

/* 标签页样式 */
.nav-tabs-custom .nav-link {
    border-radius: 14px !important;
    margin: 0 5px;
    padding: 8px 18px;
    color: #666;
}
.nav-tabs-custom .nav-link.active {
    background-color: #eff6ff;
    color: #2563eb;
    font-weight: 500;
    transform: translateY(-2px);
}
.nav-tabs {
    animation: fadeInUp 0.6s ease 0.3s forwards;
    opacity: 0;
}

/* 按钮样式 */
.btn-primary {
    background-color: #2563eb;
    border-color: #2563eb;
    height: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-align: center;
    z-index: 10;
}
.btn-primary:hover {
    background-color: #1d4ed8;
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.2);
}

/* 表单间距优化 */
.form-group {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    margin-bottom: 1.3rem;
}
.form-group:nth-child(1) { animation-delay: 0.2s; }
.form-group:nth-child(2) { animation-delay: 0.4s; }
.form-group:nth-child(3) { animation-delay: 0.6s; }

/* 动画效果定义 */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideLeft {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* 整体入场动画 */
.logo.text-center {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

/* 响应式调整 */
@media (max-width: 992px) {
    .col-xl-7.bglogo {
        width: 100%;
        min-height: 280px;
    }
    .col-xl-5 {
        width: 100%;
    }
    .auth-full-page-content {
        padding: 2.5rem;
    }
}

/* 手机端隐藏右侧图片 */
@media (max-width: 768px) {
    .col-xl-7.bglogo {
        display: none;
    }
    .row.no-gutters {
        flex-direction: row;
    }
    .col-xl-5 {
        width: 100%;
        border-radius: 24px !important;
    }
}
</style>

<div class="container-fluid p-0">
    <div class="row no-gutters">

        <!-- 右侧图片区域 -->
        <div class="col-xl-7 bglogo">
            <div class="auth-full-bg pt-lg-5 p-4">
                <div class="w-100">
                    <div class="bg-overlay"></div>
                    <div class="d-flex h-100 flex-column justify-content-center">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="text-center">
                                    <div dir="ltr">
                                        <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                            <div>
                                            <div>
                                                    <p class="text-white-50 text-left">
                                                        管理员后台系统提供强大的管理功能，助您高效管理网站</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 左侧登录区域 (白底) -->
        <div class="col-xl-5">
            <div class="auth-full-page-content p-md-5 p-4">
                <div class="login_right mx-auto">
                    <div class="d-flex flex-column h-100">
                        <div class="my-auto">
                            <div  class="logo text-center" >
                                <a href="#"><img  src="/assets/img/logo.png" alt="系统管理平台" class="cursor"></a>
                            </div>
                            <ul class="affs-nav nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <!-- 账号密码登录 -->
                                <li class="nav-item">
                                    <a class="nav-link fs-14 bg-transparent active" data-toggle="tab" href="#email" role="tab" aria-selected="true"><span class="fa fa-lock mr-1"></span> 账号密码</a>
                                </li>
                                <!-- 扫码登录 -->
                                <?php if($mode>1){
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link fs-14 bg-transparent" data-toggle="tab" href="#block-tabs-home" role="tab" aria-selected="false"><span class="fa fa-qrcode mr-1"></span> 扫码登录</a>
                                </li>
                                <?php }?>
                            </ul>

                            <div class="mt-4">
                                <div class="tab-content">
                                    <!-- 账号密码登录 -->
                                    <div id="email" class="tab-pane active" role="tabpanel">
                                        <form method="post" action="" onsubmit="return true;" >
                                            <div class="form-group">
                                                <label for="username">用户名</label>
                                                <input type="text" class="form-control" id="emailInp" name="user" value="" placeholder="请输入用户名">
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="userpassword">密码</label>
                                                    <a href="#myModal" class="text-primary mr-0" data-toggle="modal">忘记密码?</a>
                                                </div>
                                                <input type="password" class="form-control" id="emailPwdInp" name="pass" placeholder="请输入密码">
                                            </div>
                                            <?php if($verifycode==1){
                                            // [战神] 图片验证码
                                            ?>
                                            <div class="form-group" style="overflow:visible;">
                                                <label for="code">验证码</label>
                                                <div style="display: flex; align-items: center; width: 100%;">
                                                    <input type="text" class="form-control" id="code" name="code" placeholder="请输入验证码" style="flex: 1; margin-right: 10px;">
                                                    <img src="code.php?<?php echo time(); ?>" onclick="this.src='code.php?'+Math.random()" alt="验证码" style="width:120px;height:46px;cursor:pointer; flex-shrink: 0;">
                                                </div>
                                                <small class="form-text text-muted mt-1">点击图片可刷新</small>
                                            </div>
                                            <?php }?>
                                            <div class="mt-3">
                                                <button class="btn btn-primary py-2 fs-14 btn-block waves-effect waves-light" type="submit">登录</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- 扫码登录 -->
                                    <?php if($mode>1){
                                    ?>
                                    <div class="tab-pane fade" id="block-tabs-home">
                                        <div class="text-center mb-4">
                                            <div class="list-group text-center">
                                                <div class="list-group-item" style="font-weight: bold;" id="login">
                                                    <span id="loginmsg">请使用微信或QQ扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
                                                </div>
                                                <div class="list-group-item" id="qrimg" title="点击刷新二维码">
                                                </div>
                                                <div class="list-group-item" id="mobile" style="display:none;"><button type="button" id="mlogin" onclick="mloginurl()" class="btn btn-warning btn-block">跳转QQ快捷登录</button><br/><button type="button" onclick="qrlogin()" class="btn btn-success btn-block">我已完成登录</button><br/>
                                                    <span class="text-muted">提示：手机用户如需微信扫码，可截图保存二维码，在微信内扫一扫，从相册识别二维码。</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // [战神] 整合脚本
        // 页面加载完成后执行
        if(document.getElementById('qrimg')){
            getqrpic();
        }
        // 自动更新年份
        document.getElementById('year-copy').textContent = new Date().getFullYear();
    });
</script>
                    <footer class="text-muted text-center mt-5">
                        <small><span id="year-copy"></span> &copy; <a href="#" class="text-primary"><?php echo $conf['sitename']?></a> 版权所有</small>
                    </footer>

<!-- 从模板中提取的样式 -->
<!-- [战神] 已移除重复样式定义 -->

<!-- [战神] 已移除重复脚本 -->
<?php if($mode>1){?>
<script>var isbind = false;</script>
<script src="//cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="./assets/js/qrlogin.js"></script>
<?php }?>
</body>
</html>