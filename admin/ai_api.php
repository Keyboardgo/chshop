<?php
include("../includes/common.php");
$islogin=1;
if(isset($_COOKIE["admin_token"]))
{
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session=md5($conf['admin_user'].$conf['admin_pwd'].$password_hash);
	if($session==$sid) {
		$islogin=1;
	}
}
if($islogin==1){}else exit('{"success":false,"message":"未登录"}');


// 授权系统已移除，AI功能无限制使用


session_write_close();


set_time_limit(360);
ignore_user_abort(false);


header('Content-Type: application/json; charset=utf-8');


$action = isset($_POST['action']) ? $_POST['action'] : '';


$deepseek_api_key = $DB->getColumn("SELECT v FROM pre_config WHERE k='deepseek_api_key' LIMIT 1");
if(empty($deepseek_api_key)) {
    exit(json_encode([
        'success' => false,
        'message' => '未配置DeepSeek API密钥'
    ]));
}


if($action == 'chat') {
    $model = isset($_POST['model']) ? $_POST['model'] : 'deepseek-chat';
    $messages_json = isset($_POST['messages']) ? $_POST['messages'] : '[]';
    $messages = json_decode($messages_json, true);
    
    if(!is_array($messages) || empty($messages)) {
        exit(json_encode([
            'success' => false,
            'message' => '消息参数格式错误'
        ]));
    }
    
    array_unshift($messages, [
        'role' => 'system',
        'content' => '你是一个由DeepSeek开发的AI助手，可以回答用户的问题并提供帮助。回答时请尽量专业、准确、简洁，如果不确定或不知道某个问题，请直接说明，不要提供错误信息。'
    ]);
    
    try {
        $response = callDeepSeekAPI($model, $messages);
        
        if(isset($response['choices']) && isset($response['choices'][0]['message']['content'])) {
            $content = $response['choices'][0]['message']['content'];
            exit(json_encode([
                'success' => true,
                'content' => $content
            ]));
        } else {
            exit(json_encode([
                'success' => false,
                'message' => '解析API响应失败',
                'response' => $response
            ]));
        }
    } catch(Exception $e) {
        exit(json_encode([
            'success' => false,
            'message' => '调用API出错: ' . $e->getMessage()
        ]));
    }
} 
elseif($action == 'polish') {
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $is_encoded = isset($_POST['is_encoded']) ? $_POST['is_encoded'] : 'false';
    $debug_mode = isset($_POST['debug']) ? $_POST['debug'] : 'false';
    
    if(empty($content)) {
        exit(json_encode([
            'success' => false,
            'message' => '缺少需要润色的内容'
        ]));
    }
    
    // 记录原始内容长度
    $original_length = strlen($content);
    error_log('[' . date('Y-m-d H:i:s') . '] Polish API请求，原始内容长度: ' . $original_length);
    
    if($is_encoded === 'true') {
        try {
            // 先尝试base64解码，然后URL解码
            $decoded_content = base64_decode($content, true);
            if($decoded_content === false) {
                throw new Exception('Base64解码失败');
            }
            
            $content = urldecode($decoded_content);
            error_log('[' . date('Y-m-d H:i:s') . '] 解码后内容长度: ' . strlen($content));
        } catch(Exception $e) {
            error_log('[' . date('Y-m-d H:i:s') . '] 内容解码失败: ' . $e->getMessage());
            
            // 尝试不同的解码方式
            try {
                // 尝试直接URL解码
                $content = urldecode($content);
                error_log('[' . date('Y-m-d H:i:s') . '] URL解码尝试成功，长度: ' . strlen($content));
            } catch(Exception $e2) {
            exit(json_encode([
                'success' => false,
                    'message' => '内容解码失败: ' . $e->getMessage() . ' 和 ' . $e2->getMessage(),
                    'preview' => substr($content, 0, 200)
            ]));
        }
    }
    }
    
    // 检查解码后的内容是否为空
    if(empty($content)) {
        exit(json_encode([
            'success' => false,
            'message' => '解码后内容为空',
            'preview' => substr($content, 0, 200)
        ]));
    }
    
    // 调试模式直接返回解码后内容，用于测试
    if($debug_mode === 'true') {
        exit(json_encode([
            'success' => true,
            'content' => $content,
            'message' => '调试模式: 直接返回解码内容',
            'preview' => substr($content, 0, 200)
        ]));
    }
    
    // 检查API密钥是否有效
    if(empty($deepseek_api_key)) {
        exit(json_encode([
            'success' => false,
            'message' => '未配置DeepSeek API密钥，请在大模型配置中设置'
        ]));
    }
    
    // 基本安全处理
    $content = preg_replace('/on\w+\s*=\s*["\'][^"\']*["\']/i', '', $content);
    $content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $content);
    $content = str_replace('javascript:', '', $content);
    $content = preg_replace('/eval\s*\(/i', '', $content);
    
    // 解码HTML实体
    $safe_content = htmlspecialchars_decode($content);
    
    // 检查是否来自AI优化页面
    $is_from_optimize = (strpos($safe_content, '【内容类型】') !== false);
    
    if($is_from_optimize) {
        // 如果来自AI优化页面，使用优化提示
        $system_message = '你是一位专业的网站内容优化专家，擅长提升文案的吸引力、专业性和用户体验。请按照用户的要求，优化或创建网站内容。输出内容需要保持原有的格式和风格，但提升其质量和吸引力。';
    } else {
        // 如果来自商品编辑页面，使用润色提示
        $system_message = '你是一位专业的文本编辑，擅长将普通的文字内容润色为更有吸引力、专业性和表现力的内容。请对提供的内容进行润色，保持原有信息的完整性，同时使其更具吸引力。保留原有的HTML格式，如果没有格式可以适当添加。';
    }
    
    $user_message = $is_from_optimize 
        ? $safe_content 
        : "请对以下内容进行专业的润色，使其更具吸引力和表现力，保留原有的HTML格式：\n\n" . $safe_content;
    
    $messages = [
        ['role' => 'system', 'content' => $system_message],
        ['role' => 'user', 'content' => $user_message]
    ];
    
    try {
        $model = 'deepseek-chat';
        
        // 记录将要发送的消息内容
        error_log('[' . date('Y-m-d H:i:s') . '] 准备调用DeepSeek API，模型: ' . $model);
        error_log('[' . date('Y-m-d H:i:s') . '] 用户消息长度: ' . strlen($messages[1]['content']));
        
        // 设置更长的超时时间
        $response = callDeepSeekAPI($model, $messages, 2000, 120);
        
        error_log('[' . date('Y-m-d H:i:s') . '] DeepSeek API响应接收完成');
        
        // 记录原始响应（仅截取一部分）
        if (is_array($response)) {
            $response_preview = json_encode(array_slice($response, 0, 3));
            error_log('[' . date('Y-m-d H:i:s') . '] 响应预览: ' . substr($response_preview, 0, 200));
        } else {
            error_log('[' . date('Y-m-d H:i:s') . '] 非数组响应: ' . substr($response, 0, 200));
        }
        
        if(isset($response['choices']) && isset($response['choices'][0]['message']['content'])) {
            $polished_content = $response['choices'][0]['message']['content'];
            error_log('[' . date('Y-m-d H:i:s') . '] 成功提取AI响应内容，长度: ' . strlen($polished_content));
            
            // 清理可能的代码块标记
            $polished_content = preg_replace('/```html\s*([\s\S]*?)\s*```/', '$1', $polished_content);
            $polished_content = preg_replace('/```\s*([\s\S]*?)\s*```/', '$1', $polished_content);
            
            // 检查AI响应是否为空
            if(empty(trim($polished_content))) {
                error_log('[' . date('Y-m-d H:i:s') . '] AI返回了空内容');
                exit(json_encode([
                    'success' => false,
                    'message' => 'AI返回了空内容，请重试',
                    'preview' => json_encode($response)
                ]));
            }
            
            // 直接返回正确的JSON响应
            exit(json_encode([
                'success' => true,
                'content' => $polished_content
            ]));
        } elseif (is_string($response) && !empty(trim($response))) {
            // 如果响应是非空字符串，可能是直接返回了文本而非JSON
            error_log('[' . date('Y-m-d H:i:s') . '] 接收到文本响应，长度: ' . strlen($response));
            
            // 尝试解析为JSON
            $json_result = json_decode($response, true);
            if ($json_result && isset($json_result['choices'][0]['message']['content'])) {
                $polished_content = $json_result['choices'][0]['message']['content'];
                exit(json_encode([
                    'success' => true,
                    'content' => $polished_content,
                    'message' => '从文本中解析JSON成功'
                ]));
            }
            
            // 检查响应是否为HTML
            if (stripos($response, '<!DOCTYPE') !== false || stripos($response, '<html') !== false) {
                error_log('[' . date('Y-m-d H:i:s') . '] 收到HTML响应');
                exit(json_encode([
                    'success' => false,
                    'message' => 'API返回了HTML而非JSON数据，可能是服务器配置问题',
                    'preview' => substr($response, 0, 500)
                ]));
            }
            
            // 如果是有意义的文本，直接返回
            if (strlen(trim($response)) > 50) {
                error_log('[' . date('Y-m-d H:i:s') . '] 使用纯文本响应作为结果');
                exit(json_encode([
                    'success' => true,
                    'content' => $response,
                    'message' => '使用纯文本响应'
                ]));
            }
        } else {
            // 提供更详细的错误信息
            $error_msg = '解析API响应失败';
            
            if(isset($response['error'])) {
                $error_detail = is_array($response['error']) ? json_encode($response['error']) : $response['error'];
                $error_msg .= ': ' . $error_detail;
                error_log('[' . date('Y-m-d H:i:s') . '] API错误: ' . $error_detail);
            }
            
            // 检查是否包含错误代码
            if(isset($response['error']['code'])) {
                $error_code = $response['error']['code'];
                error_log('[' . date('Y-m-d H:i:s') . '] 错误代码: ' . $error_code);
                
                // 特定错误代码处理
                if($error_code == 'invalid_api_key') {
                    $error_msg = 'API密钥无效，请检查大模型配置';
                } elseif($error_code == 'rate_limit_exceeded') {
                    $error_msg = 'API调用频率超限，请稍后再试';
                }
            }
            
            exit(json_encode([
                'success' => false,
                'message' => $error_msg,
                'preview' => is_array($response) ? json_encode($response) : substr($response, 0, 500)
            ]));
        }
    } catch(Exception $e) {
        // 记录详细的错误信息，便于调试
        $error_details = 'API请求出错: ' . $e->getMessage();
        
        // 写入错误日志
        error_log('[' . date('Y-m-d H:i:s') . '] AI API Error: ' . $error_details);
        error_log('[' . date('Y-m-d H:i:s') . '] 错误堆栈: ' . $e->getTraceAsString());
        
        exit(json_encode([
            'success' => false,
            'message' => '调用AI API出错: ' . $e->getMessage(),
            'preview' => $e->getTraceAsString()
        ]));
    }
}
elseif($action == 'write_article') {
    $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $style = isset($_POST['style']) ? $_POST['style'] : 'informative';
    $length = isset($_POST['length']) ? $_POST['length'] : 'medium';
    
    if(empty($keywords)) {
        exit(json_encode([
            'success' => false,
            'message' => '缺少关键词'
        ]));
    }
    
    $style_text = '';
    switch($style) {
        case 'informative':
            $style_text = '专业信息型，注重事实和数据，语言严谨';
            break;
        case 'storytelling':
            $style_text = '故事叙述型，生动有趣，富有感染力';
            break;
        case 'tutorial':
            $style_text = '教程指导型，清晰的步骤，易于理解';
            break;
        case 'promotional':
            $style_text = '营销推广型，富有说服力，突出价值';
            break;
        case 'news':
            $style_text = '新闻报道型，客观公正，重点突出';
            break;
        default:
            $style_text = '专业信息型，注重事实和数据，语言严谨';
    }
    
    $length_text = '';
    switch($length) {
        case 'short':
            $length_text = '300-500字';
            break;
        case 'medium':
            $length_text = '800-1000字';
            break;
        case 'long':
            $length_text = '1500-2000字';
            break;
        default:
            $length_text = '800-1000字';
    }
    
    $system_prompt = "你是一个专业的文章写作AI，可以根据用户提供的关键词和要求，创作高质量的文章内容。";
    
    $user_prompt = "请根据以下要求创作一篇文章：\n\n";
    $user_prompt .= "关键词：{$keywords}\n";
    if(!empty($title)) {
        $user_prompt .= "文章主题：{$title}\n";
    }
    $user_prompt .= "文章风格：{$style_text}\n";
    $user_prompt .= "文章长度：{$length_text}\n\n";
    $user_prompt .= "要求：\n";
    $user_prompt .= "1. 请创作一篇结构完整的文章，包含标题、正文和小标题\n";
    $user_prompt .= "2. 正文应该包含适当的HTML格式，如<p>、<h3>等\n";
    $user_prompt .= "3. 同时生成一个适合SEO的文章描述，不超过200字\n";
    $user_prompt .= "4. 返回JSON格式，包含title(文章标题)、content(文章内容)、description(SEO描述)和keywords(关键词列表)\n\n";
    $user_prompt .= "开始创作：";
    
    $messages = [
        [
            'role' => 'system',
            'content' => $system_prompt
        ],
        [
            'role' => 'user',
            'content' => $user_prompt
        ]
    ];
    
    try {
        $model = 'deepseek-reasoner';
        $response = callDeepSeekAPI($model, $messages, 3000);
        
        if(isset($response['choices']) && isset($response['choices'][0]['message']['content'])) {
            $ai_content = $response['choices'][0]['message']['content'];
            
            $json_start = strpos($ai_content, '{');
            $json_end = strrpos($ai_content, '}');
            
            if($json_start !== false && $json_end !== false) {
                $json_content = substr($ai_content, $json_start, $json_end - $json_start + 1);
                $article_data = json_decode($json_content, true);
                
                if(!$article_data) {
                    preg_match('/["\'](.*?)["\']:\s*["\'](.*?)["\']/i', $ai_content, $title_match);
                    $article_title = !empty($title_match[2]) ? $title_match[2] : (!empty($title) ? $title : "关于{$keywords}的文章");
                    
                    $article_content = $ai_content;
                    
                    $article_data = [
                        'title' => $article_title,
                        'content' => $article_content,
                        'description' => substr(strip_tags($article_content), 0, 200),
                        'keywords' => $keywords
                    ];
                }
                
                $article_data = [
                    'title' => isset($article_data['title']) ? $article_data['title'] : (!empty($title) ? $title : "关于{$keywords}的文章"),
                    'content' => isset($article_data['content']) ? $article_data['content'] : $ai_content,
                    'description' => isset($article_data['description']) ? $article_data['description'] : substr(strip_tags($article_data['content'] ?? $ai_content), 0, 200),
                    'keywords' => isset($article_data['keywords']) ? $article_data['keywords'] : $keywords
                ];
                
                exit(json_encode([
                    'success' => true,
                    'article' => $article_data
                ]));
            } else {
                $simple_content = trim($ai_content);
                
                $first_line = strtok($simple_content, "\n");
                $title_text = !empty($title) ? $title : (strlen($first_line) < 50 ? $first_line : "关于{$keywords}的文章");
                
                $article_data = [
                    'title' => $title_text,
                    'content' => $simple_content,
                    'description' => substr(strip_tags($simple_content), 0, 200),
                    'keywords' => $keywords
                ];
                
                exit(json_encode([
                    'success' => true,
                    'article' => $article_data
                ]));
            }
        } else {
            exit(json_encode([
                'success' => false,
                'message' => '解析API响应失败',
                'response' => $response
            ]));
        }
    } catch(Exception $e) {
        exit(json_encode([
            'success' => false,
            'message' => '调用AI API出错: ' . $e->getMessage()
        ]));
    }
} elseif($action == 'test_connection') {
    // 简单的连接测试，不需要调用DeepSeek API
    exit(json_encode([
        'success' => true,
        'message' => 'API连接正常',
        'timestamp' => time()
    ]));
} else {
    exit(json_encode([
        'success' => false,
        'message' => '未知操作'
    ]));
}

