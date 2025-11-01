<?php
/**
 * 调试自助下单页面
**/
include("../includes/common.php");

echo "=== 调试信息 ===<br>";
echo "islogin2: " . (isset($islogin2) ? $islogin2 : '未定义') . "<br>";
echo "userrow: " . (isset($userrow) ? '已定义' : '未定义') . "<br>";
echo "conf: " . (isset($conf) ? '已定义' : '未定义') . "<br>";
echo "DB: " . (isset($DB) ? '已定义' : '未定义') . "<br>";

if(isset($islogin2) && $islogin2 == 1) {
    echo "用户已登录<br>";
    
    // 测试Template::loadRoute()
    echo "<br>=== Template::loadRoute() 测试 ===<br>";
    $template_route = \lib\Template::loadRoute();
    echo "template_route: " . ($template_route ? '存在' : '不存在') . "<br>";
    
    if($template_route) {
        echo "template_route['userindex']: " . (isset($template_route['userindex']) ? $template_route['userindex'] : '不存在') . "<br>";
        echo "template_route['userhead']: " . (isset($template_route['userhead']) ? $template_route['userhead'] : '不存在') . "<br>";
        echo "template_route['userfoot']: " . (isset($template_route['userfoot']) ? $template_route['userfoot'] : '不存在') . "<br>";
    }
    
    // 测试checkIfActive函数
    echo "<br>=== checkIfActive() 测试 ===<br>";
    $check_result = checkIfActive(',index');
    echo "checkIfActive(',index'): " . $check_result . "<br>";
    
    // 测试重定向条件
    if($template_route && isset($template_route['userindex']) && $template_route['userindex'] && $check_result == 'active') {
        echo "<span style='color:red;'>⚠️ 会触发重定向！</span><br>";
        echo "条件: template_route['userindex']存在 且 checkIfActive(',index')返回'active'<br>";
    } else {
        echo "<span style='color:green;'>✅ 不会触发重定向</span><br>";
    }
    
    // 测试包含文件
    echo "<br>=== 包含文件测试 ===<br>";
    echo "测试包含 template/default/shop.inc.php<br>";
    $usershop = true;
    if(!isset($siterow)) {
        $siterow = array('class' => '');
    }
    if(!isset($is_fenzhan)) {
        $is_fenzhan = false;
    }
    
    ob_start();
    include TEMPLATE_ROOT . 'default/shop.inc.php';
    $content = ob_get_clean();
    
    echo "包含文件成功，内容长度: " . strlen($content) . "<br>";
    echo "内容预览: " . substr($content, 0, 200) . "...<br>";
} else {
    echo "用户未登录，会跳转到登录页面<br>";
}
?> 