<?php
// ===================================================================================
// API接口开发文档 - 由教主老师创建
// 博客地址：zhonguo.ren
// QQ交流群：915043052
// ===================================================================================

session_start();
include '../config.php';
include '../common.php';
include '../head.php';

// 管理员登录验证
if ($islogin == 1) {
} else {
    exit('<script language="javascript">window.location.href="login.php";</script>');
}
?>
<div class="container-fluid" style="padding-top:70px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- 导航菜单 -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
                                <span class="sr-only">切换导航</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">API接口文档</a>
                        </div>
                        <div class="collapse navbar-collapse" id="example-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="index.php">管理首页</a></li>
                                <li><a href="devdoc.php">开发文档</a></li>
                                <li><a href="system_architecture.php">系统架构</a></li>
                                <li class="active"><a href="api_doc.php">API接口文档</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- 内容区域 -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">API接口文档</h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info">
                            <strong>文档说明：</strong>本文档详细介绍系统提供的所有API接口，包括接口地址、请求参数、返回格式、使用示例等信息，帮助开发者快速集成和调用系统API。
                            <br><strong>作者：</strong>教主老师 | <strong>博客：</strong><a href="http://zhonguo.ren" target="_blank">zhonguo.ren</a> | <strong>交流群：</strong>915043052
                        </div>

                        <!-- 标签页 -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#intro" aria-controls="intro" role="tab" data-toggle="tab">接口介绍</a></li>
                            <li role="presentation"><a href="#user" aria-controls="user" role="tab" data-toggle="tab">用户接口</a></li>
                            <li role="presentation"><a href="#goods" aria-controls="goods" role="tab" data-toggle="tab">商品接口</a></li>
                            <li role="presentation"><a href="#order" aria-controls="order" role="tab" data-toggle="tab">订单接口</a></li>
                            <li role="presentation"><a href="#pay" aria-controls="pay" role="tab" data-toggle="tab">支付接口</a></li>
                            <li role="presentation"><a href="#example" aria-controls="example" role="tab" data-toggle="tab">调用示例</a></li>
                        </ul>

                        <!-- 标签页内容 -->
                        <div class="tab-content">
                            <!-- 接口介绍 -->
                            <div role="tabpanel" class="tab-pane active" id="intro">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">接口概述</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>API接口说明</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>接口协议：</strong>HTTP/HTTPS
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>请求方式：</strong>GET/POST
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>数据格式：</strong>JSON
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>字符编码：</strong>UTF-8
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>接口前缀：</strong>/api/
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>通用参数</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>token：</strong>用户令牌，大多数接口需要此参数进行身份验证
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>timestamp：</strong>时间戳，用于防止重放攻击
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>sign：</strong>签名，用于数据完整性验证
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>返回格式说明</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre>// 成功返回格式
{
    "code": 200,
    "msg": "操作成功",
    "data": {
        // 具体返回的数据内容
    }
}

