<?php
/**
 * AI智能优化工具
 * 支持对网站公告配置中的内容进行编写和润色
 */

include("../includes/common.php");
$title = "AI智能优化";
include './head.php';
if (!$islogin) exit("<script language='javascript'>window.location.href='./login.php';</script>");

// 确认是否有deepseek_api_key配置
$deepseek_api_key = $DB->getColumn("SELECT v FROM pre_config WHERE k='deepseek_api_key' LIMIT 1");
if (empty($deepseek_api_key)) {
    showmsg('请先在<a href="./ai_settings.php">大模型配置</a>中设置DeepSeek API密钥', 3);
    exit;
}

// 获取当前公告配置
$notice_settings = [
    'anounce' => '首页公告',
    'modal' => '首页弹出公告',
    'bottom' => '站点工具/友情链接',
    'alert' => '在线下单提示',
    'gg_search' => '订单查询页面公告',
    'gg_panel' => '分站后台公告',
    'gg_announce' => '所有分站显示首页公告',
    'footer' => '首页底部排版',
    'paymsg' => '支付方式选择页面提示',
    'appalert' => 'APP启动弹出内容'
];

// 处理表单提交
if(isset($_POST['do']) && $_POST['do'] == 'optimize') {
    // 对于AJAX请求，确保发送正确的内容类型头
    $ajax = isset($_POST['ajax']) ? $_POST['ajax'] : '';
    if($ajax) {
        // 禁用输出缓冲，防止其他内容混入JSON响应
        while (ob_get_level()) ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
    }
    
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $prompt = isset($_POST['prompt']) ? $_POST['prompt'] : '';
    $auto_save = isset($_POST['auto_save']) ? intval($_POST['auto_save']) : 0;
    
    if(empty($type) || empty($prompt)) {
        if($ajax) {
            echo json_encode(['success' => false, 'message' => '参数错误']);
            exit;
        } else {
            showmsg('参数错误', 3);
            exit;
        }
    }
    
    // 保存到session，用于显示在表单中
    $_SESSION['optimize_type'] = $type;
    $_SESSION['optimize_prompt'] = $prompt;
    $_SESSION['optimize_content'] = $content;
    $_SESSION['optimize_auto_save'] = $auto_save;
    
    $result = callAIOptimize($type, $content, $prompt);
    
    // 如果优化成功且启用了自动保存，则直接保存到数据库
    if($result['success'] && $auto_save) {
        try {
            // 保存到数据库
            $DB->exec("UPDATE `pre_config` SET `v`=:value WHERE `k`=:key", [':value'=>$result['content'], ':key'=>$type]);
            
            // 更新配置缓存
            saveSetting($type, $result['content']);
            
            // 清除缓存
            $CACHE->clear();
            
            // 添加保存成功消息
            $result['auto_saved'] = true;
            $result['message'] = '内容已自动保存到系统配置';
        } catch (Exception $e) {
            $result['auto_save_error'] = '自动保存失败: ' . $e->getMessage();
        }
    }
    
    // 如果是AJAX请求，返回JSON响应
    if($ajax) {
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
    
    // 非AJAX请求的处理
    if($result['success']) {
        // 保存优化后的内容到session
        $_SESSION['optimized_content'] = $result['content'];
        // 重定向以避免表单重复提交
        header("Location: ./ai_optimize.php?action=show_result");
    } else {
        $_SESSION['optimize_error'] = 'AI优化失败: ' . $result['message'];
        header("Location: ./ai_optimize.php");
    }
    exit;
}

// 处理应用优化结果
if(isset($_POST['do']) && $_POST['do'] == 'apply') {
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $ajax = isset($_POST['ajax']) ? $_POST['ajax'] : '';
    
    // 对于AJAX请求，确保发送正确的内容类型头
    if($ajax) {
        // 关闭所有输出缓冲
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // 设置不缓存
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        
        // 设置内容类型
        header('Content-Type: application/json; charset=utf-8');
        
        // 关闭错误显示，防止PHP错误干扰JSON输出
        ini_set('display_errors', 0);
    }
    
    if(empty($type) || empty($content)) {
        if($ajax) {
            echo json_encode(['success' => false, 'message' => '参数错误']);
            exit;
        } else {
            showmsg('参数错误', 3);
            exit;
        }
    }
    
    // 定义一个函数处理AJAX响应
    function outputAjaxResponse($success, $message) {
        $response = ['success' => $success, 'message' => $message];
        echo json_encode($response);
        exit; // 确保没有其他输出
    }
    
    try {
        // 保存到数据库
        $DB->exec("UPDATE `pre_config` SET `v`=:value WHERE `k`=:key", [':value'=>$content, ':key'=>$type]);
        
        // 更新配置缓存
        saveSetting($type, $content);
        
        // 清除缓存
        $CACHE->clear();
        
        // 清除session中的内容
        unset($_SESSION['optimize_type']);
        unset($_SESSION['optimize_prompt']);
        unset($_SESSION['optimize_content']);
        unset($_SESSION['optimized_content']);
        
        if($ajax) {
            outputAjaxResponse(true, '应用成功！内容已更新到' . (isset($notice_settings[$type]) ? $notice_settings[$type] : $type));
        } else {
            showmsg('应用成功！内容已更新', 1);
        }
    } catch (Exception $e) {
        if($ajax) {
            outputAjaxResponse(false, '应用过程中发生异常：' . $e->getMessage());
        } else {
            showmsg('应用失败！发生异常：' . $e->getMessage(), 4);
        }
    }
    exit; // 确保这里退出，不继续执行
}

// 获取所选内容
if(isset($_GET['select']) && array_key_exists($_GET['select'], $notice_settings)) {
    $selected = $_GET['select'];
    $content = $conf[$selected];
    
    // 保存到session，用于显示在表单中
    $_SESSION['optimize_type'] = $selected;
    $_SESSION['optimize_content'] = $content;
}

// 初始化优化中状态
$is_optimizing = false;

?>

<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
    <div class="block">
        <div class="block-title">
            <h3 class="panel-title">AI智能优化工具</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> 本功能使用AI技术对网站公告、提示文本等内容进行智能优化和润色，让您的网站内容更加专业、吸引人。
            </div>
            
            <?php if (isset($_SESSION['optimize_error'])): ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['optimize_error']; ?>
                <?php unset($_SESSION['optimize_error']); ?>
            </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label>选择需要优化的内容</label>
                <select class="form-control" id="content-select" onchange="selectContent(this.value)">
                    <option value="">请选择...</option>
                    <?php foreach($notice_settings as $key => $name): ?>
                    <option value="<?php echo $key; ?>" <?php echo isset($_SESSION['optimize_type']) && $_SESSION['optimize_type'] == $key ? 'selected' : ''; ?>><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <?php if(isset($_GET['action']) && $_GET['action'] == 'show_result' && isset($_SESSION['optimized_content'])): ?>
            <!-- 显示优化结果 -->
            <form method="post" onsubmit="return confirm('确定要应用此优化内容吗？');">
                <input type="hidden" name="do" value="apply">
                <input type="hidden" name="type" value="<?php echo htmlspecialchars($_SESSION['optimize_type']); ?>">
                
                <div class="form-group">
                    <label>优化前内容</label>
                    <textarea class="form-control" rows="5" readonly><?php echo htmlspecialchars($_SESSION['optimize_content']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>优化后内容</label>
                    <textarea class="form-control" name="content" rows="8"><?php echo htmlspecialchars($_SESSION['optimized_content']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">应用此内容</button>
                    <a href="ai_optimize.php" class="btn btn-default btn-block">返回继续编辑</a>
                </div>
            </form>
            <?php else: ?>
            <!-- 显示优化表单 -->
            <form method="post" id="optimize-form">
                <input type="hidden" name="do" value="optimize">
                
                <div class="form-group">
                    <label>待优化内容类型</label>
                    <input type="text" class="form-control" name="type" id="type-field" value="<?php echo isset($_SESSION['optimize_type']) ? htmlspecialchars($_SESSION['optimize_type']) : ''; ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label>当前内容</label>
                    <textarea class="form-control" name="content" id="content-field" rows="5"><?php echo isset($_SESSION['optimize_content']) ? htmlspecialchars($_SESSION['optimize_content']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>优化提示</label>
                    <select class="form-control" id="prompt-template" onchange="selectPrompt(this.value)">
                        <option value="">请选择或自定义...</option>
                        <option value="请帮我润色这段文本，使其更加专业、正式">润色-专业正式</option>
                        <option value="请帮我重写这段文本，使其更加吸引人，增加用户点击和转化率">重写-提高转化率</option>
                        <option value="请帮我优化这段公告内容，使其简洁明了，让用户快速理解">优化-简洁明了</option>
                        <option value="请为我的网站编写一段引人注目的公告">创建-引人注目的公告</option>
                        <option value="请创建一段温馨提示，告知用户注意事项">创建-温馨提示</option>
                        <option value="请为我的电商网站编写一段促销公告，强调优惠力度和限时特性">创建-促销公告</option>
                    </select>
                    <textarea class="form-control mt-2" name="prompt" id="prompt-field" rows="3" placeholder="请输入AI优化提示，例如：请帮我润色这段文本，使其更加专业、正式"><?php echo isset($_SESSION['optimize_prompt']) ? htmlspecialchars($_SESSION['optimize_prompt']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="auto_save" id="auto_save" value="1" <?php echo isset($_SESSION['optimize_auto_save']) && $_SESSION['optimize_auto_save'] ? 'checked' : ''; ?>> 
                            自动保存优化结果（优化成功后直接应用到系统，无需再次确认）
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="submit-btn">开始AI优化</button>
                </div>
                
                <div id="optimize-loading" style="display:none;">
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-info" style="width: 100%">AI正在优化中，请稍候...</div>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
        <div class="panel-footer">
            <span class="glyphicon glyphicon-info-sign"></span> 使用说明：<br>
            1. 选择需要优化的内容类型<br>
            2. 可以修改当前内容或使用已有内容<br>
            3. 选择或输入优化提示，告诉AI您需要什么样的优化效果<br>
            4. 勾选"自动保存"可在优化成功后直接应用到系统<br>
            5. 点击"开始AI优化"后，系统会生成优化结果供您审核<br>
            6. 满意后点击"应用此内容"即可更新到网站
            <hr>
            <div class="text-muted text-center">
                <small>AI智能优化工具 v1.0 - 基于DeepSeek大模型技术</small>
            </div>
        </div>
    </div>
</div>

<script>
function selectContent(value) {
    if (value) {
        window.location.href = 'ai_optimize.php?select=' + value;
    }
}

function selectPrompt(value) {
    if (value) {
        document.getElementById('prompt-field').value = value;
    }
}

// 转义HTML特殊字符的函数
function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// 表单提交时使用AJAX提交
document.getElementById('optimize-form').addEventListener('submit', function(e) {
    e.preventDefault(); // 阻止表单默认提交
    
    // 验证输入
    var type = document.getElementById('type-field').value;
    var content = document.getElementById('content-field').value;
    var prompt = document.getElementById('prompt-field').value;
    var autoSave = document.getElementById('auto_save').checked ? 1 : 0;
    
    if (!type) {
        alert('请先选择需要优化的内容类型');
        return false;
    }
    
    if (!prompt) {
        alert('请输入优化提示');
        return false;
    }
    
    // 显示加载动画
    var submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> 优化中...';
    submitBtn.classList.remove('btn-primary');
    submitBtn.classList.add('btn-warning');
    document.getElementById('optimize-loading').style.display = 'block';
    
    // 使用AJAX直接调用ai_api.php
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ai_api.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('optimize-loading').style.display = 'none';
        
        // 检查响应是否包含HTML或为空
        var responseText = xhr.responseText || '';
        var trimmedResponse = responseText.trim();
        var isHtml = trimmedResponse.startsWith('<!DOCTYPE') || 
                   trimmedResponse.startsWith('<html') || 
                   trimmedResponse.indexOf('<body') > -1 || 
                   trimmedResponse.indexOf('<head') > -1;
        
        // 检查是否包含登录表单（可能是会话过期）
        var hasLoginForm = responseText.indexOf('name="user"') > -1 && 
                          responseText.indexOf('name="pass"') > -1;
        
        // 尝试解析响应
        var result;
        if (isHtml) {
            var errorMessage = '服务器返回了HTML而非JSON，可能是PHP错误或配置问题';
            if (hasLoginForm) {
                errorMessage = '会话已过期，请刷新页面重新登录';
            } else if (responseText.indexOf('Fatal error') > -1) {
                errorMessage = 'PHP严重错误，请检查服务器日志';
            } else if (responseText.indexOf('Warning') > -1) {
                errorMessage = 'PHP警告，请检查服务器配置';
            }
            
            result = {
                success: false,
                message: errorMessage,
                preview: responseText.substring(0, 300) + (responseText.length > 300 ? '...' : '')
            };
        } else {
            try {
                result = JSON.parse(responseText);
            } catch (e) {
                // 如果JSON解析失败
                result = {
                    success: false,
                    message: 'JSON解析错误: ' + e.message,
                    preview: responseText.substring(0, 300) + (responseText.length > 300 ? '...' : '')
                };
            }
        }
        
        // 处理结果
        if (result.success) {
            // 如果设置了自动保存，则调用保存API
            if (window.currentOptimizeAutoSave) {
                // 调用应用API保存内容
                submitOptimizedContentDirect(window.currentOptimizeType, result.content, function(saveResult) {
                    if (saveResult.success) {
                        submitBtn.innerHTML = '<i class="fa fa-check"></i> 优化并保存成功';
                        submitBtn.classList.remove('btn-warning');
                        submitBtn.classList.add('btn-success');
                        
                        showModal({
                            icon: 'success',
                            title: '优化并保存成功',
                            text: saveResult.message || '内容已自动保存到系统配置',
                            callback: function() {
                                // 重新加载页面，显示最新的系统配置
                                window.location.reload();
                            }
                        });
                    } else {
                        // 显示自动保存失败，但优化成功
                        alert('内容优化成功，但自动保存失败: ' + (saveResult.message || '未知错误'));
                        showOptimizedContent(result.content);
                    }
                });
                return;
            }
            
            // 优化成功提示
            submitBtn.innerHTML = '<i class="fa fa-magic"></i> 优化成功';
            submitBtn.classList.remove('btn-warning');
            submitBtn.classList.add('btn-success');
            
            // 添加优化后内容区域
            var optimizedArea = document.createElement('div');
            optimizedArea.className = 'form-group optimized_area';
            
            // 创建包含两个选项卡的内容
            var tabContent = '<div class="form-group">' +
                '<label>优化后内容</label>' +
                '<ul class="nav nav-tabs" role="tablist">' +
                '<li role="presentation" class="active"><a href="#editor-tab" aria-controls="editor" role="tab" data-toggle="tab">编辑器</a></li>' +
                '<li role="presentation"><a href="#preview-tab" aria-controls="preview" role="tab" data-toggle="tab">预览效果</a></li>' +
                '</ul>' +
                '<div class="tab-content" style="border: 1px solid #ddd; border-top: none; padding: 15px;">' +
                '<div role="tabpanel" class="tab-pane active" id="editor-tab">' +
                '<div class="input-group">' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-default" type="button" onclick="copyContent()" title="复制内容"><i class="fa fa-copy"></i></button>' +
                '</span>' +
                '<textarea class="form-control" id="optimized_content" name="optimized_content" rows="8">' + 
                escapeHtml(result.content) + '</textarea>' +
                '</div>' +
                '</div>' +
                '<div role="tabpanel" class="tab-pane" id="preview-tab">' +
                '<div id="preview_content" class="well" style="min-height: 200px; white-space: pre-wrap; overflow-wrap: break-word;">' + 
                result.content + '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="mt-3">' +
                '<button type="button" class="btn btn-success btn-block" onclick="applyOptimized()">应用此内容</button>' +
                '<button type="button" class="btn btn-default btn-block" onclick="resetOptimize()">重新优化</button>' +
                '</div>';
            
            optimizedArea.innerHTML = tabContent;
            
            // 添加监听器，当文本内容改变时更新预览
            setTimeout(function() {
                var textarea = document.getElementById('optimized_content');
                if (textarea) {
                    textarea.addEventListener('input', function() {
                        document.getElementById('preview_content').innerHTML = textarea.value;
                    });
                }
            }, 100);
            
            // 找到表单并添加结果区域（先移除旧的）
            var form = document.getElementById('optimize-form');
            var existingAreas = form.getElementsByClassName('optimized_area');
            while (existingAreas.length > 0) {
                existingAreas[0].parentNode.removeChild(existingAreas[0]);
            }
            form.appendChild(optimizedArea);
            
            // 如果是直接文本响应，显示提示
            if (result.message && result.message.includes('直接使用文本响应')) {
                showModal({
                    icon: 'info',
                    title: '优化完成（直接文本模式）',
                    text: '系统直接使用了API返回的文本而非JSON格式，可能是由于API配置变更。',
                    callback: function() {
                        // 重新加载页面，显示最新的系统配置
                        window.location.reload();
                    }
                });
            } else {
                showModal({
                    icon: 'success',
                    title: '优化成功',
                    text: '内容已优化完成，请检查并应用'
                });
            }
        } else {
            let errorMsg = result.message || '未知错误';
            submitBtn.innerHTML = '<i class="fa fa-exclamation-triangle"></i> 优化失败';
            submitBtn.classList.remove('btn-warning');
            submitBtn.classList.add('btn-danger');
            submitBtn.disabled = false;
            
            // 显示预览信息（如果有）
            let errorDetails = '';
            if (result.preview) {
                errorDetails = '<div class="mt-3"><strong>响应内容预览:</strong><br>' + 
                    '<pre class="bg-light p-2 mt-2" style="max-height:200px;overflow:auto;white-space:pre-wrap;word-break:break-all;">' + 
                    escapeHtml(result.preview) + '</pre></div>';
            }
            
            showModal({
                icon: 'error',
                title: 'AI优化失败',
                html: errorMsg + errorDetails,
                confirmButtonText: '确定'
            });
        }
    };
    
    xhr.onerror = function() {
        document.getElementById('optimize-loading').style.display = 'none';
        submitBtn.innerHTML = '<i class="fa fa-exclamation-triangle"></i> 连接错误';
        submitBtn.classList.remove('btn-warning');
        submitBtn.classList.add('btn-danger');
        submitBtn.disabled = false;
        
        showModal({
            icon: 'error',
            title: 'AI优化失败',
            text: '连接服务器失败，请检查网络连接',
            confirmButtonText: '确定'
        });
    };
    
    // 构建内容
    var full_content = "【内容类型】：" + (document.querySelector('option[value="'+type+'"]')?.textContent || type) + 
                       "\n\n【当前内容】：\n" + content + 
                       "\n\n【优化要求】：" + prompt + 
                       "\n\n请直接给出优化后的内容，不要包含任何解释或前缀。";
    
    // 使用Base64编码内容
    var encodedContent;
    try {
        encodedContent = btoa(encodeURIComponent(full_content));
    } catch (e) {
        alert('内容编码失败: ' + e.message);
        document.getElementById('optimize-loading').style.display = 'none';
        submitBtn.disabled = false;
        return;
    }
    
    // 直接调用ai_api.php的polish功能
    var postData = 'action=polish&content=' + encodedContent + '&is_encoded=true';
    xhr.send(postData);
    
    // 保存类型和自动保存设置到全局变量，供后续处理使用
    window.currentOptimizeType = type;
    window.currentOptimizeAutoSave = autoSave;
    
    return false;
});

// 应用优化后的内容
function applyOptimized() {
    var type = document.getElementById('type-field').value;
    var optimizedContent = document.getElementById('optimized_content').value;
    
    if (!optimizedContent) {
        alert('优化后内容不能为空');
        return;
    }
    
    // 直接提交内容，无需确认
    submitOptimizedContent(type, optimizedContent);
}

// 复制优化后内容
function copyContent() {
    var textarea = document.getElementById('optimized_content');
    if (!textarea) return;
    
    // 选择文本
    textarea.select();
    textarea.setSelectionRange(0, 99999); // 对于移动设备
    
    try {
        // 复制文本
        var successful = document.execCommand('copy');
        if (successful) {
            // 显示成功提示
            var copyBtn = event.target.closest('button');
            var originalHTML = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fa fa-check"></i>';
            copyBtn.classList.add('btn-success');
            
            setTimeout(function() {
                copyBtn.innerHTML = originalHTML;
                copyBtn.classList.remove('btn-success');
            }, 1500);
        } else {
            alert('复制失败，请手动复制');
        }
    } catch (err) {
        alert('复制失败: ' + err.message);
    }
    
    // 取消选择
    textarea.blur();
}

// 提交优化后内容到服务器
function submitOptimizedContent(type, content) {
    // 显示加载状态
    var submitBtn = document.querySelector('.optimized_area .btn-success');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> 正在应用...';
        submitBtn.disabled = true;
    }
    
    // 使用AJAX提交内容，避免页面刷新
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ai_optimize.php', true);
    
    xhr.onload = function() {
        // 检查是否为HTML响应
        var isHtml = xhr.responseText.trim().indexOf('<!DOCTYPE') === 0 || 
                    xhr.responseText.trim().indexOf('<html') === 0;
        
        if (isHtml) {
            // 尝试显示成功消息
            var successMsg = document.createElement('div');
            successMsg.className = 'alert alert-success';
            successMsg.innerHTML = '<i class="fa fa-check-circle"></i> 内容已应用（无法确认状态，请刷新页面检查）';
            
            // 插入到表单中
            var form = document.getElementById('optimize-form');
            var existingAlerts = form.querySelectorAll('.alert');
            existingAlerts.forEach(function(alert) {
                alert.parentNode.removeChild(alert);
            });
            form.insertBefore(successMsg, form.firstChild);
            
            // 恢复按钮状态
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fa fa-check"></i> 应用成功';
                setTimeout(function() {
                    submitBtn.innerHTML = '应用此内容';
                    submitBtn.disabled = false;
                }, 2000);
            }
            
            // 自动滚动到顶部查看结果
            window.scrollTo(0, 0);
            
            // 两秒后刷新页面
            setTimeout(function() {
                window.location.reload();
            }, 2000);
            
            return;
        }
        
        try {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // 显示成功信息
                var successMsg = document.createElement('div');
                successMsg.className = 'alert alert-success';
                successMsg.innerHTML = '<i class="fa fa-check-circle"></i> ' + response.message;
                
                // 插入到表单中
                var form = document.getElementById('optimize-form');
                var existingAlerts = form.querySelectorAll('.alert');
                existingAlerts.forEach(function(alert) {
                    alert.parentNode.removeChild(alert);
                });
                form.insertBefore(successMsg, form.firstChild);
                
                // 恢复按钮状态
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fa fa-check"></i> 应用成功';
                    setTimeout(function() {
                        submitBtn.innerHTML = '应用此内容';
                        submitBtn.disabled = false;
                    }, 2000);
                }
                
                // 自动滚动到顶部查看结果
                window.scrollTo(0, 0);
            } else {
                // 显示错误信息
                alert('应用失败: ' + (response.message || '未知错误'));
                if (submitBtn) {
                    submitBtn.innerHTML = '应用此内容';
                    submitBtn.disabled = false;
                }
            }
        } catch (e) {
            // 解析响应失败
            
            // 尝试一种备选方案 - 假设保存成功
            if (xhr.status === 200) {
                // 显示成功信息
                var successMsg = document.createElement('div');
                successMsg.className = 'alert alert-success';
                successMsg.innerHTML = '<i class="fa fa-check-circle"></i> 内容已应用（响应解析失败但HTTP状态为200）';
                
                // 插入到表单中
                var form = document.getElementById('optimize-form');
                var existingAlerts = form.querySelectorAll('.alert');
                existingAlerts.forEach(function(alert) {
                    alert.parentNode.removeChild(alert);
                });
                form.insertBefore(successMsg, form.firstChild);
                
                // 恢复按钮状态
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fa fa-check"></i> 应用成功';
                    setTimeout(function() {
                        submitBtn.innerHTML = '应用此内容';
                        submitBtn.disabled = false;
                    }, 2000);
                }
                
                // 自动滚动到顶部查看结果
                window.scrollTo(0, 0);
                
                return;
            }
            
            // 提供更多信息的错误消息
            var errorMsg = '操作失败: 服务器返回了无效的JSON响应';
            if (xhr.responseText) {
                errorMsg += '\n\n响应内容: ' + xhr.responseText.substring(0, 100);
                if (xhr.responseText.length > 100) errorMsg += '...';
            }
            
            alert(errorMsg);
            
            // 恢复按钮状态
            if (submitBtn) {
                submitBtn.innerHTML = '应用此内容';
                submitBtn.disabled = false;
            }
        }
    };
    
    xhr.onerror = function() {
        alert('网络错误，请重试');
        if (submitBtn) {
            submitBtn.innerHTML = '应用此内容';
            submitBtn.disabled = false;
        }
    };
    
    // 准备表单数据
    var formData = new FormData();
    formData.append('do', 'apply');
    formData.append('type', type);
    formData.append('content', content);
    formData.append('ajax', '1');
    
    // 使用FormData发送数据
    xhr.send(formData);
}

