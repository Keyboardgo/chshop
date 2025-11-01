<?php

error_reporting(0);
if (defined('IN_CRONLITE')) {
	return;
}
define('CACHE_FILE', 0);
define('IN_CRONLITE', true);
define('tingdong', '3530793519');
define('SYSTEM_ROOT', dirname(__FILE__) . '/');
define('ROOT', dirname(SYSTEM_ROOT) . '/');
define('TEMPLATE_ROOT', ROOT . 'template/');
define('PLUGIN_ROOT', ROOT . 'includes/plugins/');

date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");
include_once SYSTEM_ROOT . 'base.php';
@header('Cache-Control: no-store, no-cache, must-revalidate');
@header('Pragma: no-cache');
// 优化Session配置
ini_set('session.gc_maxlifetime', 259200); // 3天
ini_set('session.cookie_lifetime', 259200); // 3天
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
session_start();
include_once SYSTEM_ROOT . "autoloader.php";
Autoloader::register();
if ($is_defend == true || CC_Defender == 3) {
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		include_once SYSTEM_ROOT . 'txprotect.php';
	}
	if (CC_Defender == 1 && check_spider() == false) {
	}
	if (CC_Defender == 1 && check_spider() == false || CC_Defender == 3) {
		cc_defender();
	}
}
$scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $sitepath . '/';
if (is_file(SYSTEM_ROOT . '360safe/360webscan.php')) {
	require_once SYSTEM_ROOT . '360safe/360webscan.php';
}
require_once SYSTEM_ROOT . '360safe/xss.php';
require ROOT . 'config.php';
define('DBQZ', $dbconfig['dbqz']);
if (!defined('SQLITE') && !$dbconfig['user'] || !$dbconfig['pwd'] || !$dbconfig['dbname']) {
	header('Content-type:text/html;charset=utf-8');
	echo '<style>body{margin:0;padding:0;height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;}a.install-btn{display:inline-block;padding:12px 30px;background-color:#12b7f5;color:white;text-decoration:none;border-radius:6px;font-size:18px;transition:all 0.3s ease;margin-bottom:20px;}a.install-btn:hover{background-color:#0a96d8;transform:translateY(-2px);box-shadow:0 4px 12px rgba(18,183,245,0.3);}.tips{color:#666;font-size:14px;line-height:1.8;text-align:center;width:80%;max-width:600px;}/* 手机端适配 */@media (max-width: 768px){body{padding:0 20px;}.install-btn{width:100%;max-width:300px;text-align:center;padding:15px 0;font-size:20px;margin-bottom:25px;}.tips{width:100%;font-size:16px;line-height:1.8;padding:0 10px;}}</style><body><a href="/install/" class="install-btn">立即安装</a><div class="tips">1. 如果是在安装好的情况下弹出，那么就是你的MySQL数据库没开启，去宝塔软件商城开启即可<br>2. MySQL数据库有开启但是还是弹出这个提示，就是你数据库配置账号密码和源码内的配置文件不一样<br>3. 数据库配置文件位置：config.php，请确保该文件有正确的读写权限<br>4. 请确保数据库用户拥有创建表和读写数据的完整权限<br>5. 检查数据库是否已经成功创建，可通过宝塔数据库管理查看<br>6. 如需重新安装，请确保删除原有数据库中的所有表，避免表结构冲突</div></body>';
	exit;
}
try {
	$DB = new \lib\PdoHelper($dbconfig);
	if ($DB->query("select * from pre_config where 1") == FALSE) {
		header('Content-type:text/html;charset=utf-8');
		echo '<style>body{margin:0;padding:0;height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;}a.install-btn{display:inline-block;padding:12px 30px;background-color:#12b7f5;color:white;text-decoration:none;border-radius:6px;font-size:18px;transition:all 0.3s ease;margin-bottom:20px;}a.install-btn:hover{background-color:#0a96d8;transform:translateY(-2px);box-shadow:0 4px 12px rgba(18,183,245,0.3);}.tips{color:#666;font-size:14px;line-height:1.8;text-align:center;width:80%;max-width:600px;}/* 手机端适配 */@media (max-width: 768px){body{padding:0 20px;}.install-btn{width:100%;max-width:300px;text-align:center;padding:15px 0;font-size:20px;margin-bottom:25px;}.tips{width:100%;font-size:16px;line-height:1.8;padding:0 10px;}}</style><body><a href="/install/" class="install-btn">立即安装</a><div class="tips">1. 如果是在安装好的情况下弹出，那么就是你的MySQL数据库没开启，去宝塔软件商城开启即可<br>2. MySQL数据库有开启但是还是弹出这个提示，就是你数据库配置账号密码和源码内的配置文件不一样<br>3. 数据库配置文件位置：config.php，请确保该文件有正确的读写权限<br>4. 请确保数据库用户拥有创建表和读写数据的完整权限<br>5. 检查数据库是否已经成功创建，可通过宝塔数据库管理查看<br>6. 如需重新安装，请确保删除原有数据库中的所有表，避免表结构冲突</div></body>';
		exit;
	}
} catch (\Exception $e) {
	header('Content-type:text/html;charset=utf-8');
	echo '<style>body{margin:0;padding:0;height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;}a.install-btn{display:inline-block;padding:12px 30px;background-color:#12b7f5;color:white;text-decoration:none;border-radius:6px;font-size:18px;transition:all 0.3s ease;margin-bottom:20px;}a.install-btn:hover{background-color:#0a96d8;transform:translateY(-2px);box-shadow:0 4px 12px rgba(18,183,245,0.3);}.tips{color:#666;font-size:14px;line-height:1.8;text-align:center;width:80%;max-width:600px;}/* 手机端适配 */@media (max-width: 768px){body{padding:0 20px;}.install-btn{width:100%;max-width:300px;text-align:center;padding:15px 0;font-size:20px;margin-bottom:25px;}.tips{width:100%;font-size:16px;line-height:1.8;padding:0 10px;}}</style><body><a href="/install/" class="install-btn">立即安装</a><div class="tips">1. 如果是在安装好的情况下弹出，那么就是你的MySQL数据库没开启，去宝塔软件商城开启即可<br>2. MySQL数据库有开启但是还是弹出这个提示，就是你数据库配置账号密码和源码内的配置文件不一样<br>3. 数据库配置文件位置：config.php，请确保该文件有正确的读写权限<br>4. 请确保数据库用户拥有创建表和读写数据的完整权限<br>5. 检查数据库是否已经成功创建，可通过宝塔数据库管理查看<br>6. 如需重新安装，请确保删除原有数据库中的所有表，避免表结构冲突</div></body>';
	exit;
}
$CACHE = new \lib\Cache();
$conf = $CACHE->pre_fetch();
define('SYS_KEY', $conf['syskey']);