// 失败返回格式
{
    "code": 错误码,
    "msg": "错误信息",
    "data": null
}</pre>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>错误码说明</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>错误码</th>
                                                            <th>错误信息</th>
                                                            <th>解决方法</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>400</td>
                                                            <td>参数错误</td>
                                                            <td>检查请求参数是否完整、格式是否正确</td>
                                                        </tr>
                                                        <tr>
                                                            <td>401</td>
                                                            <td>未授权访问</td>
                                                            <td>请先登录获取token</td>
                                                        </tr>
                                                        <tr>
                                                            <td>403</td>
                                                            <td>权限不足</td>
                                                            <td>当前用户没有权限执行此操作</td>
                                                        </tr>
                                                        <tr>
                                                            <td>404</td>
                                                            <td>接口不存在</td>
                                                            <td>检查接口地址是否正确</td>
                                                        </tr>
                                                        <tr>
                                                            <td>500</td>
                                                            <td>服务器内部错误</td>
                                                            <td>联系管理员检查服务器日志</td>
                                                        </tr>
                                                        <tr>
                                                            <td>501</td>
                                                            <td>余额不足</td>
                                                            <td>请先充值</td>
                                                        </tr>
                                                        <tr>
                                                            <td>502</td>
                                                            <td>商品不存在</td>
                                                            <td>检查商品ID是否正确</td>
                                                        </tr>
                                                        <tr>
                                                            <td>503</td>
                                                            <td>库存不足</td>
                                                            <td>该商品暂时无库存</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>签名生成规则</h4>
                                            <p>为了保证API调用的安全性，所有涉及敏感操作的API都需要进行签名验证。签名生成步骤如下：</p>
                                            <ol>
                                                <li>将所有请求参数（不包括sign）按照参数名的字典序排序</li>
                                                <li>将排序后的参数拼接成key1=value1&key2=value2...的形式</li>
                                                <li>在拼接后的字符串末尾添加API密钥（api_key）</li>
                                                <li>对最终的字符串进行MD5加密，得到签名值</li>
                                                <li>将签名值作为sign参数添加到请求中</li>
                                            </ol>
                                            <div class="bg-light p-3 rounded mt-2">
                                                <pre>示例：
