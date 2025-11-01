<?php
include("../includes/common.php");
$title='AI设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");





if(isset($_POST['submit'])) {
    $config_names = ['deepseek_api_key', 'deepseek_model'];
    foreach($config_names as $name) {
        $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
        saveSetting($name, $value);
    }
    showmsg('保存成功！', 1);
}

$ai_config = [];
$config_result = $DB->getAll("SELECT * FROM pre_config WHERE k LIKE 'deepseek_%'");
foreach($config_result as $row) {
    $ai_config[$row['k']] = $row['v'];
}
$deepseek_api_key = $DB->getColumn("SELECT v FROM pre_config WHERE k='deepseek_api_key' LIMIT 1");
$deepseek_model = $DB->getColumn("SELECT v FROM pre_config WHERE k='deepseek_model' LIMIT 1");
if(empty($deepseek_model)) $deepseek_model = 'deepseek-chat';

// 查询DeepSeek账户余额
$balance_data = null;
$balance_error = null;
if(!empty($deepseek_api_key)) {
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.deepseek.com/user/balance');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $deepseek_api_key,
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($http_code == 200) {
            $balance_data = json_decode($response, true);
        } else {
            $error_response = json_decode($response, true);
            $balance_error = isset($error_response['error']['message']) ? $error_response['error']['message'] : '查询余额失败，HTTP状态码: ' . $http_code;
        }
    } catch (Exception $e) {
        $balance_error = '查询余额时发生错误: ' . $e->getMessage();
    }
}

?>

<div class="col-xs-12 col-md-10 center-block">
    <div class="block">
        <div class="block-title">
            <h3 class="panel-title">大模型配置 (DeepSeek)</h3>
        </div>
        <div class="card-body">
            <form action="./ai_settings.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> DeepSeek是一家AI大模型服务提供商，支持先进的自然语言处理能力。您可以在<a href="https://platform.deepseek.com/" target="_blank">DeepSeek平台</a>申请API密钥。
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">API密钥</label>
                    <div class="col-sm-10">
                        <input type="text" name="deepseek_api_key" value="<?php echo $deepseek_api_key; ?>" class="form-control" placeholder="请输入DeepSeek API Key">
                        <small class="help-block">用于调用DeepSeek API的密钥，请在<a href="https://platform.deepseek.com/api_keys" target="_blank">官方平台</a>申请</small>
                    </div>
                </div>
                
                <!-- 账户余额显示区域 -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">账户余额</label>
                    <div class="col-sm-10">
                        <?php if(empty($deepseek_api_key)): ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-circle"></i> 请先配置API密钥后查看账户余额
                            </div>
                        <?php elseif($balance_error): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-times-circle"></i> <?php echo $balance_error; ?>
                            </div>
                        <?php elseif($balance_data): ?>
                            <div class="alert <?php echo $balance_data['is_available'] ? 'alert-success' : 'alert-warning'; ?>">
                                <i class="fa fa-<?php echo $balance_data['is_available'] ? 'check-circle' : 'exclamation-circle'; ?>"></i> 
                                账户状态: <?php echo $balance_data['is_available'] ? '可用' : '余额不足'; ?>
                            </div>
                            <?php if(!empty($balance_data['balance_infos'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>货币</th>
                                                <th>总余额</th>
                                                <th>赠金余额</th>
                                                <th>充值余额</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($balance_data['balance_infos'] as $balance): ?>
                                                <tr>
                                                    <td><?php echo $balance['currency'] == 'CNY' ? '人民币 (CNY)' : '美元 (USD)'; ?></td>
                                                    <td><?php echo $balance['total_balance']; ?></td>
                                                    <td><?php echo $balance['granted_balance']; ?></td>
                                                    <td><?php echo $balance['topped_up_balance']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-muted">
                                    <i class="fa fa-refresh"></i> 余额数据为实时查询结果，如需刷新请重新加载页面
                                </p>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-circle"></i> 无法获取账户余额信息
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">默认模型</label>
                    <div class="col-sm-10">
                        <select name="deepseek_model" class="form-control">
                            <option value="deepseek-chat" <?php echo $deepseek_model == 'deepseek-chat' ? 'selected' : ''; ?>>DeepSeek-V3-0324 (功能全面的通用大模型)</option>
                            <option value="deepseek-reasoner" <?php echo $deepseek_model == 'deepseek-reasoner' ? 'selected' : ''; ?>>DeepSeek-R1-0528 (擅长推理的专业大模型)</option>
                        </select>
                        <small class="help-block">选择默认使用的大模型类型</small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">价格说明</label>
                    <div class="col-sm-10">
                        <div class="well">
                            <h4>DeepSeek模型价格参考</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>模型</th>
                                        <th>输入价格</th>
                                        <th>输出价格</th>
                                        <th>适用场景</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DeepSeek-V3-0324</td>
                                        <td>0.002元/1K tokens</td>
                                        <td>0.01元/1K tokens</td>
                                        <td>通用对话、内容创作、知识问答</td>
                                    </tr>
                                    <tr>
                                        <td>DeepSeek-R1-0528</td>
                                        <td>0.003元/1K tokens</td>
                                        <td>0.015元/1K tokens</td>
                                        <td>逻辑推理、数学解题、代码生成</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>注：实际价格以DeepSeek官方为准</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">AI功能说明</label>
                    <div class="col-sm-10">
                        <div class="well">
                            <h4>系统已集成的AI功能</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>功能</th>
                                        <th>页面位置</th>
                                        <th>说明</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>AI对话助手</td>
                                        <td><a href="./ai_model.php">AI对话助手</a></td>
                                        <td>多轮对话，可保存会话记录</td>
                                    </tr>
                                    <tr>
                                        <td>商品描述润色</td>
                                        <td>商品管理-编辑页面</td>
                                        <td>自动优化商品描述，提升营销效果</td>
                                    </tr>
                                    <tr>
                                        <td>文章润色</td>
                                        <td>文章管理-编辑页面</td>
                                        <td>优化文章内容，提高专业性和吸引力</td>
                                    </tr>
                                    <tr>
                                        <td>AI自动编写文章</td>
                                        <td>文章管理-编辑页面</td>
                                        <td>根据关键词自动生成完整文章</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="submit" value="保存设置" class="btn btn-primary btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './foot.php'; ?> 