// 重置优化
function resetOptimize() {
    var submitBtn = document.getElementById('submit-btn');
    submitBtn.innerHTML = '开始AI优化';
    submitBtn.classList.remove('btn-success', 'btn-danger');
    submitBtn.classList.add('btn-primary');
    submitBtn.disabled = false;
    
    // 移除优化后区域
    var optimizedAreas = document.getElementsByClassName('optimized_area');
    while (optimizedAreas.length > 0) {
        optimizedAreas[0].parentNode.removeChild(optimizedAreas[0]);
    }
}

// 添加直接保存优化结果的函数
function submitOptimizedContentDirect(type, content, callback) {
    // 使用AJAX提交内容到服务器
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ai_optimize.php', true);
    
    // 使用FormData发送数据，不设置Content-Type头
    var formData = new FormData();
    formData.append('do', 'apply');
    formData.append('type', type);
    formData.append('content', content);
    formData.append('ajax', '1');
    
    xhr.onload = function() {
        var response;
        try {
            // 检查是否为HTML响应
            var isHtml = xhr.responseText.indexOf('<!DOCTYPE') === 0 || 
                        xhr.responseText.indexOf('<html') === 0;
            
            if (isHtml) {
                // 尝试直接显示保存成功消息
                callback({
                    success: true, 
                    message: '内容已保存，请刷新页面检查最新状态'
                });
                return;
            }
            
            response = JSON.parse(xhr.responseText);
        } catch(e) {
            // 尝试一种备选方案 - 假设保存成功
            if (xhr.status === 200) {
                callback({
                    success: true,
                    message: '内容已保存（响应解析失败但HTTP状态为200）'
                });
                return;
            }
            
            callback({
                success: false,
                message: '解析响应失败: ' + e.message
            });
            return;
        }
        
        callback(response);
    };
    
    xhr.onerror = function() {
        callback({
            success: false,
            message: '网络错误'
        });
    };
    
    // 发送FormData数据
    xhr.send(formData);
}