参数：token=abc123&timestamp=1620000000&user_id=1001
排序后：timestamp=1620000000&token=abc123&user_id=1001
拼接API密钥：timestamp=1620000000&token=abc123&user_id=1001&api_key=mysecretkey
MD5加密：4f3d5a1b2c8e9d0f7g6h5j4k3l2m1n0
最终签名：sign=4f3d5a1b2c8e9d0f7g6h5j4k3l2m1n0</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 用户接口 -->
                            <div role="tabpanel" class="tab-pane" id="user">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">用户相关接口</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- 用户登录 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">1. 用户登录 - /api/user_login.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>POST</p>
                                                    <p><strong>接口描述：</strong>用户登录接口，用于获取访问令牌</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>username</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户名</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>password</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>密码（明文）</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "登录成功",
    "data": {
        "uid": 1001,               // 用户ID
        "username": "testuser",    // 用户名
        "token": "abc123def456",   // 访问令牌
        "balance": 100.50,         // 账户余额
        "level": 1                 // 用户等级
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 获取用户信息 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">2. 获取用户信息 - /api/user_info.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>获取当前登录用户的详细信息</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "获取成功",
    "data": {
        "uid": 1001,               // 用户ID
        "username": "testuser",    // 用户名
        "email": "test@example.com", // 邮箱
        "mobile": "13800138000",    // 手机号
        "balance": 100.50,         // 账户余额
        "level": 1,                // 用户等级
        "reg_time": "2021-01-01 12:00:00", // 注册时间
        "last_login": "2021-06-01 12:00:00" // 最后登录时间
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 查询余额 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">3. 查询余额 - /api/user_balance.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>查询用户账户余额</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "查询成功",
    "data": {
        "balance": 100.50,         // 账户余额
        "freeze_balance": 0.00     // 冻结余额
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 修改密码 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">4. 修改密码 - /api/change_password.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>POST</p>
                                                    <p><strong>接口描述：</strong>修改用户密码</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>old_pass</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>旧密码（明文）</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>new_pass</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>新密码（明文）</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "密码修改成功",
    "data": null
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 商品接口 -->
                            <div role="tabpanel" class="tab-pane" id="goods">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">商品相关接口</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- 获取商品列表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">1. 获取商品列表 - /api/goods_list.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>获取商品列表，可按分类筛选</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>cid</td>
                                                                        <td>int</td>
                                                                        <td>否</td>
                                                                        <td>分类ID，不填则获取所有分类商品</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>page</td>
                                                                        <td>int</td>
                                                                        <td>否</td>
                                                                        <td>页码，默认1</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>limit</td>
                                                                        <td>int</td>
                                                                        <td>否</td>
                                                                        <td>每页数量，默认20</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "获取成功",
    "data": {
        "total": 100,              // 总商品数
        "page": 1,                 // 当前页码
        "limit": 20,               // 每页数量
        "goods": [
            {
                "tid": 1,           // 商品ID
                "cid": 10,          // 分类ID
                "name": "测试商品",   // 商品名称
                "price": 10.00,     // 商品价格
                "stock": 999,       // 商品库存
                "status": 1,        // 商品状态：1-上架，0-下架
                "description": "商品描述", // 商品描述
                "created_at": "2021-01-01 12:00:00" // 创建时间
            },
            // 更多商品...
        ]
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 获取商品详情 -->
                                        <div class="mb-6">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">2. 获取商品详情 - /api/goods_detail.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>获取指定商品的详细信息</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>tid</td>
                                                                        <td>int</td>
                                                                        <td>是</td>
                                                                        <td>商品ID</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "获取成功",
    "data": {
        "tid": 1,                   // 商品ID
        "cid": 10,                  // 分类ID
        "name": "测试商品",           // 商品名称
        "price": 10.00,             // 商品价格
        "stock": 999,               // 商品库存
        "status": 1,                // 商品状态：1-上架，0-下架
        "description": "商品描述",       // 商品描述
        "created_at": "2021-01-01 12:00:00", // 创建时间
        "updated_at": "2021-01-02 12:00:00", // 更新时间
        "class_name": "测试分类"         // 分类名称
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 获取商品库存 -->
                                        <div class="mb-6">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">3. 获取商品库存 - /api/goods_stock.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>获取指定商品的实时库存</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>tid</td>
                                                                        <td>int</td>
                                                                        <td>是</td>
                                                                        <td>商品ID</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "查询成功",
    "data": {
        "tid": 1,                   // 商品ID
        "stock": 999,               // 当前库存
        "status": 1                 // 商品状态：1-可购买，0-不可购买
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 订单接口 -->
                            <div role="tabpanel" class="tab-pane" id="order">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">订单相关接口</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- 创建订单 -->
                                        <div class="mb-6">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">1. 创建订单 - /api/create_order.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>POST</p>
                                                    <p><strong>接口描述：</strong>创建商品订单</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>tid</td>
                                                                        <td>int</td>
                                                                        <td>是</td>
                                                                        <td>商品ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>num</td>
                                                                        <td>int</td>
                                                                        <td>是</td>
                                                                        <td>购买数量</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>input</td>
                                                                        <td>string</td>
                                                                        <td>否</td>
                                                                        <td>输入内容（如账号、链接等）</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "订单创建成功",
    "data": {
        "order_no": "202106011234567890", // 订单号
        "tid": 1,                        // 商品ID
        "num": 1,                        // 购买数量
        "price": 10.00,                  // 商品单价
        "total_price": 10.00,            // 订单总价
        "status": 1,                     // 订单状态：1-待处理，2-处理中，3-已完成，4-已取消，5-处理失败
        "create_time": "2021-06-01 12:34:56" // 创建时间
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 查询订单状态 -->
                                        <div class="mb-6">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">2. 查询订单状态 - /api/order_status.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>查询指定订单的处理状态</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>order_no</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>订单号</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "查询成功",
    "data": {
        "order_no": "202106011234567890", // 订单号
        "status": 3,                     // 订单状态：1-待处理，2-处理中，3-已完成，4-已取消，5-处理失败
        "status_text": "已完成",          // 状态文字描述
        "result": "订单处理结果内容",        // 订单处理结果（如果已完成）
        "create_time": "2021-06-01 12:34:56", // 创建时间
        "finish_time": "2021-06-01 12:36:00"  // 完成时间
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 获取订单列表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">3. 获取订单列表 - /api/order_list.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>获取用户的订单列表</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>page</td>
                                                                        <td>int</td>
                                                                        <td>否</td>
                                                                        <td>页码，默认1</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>limit</td>
                                                                        <td>int</td>
                                                                        <td>否</td>
                                                                        <td>每页数量，默认20</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>status</td>
                                                                        <td>int</td>
                                                                        <td>否</td>
                                                                        <td>订单状态，不填则查询所有状态</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>start_time</td>
                                                                        <td>string</td>
                                                                        <td>否</td>
                                                                        <td>开始时间，格式：2021-06-01</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>end_time</td>
                                                                        <td>string</td>
                                                                        <td>否</td>
                                                                        <td>结束时间，格式：2021-06-30</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "获取成功",
    "data": {
        "total": 50,                  // 总订单数
        "page": 1,                    // 当前页码
        "limit": 20,                  // 每页数量
        "orders": [
            {
                "order_no": "202106011234567890", // 订单号
                "tid": 1,                        // 商品ID
                "goods_name": "测试商品",           // 商品名称
                "num": 1,                        // 购买数量
                "total_price": 10.00,            // 订单总价
                "status": 3,                     // 订单状态
                "status_text": "已完成",          // 状态文字描述
                "create_time": "2021-06-01 12:34:56", // 创建时间
                "finish_time": "2021-06-01 12:36:00"  // 完成时间
            },
            // 更多订单...
        ]
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 支付接口 -->
                            <div role="tabpanel" class="tab-pane" id="pay">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">支付相关接口</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- 创建支付 -->
                                        <div class="mb-6">
                                            <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">1. 创建支付 - /api/create_pay.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>POST</p>
                                                    <p><strong>接口描述：</strong>创建充值支付订单</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>money</td>
                                                                        <td>float</td>
                                                                        <td>是</td>
                                                                        <td>充值金额</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>type</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>支付方式：alipay-支付宝，wechat-微信支付</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "创建支付成功",
    "data": {
        "trade_no": "202106011234567890", // 交易单号
        "money": 100.00,                  // 支付金额
        "type": "alipay",                // 支付方式
        "pay_url": "https://pay.example.com/pay?order=xxx", // 支付链接
        "qr_code": "https://pay.example.com/qrcode/xxx.png", // 支付二维码（如果是扫码支付）
        "create_time": "2021-06-01 12:34:56" // 创建时间
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 查询支付状态 -->
                                        <div class="mb-6">
                                            <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">2. 查询支付状态 - /api/pay_status.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>查询指定支付订单的状态</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>trade_no</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>交易单号</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "查询成功",
    "data": {
        "trade_no": "202106011234567890", // 交易单号
        "money": 100.00,                  // 支付金额
        "status": 2,                      // 支付状态：1-待支付，2-已支付，3-已取消，4-支付失败
        "status_text": "已支付",           // 状态文字描述
        "pay_time": "2021-06-01 12:36:00" // 支付时间
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 获取支付配置 -->
                                        <div class="mb-6">
                                            <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">3. 获取支付配置 - /api/pay_config.php</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>请求方式：</strong>GET</p>
                                                    <p><strong>接口描述：</strong>获取系统支持的支付方式配置</p>
                                                    
                                                    <div class="mt-3">
                                                        <h5>请求参数</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>参数名</th>
                                                                        <th>类型</th>
                                                                        <th>是否必填</th>
                                                                        <th>描述</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>token</td>
                                                                        <td>string</td>
                                                                        <td>是</td>
                                                                        <td>用户令牌</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h5>返回数据</h5>
                                                        <div class="bg-dark text-green p-3 rounded">
<pre>{
    "code": 200,
    "msg": "获取成功",
    "data": {
        "min_money": 1.00,               // 最小充值金额
        "max_money": 10000.00,           // 最大充值金额
        "pay_methods": [
            {
                "type": "alipay",       // 支付方式标识
                "name": "支付宝",       // 支付方式名称
                "icon": "https://example.com/alipay.png", // 支付图标
                "status": 1              // 状态：1-启用，0-禁用
            },
            {
                "type": "wechat",       // 支付方式标识
                "name": "微信支付",     // 支付方式名称
                "icon": "https://example.com/wechat.png", // 支付图标
                "status": 1              // 状态：1-启用，0-禁用
            }
        ]
    }
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 调用示例 -->
                            <div role="tabpanel" class="tab-pane" id="example">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">API调用示例</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- PHP调用示例 -->
                                        <div class="mb-6">
                                            <h4 class="text-primary">PHP调用示例</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre>// PHP通用API请求函数
function api_request($url, $params = array(), $method = 'GET') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    } else {
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        }
    }
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// 1. 用户登录示例\$login_result = api_request('http://127.0.0.3/api/user_login.php', array(
    'username' => 'testuser',
    'password' => 'test123'
), 'POST');

if (\$login_result['code'] == 200) {
    \$token = \$login_result['data']['token'];
    echo '登录成功，Token：' . \$token . "\n";
} else {
    echo '登录失败：' . \$login_result['msg'] . "\n";
}

// 2. 创建订单示例（需要先登录获取token）\$order_result = api_request('http://127.0.0.3/api/create_order.php', array(
    'token' => \$token,
    'tid' => 1,
    'num' => 1,
    'input' => 'test input'
), 'POST');

if (\$order_result['code'] == 200) {
    \$order_no = \$order_result['data']['order_no'];
    echo '订单创建成功，订单号：' . \$order_no . "\n";
} else {
    echo '订单创建失败：' . \$order_result['msg'] . "\n";
}

// 3. 查询订单状态示例
\$status_result = api_request('http://127.0.0.3/api/order_status.php', array(
    'token' => \$token,
    'order_no' => \$order_no
), 'GET');

if (\$status_result['code'] == 200) {
    echo '订单状态：' . \$status_result['data']['status_text'] . "\n";
    if (\$status_result['data']['status'] == 3) {
        echo '订单结果：' . \$status_result['data']['result'] . "\n";
    }
} else {
    echo '查询失败：' . \$status_result['msg'] . "\n";
}</pre>
                                            </div>
                                        </div>

                                        <!-- JavaScript调用示例 -->
                                        <div class="mb-6">
                                            <h4 class="text-primary">JavaScript调用示例</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre>// JavaScript使用Fetch API调用示例

// 1. 用户登录示例
async function userLogin() {
    try {
        const response = await fetch('http://127.0.0.3/api/user_login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: 'testuser',
                password: 'test123'
            })
        });
        
        const data = await response.json();
        
        if (data.code === 200) {
            const token = data.data.token;
            console.log('登录成功，Token：', token);
            return token;
        } else {
            console.error('登录失败：', data.msg);
            return null;
        }
    } catch (error) {
        console.error('请求异常：', error);
        return null;
    }
}

// 2. 创建订单示例
async function createOrder(token) {
    try {
        const response = await fetch('http://127.0.0.3/api/create_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                token: token,
                tid: 1,
                num: 1,
                input: 'test input'
            })
        });
        
        const data = await response.json();
        
        if (data.code === 200) {
            const orderNo = data.data.order_no;
            console.log('订单创建成功，订单号：', orderNo);
            return orderNo;
        } else {
            console.error('订单创建失败：', data.msg);
            return null;
        }
    } catch (error) {
        console.error('请求异常：', error);
        return null;
    }
}

