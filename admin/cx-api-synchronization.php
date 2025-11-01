<?php
/*
 * 自动同步API处理文件
 * 博客：zhonguo.ren
 * QQ群：915043052
 * 开发者：教主
 * 功能：处理商品自动同步的核心逻辑，包括分类同步、商品同步、数据更新等
 */
header("Content-Type: text/html;charset=utf-8");
include("../includes/common.php");

// 检查监控密钥
$monitor_key = $DB->getColumn("SELECT v FROM pre_config WHERE k='monitor_key'");
if($monitor_key && $_GET['key'] != $monitor_key) {
    exit('Access Denied');
}

// 检查是否正在执行同步任务
$last_sync_time = $DB->getColumn("SELECT v FROM pre_config WHERE k='last_sync_time'");
$sync_interval = $DB->getColumn("SELECT v FROM pre_config WHERE k='sync_interval'") ?: 5;

if($last_sync_time && (time() - strtotime($last_sync_time) < $sync_interval * 60)) {
    echo "同步间隔设置为{$sync_interval}分钟，{$last_sync_time}执行过一次，当前不执行同步<br/>";
    exit();
}

// 设置同步任务开始时间
$DB->exec("REPLACE INTO pre_config SET k='last_sync_time',v='{$date}'");
echo "同步任务开始时间：{$date}<br/>";

// 实例化长时间任务管理器
include_once('includes/LongRunningTask.php');
$task = new LongRunningTask('auto_sync');

// 检查是否已有任务在运行
if($task->isRunning()) {
    echo "检测到同步任务正在执行中，跳过本次执行<br/>";
    exit();
}

// 初始化任务
$task->init();

try {
    // 获取所有启用的同步配置
    $configs = $DB->query("SELECT * FROM pre_sync_config WHERE status=1");
    $total_synced = 0;
    $total_updated = 0;
    $total_deleted = 0;
    
    while($row = $configs->fetch()) {
        $task->updateProgress("开始处理站点配置: ID=" . $row['shequ_id']);
        echo "开始处理站点配置: ID=" . $row['shequ_id'] . "<br/>";
        
        // 获取对接站点信息
        $shequ = $DB->getRow("SELECT * FROM pre_shequ WHERE id='" . $row['shequ_id'] . "'");
        if(!$shequ) {
            $task->updateProgress("跳过: 未找到站点信息 ID=" . $row['shequ_id']);
            echo "跳过: 未找到站点信息 ID=" . $row['shequ_id'] . "<br/>";
            continue;
        }
        
        // 检查插件是否存在
        $plugin_file = SYS_ROOT . 'plugins/third_' . $shequ['type'] . '/index.php';
        if(!file_exists($plugin_file)) {
            $task->updateProgress("跳过: 插件不存在 third_{$shequ['type']}");
            echo "跳过: 插件不存在 third_{$shequ['type']}<br/>";
            continue;
        }
        
        // 同步分类
        if($row['sync_class'] || $row['add_class']) {
            $task->updateProgress("开始同步分类信息");
            echo "开始同步分类信息<br/>";
            syncCategories($shequ, $row, $task);
        }
        
        // 同步商品
        $synced_count = syncProducts($shequ, $row, $task);
        $total_synced += $synced_count['synced'];
        $total_updated += $synced_count['updated'];
        $total_deleted += $synced_count['deleted'];
        
        $task->updateProgress("站点同步完成: 新增{$synced_count['synced']}, 更新{$synced_count['updated']}, 删除{$synced_count['deleted']}");
        echo "站点同步完成: 新增{$synced_count['synced']}, 更新{$synced_count['updated']}, 删除{$synced_count['deleted']}<br/>";
    }
    
    $task->updateProgress("同步任务完成: 总计新增{$total_synced}, 更新{$total_updated}, 删除{$total_deleted}");
    echo "同步任务完成: 总计新增{$total_synced}, 更新{$total_updated}, 删除{$total_deleted}<br/>";
    echo "同步任务结束时间: " . date('Y-m-d H:i:s') . "<br/>";
    
} catch(Exception $e) {
    $task->updateProgress("同步任务异常: " . $e->getMessage());
    echo "同步任务异常: " . $e->getMessage() . "<br/>";
} finally {
    // 清理任务
    $task->cleanup();
    
    // 更新同步结束时间
    $DB->exec("REPLACE INTO pre_config SET k='last_sync_end_time',v='" . date('Y-m-d H:i:s') . "'");
}

/**
 * 同步分类信息
 */
