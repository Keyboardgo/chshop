<?php
// ===================================================================================
// 数据库设计文档 - 由教主老师创建
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
                            <a class="navbar-brand" href="#">数据库设计文档</a>
                        </div>
                        <div class="collapse navbar-collapse" id="example-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="index.php">管理首页</a></li>
                                <li><a href="devdoc.php">开发文档</a></li>
                                <li><a href="system_architecture.php">系统架构</a></li>
                                <li><a href="api_doc.php">API接口文档</a></li>
                                <li class="active"><a href="database_design.php">数据库设计</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- 内容区域 -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">数据库设计文档</h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info">
                            <strong>文档说明：</strong>本文档详细介绍系统的数据库设计，包括数据库架构、表结构设计、表关系、索引优化及数据安全措施等内容。
                            <br><strong>作者：</strong>教主老师 | <strong>博客：</strong><a href="http://zhonguo.ren" target="_blank">zhonguo.ren</a> | <strong>交流群：</strong>915043052
                        </div>

                        <!-- 标签页 -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">数据库概览</a></li>
                            <li role="presentation"><a href="#tables" aria-controls="tables" role="tab" data-toggle="tab">表结构详解</a></li>
                            <li role="presentation"><a href="#relations" aria-controls="relations" role="tab" data-toggle="tab">表关系图</a></li>
                            <li role="presentation"><a href="#indexes" aria-controls="indexes" role="tab" data-toggle="tab">索引优化</a></li>
                            <li role="presentation"><a href="#security" aria-controls="security" role="tab" data-toggle="tab">数据安全</a></li>
                            <li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab">性能优化</a></li>
                        </ul>

                        <!-- 标签页内容 -->
                        <div class="tab-content">
                            <!-- 数据库概览 -->
                            <div role="tabpanel" class="tab-pane active" id="overview">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">数据库架构</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>数据库信息</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>数据库类型：</strong>MySQL 5.7
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>字符集：</strong>utf8mb4
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>排序规则：</strong>utf8mb4_unicode_ci
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>存储引擎：</strong>InnoDB (默认)
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>表前缀：</strong>shua_
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>数据库设计原则</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>数据独立性：</strong>遵循数据库设计三大范式
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>性能优化：</strong>合理设计索引，优化查询效率
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>数据安全：</strong>加密敏感数据，控制访问权限
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>可扩展性：</strong>模块化设计，便于未来扩展
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>维护性：</strong>详细的字段说明和注释
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>数据库表分类</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>分类</th>
                                                            <th>表名</th>
                                                            <th>描述</th>
                                                            <th>核心程度</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td rowspan="2">用户管理</td>
                                                            <td>shua_account</td>
                                                            <td>管理员账户表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>用户/站点表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2">商品管理</td>
                                                            <td>shua_tools</td>
                                                            <td>商品表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_class</td>
                                                            <td>商品分类表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2">订单管理</td>
                                                            <td>shua_orders</td>
                                                            <td>订单表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_faka</td>
                                                            <td>卡密表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td>支付管理</td>
                                                            <td>shua_pay</td>
                                                            <td>支付记录表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2">系统管理</td>
                                                            <td>shua_config</td>
                                                            <td>系统配置表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_logs</td>
                                                            <td>操作日志表</td>
                                                            <td>重要</td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2">财务管理</td>
                                                            <td>shua_tixian</td>
                                                            <td>提现记录表</td>
                                                            <td>核心</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_shop</td>
                                                            <td>商户记录表</td>
                                                            <td>重要</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>数据库关系概览</h4>
                                            <div class="bg-light p-4 rounded">
                                                <p>系统数据库采用了清晰的关系设计，主要关系包括：</p>
                                                <ul>
                                                    <li><strong>用户-订单关系：</strong>一个用户可以创建多个订单（一对多）</li>
                                                    <li><strong>商品-订单关系：</strong>一个商品可以出现在多个订单中（一对多）</li>
                                                    <li><strong>分类-商品关系：</strong>一个分类可以包含多个商品（一对多）</li>
                                                    <li><strong>用户-支付关系：</strong>一个用户可以进行多次支付（一对多）</li>
                                                    <li><strong>用户-提现关系：</strong>一个用户可以提交多个提现申请（一对多）</li>
                                                    <li><strong>商品-卡密关系：</strong>一个商品可以对应多个卡密（一对多）</li>
                                                </ul>
                                                <p>这种关系设计确保了数据的一致性和完整性，同时提高了数据查询和管理的效率。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 表结构详解 -->
                            <div role="tabpanel" class="tab-pane" id="tables">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">表结构详细设计</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- 管理员账户表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">1. 管理员账户表 - shua_account</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>表说明：</strong>存储系统管理员账户信息</p>
                                                    
                                                    <div class="mt-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>字段名</th>
                                                                        <th>数据类型</th>
                                                                        <th>长度</th>
                                                                        <th>是否主键</th>
                                                                        <th>是否自增</th>
                                                                        <th>默认值</th>
                                                                        <th>是否允许空</th>
                                                                        <th>备注</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>id</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>是</td>
                                                                        <td>是</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>管理员ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>user</td>
                                                                        <td>varchar</td>
                                                                        <td>32</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>用户名</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>pass</td>
                                                                        <td>varchar</td>
                                                                        <td>32</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>密码（MD5加密）</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>addtime</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>添加时间</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>login_ip</td>
                                                                        <td>varchar</td>
                                                                        <td>20</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>NULL</td>
                                                                        <td>是</td>
                                                                        <td>登录IP</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>login_time</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>登录时间</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 用户/站点表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">2. 用户/站点表 - shua_site</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>表说明：</strong>存储系统用户和站点信息</p>
                                                    
                                                    <div class="mt-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>字段名</th>
                                                                        <th>数据类型</th>
                                                                        <th>长度</th>
                                                                        <th>是否主键</th>
                                                                        <th>是否自增</th>
                                                                        <th>默认值</th>
                                                                        <th>是否允许空</th>
                                                                        <th>备注</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>zid</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>是</td>
                                                                        <td>是</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>站点ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>upzid</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>上级站点ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>domain</td>
                                                                        <td>varchar</td>
                                                                        <td>100</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>域名</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>user</td>
                                                                        <td>varchar</td>
                                                                        <td>50</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>用户名</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>pass</td>
                                                                        <td>varchar</td>
                                                                        <td>32</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>balance</td>
                                                                        <td>decimal</td>
                                                                        <td>10,2</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0.00</td>
                                                                        <td>否</td>
                                                                        <td>余额</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>status</td>
                                                                        <td>tinyint</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>状态：1-正常，0-禁用</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>addtime</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>注册时间</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>level</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>等级</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>api_token</td>
                                                                        <td>varchar</td>
                                                                        <td>32</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 商品表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">3. 商品表 - shua_tools</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>表说明：</strong>存储系统商品信息</p>
                                                    
                                                    <div class="mt-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>字段名</th>
                                                                        <th>数据类型</th>
                                                                        <th>长度</th>
                                                                        <th>是否主键</th>
                                                                        <th>是否自增</th>
                                                                        <th>默认值</th>
                                                                        <th>是否允许空</th>
                                                                        <th>备注</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>tid</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>是</td>
                                                                        <td>是</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>商品ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>zid</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>站点ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>name</td>
                                                                        <td>varchar</td>
                                                                        <td>50</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>price</td>
                                                                        <td>decimal</td>
                                                                        <td>10,2</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0.00</td>
                                                                        <td>否</td>
                                                                        <td>价格</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>cost_price</td>
                                                                        <td>decimal</td>
                                                                        <td>10,2</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0.00</td>
                                                                        <td>否</td>
                                                                        <td>成本价</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>type</td>
                                                                        <td>varchar</td>
                                                                        <td>30</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>input</td>
                                                                        <td>tinyint</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>是否需要输入</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>stock</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>9999</td>
                                                                        <td>否</td>
                                                                        <td>库存</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>status</td>
                                                                        <td>tinyint</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>状态：1-上架，0-下架</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>description</td>
                                                                        <td>text</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>addtime</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>添加时间</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 订单表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">4. 订单表 - shua_orders</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>表说明：</strong>存储系统订单信息</p>
                                                    
                                                    <div class="mt-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>字段名</th>
                                                                        <th>数据类型</th>
                                                                        <th>长度</th>
                                                                        <th>是否主键</th>
                                                                        <th>是否自增</th>
                                                                        <th>默认值</th>
                                                                        <th>是否允许空</th>
                                                                        <th>备注</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>id</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>是</td>
                                                                        <td>是</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>订单ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>tid</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>商品ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>zid</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>用户ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>order_no</td>
                                                                        <td>varchar</td>
                                                                        <td>32</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>num</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>数量</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>price</td>
                                                                        <td>decimal</td>
                                                                        <td>10,2</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0.00</td>
                                                                        <td>否</td>
                                                                        <td>单价</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>total_price</td>
                                                                        <td>decimal</td>
                                                                        <td>10,2</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>input</td>
                                                                        <td>text</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>result</td>
                                                                        <td>text</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>status</td>
                                                                        <td>tinyint</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>1</td>
                                                                        <td>否</td>
                                                                        <td>状态：1-待处理，2-处理中，3-已完成，4-已取消，5-处理失败</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>addtime</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>下单时间</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>usetime</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>0</td>
                                                                        <td>否</td>
                                                                        <td>完成时间</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 系统配置表 -->
                                        <div class="mb-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">5. 系统配置表 - shua_config</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>表说明：</strong>存储系统各项配置参数</p>
                                                    
                                                    <div class="mt-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>字段名</th>
                                                                        <th>数据类型</th>
                                                                        <th>长度</th>
                                                                        <th>是否主键</th>
                                                                        <th>是否自增</th>
                                                                        <th>默认值</th>
                                                                        <th>是否允许空</th>
                                                                        <th>备注</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>id</td>
                                                                        <td>int</td>
                                                                        <td>11</td>
                                                                        <td>是</td>
                                                                        <td>是</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>配置ID</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>k</td>
                                                                        <td>varchar</td>
                                                                        <td>50</td>
                                                                        <td>否</td>
                                                                        <td>否</td>
                                                                        <td>NULL</td>
                                                                        <td>否</td>
                                                                        <td>配置键名</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>v</td>
                                                                        <td>text</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>desc</td>
                                                                        <td>varchar</td>
                                                                        <td>255</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 其他重要表结构可以根据需要继续添加 -->
                                    </div>
                                </div>
                            </div>

                            <!-- 表关系图 -->
                            <div role="tabpanel" class="tab-pane" id="relations">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">数据库表关系图</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="alert alert-info">
                                            <strong>说明：</strong>下图展示了系统主要数据表之间的关系，通过外键和逻辑关联体现了数据的流转和依赖关系。
                                        </div>

                                        <div class="bg-white p-4 rounded shadow">
                                            <!-- 简单的表关系图 -->
                                            <svg width="100%" height="600" viewBox="0 0 1200 600" xmlns="http://www.w3.org/2000/svg">
                                                <!-- 管理员表 -->
                                                <rect x="100" y="50" width="180" height="80" rx="5" fill="#f0f8ff" stroke="#4682b4" stroke-width="2"/>
                                                <text x="190" y="80" text-anchor="middle" font-weight="bold">shua_account</text>
                                                <text x="190" y="100" text-anchor="middle" font-size="12">管理员账户表</text>
                                                
                                                <!-- 用户/站点表 -->
                                                <rect x="100" y="200" width="180" height="80" rx="5" fill="#f0fff4" stroke="#2e8b57" stroke-width="2"/>
                                                <text x="190" y="230" text-anchor="middle" font-weight="bold">shua_site</text>
                                                <text x="190" y="250" text-anchor="middle" font-size="12">用户/站点表</text>
                                                
                                                <!-- 商品分类表 -->
                                                <rect x="350" y="50" width="180" height="80" rx="5" fill="#fff0f5" stroke="#c71585" stroke-width="2"/>
                                                <text x="440" y="80" text-anchor="middle" font-weight="bold">shua_class</text>
                                                <text x="440" y="100" text-anchor="middle" font-size="12">商品分类表</text>
                                                
                                                <!-- 商品表 -->
                                                <rect x="350" y="200" width="180" height="80" rx="5" fill="#f5f5dc" stroke="#daa520" stroke-width="2"/>
                                                <text x="440" y="230" text-anchor="middle" font-weight="bold">shua_tools</text>
                                                <text x="440" y="250" text-anchor="middle" font-size="12">商品表</text>
                                                
                                                <!-- 订单表 -->
                                                <rect x="600" y="125" width="180" height="80" rx="5" fill="#f0f8ff" stroke="#4169e1" stroke-width="2"/>
                                                <text x="690" y="155" text-anchor="middle" font-weight="bold">shua_orders</text>
                                                <text x="690" y="175" text-anchor="middle" font-size="12">订单表</text>
                                                
                                                <!-- 卡密表 -->
                                                <rect x="600" y="275" width="180" height="80" rx="5" fill="#fff5ee" stroke="#cd5c5c" stroke-width="2"/>
                                                <text x="690" y="305" text-anchor="middle" font-weight="bold">shua_faka</text>
                                                <text x="690" y="325" text-anchor="middle" font-size="12">卡密表</text>
                                                
                                                <!-- 支付表 -->
                                                <rect x="850" y="50" width="180" height="80" rx="5" fill="#f0e68c" stroke="#ff8c00" stroke-width="2"/>
                                                <text x="940" y="80" text-anchor="middle" font-weight="bold">shua_pay</text>
                                                <text x="940" y="100" text-anchor="middle" font-size="12">支付记录表</text>
                                                
                                                <!-- 提现表 -->
                                                <rect x="850" y="200" width="180" height="80" rx="5" fill="#e6e6fa" stroke="#9370db" stroke-width="2"/>
                                                <text x="940" y="230" text-anchor="middle" font-weight="bold">shua_tixian</text>
                                                <text x="940" y="250" text-anchor="middle" font-size="12">提现记录表</text>
                                                
                                                <!-- 日志表 -->
                                                <rect x="850" y="350" width="180" height="80" rx="5" fill="#dcdcdc" stroke="#696969" stroke-width="2"/>
                                                <text x="940" y="380" text-anchor="middle" font-weight="bold">shua_logs</text>
                                                <text x="940" y="400" text-anchor="middle" font-size="12">操作日志表</text>
                                                
                                                <!-- 配置表 -->
                                                <rect x="350" y="350" width="180" height="80" rx="5" fill="#ffe4e1" stroke="#ff6347" stroke-width="2"/>
                                                <text x="440" y="380" text-anchor="middle" font-weight="bold">shua_config</text>
                                                <text x="440" y="400" text-anchor="middle" font-size="12">系统配置表</text>
                                                
                                                <!-- 关系线 -->
                                                <!-- 管理员表 -> 配置表 -->
                                                <line x1="280" y1="90" x2="350" y2="390" stroke="#4682b4" stroke-width="1.5" stroke-dasharray="5,5"/>
                                                <polygon points="350,390 345,380 355,380" fill="#4682b4"/>
                                                
                                                <!-- 用户表 -> 订单表 -->
                                                <line x1="280" y1="240" x2="600" y2="165" stroke="#2e8b57" stroke-width="1.5"/>
                                                <polygon points="600,165 590,160 590,170" fill="#2e8b57"/>
                                                
                                                <!-- 用户表 -> 支付表 -->
                                                <line x1="280" y1="220" x2="850" y2="90" stroke="#2e8b57" stroke-width="1.5"/>
                                                <polygon points="850,90 840,85 840,95" fill="#2e8b57"/>
                                                
                                                <!-- 用户表 -> 提现表 -->
                                                <line x1="280" y1="260" x2="850" y2="240" stroke="#2e8b57" stroke-width="1.5"/>
                                                <polygon points="850,240 840,235 840,245" fill="#2e8b57"/>
                                                
                                                <!-- 分类表 -> 商品表 -->
                                                <line x1="440" y1="130" x2="440" y2="200" stroke="#c71585" stroke-width="1.5"/>
                                                <polygon points="440,200 435,190 445,190" fill="#c71585"/>
                                                
                                                <!-- 商品表 -> 订单表 -->
                                                <line x1="530" y1="240" x2="650" y2="165" stroke="#daa520" stroke-width="1.5"/>
                                                <polygon points="650,165 640,160 640,170" fill="#daa520"/>
                                                
                                                <!-- 商品表 -> 卡密表 -->
                                                <line x1="530" y1="260" x2="650" y2="275" stroke="#daa520" stroke-width="1.5"/>
                                                <polygon points="650,275 640,270 640,280" fill="#daa520"/>
                                                
                                                <!-- 订单表 -> 日志表 -->
                                                <line x1="780" y1="165" x2="850" y2="390" stroke="#4169e1" stroke-width="1.5" stroke-dasharray="5,5"/>
                                                <polygon points="850,390 840,385 840,395" fill="#4169e1"/>
                                                
                                                <!-- 支付表 -> 日志表 -->
                                                <line x1="940" y1="130" x2="940" y2="350" stroke="#ff8c00" stroke-width="1.5" stroke-dasharray="5,5"/>
                                                <polygon points="940,350 935,340 945,340" fill="#ff8c00"/>
                                                
                                                <!-- 提现表 -> 日志表 -->
                                                <line x1="940" y1="280" x2="940" y2="390" stroke="#9370db" stroke-width="1.5" stroke-dasharray="5,5"/>
                                                <polygon points="940,390 935,380 945,380" fill="#9370db"/>
                                            </svg>
                                        </div>

                                        <div class="mt-6">
                                            <h4>表关系说明</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>源表</th>
                                                            <th>源字段</th>
                                                            <th>目标表</th>
                                                            <th>目标字段</th>
                                                            <th>关系类型</th>
                                                            <th>描述</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>zid</td>
                                                            <td>shua_orders</td>
                                                            <td>zid</td>
                                                            <td>一对多</td>
                                                            <td>一个用户可以创建多个订单</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>zid</td>
                                                            <td>shua_pay</td>
                                                            <td>zid</td>
                                                            <td>一对多</td>
                                                            <td>一个用户可以进行多次支付</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>zid</td>
                                                            <td>shua_tixian</td>
                                                            <td>zid</td>
                                                            <td>一对多</td>
                                                            <td>一个用户可以提交多个提现申请</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_class</td>
                                                            <td>cid</td>
                                                            <td>shua_tools</td>
                                                            <td>cid</td>
                                                            <td>一对多</td>
                                                            <td>一个分类可以包含多个商品</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_tools</td>
                                                            <td>tid</td>
                                                            <td>shua_orders</td>
                                                            <td>tid</td>
                                                            <td>一对多</td>
                                                            <td>一个商品可以出现在多个订单中</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_tools</td>
                                                            <td>tid</td>
                                                            <td>shua_faka</td>
                                                            <td>tid</td>
                                                            <td>一对多</td>
                                                            <td>一个商品可以对应多个卡密</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>zid</td>
                                                            <td>shua_logs</td>
                                                            <td>zid</td>
                                                            <td>一对多</td>
                                                            <td>一个用户可以产生多个操作日志</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 索引优化 -->
                            <div role="tabpanel" class="tab-pane" id="indexes">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">索引优化建议</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="alert alert-warning">
                                            <strong>索引优化说明：</strong>合理的索引设计可以显著提高数据库查询性能，但过多的索引会影响写入性能。以下是针对各表的索引优化建议。
                                        </div>

                                        <div class="mb-6">
                                            <h4>当前索引状态</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>表名</th>
                                                            <th>索引名称</th>
                                                            <th>索引字段</th>
                                                            <th>索引类型</th>
                                                            <th>备注</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>shua_account</td>
                                                            <td>PRIMARY</td>
                                                            <td>id</td>
                                                            <td>主键</td>
                                                            <td>自增主键索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_account</td>
                                                            <td>user</td>
                                                            <td>user</td>
                                                            <td>唯一索引</td>
                                                            <td>用户名唯一索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>PRIMARY</td>
                                                            <td>zid</td>
                                                            <td>主键</td>
                                                            <td>自增主键索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>user</td>
                                                            <td>user</td>
                                                            <td>唯一索引</td>
                                                            <td>用户名唯一索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_tools</td>
                                                            <td>PRIMARY</td>
                                                            <td>tid</td>
                                                            <td>主键</td>
                                                            <td>自增主键索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_orders</td>
                                                            <td>PRIMARY</td>
                                                            <td>id</td>
                                                            <td>主键</td>
                                                            <td>自增主键索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_orders</td>
                                                            <td>order_no</td>
                                                            <td>order_no</td>
                                                            <td>唯一索引</td>
                                                            <td>订单号唯一索引</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_pay</td>
                                                            <td>PRIMARY</td>
                                                            <td>id</td>
                                                            <td>主键</td>
                                                            <td>自增主键索引</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4>建议添加的索引</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>表名</th>
                                                            <th>索引字段</th>
                                                            <th>索引类型</th>
                                                            <th>优化效果</th>
                                                            <th>SQL语句</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>api_token</td>
                                                            <td>普通索引</td>
                                                            <td>加速API访问认证</td>
                                                            <td>ALTER TABLE `shua_site` ADD INDEX `idx_api_token` (`api_token`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_tools</td>
                                                            <td>cid, status</td>
                                                            <td>复合索引</td>
                                                            <td>加速商品分类查询和状态筛选</td>
                                                            <td>ALTER TABLE `shua_tools` ADD INDEX `idx_cid_status` (`cid`, `status`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_orders</td>
                                                            <td>zid, addtime</td>
                                                            <td>复合索引</td>
                                                            <td>加速用户订单列表查询和时间排序</td>
                                                            <td>ALTER TABLE `shua_orders` ADD INDEX `idx_zid_addtime` (`zid`, `addtime`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_orders</td>
                                                            <td>status, addtime</td>
                                                            <td>复合索引</td>
                                                            <td>加速按状态查询订单和时间排序</td>
                                                            <td>ALTER TABLE `shua_orders` ADD INDEX `idx_status_addtime` (`status`, `addtime`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_orders</td>
                                                            <td>tid, addtime</td>
                                                            <td>复合索引</td>
                                                            <td>加速按商品查询订单和时间排序</td>
                                                            <td>ALTER TABLE `shua_orders` ADD INDEX `idx_tid_addtime` (`tid`, `addtime`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_pay</td>
                                                            <td>zid, addtime</td>
                                                            <td>复合索引</td>
                                                            <td>加速用户支付记录查询和时间排序</td>
                                                            <td>ALTER TABLE `shua_pay` ADD INDEX `idx_zid_addtime` (`zid`, `addtime`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_pay</td>
                                                            <td>trade_no</td>
                                                            <td>唯一索引</td>
                                                            <td>确保交易单号唯一并加速查询</td>
                                                            <td>ALTER TABLE `shua_pay` ADD UNIQUE INDEX `idx_trade_no` (`trade_no`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_tixian</td>
                                                            <td>zid, status</td>
                                                            <td>复合索引</td>
                                                            <td>加速用户提现记录查询和状态筛选</td>
                                                            <td>ALTER TABLE `shua_tixian` ADD INDEX `idx_zid_status` (`zid`, `status`);</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_logs</td>
                                                            <td>zid, addtime</td>
                                                            <td>复合索引</td>
                                                            <td>加速用户操作日志查询和时间排序</td>
                                                            <td>ALTER TABLE `shua_logs` ADD INDEX `idx_zid_addtime` (`zid`, `addtime`);</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4>索引使用注意事项</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>避免过度索引：</strong>每个表的索引数量不宜过多，一般不超过5个
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>选择合适的字段：</strong>经常用于WHERE条件、ORDER BY、GROUP BY和JOIN的字段适合建立索引
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>前缀索引：</strong>对于较长的字符串字段，可以只对前几个字符建立索引，提高效率
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>复合索引顺序：</strong>将选择性高的字段放在复合索引前面
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>定期维护：</strong>定期检查索引使用情况，删除不使用或使用频率低的索引
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>避免在频繁更新的字段上建立索引：</strong>会影响写入性能
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>注意索引选择性：</strong>选择性低的字段（如性别）不适合建立索引
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mb-6">
                                            <h4>查询优化示例</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre>-- 优化前：没有合适的索引，全表扫描
SELECT * FROM shua_orders WHERE zid = 1001 AND addtime > 1609430400 ORDER BY addtime DESC;

-- 优化后：添加索引idx_zid_addtime，使用索引扫描
-- 先添加索引
ALTER TABLE `shua_orders` ADD INDEX `idx_zid_addtime` (`zid`, `addtime`);
-- 执行查询（会使用索引）
SELECT * FROM shua_orders WHERE zid = 1001 AND addtime > 1609430400 ORDER BY addtime DESC;

-- 优化前：LIKE查询以%开头，无法使用索引
SELECT * FROM shua_tools WHERE name LIKE '%测试%';

-- 优化后：如果需要频繁进行这类查询，可以考虑使用全文索引
ALTER TABLE `shua_tools` ADD FULLTEXT INDEX `ft_name` (`name`);
SELECT * FROM shua_tools WHERE MATCH(name) AGAINST('测试');

-- 优化前：没有WHERE条件，全表扫描
SELECT COUNT(*) FROM shua_orders;

-- 优化后：如果需要频繁统计，可以考虑使用计数表或缓存结果
-- 创建计数表
CREATE TABLE `shua_counts` (
    `table_name` VARCHAR(50) NOT NULL PRIMARY KEY,
    `count` INT NOT NULL DEFAULT 0,
    `update_time` INT NOT NULL DEFAULT 0
);
-- 定期更新计数
UPDATE `shua_counts` SET `count` = (SELECT COUNT(*) FROM shua_orders), `update_time` = UNIX_TIMESTAMP() WHERE `table_name` = 'shua_orders';
-- 查询计数
SELECT `count` FROM `shua_counts` WHERE `table_name` = 'shua_orders';</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 数据安全 -->
                            <div role="tabpanel" class="tab-pane" id="security">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">数据安全措施</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="alert alert-danger">
                                            <strong>数据安全重要性：</strong>数据安全是系统稳定运行的重要保障，以下是系统采取的数据安全措施和建议。
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>数据加密</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>密码加密：</strong>用户密码使用MD5加密存储，建议升级为更安全的加密方式
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>敏感信息：</strong>银行卡号、身份证号等敏感信息应进行加密存储
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>传输加密：</strong>API接口建议使用HTTPS协议进行数据传输加密
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>密钥管理：</strong>加密密钥应妥善保管，避免明文存储在代码或配置文件中
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>访问控制</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>权限分离：</strong>不同用户分配不同的操作权限，遵循最小权限原则
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>登录限制：</strong>设置登录失败次数限制，防止暴力破解
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>会话管理：</strong>合理设置会话过期时间，避免会话被劫持
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>IP白名单：</strong>重要管理接口建议设置IP白名单访问限制
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>SQL注入防护</h4>
                                            <div class="bg-light p-3 rounded">
                                                <p>系统开发中应严格防止SQL注入攻击，主要措施包括：</p>
                                                <ol>
                                                    <li>使用参数化查询或预处理语句，避免直接拼接SQL语句</li>
                                                    <li>对用户输入进行严格的过滤和转义</li>
                                                    <li>限制用户输入的长度和格式</li>
                                                    <li>避免使用动态SQL语句，特别是包含用户输入的部分</li>
                                                    <li>定期进行安全审计和漏洞扫描</li>
                                                </ol>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>数据备份与恢复</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>备份类型</th>
                                                            <th>备份频率</th>
                                                            <th>备份方式</th>
                                                            <th>存储位置</th>
                                                            <th>恢复方法</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>全量备份</td>
                                                            <td>每天1次</td>
                                                            <td>mysqldump命令</td>
                                                            <td>本地+异地存储</td>
                                                            <td>mysql命令导入</td>
                                                        </tr>
                                                        <tr>
                                                            <td>增量备份</td>
                                                            <td>每小时1次</td>
                                                            <td>二进制日志</td>
                                                            <td>本地存储</td>
                                                            <td>mysqlbinlog命令</td>
                                                        </tr>
                                                        <tr>
                                                            <td>重要表备份</td>
                                                            <td>每30分钟1次</td>
                                                            <td>mysqldump命令</td>
                                                            <td>本地存储</td>
                                                            <td>mysql命令导入</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>安全编码示例</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre>// 错误示例：直接拼接SQL语句，存在SQL注入风险
$user = $_POST['username'];
$pass = $_POST['password'];
$sql = "SELECT * FROM shua_site WHERE user = '$user' AND pass = '$pass'";
$result = mysqli_query($conn, $sql);

// 正确示例：使用参数化查询，防止SQL注入
$user = $_POST['username'];
$pass = $_POST['password'];
$stmt = $conn->prepare("SELECT * FROM shua_site WHERE user = ? AND pass = ?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

// 错误示例：明文存储敏感信息
$credit_card = $_POST['credit_card'];
$sql = "INSERT INTO payments (card_number) VALUES ('$credit_card')";

// 正确示例：加密存储敏感信息
$credit_card = $_POST['credit_card'];
$encrypted_card = encrypt_data($credit_card, $encryption_key);
$stmt = $conn->prepare("INSERT INTO payments (card_number) VALUES (?)");
$stmt->bind_param("s", $encrypted_card);</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 性能优化 -->
                            <div role="tabpanel" class="tab-pane" id="optimization">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">数据库性能优化建议</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="alert alert-success">
                                            <strong>性能优化说明：</strong>随着系统数据量的增长，数据库性能优化变得越来越重要。以下是针对系统的数据库性能优化建议。
                                        </div>

                                        <div class="mb-6">
                                            <h4>数据库配置优化</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>配置项</th>
                                                            <th>当前值</th>
                                                            <th>建议值</th>
                                                            <th>说明</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>innodb_buffer_pool_size</td>
                                                            <td>128M</td>
                                                            <td>系统内存的50%-80%</td>
                                                            <td>InnoDB缓冲池大小，对性能影响最大的参数</td>
                                                        </tr>
                                                        <tr>
                                                            <td>max_connections</td>
                                                            <td>151</td>
                                                            <td>根据并发量调整（建议500-1000）</td>
                                                            <td>最大连接数</td>
                                                        </tr>
                                                        <tr>
                                                            <td>innodb_log_file_size</td>
                                                            <td>48M</td>
                                                            <td>256M-1G</td>
                                                            <td>InnoDB日志文件大小</td>
                                                        </tr>
                                                        <tr>
                                                            <td>innodb_flush_log_at_trx_commit</td>
                                                            <td>1</td>
                                                            <td>2（非严格事务场景）</td>
                                                            <td>控制日志刷新策略，1最安全，2性能更好</td>
                                                        </tr>
                                                        <tr>
                                                            <td>query_cache_size</td>
                                                            <td>1M</td>
                                                            <td>0（MySQL 8.0已移除）</td>
                                                            <td>查询缓存大小，在写多读少的场景下建议关闭</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4>表结构优化建议</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>表名</th>
                                                            <th>优化建议</th>
                                                            <th>优化理由</th>
                                                            <th>实现方案</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>shua_orders</td>
                                                            <td>分区表</td>
                                                            <td>订单表数据量大，按时间分区可提高查询性能</td>
                                                            <td>按年或按月进行水平分区</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_logs</td>
                                                            <td>归档旧数据</td>
                                                            <td>日志表增长快，归档旧数据可提高查询性能</td>
                                                            <td>定期将超过6个月的数据迁移到归档表</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_tools</td>
                                                            <td>拆分大字段</td>
                                                            <td>description字段较大，影响查询性能</td>
                                                            <td>将description字段拆分到单独的表中</td>
                                                        </tr>
                                                        <tr>
                                                            <td>shua_site</td>
                                                            <td>增加冗余字段</td>
                                                            <td>频繁查询的统计数据可增加冗余字段</td>
                                                            <td>添加order_count、total_spend等冗余字段</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4>查询优化技巧</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>只查询需要的字段：</strong>避免使用SELECT *，只查询需要的字段
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>使用LIMIT：</strong>分页查询时使用LIMIT限制返回行数
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>优化JOIN查询：</strong>小表驱动大表，避免笛卡尔积
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>避免子查询：</strong>尽量使用JOIN代替子查询
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>使用EXPLAIN分析：</strong>使用EXPLAIN分析查询执行计划
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>避免在WHERE子句中使用函数：</strong>会导致索引失效
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>使用连接池：</strong>减少数据库连接建立和关闭的开销
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>读写分离：</strong>在高并发场景下考虑读写分离架构
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mb-6">
                                            <h4>性能监控与诊断</h4>
                                            <div class="bg-light p-3 rounded">
                                                <p>定期监控数据库性能，及时发现并解决问题：</p>
                                                <ol>
                                                    <li>使用MySQL自带的慢查询日志记录执行时间超过阈值的SQL语句</li>
                                                    <li>使用EXPLAIN分析慢查询的执行计划，找出性能瓶颈</li>
                                                    <li>监控数据库连接数、缓存命中率、锁等待等关键指标</li>
                                                    <li>定期检查表碎片，对表进行优化（OPTIMIZE TABLE）</li>
                                                    <li>使用专业的监控工具（如Zabbix、Prometheus等）进行实时监控</li>
                                                </ol>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4>实用性能优化示例</h4>
                                            <div class="bg-dark text-green p-3 rounded">
<pre>-- 慢查询优化：优化前
SELECT o.*, t.name, s.user FROM shua_orders o, shua_tools t, shua_site s 
WHERE o.tid = t.tid AND o.zid = s.zid AND o.status = 3 
ORDER BY o.addtime DESC LIMIT 0, 20;

-- 慢查询优化：优化后（添加适当索引，使用JOIN代替隐式连接）
-- 先添加索引
ALTER TABLE `shua_orders` ADD INDEX `idx_status_addtime` (`status`, `addtime`);
-- 优化查询语句
SELECT o.*, t.name, s.user FROM shua_orders o
INNER JOIN shua_tools t ON o.tid = t.tid
INNER JOIN shua_site s ON o.zid = s.zid
WHERE o.status = 3 
ORDER BY o.addtime DESC LIMIT 0, 20;

-- 优化分页查询：优化前（大数据量下LIMIT offset性能差）
SELECT * FROM shua_orders ORDER BY id DESC LIMIT 100000, 20;

-- 优化分页查询：优化后（使用主键范围查询）
SELECT * FROM shua_orders WHERE id > 100000 ORDER BY id DESC LIMIT 20;

-- 优化统计查询：优化前（实时计算）
SELECT COUNT(*) AS total_orders, SUM(total_price) AS total_amount 
FROM shua_orders WHERE zid = 1001 AND addtime > 1609430400;

-- 优化统计查询：优化后（使用缓存表）
-- 创建缓存表
CREATE TABLE `shua_orders_stats` (
    `zid` INT NOT NULL,
    `date` DATE NOT NULL,
    `total_orders` INT NOT NULL DEFAULT 0,
    `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`zid`, `date`)
);
-- 定期更新缓存表
INSERT INTO `shua_orders_stats` (zid, date, total_orders, total_amount)
SELECT zid, DATE(FROM_UNIXTIME(addtime)), COUNT(*), SUM(total_price)
FROM shua_orders
WHERE date(FROM_UNIXTIME(addtime)) = CURDATE()
GROUP BY zid, DATE(FROM_UNIXTIME(addtime))
ON DUPLICATE KEY UPDATE
    total_orders = VALUES(total_orders),
    total_amount = VALUES(total_amount);
-- 查询缓存表
SELECT SUM(total_orders) AS total_orders, SUM(total_amount) AS total_amount
FROM shua_orders_stats
WHERE zid = 1001 AND date >= '2021-01-01';

-- 读写分离示例：主库写，从库读
-- 写入操作（主库）
INSERT INTO shua_orders (tid, zid, order_no, num, price, total_price) 
VALUES (101, 1001, '20210601123456', 1, 10.00, 10.00);

-- 读取操作（从库）
SELECT * FROM shua_orders WHERE zid = 1001 ORDER BY addtime DESC LIMIT 20;</pre>
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
</div>

<?php include '../foot.php'; ?>