// 3. 查询订单状态示例
async function queryOrderStatus(token, orderNo) {
    try {
        const response = await fetch(`http://127.0.0.3/api/order_status.php?token=${encodeURIComponent(token)}&order_no=${encodeURIComponent(orderNo)}`, {
            method: 'GET'
        });
        
        const data = await response.json();
        
        if (data.code === 200) {
            console.log('订单状态：', data.data.status_text);
            if (data.data.status === 3) {
                console.log('订单结果：', data.data.result);
            }
            return data.data;
        } else {
            console.error('查询失败：', data.msg);
            return null;
        }
    } catch (error) {
        console.error('请求异常：', error);
        return null;
    }
}

// 调用流程示例
async function main() {
    const token = await userLogin();
    if (token) {
        const orderNo = await createOrder(token);
        if (orderNo) {
            // 轮询查询订单状态
            const checkStatus = async () => {
                const status = await queryOrderStatus(token, orderNo);
                if (status && status.status !== 3 && status.status !== 4 && status.status !== 5) {
                    setTimeout(checkStatus, 3000); // 3秒后再次查询
                }
            };
            checkStatus();
        }
    }
}

// 执行主函数
main();</pre>
                                            </div>
                                        </div>

                                        <!-- Python调用示例 -->
                                        <div class="mb-6">
                                            <h4 class="text-primary">Python调用示例</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre># Python调用示例