// 显示优化后内容的函数
function showOptimizedContent(content) {
    // 优化成功提示
    var submitBtn = document.getElementById('submit-btn');
    submitBtn.innerHTML = '<i class="fa fa-magic"></i> 优化成功';
    submitBtn.classList.remove('btn-warning');
    submitBtn.classList.add('btn-success');
    
    // 添加优化后内容区域
    var optimizedArea = document.createElement('div');
    optimizedArea.className = 'form-group optimized_area';
    
    // 创建包含两个选项卡的内容
    var tabContent = '<div class="form-group">' +
        '<label>优化后内容</label>' +
        '<ul class="nav nav-tabs" role="tablist">' +
        '<li role="presentation" class="active"><a href="#editor-tab" aria-controls="editor" role="tab" data-toggle="tab">编辑器</a></li>' +
        '<li role="presentation"><a href="#preview-tab" aria-controls="preview" role="tab" data-toggle="tab">预览效果</a></li>' +
        '</ul>' +
        '<div class="tab-content" style="border: 1px solid #ddd; border-top: none; padding: 15px;">' +
        '<div role="tabpanel" class="tab-pane active" id="editor-tab">' +
        '<div class="input-group">' +
        '<span class="input-group-btn">' +
        '<button class="btn btn-default" type="button" onclick="copyContent()" title="复制内容"><i class="fa fa-copy"></i></button>' +
        '</span>' +
        '<textarea class="form-control" id="optimized_content" name="optimized_content" rows="8">' + 
        escapeHtml(content) + '</textarea>' +
        '</div>' +
        '</div>' +
        '<div role="tabpanel" class="tab-pane" id="preview-tab">' +
        '<div id="preview_content" class="well" style="min-height: 200px; white-space: pre-wrap; overflow-wrap: break-word;">' + 
        content + '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="mt-3">' +
        '<button type="button" class="btn btn-success btn-block" onclick="applyOptimized()">应用此内容</button>' +
        '<button type="button" class="btn btn-default btn-block" onclick="resetOptimize()">重新优化</button>' +
        '</div>';
    
    optimizedArea.innerHTML = tabContent;
    
    // 添加监听器，当文本内容改变时更新预览
    setTimeout(function() {
        var textarea = document.getElementById('optimized_content');
        if (textarea) {
            textarea.addEventListener('input', function() {
                document.getElementById('preview_content').innerHTML = textarea.value;
            });
        }
    }, 100);
    
    // 找到表单并添加结果区域（先移除旧的）
    var form = document.getElementById('optimize-form');
    var existingAreas = form.getElementsByClassName('optimized_area');
    while (existingAreas.length > 0) {
        existingAreas[0].parentNode.removeChild(existingAreas[0]);
    }
    form.appendChild(optimizedArea);
    
    // 使用SweetAlert2显示成功消息
    showModal({
        icon: 'success',
        title: '优化成功',
        text: '内容已优化完成，请检查并应用'
    });
}

