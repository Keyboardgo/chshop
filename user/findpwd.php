<?php
/**
 * 找回密码 - 美化版
 * 博客地址: zhonguo.ren
 * QQ群: 915043052
**/
$is_defend=true;
include("../includes/common.php");
if(isset($_GET['act']) && $_GET['act']=='qrlogin'){
	if(isset($_SESSION['findpwd_qq']) && $qq=$_SESSION['findpwd_qq']){
		$row=$DB->getRow("SELECT zid,user,pwd,status FROM pre_site WHERE qq=:qq LIMIT 1", [':qq'=>$qq]);
		unset($_SESSION['findpwd_qq']);
		if($row['user']){
			if($row['status']==0){
				exit('{"code":-1,"msg":"当前账号已被封禁！"}');
			}
			$session=md5($row['user'].$row['pwd'].$password_hash);
			$token=authcode("{$row['zid']}\t{$session}", 'ENCODE', SYS_KEY);
			setcookie("user_token", $token, time() + 604800, '/');
			log_result('分站找回密码', 'User:'.$row['user'].' IP:'.$clientip, null, 1);
			$DB->exec("UPDATE pre_site SET lasttime='$date' WHERE zid='{$row['zid']}'");
			exit('{"code":1,"msg":"登录成功，请在用户资料设置里重置密码","url":"./"}');
		}else{
			@header('Content-Type: application/json; charset=UTF-8');
			exit('{"code":-1,"msg":"当前QQ不存在，请确认你已注册过账号或开通过分站"}');
		}
	}else{
		@header('Content-Type: application/json; charset=UTF-8');
			exit('{"code":-2,"msg":"验证失败，请重新扫码"}');
	}
}elseif($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
$title='找回密码';
include './head2.php';
?>
<link rel="stylesheet" href="../assets/css/login-styles.css">
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
        <div class="login-form-container">
        <div class="heading">找回密码</div>
        <div class="form">
            <div style="text-align: center; margin: 20px 0;">
                <div style="font-weight: bold; color: #666; margin-bottom: 20px;">
                    <span id="loginmsg">请使用QQ手机版扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
                </div>
                <div id="qrimg" style="margin: 20px 0;">
                </div>
                <button type="button" onclick="qrlogin()" class="login-button">我已完成登录</button>
            </div>
            
            <?php if($conf['login_qq']==1){?>
            <div style="margin: 20px 0; padding: 15px; background-color: #f0f9ff; border-radius: 10px; font-size: 12px; color: #666;">
                提示：只能找回注册时填写了QQ号码的帐号密码，QQ快捷登录的暂不支持该方式找回密码。
            </div>
            <?php }?>
            
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <a href="login.php" class="forgot-password" style="text-decoration: none;">返回登录</a>
                <a href="reg.php" class="forgot-password" style="text-decoration: none;">注册用户</a>
            </div>
        </div>
        </div>
    </div>
</div>
<script src="<?php echo $cdnpublic?>jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo $cdnpublic?>twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/js/qrlogin.js?ver=<?php echo VERSION ?>"></script>
</body>
</html>