if ($conf['qqjump'] == 1 && (!strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/') === false || !strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false)) {
	if ($_GET['open'] == 1 && !strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) {
		header('Content-Disposition: attachment; filename="load.doc"');
		header('Content-Type: application/vnd.ms-word;charset=utf-8');
	} else {
		header('Content-type:text/html;charset=utf-8');
	}
	include ROOT . 'template/default/jump.php';
	exit(0);
}
$password_hash = '!@#%!s!0';
include_once SYSTEM_ROOT . "function.php";
include_once SYSTEM_ROOT . "core.func.php";
include_once SYSTEM_ROOT . "ajax.func.php";
include_once SYSTEM_ROOT . "member.php";

if (!file_exists(ROOT . 'install/install.lock') && file_exists(ROOT . 'install/index.php')) {
	sysmsg('<h2>检测到无 install.lock 文件</h2><ul><li><font size="4">如果您尚未安装本程序，请<a href="/install/">前往安装</a></font></li><li><font size="4">如果您已经安装本程序，请手动放置一个空的 install.lock 文件到 /install 文件夹下，<b>为了您站点安全，在您完成它之前我们不会工作。</b></font></li></ul><br/><h4>为什么必须建立 install.lock 文件？</h4>它是安装保护文件，如果检测不到它，就会认为站点还没安装，此时任何人都可以安装/重装你的网站。<br/><br/>');
	exit;
}

$cookiesid = $_COOKIE['mysid'];
if (!$cookiesid || !preg_match('/^[0-9a-z]{32}$/i', $cookiesid)) {
	$cookiesid = md5(uniqid(mt_rand(), 1) . time());
	setcookie('mysid', $cookiesid, time() + 604800, '/');
}
if (isset($_COOKIE['invite'])) {
	$invite_id = intval($_COOKIE['invite']);
}
$domain = addslashes($_SERVER['HTTP_HOST']);
$siterow = $DB->getRow("SELECT * FROM pre_site WHERE domain=:domain OR domain2=:domain LIMIT 1", array(':domain' => $domain));
if ($siterow && $siterow['status'] == 1) {
	$is_fenzhan = true;
	if ($siterow['template'] == NULL || $conf['fenzhan_template'] == 0) {
		$siterow['template'] = $conf['template'];
	}
	$conf = array_merge($conf, $siterow);
	$conf['kfqq'] = $conf['qq'];
} else {
	$is_fenzhan = false;
}

function x_real_ip()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all("#\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}#s", $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] as $xip) {
			if (!preg_match("#^(10|172\\.16|192\\.168)\\.#", $xip)) {
				$ip = $xip;
			}
		}
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	} elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match("/^([0-9]{1,3}\\.){3}[0-9]{1,3}\$/", $_SERVER['HTTP_X_REAL_IP'])) {
		$ip = $_SERVER['HTTP_X_REAL_IP'];
	}
	return $ip;
}

