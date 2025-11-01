<?php
/*
 * 计划任务处理文件
 * 博客：zhonguo.ren
 * QQ群：915043052
 * 开发者：教主
 * 功能：处理各种自动任务，包括自动补单、数据清理等
 */
header("Content-Type: text/html;charset=utf-8");
include("../includes/common.php");

// 检查是否启用了自动补单
$autoreorder = $DB->getColumn("SELECT v FROM pre_config WHERE k='autoreorder'");

// 获取自动补单配置
$autoreorder_config = [];
$config_keys = [
    'autoreorder_interval' => 5,
    'autoreorder_limit' => 50,
    'autoreorder_max_retries' => 3,
    'autoreorder_status' => '0,1,2',
    'autoreorder_after' => 10,
    'autoreorder_timeout' => 30
];

foreach($config_keys as $key => $default) {
    $value = $DB->getColumn("SELECT v FROM pre_config WHERE k='{$key}'");
    $autoreorder_config[$key] = $value !== false ? $value : $default;
}

// 检查上次执行时间
$last_reorder_time = $DB->getColumn("SELECT v FROM pre_config WHERE k='last_reorder_time'");
$current_time = time();

// 判断是否需要执行补单
$should_reorder = false;
if($autoreorder == 1) {
    if(!$last_reorder_time || ($current_time - strtotime($last_reorder_time) >= $autoreorder_config['autoreorder_interval'] * 60)) {
        $should_reorder = true;
    }
}