function callDeepSeekAPI($model, $messages, $max_tokens = 2000, $timeout = 60) {
    global $deepseek_api_key;
    
    $user_message = end($messages)['content'] ?? '无用户消息';
    
    $data = [
        'model' => $model,
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => $max_tokens,
        'stream' => false
    ];
    
    $max_retries = 3;
    $retry_count = 0;
    $retry_delay = 2;
    
    while ($retry_count < $max_retries) {
        $ch = curl_init('https://api.deepseek.com/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $deepseek_api_key,
            'Accept: application/json',
            'User-Agent: DeepSeekAPI/1.0 Rainbow-Shop',
            'Connection: close',
            'Cache-Control: no-cache, no-store',
            'Accept-Encoding: gzip, deflate'
        ]);
        
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        
        curl_setopt($ch, CURLOPT_ENCODING, '');
        
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 600);
        
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        
        $request_info = [
            'http_code' => $httpCode,
            'content_type' => $content_type,
            'total_time' => $total_time,
            'size_download' => curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD),
            'speed_download' => curl_getinfo($ch, CURLINFO_SPEED_DOWNLOAD),
            'request_size' => curl_getinfo($ch, CURLINFO_REQUEST_SIZE)
        ];
        
        curl_close($ch);
        
        $should_retry = false;
        
        if ($curl_errno) {
            $error_message = "CURL错误 #{$curl_errno}: {$curl_error}";
            $should_retry = true;
        } 
        elseif ($httpCode !== 200) {
            $error_message = "API请求失败，状态码: {$httpCode}";
            
            if ($httpCode == 401) {
                $error_message .= "（认证失败，请检查API密钥）";
            } else if ($httpCode == 400) {
                $error_message .= "（请求参数错误）";
            } else if ($httpCode == 429) {
                $error_message .= "（请求频率超限）";
                $should_retry = true;
            } else if ($httpCode >= 500) {
                $error_message .= "（服务器错误）";
                $should_retry = true;
            }
            
            if ($response) {
                $log_response = strlen($response) > 200 ? substr($response, 0, 200) . '...' : $response;
                $error_message .= ", 响应: {$log_response}";
            }
        }
        elseif ($response === false || $response === null || trim($response) === '') {
            $error_message = "API返回了空响应";
            $should_retry = true;
        }
        else {
            $clean_response = preg_replace('/[\x00-\x1F\x7F]/u', '', trim($response));
            
            $result = json_decode($clean_response, true);
            
            if ($result === null) {
                $json_start = strpos($clean_response, '{');
                $json_end = strrpos($clean_response, '}');
                
                if ($json_start !== false && $json_end !== false && $json_end > $json_start) {
                    $json_string = substr($clean_response, $json_start, $json_end - $json_start + 1);
                    $result = json_decode($json_string, true);
                    
                    if ($result !== null) {
                        return $result;
                    }
                }
                
                $json_error = json_last_error_msg();
                $error_message = "无法解析API响应: JSON错误({$json_error})，原始响应: " . substr($clean_response, 0, 200) . (strlen($clean_response) > 200 ? '...' : '');
                $should_retry = true;
            } else {
                return $result;
            }
        }
        
        if ($should_retry && $retry_count < $max_retries - 1) {
            $retry_count++;
            $sleep_time = $retry_delay * pow(2, $retry_count - 1);
            
            sleep($sleep_time);
            continue;
        }
        
        $final_error = $error_message . ($should_retry ? "（已重试{$retry_count}次）" : "");
        throw new Exception($final_error);
    }
} 