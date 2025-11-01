<?php
if(!defined('IN_CRONLITE')) exit();

/**
 * 授权验证系统
 * 基于域名和授权码的验证
 */

// 授权API地址
define('AUTH_API_URL', API_URL . '/api/verify.php');

// 授权状态常量
define('AUTH_STATUS_SUCCESS', 'success');
define('AUTH_STATUS_TRIAL', 'trial');
define('AUTH_STATUS_ERROR', 'error');

// 授权缓存文件
define('AUTH_CACHE_FILE', ROOT . 'includes/cache/auth_cache.php');

// 调试模式（设置为true开启调试）
define('AUTH_DEBUG', false);

// 调试日志文件
define('AUTH_DEBUG_LOG', ROOT . 'includes/cache/auth_debug.log');

// 授权安全密钥，用于签名和加密（建议修改为随机字符串）
define('AUTH_SECURITY_KEY', md5(SYS_KEY . 'auth_security_key_' . $_SERVER['HTTP_HOST']));

/**
 * 记录调试信息
 */
function auth_debug_log($message, $data = null) {
    // 调试功能已禁用，此函数不执行任何操作
    return;
}

/**
 * 获取当前域名
 */
function get_auth_domain() {
    $domain = $_SERVER['HTTP_HOST'];
    // 去除端口号
    if(strpos($domain, ':') !== false) {
        $domain = explode(':', $domain)[0];
    }
    // 去除www前缀
    if(substr($domain, 0, 4) === 'www.') {
        $domain = substr($domain, 4);
    }
    return $domain;
}

/**
 * 从缓存中获取授权信息
 */
function get_auth_cache() {
    if(file_exists(AUTH_CACHE_FILE)) {
        $encrypted_content = @file_get_contents(AUTH_CACHE_FILE);
        if($encrypted_content) {
            // 解密数据
            $serialized_content = decrypt_auth_data($encrypted_content);
            if($serialized_content === false) {
                return false;
            }
            
            // 反序列化数据
            $cache_data = @unserialize($serialized_content);
            if($cache_data === false) {
                return false;
            }
            
            // 验证签名
            $signature = $cache_data['signature'];
            unset($cache_data['signature']);
            $expected_signature = md5(json_encode($cache_data) . AUTH_SECURITY_KEY);
            
            if($signature !== $expected_signature) {
                return false;
            }
            
            // 验证域名和IP
            $current_domain = get_auth_domain();
            $current_ip = x_real_ip();
            
            if($cache_data['domain'] !== $current_domain) {
                return false;
            }
            
            // 验证过期时间
            if($cache_data && isset($cache_data['expire_time']) && $cache_data['expire_time'] > time()) {
                return $cache_data['auth_data'];
            }
        }
    }
    
    return false;
}

/**
 * 保存授权信息到缓存
 */
function save_auth_cache($auth_data, $expire_time = 86400) {
    $cache_data = [
        'auth_data' => $auth_data,
        'expire_time' => time() + $expire_time,
        'domain' => get_auth_domain(),
        'ip' => x_real_ip(),
        'time' => time()
    ];
    
    // 生成签名
    $signature = md5(json_encode($cache_data) . AUTH_SECURITY_KEY);
    $cache_data['signature'] = $signature;
    
    // 序列化并加密数据
    $serialized_data = serialize($cache_data);
    $encrypted_data = encrypt_auth_data($serialized_data);
    
    // 确保缓存目录存在
    $cache_dir = dirname(AUTH_CACHE_FILE);
    if(!is_dir($cache_dir)) {
        mkdir($cache_dir, 0755, true);
    }
    
    // 写入缓存文件
    @file_put_contents(AUTH_CACHE_FILE, $encrypted_data);
}

/**
 * 加密授权数据
 */
function encrypt_auth_data($data) {
    // 生成随机IV
    $iv_size = openssl_cipher_iv_length('AES-256-CBC');
    $iv = openssl_random_pseudo_bytes($iv_size);
    
    // 加密数据
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', AUTH_SECURITY_KEY, 0, $iv);
    
    // 将IV和加密数据合并
    $result = base64_encode($iv . base64_decode($encrypted));
    
    return $result;
}

/**
 * 解密授权数据
 */
