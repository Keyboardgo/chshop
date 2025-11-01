<?php
// 前台客服AJAX接口
include("../includes/common.php");
include("../includes/chat_auto_reply.php");
@header('Content-Type: application/json; charset=UTF-8');

$act = isset($_GET['act']) ? $_GET['act'] : null;
$user_ip = real_ip();
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

function getSessionId($DB, $user_ip, $user_agent) {
    $row = $DB->getRow("SELECT * FROM shua_chat_session WHERE user_ip=? AND status=1 ORDER BY id DESC LIMIT 1", [$user_ip]);
    if($row) return $row['id'];
    // 自动创建新会话
    $DB->exec("INSERT INTO shua_chat_session (user_ip, user_agent, status, last_msg_time, create_time) VALUES (?,?,?,?,NOW())", [$user_ip, $user_agent, 1, date('Y-m-d H:i:s')]);
    return $DB->lastInsertId();
}

switch($act){
    case 'get':
        // 获取会话和消息
        $session_id = getSessionId($DB, $user_ip, $user_agent);
        $messages = $DB->getAll("SELECT * FROM shua_chat_message WHERE session_id=? ORDER BY id ASC LIMIT 100", [$session_id]);
        $data = [];
        foreach($messages as $msg){
            $data[] = [
                'id' => $msg['id'],
                'sender' => $msg['sender'],
                'content' => $msg['content'],
                'type' => $msg['type'],
                'create_time' => $msg['create_time']
            ];
        }
        exit(json_encode(['code'=>0,'session_id'=>$session_id,'data'=>$data]));
        break;
    case 'send':
        // 发送消息（支持图片）
        $session_id = getSessionId($DB, $user_ip, $user_agent);
        
        // 防刷屏功能实现
        $chat_anti_spam_enable = $conf['chat_anti_spam_enable'] ?? 1;
        if($chat_anti_spam_enable == 1){
            // 自动检查表是否存在，不存在则创建
            try {
                $prefix = $conf['prefix'] ?? 'shua_';
                $table_name = "{$prefix}chat_ban";
                
                // 检查表是否存在
                $stmt = $DB->query("SHOW TABLES LIKE '$table_name'");
                $table_exists = $stmt->rowCount() > 0;
                
                if (!$table_exists) {
                    // 创建表
                    $sql = "CREATE TABLE $table_name (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        user_ip VARCHAR(50) NOT NULL,
                        user_agent VARCHAR(255) NULL,
                        session_id VARCHAR(50) NOT NULL,
                        ban_time INT NOT NULL,
                        ban_end_time DATETIME NOT NULL,
                        create_time DATETIME NOT NULL
                    )";
                    
                    $DB->exec($sql);
                }
            } catch (Exception $e) {
                // 表创建失败不影响程序运行，但可以记录日志
                // error_log('Failed to create chat ban table: ' . $e->getMessage());
            }
            // 检查用户是否被封禁
            $ban_info = $DB->getRow("SELECT * FROM shua_chat_ban WHERE user_ip=? AND ban_end_time>NOW() LIMIT 1", [$user_ip]);
            if($ban_info){
                // 计算剩余封禁时间
                $ban_end = strtotime($ban_info['ban_end_time']);
                $now = time();
                $remaining = $ban_end - $now;
                $remaining_text = '';
                if($remaining < 60){
                    $remaining_text = "{$remaining}秒";
                }elseif($remaining < 3600){
                    $remaining_text = floor($remaining/60)."分钟";
                }else{
                    $remaining_text = floor($remaining/3600)."小时";
                }
                exit(json_encode(['code'=>-7,'msg'=>'您已被禁言，剩余时间：{$remaining_text}']));
            }
            
            // 检查一分钟内发送的消息数量
            $max_messages = $conf['chat_max_messages'] ?? 10;
            $one_minute_ago = date('Y-m-d H:i:s', time() - 60);
            $msg_count = $DB->getColumn("SELECT COUNT(*) FROM shua_chat_message WHERE session_id=? AND sender='user' AND create_time>?", [$session_id, $one_minute_ago]);
            
            if($msg_count >= $max_messages){
                // 获取用户的违规次数
                $violations = $DB->getColumn("SELECT COUNT(*) FROM shua_chat_ban WHERE user_ip=?", [$user_ip]);
                
                // 设置封禁时长
                if($violations >= 1){
                    // 二次违规，封禁一天
                    $ban_time = $conf['chat_second_ban_time'] ?? 24;
                    $ban_end_time = date('Y-m-d H:i:s', time() + ($ban_time * 3600));
                    $ban_msg = "由于您在短时间内发送消息过多（二次违规），已被禁言{$ban_time}小时";
                }else{
                    // 首次违规，封禁3分钟
                    $ban_time = $conf['chat_first_ban_time'] ?? 3;
                    $ban_end_time = date('Y-m-d H:i:s', time() + ($ban_time * 60));
                    $ban_msg = "由于您在短时间内发送消息过多，已被禁言{$ban_time}分钟";
                }
                
                // 记录封禁信息
                $DB->exec("INSERT INTO shua_chat_ban (user_ip, user_agent, session_id, ban_time, ban_end_time, create_time) VALUES (?,?,?,?,?,NOW())", 
                          [$user_ip, $user_agent, $session_id, $ban_time, $ban_end_time]);
                
                // 清除用户的刷屏消息（只保留最早的几条）
                $keep_count = 5; // 保留的消息数量
                $delete_ids = $DB->getCol("SELECT id FROM shua_chat_message WHERE session_id=? AND sender='user' AND create_time>? ORDER BY id DESC LIMIT ?", 
                                         [$session_id, $one_minute_ago, $msg_count - $keep_count]);
                if(!empty($delete_ids)){
                    $DB->exec("DELETE FROM shua_chat_message WHERE id IN (".implode(',', $delete_ids).")");
                }
                
                exit(json_encode(['code'=>-7,'msg'=>$ban_msg]));
            }
        }
        $content = trim($_POST['content'] ?? '');
        $type = 0;
        if(isset($_FILES['image']) && $_FILES['image']['size']>0){
            // 获取图片上传限制配置
            $chat_image_limit_enable = $conf['chat_image_limit_enable'] ?? 1;
            $chat_image_max_size = ($conf['chat_image_max_size'] ?? 2048) * 1024; // 转换为字节
            $chat_image_formats = strtolower($conf['chat_image_formats'] ?? 'jpg,jpeg,png,gif');
            $allowed_formats = array_map('trim', explode(',', $chat_image_formats));
            
            // 获取文件信息
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $file_size = $_FILES['image']['size'];
            
            // 如果开启了图片上传限制，则进行检查
            if($chat_image_limit_enable == 1){
                // 检查图片大小
                if($file_size > $chat_image_max_size){
                    exit(json_encode(['code'=>-5,'msg'=>'图片大小超过限制，请上传小于'.($chat_image_max_size/1024).'KB的图片']));
                }
                
                // 检查图片格式
                if(!in_array($ext, $allowed_formats)){
                    exit(json_encode(['code'=>-6,'msg'=>'不支持的图片格式，请上传'.implode(',', $allowed_formats).'格式的图片']));
                }
            }
            
            $filename = 'chat_'.date('YmdHis').'_'.rand(1000,9999).'.'.$ext;
            $filepath = ROOT.'assets/img/chat/'.$filename;
            if(!is_dir(ROOT.'assets/img/chat/')) mkdir(ROOT.'assets/img/chat/',0777,true);
            if(move_uploaded_file($_FILES['image']['tmp_name'], $filepath)){
                $content = '/assets/img/chat/'.$filename;
                $type = 1;
            }else{
                exit(json_encode(['code'=>-1,'msg'=>'图片上传失败']));
            }
        }
        if(empty($content)) exit(json_encode(['code'=>-1,'msg'=>'消息内容不能为空']));
        
        // 违禁词检查（仅对文本消息进行检查）
        if($type == 0 && checkProhibitedWords($content)) {
            exit(json_encode(['code'=>-3,'msg'=>getProhibitedMessage()]));
        }
        $result = $DB->exec("INSERT INTO shua_chat_message (session_id,sender,content,type,create_time) VALUES (?,?,?,?,NOW())", [$session_id,'user',$content,$type]);
        if($result === false) exit(json_encode(['code'=>-2,'msg'=>'数据库写入失败:'.print_r($DB->error(),true)]));
        $DB->exec("UPDATE shua_chat_session SET last_msg_time=NOW(), status=1 WHERE id=?", [$session_id]);
        
        // 自动回复处理
        $auto_reply = getAutoReply($content);
        if($auto_reply) {
            $DB->exec("INSERT INTO shua_chat_message (session_id,sender,content,type,create_time) VALUES (?,?,?,?,NOW())", [$session_id,'admin',$auto_reply['reply'],0]);
            $DB->exec("UPDATE shua_chat_session SET last_msg_time=NOW() WHERE id=?", [$session_id]);
            exit(json_encode(['code'=>0,'msg'=>'发送成功','auto_reply'=>$auto_reply]));
        }
        
        exit(json_encode(['code'=>0,'msg'=>'发送成功']));
        break;
    default:
        exit(json_encode(['code'=>-4,'msg'=>'No Act']));
}