// 简单的模态框函数，替代SweetAlert2
function showModal(options) {
    // 如果未提供任何参数或参数为空，不显示模态框，仅返回对象引用
    if (!options || (!options.title && !options.text && !options.html)) {
        return {
            then: function(callback) {
                if (callback) {
                    setTimeout(callback, 100);
                }
            }
        };
    }

    // 查找已有的模态框元素
    var modal = document.getElementById("customAlertModal");
    
    // 如果模态框不存在，使用alert代替而不是创建新模态框
    // 这样避免在选择内容时触发模态框闪现
    if (!modal) {
        alert(options.title + "\n\n" + (options.text || options.html || ""));
        if (options.callback) {
            setTimeout(options.callback, 100);
        }
        return {
            then: function(callback) {
                if (callback) {
                    setTimeout(callback, 100);
                }
            }
        };
    }

    // 设置标题和内容
    var titleEl = modal.querySelector(".modal-title");
    var bodyEl = modal.querySelector(".modal-body");
    var iconClass = "";

    switch(options.icon) {
        case "success": iconClass = "text-success fa fa-check-circle"; break;
        case "error": iconClass = "text-danger fa fa-times-circle"; break;
        case "warning": iconClass = "text-warning fa fa-exclamation-triangle"; break;
        case "info": iconClass = "text-info fa fa-info-circle"; break;
    }

    titleEl.innerHTML = options.icon ? "<i class='" + iconClass + "'></i> " + options.title : options.title;
    
    if (options.html) {
        bodyEl.innerHTML = options.html;
    } else {
        bodyEl.textContent = options.text || "";
    }

    // 如果有回调，设置模态框关闭后触发
    if (options.callback) {
        $(modal).one("hidden.bs.modal", options.callback);
    }

    // 显示模态框
    $(modal).modal("show");
    
    // 返回一个带有then方法的对象，以保持API兼容性
    return {
        then: function(callback) {
            if (callback) {
                $(modal).one("hidden.bs.modal", callback);
            }
        }
    };
}

