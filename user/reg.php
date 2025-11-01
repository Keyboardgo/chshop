<?php
/**
 * 注册页面 - 美化版
 * 博客地址: zhonguo.ren
 * QQ群: 915043052
**/
$is_defend=true;
include("../includes/common.php");
if($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
if(!$conf['user_open'] && $conf['fenzhan_buy']==1){
	exit("<script language='javascript'>window.location.href='./regsite.php';</script>");
}elseif(!$conf['user_open']){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('未开放新用户注册');window.location.href='./';</script>");
}
$title='用户注册';
include './head2.php';

$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
$x = new \lib\hieroglyphy();
$addsalt_js = $x->hieroglyphyString($addsalt);
?>
<link rel="stylesheet" href="../assets/css/login-styles.css">
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
        <div class="login-form-container">
        <div class="heading">新用户注册</div>
        <form class="form">
            <input type="hidden" name="captcha_type" value="<?php echo $conf['captcha_open']?>"/>
            <input type="text" class="input" name="user" placeholder="输入登录用户名" required="required">
            <input type="password" class="input" name="pwd" placeholder="输入6位以上密码" required="required">
            <input type="text" class="input" name="qq" placeholder="输入QQ号，用于找回密码" required="required">
            
            <?php if($conf['captcha_open']>=1){?>
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
            <?php }else{?>
            <div style="display: flex; gap: 10px; align-items: center;">
                <input type="text" class="input" name="code" placeholder="输入验证码" required="required" style="flex: 1;">
                <img id="codeimg" src="./code.php?r=<?php echo time();?>" height="43" onclick="this.src='./code.php?r='+Math.random();" title="点击更换验证码" style="border-radius: 10px; cursor: pointer;">
            </div>
            <br/>
            <?php }?>
            
            <button type="button" id="submit_reg" class="login-button">立即注册</button>
            
            <div class="agreement">
                已有账号? <a href="login.php">返回登录</a>
                <a href="../" style="margin-left: 10px;">返回首页</a>
            </div>
        </form>
        </div>
    </div>
</div>
<script src="<?php echo $cdnpublic?>jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo $cdnpublic?>twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo $cdnpublic?>layer/2.3/layer.js"></script>
<script>
var hashsalt=<?php echo $addsalt_js?>;
</script>
<input type="hidden" name="hashsalt" value="<?php echo $addsalt?>" />
<script src="../assets/js/reguser.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>