function decrypt_auth_data($encrypted_data) {
    try {
        // 解码数据
        $decoded = base64_decode($encrypted_data);
        if ($decoded === false) {
            return false;
        }
        
        // 提取IV
        $iv_size = openssl_cipher_iv_length('AES-256-CBC');
        if (strlen($decoded) <= $iv_size) {
            return false;
        }
        
        $iv = substr($decoded, 0, $iv_size);
        $encrypted = base64_encode(substr($decoded, $iv_size));
        
        // 解密数据
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', AUTH_SECURITY_KEY, 0, $iv);
        if ($decrypted === false) {
            return false;
        }
        
        return $decrypted;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * 清除授权缓存
 */
function clear_auth_cache() {
    if(file_exists(AUTH_CACHE_FILE)) {
        @unlink(AUTH_CACHE_FILE);
    }
}

/**
 * 发送授权验证请求
 */
function verify_auth($license_key = '', $debug_mode = false) {
    global $conf;
    
    $domain = get_auth_domain();
    $ip = x_real_ip();
    $params = [
        'domain' => $domain,
        'ip' => $ip,
        'time' => time(),
        'version' => isset($conf['version']) ? $conf['version'] : '1.0'
    ];
    
    // 调试模式已禁用
    $debug_info = [];
    
    if($license_key) {
        $params['license_key'] = $license_key;
    }
    
    // 构建请求URL
    $query = http_build_query($params);
    $url = AUTH_API_URL . '?' . $query;
    
    // 发送请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'AuthClient/1.0');
    
    $response = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    if($response) {
        $result = json_decode($response, true);
        if($result && isset($result['status'])) {
            return $result;
        }
    }
    
    // 请求失败，返回错误信息
    $error_data = [
        'status' => AUTH_STATUS_ERROR,
        'message' => '无法连接到授权服务器'
    ];
    
    return $error_data;
}

/**
 * 检查授权状态
 */
function check_auth() {
    // 先从缓存获取授权信息
    $auth_data = get_auth_cache();
    
    if(!$auth_data) {
        // 缓存不存在或已过期，重新验证
        $auth_data = verify_auth();
        
        // 如果验证成功，缓存授权信息
        if($auth_data['status'] == AUTH_STATUS_SUCCESS) {
            save_auth_cache($auth_data);
        }
    }
    
    return $auth_data;
}

/**
 * 获取调试日志内容
 */
function get_auth_debug_log($lines = 50) {
    return "调试功能已禁用";
}

/**
 * 验证授权并处理结果
 */
function validate_auth() {
    $auth_data = check_auth();
    
    // 添加额外的安全检查
    if($auth_data && $auth_data['status'] == AUTH_STATUS_SUCCESS) {
        // 验证授权域名是否匹配当前域名
        $current_domain = get_auth_domain();
        if(isset($auth_data['domain']) && $auth_data['domain'] != $current_domain) {
            $auth_data = [
                'status' => AUTH_STATUS_ERROR,
                'message' => '授权域名不匹配，请联系官方获取正确的授权'
            ];
        }
        
        // 检查授权是否过期
        if(isset($auth_data['expires_at']) && $auth_data['expires_at'] !== 0 && $auth_data['expires_at'] !== '0') {
            $is_expired = false;
            
            if(is_numeric($auth_data['expires_at'])) {
                // 时间戳格式
                $is_expired = $auth_data['expires_at'] < time();
            } else {
                // 日期字符串格式
                $expires_timestamp = strtotime($auth_data['expires_at']);
                if($expires_timestamp !== false) {
                    $is_expired = $expires_timestamp < time();
                }
            }
            
            // 如果授权已过期，修改状态
            if($is_expired) {
                $auth_data = [
                    'status' => AUTH_STATUS_ERROR,
                    'message' => '您的授权已过期，请联系官方进行续费',
                    'is_expired' => true
                ];
            }
        }
    }
    
    // 如果是成功状态，检查是否是试用模式
    if($auth_data['status'] == AUTH_STATUS_SUCCESS) {
        if(isset($auth_data['license_status']) && $auth_data['license_status'] == AUTH_STATUS_TRIAL) {
            // 试用模式，可以继续使用，但会显示水印或其他限制
            return true;
        }
        // 正式授权，可以正常使用
        return true;
    }
    
    // 授权验证失败，重定向到授权管理页面
    $error_message = isset($auth_data['message']) ? $auth_data['message'] : '授权验证失败';
    
    // 获取当前脚本名称
    $current_script = basename($_SERVER['SCRIPT_NAME']);
    
    // 如果当前不是授权管理页面，则重定向到授权管理页面
    if($current_script != 'set_auth.php') {
        header('Location: ./set_auth.php?error=' . urlencode($error_message));
        exit;
    }
    
    // 如果已经在授权管理页面，则不做重定向，让页面正常显示
    return false;
}

// 不再自动执行授权验证，而是在需要的地方手动调用
// validate_auth(); 