import requests
import json

# 通用API请求函数
def api_request(url, params=None, method='GET'):
    try:
        if method == 'POST':
            response = requests.post(url, data=params)
        else:
            response = requests.get(url, params=params)
        
        # 检查响应状态
        if response.status_code == 200:
            return response.json()
        else:
            return {'code': response.status_code, 'msg': 'HTTP请求失败', 'data': None}
    except Exception as e:
        return {'code': 500, 'msg': str(e), 'data': None}

# 1. 用户登录示例
def user_login(username, password):
    url = 'http://127.0.0.3/api/user_login.php'
    params = {
        'username': username,
        'password': password
    }
    result = api_request(url, params, 'POST')
    return result

# 2. 创建订单示例
def create_order(token, tid, num, input_data=''):
    url = 'http://127.0.0.3/api/create_order.php'
    params = {
        'token': token,
        'tid': tid,
        'num': num,
        'input': input_data
    }
    result = api_request(url, params, 'POST')
    return result

# 3. 查询订单状态示例
def query_order_status(token, order_no):
    url = 'http://127.0.0.3/api/order_status.php'
    params = {
        'token': token,
        'order_no': order_no
    }
    result = api_request(url, params, 'GET')
    return result

# 调用示例
if __name__ == '__main__':
    # 用户登录
    login_result = user_login('testuser', 'test123')
    if login_result['code'] == 200:
        token = login_result['data']['token']
        print(f'登录成功，Token：{token}')
        
        # 创建订单
        order_result = create_order(token, 1, 1, 'test input')
        if order_result['code'] == 200:
            order_no = order_result['data']['order_no']
            print(f'订单创建成功，订单号：{order_no}')
            
            # 查询订单状态
            status_result = query_order_status(token, order_no)
            if status_result['code'] == 200:
                print(f'订单状态：{status_result['data']['status_text']}')
                if status_result['data']['status'] == 3:
                    print(f'订单结果：{status_result['data']['result']}')
            else:
                print(f'查询失败：{status_result['msg']}')
        else:
            print(f'订单创建失败：{order_result['msg']}')
    else:
        print(f'登录失败：{login_result['msg']}')</pre>
                                            </div>
                                        </div>

                                        <!-- API调用注意事项 -->
                                        <div class="mb-6">
                                            <h4 class="text-warning">API调用注意事项</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>接口频率限制：</strong>为保证系统稳定，API接口有访问频率限制，建议不要频繁调用
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>错误处理：</strong>请务必处理API返回的错误情况，不要假定所有请求都会成功
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>超时处理：</strong>设置合理的请求超时时间，避免因网络问题导致程序卡死
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>数据缓存：</strong>对于不常变动的数据，可以进行本地缓存，减少API调用次数
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>安全措施：</strong>不要在客户端暴露API密钥等敏感信息，建议在服务端进行API调用
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>订单查询：</strong>对于异步处理的订单，可以使用轮询方式查询结果，但轮询间隔应不少于3秒
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>异常重试：</strong>对于网络波动等临时性问题导致的请求失败，可以适当进行重试，但需设置最大重试次数
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../foot.php'; ?>
<script src="<?php echo $cdnpublic?>layer/3.1.1/layer.js"></script>