function syncCategories($shequ, $config, $task) {
    global $DB, $date, $conf;
    
    try {
        // 加载插件
        $plugin = new \lib\Plugin('third_' . $shequ['type']);
        
        // 获取分类列表
        $categories = $plugin->call('getCategories', $shequ);
        
        if(empty($categories)) {
            $task->updateProgress("未获取到分类数据");
            echo "未获取到分类数据<br/>";
            return;
        }
        
        $added = 0;
        $updated = 0;
        
        foreach($categories as $cat) {
            // 检查分类是否已存在
            $existing_cat = $DB->getRow("SELECT * FROM pre_class WHERE `name`=? AND shequ_id=?", [$cat['name'], $shequ['id']]);
            
            $data = [
                'name' => $cat['name'],
                'shequ_id' => $shequ['id'],
                'sort' => $cat['sort'] ?? 0,
                'addtime' => $existing_cat ? $existing_cat['addtime'] : $date,
                'uptime' => $date
            ];
            
            if($existing_cat) {
                // 更新分类
                if($config->sync_sort && $existing_cat['sort'] != $data['sort']) {
                    $DB->update('pre_class', $data, ['id' => $existing_cat['id']]);
                    $updated++;
                }
            } elseif($config['add_class']) {
                // 新增分类
                $data['fid'] = 0;
                $data['status'] = 1;
                $DB->insert('pre_class', $data);
                $added++;
            }
        }
        
        $task->updateProgress("分类同步完成: 新增{$added}, 更新{$updated}");
        echo "分类同步完成: 新增{$added}, 更新{$updated}<br/>";
        
    } catch(Exception $e) {
        $task->updateProgress("分类同步失败: " . $e->getMessage());
        echo "分类同步失败: " . $e->getMessage() . "<br/>";
    }
}

/**
 * 同步商品信息
 */
function syncProducts($shequ, $config, $task) {
    global $DB, $date, $conf;
    
    $synced = 0;
    $updated = 0;
    $deleted = 0;
    
    try {
        // 加载插件
        $plugin = new \lib\Plugin('third_' . $shequ['type']);
        
        // 获取商品列表
        $params = [
            'page' => 1,
            'limit' => $config['sync_limit']
        ];
        $products = $plugin->call('getProducts', $shequ, $params);
        
        if(empty($products)) {
            $task->updateProgress("未获取到商品数据");
            echo "未获取到商品数据<br/>";
            return ['synced' => 0, 'updated' => 0, 'deleted' => 0];
        }
        
        $product_ids = [];
        $shequ_product_ids = [];
        
        foreach($products as $product) {
            // 检查任务超时
            $task->checkTimeout();
            
            $shequ_product_ids[] = $product['id'];
            $existing_product = $DB->getRow("SELECT * FROM pre_goods WHERE shequ_id=? AND shequ_goods_id=?", [$shequ['id'], $product['id']]);
            
            // 处理分类映射
            $class_id = 0;
            if($product['class']) {
                $class = $DB->getRow("SELECT * FROM pre_class WHERE `name`=? AND shequ_id=?", [$product['class'], $shequ['id']]);
                $class_id = $class ? $class['id'] : 0;
            }
            
            // 如果没有分类且不允许新增分类，跳过该商品
            if(!$class_id && !$config['add_class']) {
                $task->updateProgress("跳过: 商品{$product['name']}无对应分类且不允许新增分类");
                echo "跳过: 商品{$product['name']}无对应分类且不允许新增分类<br/>";
                continue;
            }
            
            // 处理加价模板
            $price = $product['price'];
            if($config['markup_template']) {
                $markup_template = $DB->getRow("SELECT * FROM pre_price WHERE id=?", [$config['markup_template']]);
                if($markup_template) {
                    $price = calculateMarkupPrice($price, $markup_template);
                }
            }
            
            // 构建商品数据
            $product_data = [
                'shequ_id' => $shequ['id'],
                'shequ_goods_id' => $product['id'],
                'name' => $config['sync_name'] ? $product['name'] : ($existing_product ? $existing_product['name'] : $product['name']),
                'price' => $config['sync_price'] ? $price : ($existing_product ? $existing_product['price'] : $price),
                'cost' => $config['sync_cost'] ? ($product['cost'] ?? 0) : ($existing_product ? $existing_product['cost'] : ($product['cost'] ?? 0)),
                'sort' => $config['sync_goods_sort'] ? ($product['sort'] ?? 0) : ($existing_product ? $existing_product['sort'] : ($product['sort'] ?? 0)),
                'shequ_status' => 1,
                'uptime' => $date
            ];
            
            // 添加可选字段
            if($config['sync_desc']) $product_data['content'] = $product['content'] ?? '';
            if($class_id) $product_data['class'] = $class_id;
            
            // 处理图片同步
            if($config['sync_image'] && !empty($product['images'])) {
                $image_urls = [];
                foreach($product['images'] as $img) {
                    $image_path = saveRemoteImage($img);
                    if($image_path) {
                        $image_urls[] = $image_path;
                    }
                }
                if(!empty($image_urls)) {
                    $product_data['images'] = json_encode($image_urls);
                }
            }
            
            if($existing_product) {
                // 更新商品
                $DB->update('pre_goods', $product_data, ['id' => $existing_product['id']]);
                $product_ids[] = $existing_product['id'];
                $updated++;
                
                // 更新网盘投诉设置
                if($config['sync_workorder']) {
                    $DB->update('pre_goods', ['workorder' => 1], ['id' => $existing_product['id']]);
                }
                
                $task->updateProgress("更新商品: {$product['name']}");
                echo "更新商品: {$product['name']}<br/>";
            } elseif($config['add_goods'] && $class_id) {
                // 新增商品
                $product_data['fid'] = 0;
                $product_data['stock'] = 9999;
                $product_data['sales'] = 0;
                $product_data['status'] = 1;
                $product_data['addtime'] = $date;
                $product_data['workorder'] = $config['sync_workorder'] ? 1 : 0;
                
                $gid = $DB->insert('pre_goods', $product_data);
                if($gid) {
                    $product_ids[] = $gid;
                    $synced++;
                    
                    // 记录上架日志
                    if($config['sync_log']) {
                        $DB->insert('pre_goods_record', [
                            'gid' => $gid,
                            'type' => 'up',
                            'price' => $product_data['price'],
                            'operator' => 'auto_sync',
                            'addtime' => $date
                        ]);
                    }
                    
                    $task->updateProgress("新增商品: {$product['name']}");
                    echo "新增商品: {$product['name']}<br/>";
                }
            }
        }
        
        // 处理下架商品
        if($config['delete_rule'] > 0) {
            $deleted_count = handleDeletedProducts($shequ['id'], $shequ_product_ids, $config['delete_rule'], $task);
            $deleted += $deleted_count;
        }
        
    } catch(Exception $e) {
        $task->updateProgress("商品同步失败: " . $e->getMessage());
        echo "商品同步失败: " . $e->getMessage() . "<br/>";
    }
    
    return ['synced' => $synced, 'updated' => $updated, 'deleted' => $deleted];
}