// 如果是手动触发或满足自动触发条件，则执行补单
if($should_reorder || $_GET['action'] == 'reorder') {
    // 更新最后执行时间
    $DB->exec("REPLACE INTO pre_config SET k='last_reorder_time',v='{$date}'");
    
    // 执行自动补单
    $result = autoReorder($autoreorder_config);
    
    // 输出结果
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'code' => 1,
        'msg' => "自动补单完成，处理订单{$result['processed']}个，成功{$result['success']}个，失败{$result['failed']}个"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * 自动补单核心函数
 */
function autoReorder($config) {
    global $DB, $date;
    
    $processed = 0;
    $success = 0;
    $failed = 0;
    
    // 解析订单状态
    $status_array = explode(',', $config['autoreorder_status']);
    $status_condition = implode(',', $status_array);
    
    // 计算时间条件
    $after_time = date('Y-m-d H:i:s', time() - $config['autoreorder_after'] * 60);
    $timeout_time = date('Y-m-d H:i:s', time() - $config['autoreorder_timeout'] * 60);
    
    // 查询需要补单的订单
    $query = "SELECT * FROM pre_orders WHERE 
        status IN ({$status_condition}) AND 
        addtime >= '{$timeout_time}' AND 
        addtime <= '{$after_time}' AND 
        reorder_times < '{$config['autoreorder_max_retries']}' 
        ORDER BY addtime ASC 
        LIMIT {$config['autoreorder_limit']}";
    
    $orders = $DB->query($query);
    
    while($order = $orders->fetch()) {
        $processed++;
        
        try {
            // 补单前更新订单状态为处理中
            $DB->update('pre_orders', [
                'status' => 1,
                'reorder_times' => $order['reorder_times'] + 1,
                'last_reorder_time' => $date
            ], ['id' => $order['id']]);
            
            // 获取商品信息
            $goods = $DB->getRow("SELECT * FROM pre_goods WHERE id='{$order['gid']}'");
            if(!$goods) {
                $failed++;
                continue;
            }
            
            // 获取商品对应的对接信息
            $shequ = null;
            if($goods['shequ_id']) {
                $shequ = $DB->getRow("SELECT * FROM pre_shequ WHERE id='{$goods['shequ_id']}'");
            }
            
            // 根据商品类型执行对应的补单逻辑
            $result = false;
            if($shequ) {
                // 第三方对接商品
                $result = reorderThirdParty($order, $goods, $shequ);
            } else {
                // 本地商品
                $result = reorderLocal($order, $goods);
            }
            
            // 处理补单结果
            if($result) {
                $DB->update('pre_orders', [
                    'status' => 2,
                    'endtime' => $date,
                    'result' => isset($result['result']) ? $result['result'] : '补单成功'
                ], ['id' => $order['id']]);
                $success++;
            } else {
                $failed++;
            }
            
        } catch(Exception $e) {
            $failed++;
            // 记录错误信息
            $DB->update('pre_orders', [
                'result' => '补单失败：' . $e->getMessage()
            ], ['id' => $order['id']]);
        }
    }
    
    return [
        'processed' => $processed,
        'success' => $success,
        'failed' => $failed
    ];
}

/**
 * 第三方对接商品补单
 */
function reorderThirdParty($order, $goods, $shequ) {
    global $DB;
    
    try {
        // 加载对应插件
        $plugin_file = SYS_ROOT . 'plugins/third_' . $shequ['type'] . '/index.php';
        if(!file_exists($plugin_file)) {
            throw new Exception("插件不存在 third_{$shequ['type']}");
        }
        
        // 创建插件实例
        $plugin = new \lib\Plugin('third_' . $shequ['type']);
        
        // 构建下单参数
        $params = [
            'order_no' => $order['orderno'],
            'goods_id' => $goods['shequ_goods_id'],
            'goods_name' => $goods['name'],
            'goods_price' => $goods['price'],
            'num' => $order['num'],
            'total' => $order['total'],
            'account' => $order['account'],
            'custom' => $order['custom'],
            'buyer' => $order['buyer']
        ];
        
        // 调用插件下单接口
        $result = $plugin->call('doGoods', $shequ, $params);
        
        if($result && $result['code'] == 1) {
            // 补单成功
            return $result;
        } else {
            throw new Exception($result['msg'] ?? '补单失败，未知错误');
        }
        
    } catch(Exception $e) {
        throw $e;
    }
}

/**
 * 本地商品补单
 */
function reorderLocal($order, $goods) {
    global $DB;
    
    try {
        // 检查库存
        if($goods['stock'] < $order['num']) {
            throw new Exception('库存不足');
        }
        
        // 获取商品卡密
        $codes = $DB->query("SELECT * FROM pre_kms WHERE gid='{$goods['id']}' AND used=0 LIMIT {$order['num']}");
        $code_list = [];
        while($code = $codes->fetch()) {
            $code_list[] = $code['km'];
        }
        
        if(count($code_list) < $order['num']) {
            throw new Exception('卡密数量不足');
        }
        
        // 更新卡密状态
        $km_ids = [];
        foreach($code_list as $km) {
            $km_row = $DB->getRow("SELECT * FROM pre_kms WHERE km='{$km}'");
            $km_ids[] = $km_row['id'];
        }
        $DB->update('pre_kms', ['used' => 1, 'uid' => $order['uid'], 'oid' => $order['id'], 'usetime' => $date], "id IN (" . implode(',', $km_ids) . ")");
        
        // 更新库存
        $DB->update('pre_goods', ['stock' => $goods['stock'] - $order['num'], 'sales' => $goods['sales'] + $order['num']], ['id' => $goods['id']]);
        
        return [
            'code' => 1,
            'msg' => '补单成功',
            'result' => implode('\n', $code_list)
        ];
        
    } catch(Exception $e) {
        throw $e;
    }
}

// 如果没有执行补单操作，输出提示信息
if($autoreorder == 0) {
    echo "自动补单功能已关闭<br/>";
} else {
    echo "未达到补单时间间隔，跳过本次执行<br/>";
    echo "上次执行时间: {$last_reorder_time}<br/>";
    echo "设置的间隔: {$autoreorder_config['autoreorder_interval']}分钟<br/>";
}

// 执行其他计划任务（如果有）
doOtherTasks();

/**
 * 执行其他计划任务
 */
function doOtherTasks() {
    // 这里可以添加其他计划任务的逻辑
    // 例如：数据清理、统计更新等
}
?>