function check_spider()
{
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if (strpos($useragent, 'baiduspider') !== false) {
		return 'baiduspider';
	}
	if (strpos($useragent, 'googlebot') !== false) {
		return 'googlebot';
	}
	if (strpos($useragent, '360spider') !== false) {
		return '360spider';
	}
	if (strpos($useragent, 'soso') !== false) {
		return 'soso';
	}
	if (strpos($useragent, 'bing') !== false) {
		return 'bing';
	}
	if (strpos($useragent, 'yahoo') !== false) {
		return 'yahoo';
	}
	if (strpos($useragent, 'sohu-search') !== false) {
		return 'Sohubot';
	}
	if (strpos($useragent, 'sogou') !== false) {
		return 'sogou';
	}
	if (strpos($useragent, 'youdaobot') !== false) {
		return 'YoudaoBot';
	}
	if (strpos($useragent, 'robozilla') !== false) {
		return 'Robozilla';
	}
	if (strpos($useragent, 'msnbot') !== false) {
		return 'msnbot';
	}
	if (strpos($useragent, 'lycos') !== false) {
		return 'Lycos';
	}
	if (!strpos($useragent, 'ia_archiver') === false) {
	} elseif (!strpos($useragent, 'iaarchiver') === false) {
		return 'alexa';
	}
	if (strpos($useragent, 'archive.org_bot') !== false) {
		return 'Archive';
	}
	if (strpos($useragent, 'sitebot') !== false) {
		return 'SiteBot';
	}
	if (strpos($useragent, 'gosospider') !== false) {
		return 'gosospider';
	}
	if (strpos($useragent, 'gigabot') !== false) {
		return 'Gigabot';
	}
	if (strpos($useragent, 'yrspider') !== false) {
		return 'YRSpider';
	}
	if (strpos($useragent, 'gigabot') !== false) {
		return 'Gigabot';
	}
	if (strpos($useragent, 'wangidspider') !== false) {
		return 'WangIDSpider';
	}
	if (strpos($useragent, 'foxspider') !== false) {
		return 'FoxSpider';
	}
	if (strpos($useragent, 'docomo') !== false) {
		return 'DoCoMo';
	}
	if (strpos($useragent, 'yandexbot') !== false) {
		return 'YandexBot';
	}
	if (strpos($useragent, 'sinaweibobot') !== false) {
		return 'SinaWeiboBot';
	}
	if (strpos($useragent, 'catchbot') !== false) {
		return 'CatchBot';
	}
	if (strpos($useragent, 'surveybot') !== false) {
		return 'SurveyBot';
	}
	if (strpos($useragent, 'dotbot') !== false) {
		return 'DotBot';
	}
	if (strpos($useragent, 'purebot') !== false) {
		return 'Purebot';
	}
	if (strpos($useragent, 'ccbot') !== false) {
		return 'CCBot';
	}
	if (strpos($useragent, 'mlbot') !== false) {
		return 'MLBot';
	}
	if (strpos($useragent, 'adsbot-google') !== false) {
		return 'AdsBot-Google';
	}
	if (strpos($useragent, 'ahrefsbot') !== false) {
		return 'AhrefsBot';
	}
	if (strpos($useragent, 'spbot') !== false) {
		return 'spbot';
	}
	if (strpos($useragent, 'augustbot') !== false) {
		return 'AugustBot';
	}
	return false;
}