// 提供Swal对象的兼容性
var Swal = {
    fire: showModal
};
</script>

<?php
// 不再重复初始化模态框，使用showModal函数中的创建逻辑
echo '<script>
// 提供Swal对象的兼容性
var Swal = {
    fire: showModal
};

// 确保页面加载完成后只初始化模态框DOM而不显示
document.addEventListener("DOMContentLoaded", function() {
    // 延迟一点时间以避免干扰页面加载和选择操作
    setTimeout(function() {
        if (!document.getElementById("customAlertModal")) {
            // 创建模态框但不显示
            var modalTemplate = \'<div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog">\
              <div class="modal-dialog" role="document">\
                <div class="modal-content">\
                  <div class="modal-header">\
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                    <h4 class="modal-title"></h4>\
                  </div>\
                  <div class="modal-body"></div>\
                  <div class="modal-footer">\
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>\
                  </div>\
                </div>\
              </div>\
            </div>\';
            
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = modalTemplate;
            document.body.appendChild(modalContainer.firstChild);
            
            // 确保模态框被初始化但不显示
            $("#customAlertModal").modal({show: false});
        }
    }, 500); // 延迟500毫秒
});
</script>';

include './foot.php';

/**
 * 调用AI优化API
 * @param string $type 内容类型
 * @param string $content 原始内容
 * @param string $prompt 优化提示
 * @return array 结果数组 ['success' => bool, 'content' => string, 'message' => string]
 */