/**
 * 处理下架商品
 */
function handleDeletedProducts($shequ_id, $active_product_ids, $delete_rule, $task) {
    global $DB, $date;
    
    $count = 0;
    $query = "SELECT id, name FROM pre_goods WHERE shequ_id=? AND shequ_status=1";
    $params = [$shequ_id];
    
    if(!empty($active_product_ids)) {
        $query .= " AND shequ_goods_id NOT IN (" . implode(",", array_map(function($id) { return "'" . addslashes($id) . "'"; }, $active_product_ids)) . ")";
    }
    
    $products = $DB->query($query, $params);
    
    while($product = $products->fetch()) {
        if($delete_rule == 1) {
            // 下架商品
            $DB->update('pre_goods', ['status' => 0, 'shequ_status' => 0, 'uptime' => $date], ['id' => $product['id']]);
            $task->updateProgress("下架商品: {$product['name']}");
            echo "下架商品: {$product['name']}<br/>";
        } elseif($delete_rule == 2) {
            // 删除商品
            $DB->delete('pre_goods', ['id' => $product['id']]);
            $task->updateProgress("删除商品: {$product['name']}");
            echo "删除商品: {$product['name']}<br/>";
        }
        $count++;
    }
    
    return $count;
}

/**
 * 根据加价模板计算价格
 */
function calculateMarkupPrice($base_price, $markup_template) {
    $price = $base_price;
    
    if($markup_template['type'] == 1) {
        // 固定金额加价
        $price += $markup_template['value'];
    } elseif($markup_template['type'] == 2) {
        // 百分比加价
        $price = $price * (1 + $markup_template['value'] / 100);
    }
    
    // 价格精度处理
    $price = round($price, 2);
    
    return $price;
}

/**
 * 保存远程图片到本地
 */
function saveRemoteImage($url) {
    try {
        $img_dir = SYS_ROOT . 'assets/upload/image/';
        $img_url = $conf['local'] . 'assets/upload/image/';
        
        // 创建目录
        if(!is_dir($img_dir)) {
            mkdir($img_dir, 0755, true);
        }
        
        // 获取文件名和扩展名
        $path_info = pathinfo($url);
        $ext = isset($path_info['extension']) ? '.' . $path_info['extension'] : '.jpg';
        $filename = md5($url . time()) . $ext;
        $filepath = $img_dir . $filename;
        $fileurl = $img_url . $filename;
        
        // 下载图片
        $img_data = @file_get_contents($url);
        if($img_data) {
            @file_put_contents($filepath, $img_data);
            if(file_exists($filepath)) {
                return $fileurl;
            }
        }
        
        return false;
    } catch(Exception $e) {
        return false;
    }
}
?>