function cc_defender()
{
	$iptoken = md5(x_real_ip() . date('Ymd')) . md5(time() . rand(11111, 99999));
	if (!isset($_COOKIE['sec_defend']) || substr($_COOKIE['sec_defend'], 0, 32) !== substr($iptoken, 0, 32)) {
		if (!$_COOKIE['sec_defend_time']) {
			$_COOKIE['sec_defend_time'] = 0;
		}
		$x = new \lib\hieroglyphy();
		$setCookie = $x->hieroglyphyString($iptoken);
		$sec_defend_time = $_COOKIE['sec_defend_time'] + 1;
		header('Content-type:text/html;charset=utf-8');
		if ($sec_defend_time >= 10) {
			exit('浏览器不支持COOKIE或者不正常访问！');
		}
		echo '<html><head><meta http-equiv="pragma" content="no-cache"><meta http-equiv="cache-control" content="no-cache"><meta http-equiv="content-type" content="text/html;charset=utf-8"><title>正在加载中</title><script>function setCookie(name,value){var exp = new Date();exp.setTime(exp.getTime() + 60*60*1000);document.cookie = name + "="+ escape (value).replace(/\\+/g, \'%2B\') + ";expires=" + exp.toGMTString() + ";path=/";}function getCookie(name){var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");if(arr=document.cookie.match(reg))return unescape(arr[2]);else return null;}var sec_defend_time=getCookie(\'sec_defend_time\')||0;sec_defend_time++;setCookie(\'sec_defend\',' . $setCookie . ');setCookie(\'sec_defend_time\',sec_defend_time);if(sec_defend_time>1)window.location.href="./index.php";else window.location.reload();</script></head><body></body></html>';
		exit(0);
	} else {
		if (isset($_COOKIE['sec_defend_time'])) {
			setcookie('sec_defend_time', '', time() - 604800, '/');
		}
	}
}

function copydirs($source, $dest)
{
	if (!is_dir($dest)) {
		mkdir($dest, 0755, true);
	}
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
	foreach ($iterator as $item) {
		if ($item->isDir()) {
			$sent_dir = $dest . "/" . $iterator->getSubPathName();
			if (!is_dir($sent_dir)) {
				mkdir($sent_dir, 0755, true);
			}
		} else {
			copy($item, $dest . "/" . $iterator->getSubPathName());
		}
	}
}

function rmdirs($dir, $rmself = true)
{
	if (!is_dir($dir)) {
		return false;
	}
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
	foreach ($files as $file) {
		$todo = $file->isDir() ? 'rmdir' : 'unlink';
		$todo($file->getRealPath());
	}
	if ($rmself) {
		@rmdir($dir);
	}
	return true;
}


define('API_URL', 'https://sq.coolcy.net');

// 防墙引导页功能检测
if($conf['wall_guide_open'] == 1 && empty($_COOKIE['wall_guide_skip'])) {
    $is_system_file = strpos($_SERVER['PHP_SELF'], 'admin/') !== false || strpos($_SERVER['PHP_SELF'], 'install/') !== false || strpos($_SERVER['PHP_SELF'], 'api/') !== false || strpos($_SERVER['PHP_SELF'], 'cron.php') !== false;
    if(!$is_system_file) {
        include TEMPLATE_ROOT . 'wall_guide.php';
        exit;
    }
}

// 引入授权验证文件
if(!strpos($_SERVER['PHP_SELF'], 'install/') && !strpos($_SERVER['PHP_SELF'], 'api/') && !strpos($_SERVER['PHP_SELF'], 'cron.php')) {
    include_once SYSTEM_ROOT . 'auth.php';
}