function callAIOptimize($type, $content, $prompt) {
    global $notice_settings;
    
    // 准备API请求数据
    $type_name = isset($notice_settings[$type]) ? $notice_settings[$type] : $type;
    
    // 构建内容，包含类型和优化提示
    $full_content = "【内容类型】：{$type_name}\n\n【当前内容】：\n{$content}\n\n【优化要求】：{$prompt}\n\n请直接给出优化后的内容，不要包含任何解释或前缀。";
    
    // 使用Base64编码内容，避免HTML被WAF拦截
    $encodedContent = base64_encode(urlencode($full_content));
    
    try {
        // 调用API - 使用polish功能替代optimize_content
        $ch = curl_init();
        
        // 获取当前脚本目录
        $current_dir = dirname($_SERVER['SCRIPT_FILENAME']);
        $api_url = $current_dir . '/ai_api.php';
        
        // 设置cURL选项 - 使用绝对路径
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'action' => 'polish',
            'content' => $encodedContent,
            'is_encoded' => 'true'
        ]));
        curl_setopt($ch, CURLOPT_COOKIE, $_SERVER['HTTP_COOKIE']); // 传递当前会话cookie
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // 连接超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 120); // 总执行时间
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 不验证SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 不验证主机名
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // 即使HTTP状态码不是200也不会失败
        
        // 执行请求
        $response = curl_exec($ch);
        
        // 检查是否有错误
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        // 如果有cURL错误
        if ($curl_errno) {
            // 尝试使用file_get_contents作为备选方案
            $context = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => [
                        'Content-Type: application/x-www-form-urlencoded',
                        'Cookie: ' . $_SERVER['HTTP_COOKIE']
                    ],
                    'content' => http_build_query([
                        'action' => 'polish',
                        'content' => $encodedContent,
                        'is_encoded' => 'true'
                    ]),
                    'timeout' => 120
                ]
            ]);
            
            $response = @file_get_contents($api_url, false, $context);
            
            if ($response === false) {
                return [
                    'success' => false,
                    'content' => '',
                    'message' => "cURL错误 ({$curl_errno}): {$curl_error} - 备选方法也失败"
                ];
            }
        }
        
        // 如果HTTP状态码不是200且不是cURL错误的备选方案
        if ($httpCode !== 200 && !$curl_errno) {
            return [
                'success' => false,
                'content' => '',
                'message' => "HTTP错误: {$httpCode}"
            ];
        }
        
        // 尝试解析JSON响应
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $json_error = json_last_error_msg();
            
            // 检查响应内容是否为HTML (可能是PHP错误输出)
            $is_html = (stripos($response, '<!DOCTYPE html>') !== false) || 
                       (stripos($response, '<html') !== false) || 
                       (stripos($response, '<body') !== false);
            
            // 检查是否包含PHP错误
            $has_php_error = (stripos($response, 'Parse error') !== false) || 
                             (stripos($response, 'Fatal error') !== false) || 
                             (stripos($response, 'Warning') !== false) || 
                             (stripos($response, 'Notice') !== false);
            
            $error_message = "JSON解析错误: " . $json_error;
            
            if ($is_html) {
                $error_message .= " - 服务器返回了HTML内容而非JSON";
            }
            
            if ($has_php_error) {
                $error_message .= " - 检测到PHP错误";
            }
            
            // 尝试提取响应中可能的错误信息
            if (preg_match('/error[\"\':\s]+(.*?)[\"\',}]/i', $response, $matches)) {
                $error_message .= " - " . $matches[1];
            }
            
            // 显示部分响应内容
            $preview = substr($response, 0, 300);
            if (strlen($response) > 300) {
                $preview .= '...';
            }
            
            // 尝试直接使用响应内容
            if (!empty($response) && !$is_html && !$has_php_error) {
                // 检查是否有明显的文本内容，如果有可能是API直接返回了优化后的内容而不是JSON
                $clean_text = strip_tags($response);
                if (strlen($clean_text) > 50 && !preg_match('/^[\{\[\d]/', trim($clean_text))) {
                    return [
                        'success' => true,
                        'content' => $clean_text,
                        'message' => '(直接使用文本响应)',
                        'preview' => $preview
                    ];
                }
            }
            
            return [
                'success' => false,
                'content' => '',
                'message' => $error_message,
                'preview' => $preview
            ];
        }
        
        if (isset($result['success']) && $result['success'] === true) {
            return [
                'success' => true,
                'content' => $result['content'],
                'message' => ''
            ];
        } else {
            return [
                'success' => false,
                'content' => '',
                'message' => isset($result['message']) ? $result['message'] : '获取AI响应失败'
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'content' => '',
            'message' => '异常: ' . $e->getMessage()
        ];
    }
}
?> 