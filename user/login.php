<?php
/**
 * 登录页面 - 美化版
 * 博客地址: zhonguo.ren
 * QQ群: 915043052
**/
$is_defend=true;
include("../includes/common.php");
if(isset($_GET['logout'])){
	if(!checkRefererHost())exit();
	setcookie("user_token", "", time() - 604800, '/');
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
$title='用户登录';
include './head2.php';
?>
<link rel="stylesheet" href="../assets/css/login-styles.css">
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
        <div class="login-form-container">
        <div class="heading">用户登录</div>
        <form class="form">
            <input type="text" class="input" name="user" placeholder="用户名" required="required">
            <input type="password" class="input" name="pass" placeholder="密码" required="required">
            
            <?php if($conf['captcha_open_login']==1 && $conf['captcha_open']>=1){?>
            <input type="hidden" name="captcha_type" value="<?php echo $conf['captcha_open']?>"/>
            <?php if($conf['captcha_open']>=2){?><input type="hidden" name="appid" value="<?php echo $conf['captcha_id']?>"/><?php }?>
            <div id="captcha" style="margin: auto;"><div id="captcha_text">
                正在加载验证码
            </div>
            <div id="captcha_wait">
                <div class="loading">
                    <div class="loading-dot"></div>
                    <div class="loading-dot"></div>
                    <div class="loading-dot"></div>
                    <div class="loading-dot"></div>
                </div>
            </div></div>
            <div id="captchaform"></div>
            <br/>
            <?php }?>
            
            <button type="button" id="submit_login" class="login-button">立即登录</button>
            
            <div class="forgot-password">
                <a href="findpwd.php">找回密码?</a>
            </div>
            
            <?php if($conf['login_qq']>=1 || $conf['login_wx']>=1){?>
            <div class="social-account-container">
                <div class="title">社交账号登录</div>
                <div class="social-accounts">
                    <?php if($conf['login_qq']>=1){?>
                    <a href="javascript:connect('qq')" class="social-button">
                        <svg class="svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M17.858 17.034c-.234.363-1.807 2.87-1.807 2.87-.164.26-.546.258-.707 0 0 0-1.572-2.508-1.808-2.872a.96.96 0 01-.256-.696v-4.938c0-.433.35-.783.784-.783h1.16c.435 0 .783.35.783.783v4.204c0 .16.054.316.15.45.096.136.23.22.385.248zm-4.605-3.68a.602.602 0 01-.603-.603c0-.333.27-.604.603-.604a.603.603 0 010 1.207zm-2.79 0a.602.602 0 01-.602-.603c0-.333.27-.604.602-.604a.603.603 0 010 1.207zM12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm-1.287 17.676c-.495.474-1.792 1.726-1.792 1.726-.25.24-.712.24-.96 0 0 0-1.298-1.252-1.792-1.726a1.636 1.636 0 01-.466-1.17v-5.334a1.632 1.632 0 01.466-1.169c.495-.475 1.793-1.726 1.793-1.726.248-.24.708-.24.96 0 0 0 1.297 1.251 1.792 1.726a1.63 1.63 0 01.466 1.17v5.333a1.633 1.633 0 01-.466 1.17zM12 5.4c-3.66 0-6.6 2.94-6.6 6.6s2.94 6.6 6.6 6.6 6.6-2.94 6.6-6.6-2.94-6.6-6.6-6.6zm5.67 10.91c0 1.568-1.27 2.84-2.83 2.84s-2.83-1.272-2.83-2.84c0-1.567 1.27-2.838 2.83-2.838s2.83 1.271 2.83 2.838z"/>
                        </svg>
                    </a>
                    <?php }?>
                    <?php if($conf['login_wx']>=1){?>
                    <a href="javascript:connect('wx')" class="social-button">
                        <svg class="svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm2.845 17.399c-.194.376-.612.636-1.08.636h-.49c-.08 0-.16-.01-.24-.02a10.37 10.37 0 01-4.15 0c-.08.01-.16.02-.24.02h-.49c-.468 0-.886-.26-.937-.636-.463-2.802.033-5.018 1.697-7.084 1.674-2.079 4.048-3.64 6.66-3.64 2.61 0 4.985 1.561 6.658 3.64 1.665 2.066 2.161 4.282 1.698 7.084-.05.376-.47.636-.936.636h-.49c-.08 0-.16-.01-.24-.02a10.37 10.37 0 01-4.15 0c-.08.01-.16.02-.24.02h-.49zm-.669-2.508c.867 0 1.612-.137 2.23-.412-.077-.23-.594-.388-.942-.44-.35-.053-1.282-.037-1.288-.037h-.003c-.006 0-.936-.016-1.287.037-.349.052-.865.21-.942.44.618.275 1.363.412 2.23.412zm0-1.628c-.867 0-1.613.137-2.23.412.077.23.595.388.942.44.35.053 1.283.037 1.288.037h.003c.006 0 .936.016 1.287-.037.349-.052.865-.21.942-.44-.617-.275-1.363-.412-2.23-.412zM12 12.64c-.77 0-1.395.625-1.395 1.394s.625 1.395 1.395 1.395c.769 0 1.394-.626 1.394-1.395s-.625-1.394-1.394-1.394zm0-1.627c-1.767 0-3.2 1.433-3.2 3.2s1.433 3.2 3.2 3.2 3.2-1.433 3.2-3.2-1.433-3.2-3.2-3.2z"/>
                        </svg>
                    </a>
                    <?php }?>
                </div>
            </div>
            <?php }?>
            
            <div class="agreement">
                还没有账号? <a href="<?php echo $conf['user_open']==1 ? 'reg.php' : 'regsite.php';?>">立即注册</a>
                <a href="../" style="margin-left: 10px;">返回首页</a>
            </div>
        </form>
        </div>
    </div>
</div>
<script src="<?php echo $cdnpublic?>jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo $cdnpublic?>twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo $cdnpublic?>layer/2.3/layer.js"></script>
<script src="../assets/js/login.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>