<?php
// ===================================================================================
// 系统架构开发文档 - 由教主老师创建
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
                            <a class="navbar-brand" href="#">系统架构文档</a>
                        </div>
                        <div class="collapse navbar-collapse" id="example-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="index.php">管理首页</a></li>
                                <li><a href="devdoc.php">开发文档</a></li>
                                <li class="active"><a href="system_architecture.php">系统架构</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- 内容区域 -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">系统架构文档</h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info">
                            <strong>文档说明：</strong>本文档详细介绍系统的整体架构设计、模块划分、核心流程和技术选型，帮助开发者更好地理解系统结构，便于二次开发和维护。
                            <br><strong>作者：</strong>教主老师 | <strong>博客：</strong><a href="http://zhonguo.ren" target="_blank">zhonguo.ren</a> | <strong>交流群：</strong>915043052
                        </div>

                        <!-- 标签页 -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">整体架构</a></li>
                            <li role="presentation"><a href="#modules" aria-controls="modules" role="tab" data-toggle="tab">模块划分</a></li>
                            <li role="presentation"><a href="#coreprocess" aria-controls="coreprocess" role="tab" data-toggle="tab">核心流程</a></li>
                            <li role="presentation"><a href="#technology" aria-controls="technology" role="tab" data-toggle="tab">技术选型</a></li>
                            <li role="presentation"><a href="#extend" aria-controls="extend" role="tab" data-toggle="tab">扩展开发</a></li>
                        </ul>

                        <!-- 标签页内容 -->
                        <div class="tab-content">
                            <!-- 整体架构 -->
                            <div role="tabpanel" class="tab-pane active" id="overview">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">系统整体架构</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>系统架构图</h4>
                                                <div class="bg-light p-4 rounded" style="border:1px solid #ddd;">
                                                    <pre class="text-center">
+------------------+    +------------------+    +------------------+
|  客户端层         |    |  API接口层        |    |  管理后台        |
|  (用户浏览器/程序) |<-->|  (API服务)        |<-->|  (管理功能)      |
+------------------+    +------------------+    +------------------+
                               ^                        ^
                               |                        |
                               v                        v
+------------------+    +------------------+    +------------------+
|  数据存储层       |<-->|  业务逻辑层        |<-->|  工具函数层      |
|  (MySQL数据库)    |    |  (核心功能实现)    |    |  (通用功能)      |
+------------------+    +------------------+    +------------------+
                                                    </pre>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>架构说明</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>客户端层：</strong>用户直接交互的界面，包括Web端浏览器和API调用客户端。
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>API接口层：</strong>提供标准化的接口供外部系统调用，实现系统间的数据交互。
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>管理后台：</strong>系统管理员使用的管理界面，用于配置、监控和维护系统。
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>业务逻辑层：</strong>核心业务逻辑的实现，处理各类业务请求和数据处理。
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>工具函数层：</strong>提供通用的功能和工具，如数据验证、日志记录等。
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>数据存储层：</strong>负责数据的持久化存储，主要使用MySQL数据库。
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 系统分层 -->
                                <div class="panel panel-info mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">系统分层设计</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>层级名称</th>
                                                        <th>主要职责</th>
                                                        <th>文件位置</th>
                                                        <th>核心文件</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>表示层</td>
                                                        <td>用户界面展示、接收用户请求</td>
                                                        <td>/admin/, /user/, /api/</td>
                                                        <td>各类.php页面文件</td>
                                                    </tr>
                                                    <tr>
                                                        <td>控制层</td>
                                                        <td>请求处理、参数验证、业务转发</td>
                                                        <td>/admin/, /api/</td>
                                                        <td>各类处理文件</td>
                                                    </tr>
                                                    <tr>
                                                        <td>业务层</td>
                                                        <td>核心业务逻辑实现</td>
                                                        <td>/include/, /class/</td>
                                                        <td>功能类文件</td>
                                                    </tr>
                                                    <tr>
                                                        <td>数据访问层</td>
                                                        <td>数据库交互、数据操作</td>
                                                        <td>/common.php</td>
                                                        <td>数据库操作函数</td>
                                                    </tr>
                                                    <tr>
                                                        <td>基础设施层</td>
                                                        <td>配置管理、日志记录、工具函数</td>
                                                        <td>/config.php, /common.php</td>
                                                        <td>配置和工具文件</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 模块划分 -->
                            <div role="tabpanel" class="tab-pane" id="modules">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">系统模块划分</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p class="text-muted">系统按照功能划分为以下主要模块，各模块之间通过接口进行交互，保持相对独立。</p>

                                        <div class="row">
                                            <!-- 用户模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">1. 用户模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>负责用户的注册、登录、信息管理、权限控制等功能。</p>
                                                        <p><strong>核心表：</strong>shua_account, shua_site</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/login.php - 管理员登录</li>
                                                            <li>admin/user_manage.php - 用户管理</li>
                                                            <li>api/user_login.php - API用户登录</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 商品模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">2. 商品模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>负责商品的分类、添加、编辑、上下架等管理功能。</p>
                                                        <p><strong>核心表：</strong>shua_tools, shua_class</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/tools_list.php - 商品列表</li>
                                                            <li>admin/class_manage.php - 分类管理</li>
                                                            <li>api/goods_list.php - API商品列表</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 订单模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">3. 订单模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>负责订单的创建、处理、查询、状态更新等功能。</p>
                                                        <p><strong>核心表：</strong>shua_orders, shua_faka</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/order_manage.php - 订单管理</li>
                                                            <li>admin/faka_manage.php - 卡密管理</li>
                                                            <li>api/create_order.php - API创建订单</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 支付模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-warning">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">4. 支付模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>负责支付的处理、回调、对账等功能。</p>
                                                        <p><strong>核心表：</strong>shua_pay</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/pay_manage.php - 支付管理</li>
                                                            <li>api/create_pay.php - API创建支付</li>
                                                            <li>pay/callback.php - 支付回调处理</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 提现模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-danger">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">5. 提现模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>负责用户余额提现申请、审核、打款等功能。</p>
                                                        <p><strong>核心表：</strong>shua_tixian</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/tixian_manage.php - 提现管理</li>
                                                            <li>user/tixian.php - 用户提现申请</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 系统配置模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">6. 系统配置模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>负责系统各项配置的管理和维护。</p>
                                                        <p><strong>核心表：</strong>shua_config</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/system_config.php - 系统配置</li>
                                                            <li>config.php - 基础配置文件</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- API接口模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">7. API接口模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>提供标准化的接口供外部系统调用。</p>
                                                        <p><strong>核心表：</strong>shua_account</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>api/*.php - 各类API接口文件</li>
                                                            <li>api/common.php - API通用函数</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 日志模块 -->
                                            <div class="col-md-6 mb-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">8. 日志模块</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p><strong>功能描述：</strong>记录系统运行日志、用户操作日志等。</p>
                                                        <p><strong>核心表：</strong>shua_logs, shua_toollogs</p>
                                                        <p><strong>主要文件：</strong></p>
                                                        <ul>
                                                            <li>admin/logs.php - 系统日志</li>
                                                            <li>admin/tool_logs.php - 工具操作日志</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 核心流程 -->
                            <div role="tabpanel" class="tab-pane" id="coreprocess">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">系统核心业务流程</h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <!-- 订单创建流程 -->
                                        <div class="mb-6">
                                            <h4 class="text-primary">1. 订单创建与处理流程</h4>
                                            <div class="bg-light p-4 rounded" style="border:1px solid #ddd;">
                                                <pre>
+----------------+    +----------------+    +----------------+    +----------------+
|  用户提交订单   | -> |  验证订单信息   | -> |  创建订单记录   | -> |  处理订单任务   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                                         |
                                                                         v
+----------------+    +----------------+    +----------------+    +----------------+
|  完成订单处理   | <- |  生成订单结果   | <- |  更新订单状态   | <- |  执行具体操作   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                </pre>
                                            </div>
                                            <p class="mt-2"><strong>流程说明：</strong></p>
                                            <ol>
                                                <li>用户通过前台或API提交订单请求</li>
                                                <li>系统验证订单信息（商品是否存在、余额是否足够等）</li>
                                                <li>系统在数据库中创建订单记录</li>
                                                <li>系统根据商品类型执行相应的处理逻辑</li>
                                                <li>处理完成后更新订单状态</li>
                                                <li>生成订单结果并通知用户</li>
                                            </ol>
                                        </div>

                                        <!-- 支付流程 -->
                                        <div class="mb-6">
                                            <h4 class="text-success">2. 支付流程</h4>
                                            <div class="bg-light p-4 rounded" style="border:1px solid #ddd;">
                                                <pre>
+----------------+    +----------------+    +----------------+    +----------------+
|  用户发起支付   | -> |  创建支付记录   | -> |  调用支付接口   | -> |  用户完成支付   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                                         |
                                                                         v
+----------------+    +----------------+    +----------------+    +----------------+
|  支付完成通知   | <- |  更新用户余额   | <- |  处理支付回调   | <- |  支付平台回调   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                </pre>
                                            </div>
                                            <p class="mt-2"><strong>流程说明：</strong></p>
                                            <ol>
                                                <li>用户在系统中发起支付请求</li>
                                                <li>系统创建支付记录并生成唯一订单号</li>
                                                <li>调用第三方支付平台接口</li>
                                                <li>用户在支付平台完成支付</li>
                                                <li>支付平台向系统发送支付回调通知</li>
                                                <li>系统验证回调数据并更新订单状态</li>
                                                <li>系统更新用户余额并完成支付流程</li>
                                            </ol>
                                        </div>

                                        <!-- 提现流程 -->
                                        <div class="mb-6">
                                            <h4 class="text-info">3. 提现流程</h4>
                                            <div class="bg-light p-4 rounded" style="border:1px solid #ddd;">
                                                <pre>
+----------------+    +----------------+    +----------------+    +----------------+
|  用户提交提现   | -> |  创建提现记录   | -> |  管理员审核提现 | -> |  处理提现打款   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                                         |
                                                                         v
+----------------+    +----------------+    +----------------+    +----------------+
|  提现完成通知   | <- |  更新用户余额   | <- |  更新提现状态   | <- |  执行打款操作   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                </pre>
                                            </div>
                                            <p class="mt-2"><strong>流程说明：</strong></p>
                                            <ol>
                                                <li>用户提交提现申请，填写提现金额和提现方式</li>
                                                <li>系统创建提现记录并冻结用户相应余额</li>
                                                <li>管理员审核提现申请</li>
                                                <li>审核通过后，系统执行打款操作</li>
                                                <li>打款完成后更新提现状态</li>
                                                <li>系统更新用户余额并通知用户提现结果</li>
                                            </ol>
                                        </div>

                                        <!-- 用户注册/登录流程 -->
                                        <div class="mb-6">
                                            <h4 class="text-warning">4. 用户注册/登录流程</h4>
                                            <div class="bg-light p-4 rounded" style="border:1px solid #ddd;">
                                                <pre>
+----------------+    +----------------+    +----------------+    +----------------+
|  用户注册/登录  | -> |  验证用户信息   | -> |  生成用户令牌   | -> |  记录登录日志   |
+----------------+    +----------------+    +----------------+    +----------------+
                                                </pre>
                                            </div>
                                            <p class="mt-2"><strong>流程说明：</strong></p>
                                            <ol>
                                                <li>用户提交注册或登录请求</li>
                                                <li>系统验证用户信息（用户名密码是否正确、是否注册等）</li>
                                                <li>验证通过后，系统生成用户令牌并保存</li>
                                                <li>记录用户登录日志</li>
                                                <li>返回登录成功信息和用户令牌</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 技术选型 -->
                            <div role="tabpanel" class="tab-pane" id="technology">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">系统技术选型</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>技术类别</th>
                                                        <th>技术名称</th>
                                                        <th>版本</th>
                                                        <th>用途说明</th>
                                                        <th>备注</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>后端开发</td>
                                                        <td>PHP</td>
                                                        <td>7.4+</td>
                                                        <td>服务端业务逻辑实现</td>
                                                        <td>支持现代PHP特性</td>
                                                    </tr>
                                                    <tr>
                                                        <td>数据库</td>
                                                        <td>MySQL</td>
                                                        <td>5.7</td>
                                                        <td>数据存储和查询</td>
                                                        <td>支持InnoDB引擎</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Web服务器</td>
                                                        <td>Nginx</td>
                                                        <td>1.22.0</td>
                                                        <td>静态资源处理、反向代理</td>
                                                        <td>高性能Web服务器</td>
                                                    </tr>
                                                    <tr>
                                                        <td>操作系统</td>
                                                        <td>Windows</td>
                                                        <td>-</td>
                                                        <td>服务器运行环境</td>
                                                        <td>Win宝塔面板</td>
                                                    </tr>
                                                    <tr>
                                                        <td>前端框架</td>
                                                        <td>Bootstrap</td>
                                                        <td>3.x</td>
                                                        <td>响应式UI设计</td>
                                                        <td>用于管理后台界面</td>
                                                    </tr>
                                                    <tr>
                                                        <td>JavaScript框架</td>
                                                        <td>jQuery</td>
                                                        <td>3.x</td>
                                                        <td>DOM操作、AJAX请求</td>
                                                        <td>简化前端开发</td>
                                                    </tr>
                                                    <tr>
                                                        <td>弹窗组件</td>
                                                        <td>Layer</td>
                                                        <td>3.1.1</td>
                                                        <td>消息提示、对话框</td>
                                                        <td>增强用户交互体验</td>
                                                    </tr>
                                                    <tr>
                                                        <td>缓存机制</td>
                                                        <td>Session</td>
                                                        <td>-</td>
                                                        <td>用户会话管理</td>
                                                        <td>基于PHP Session</td>
                                                    </tr>
                                                    <tr>
                                                        <td>加密方式</td>
                                                        <td>MD5</td>
                                                        <td>-</td>
                                                        <td>密码加密存储</td>
                                                        <td>建议升级为更安全的加密方式</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- 技术架构优缺点 -->
                                <div class="panel panel-info mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">技术架构优缺点分析</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="text-success">优点</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">技术栈成熟，开发成本低</li>
                                                    <li class="list-group-item">部署简单，环境要求低</li>
                                                    <li class="list-group-item">开发速度快，适合中小型项目</li>
                                                    <li class="list-group-item">PHP与MySQL配合稳定高效</li>
                                                    <li class="list-group-item">宝塔面板简化了服务器管理</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="text-danger">缺点与改进空间</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">代码结构不够模块化，不利于大型项目维护</li>
                                                    <li class="list-group-item">安全性考虑不足，如密码存储使用MD5</li>
                                                    <li class="list-group-item">缺乏现代化的框架支持，如Laravel、ThinkPHP</li>
                                                    <li class="list-group-item">前端技术相对落后，可考虑使用Vue.js等现代框架</li>
                                                    <li class="list-group-item">缺乏完善的缓存机制，可考虑引入Redis</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 扩展开发 -->
                            <div role="tabpanel" class="tab-pane" id="extend">
                                <div class="panel panel-default mt-4">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">系统扩展开发指南</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="mb-4">
                                            <h4>1. 开发前准备</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">搭建本地开发环境：PHP 7.4+、MySQL 5.7、Nginx 1.22.0</li>
                                                <li class="list-group-item">配置开发工具：推荐使用VSCode、PHPStorm等IDE</li>
                                                <li class="list-group-item">了解系统目录结构和核心文件</li>
                                                <li class="list-group-item">熟悉系统的数据库结构和业务流程</li>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <h4>2. 目录结构说明</h4>
                                            <pre class="bg-dark text-green p-3 rounded">
├── admin/             # 管理后台目录
│   ├── index.php      # 管理后台首页
│   ├── devdoc.php     # 开发文档
│   └── system_architecture.php # 系统架构文档
├── api/               # API接口目录
│   ├── common.php     # API通用函数
│   └── *.php          # 各类API接口文件
├── user/              # 用户前台目录
├── pay/               # 支付相关目录
├── config.php         # 系统配置文件
└── common.php         # 通用函数文件
</pre>
                                        </div>

                                        <div class="mb-4">
                                            <h4>3. 添加新功能模块</h4>
                                            <p><strong>步骤：</strong></p>
                                            <ol>
                                                <li>设计数据库表结构，在MySQL中创建新表</li>
                                                <li>在admin目录下创建相应的管理页面</li>
                                                <li>在api目录下创建相应的API接口（如有需要）</li>
                                                <li>在common.php中添加通用函数（如有需要）</li>
                                                <li>更新导航菜单，将新功能整合到系统中</li>
                                            </ol>
                                        </div>

                                        <div class="mb-4">
                                            <h4>4. 代码规范</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">使用统一的命名规范：变量名、函数名使用小写字母加下划线</li>
                                                <li class="list-group-item">类名使用驼峰命名法</li>
                                                <li class="list-group-item">添加必要的注释，特别是核心功能和复杂逻辑</li>
                                                <li class="list-group-item">遵循PHP代码规范（PSR-1、PSR-2）</li>
                                                <li class="list-group-item">避免在视图文件中编写复杂的业务逻辑</li>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <h4>5. 安全性考虑</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">对所有用户输入进行过滤和验证</li>
                                                <li class="list-group-item">避免SQL注入，使用预处理语句</li>
                                                <li class="list-group-item">保护敏感信息，如密码使用更安全的加密方式</li>
                                                <li class="list-group-item">设置合理的文件权限</li>
                                                <li class="list-group-item">定期备份数据库和重要文件</li>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <h4>6. 性能优化建议</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">合理使用索引，优化数据库查询</li>
                                                <li class="list-group-item">减少数据库查询次数，使用缓存机制</li>
                                                <li class="list-group-item">优化图片和静态资源，使用CDN加速</li>
                                                <li class="list-group-item">使用PHP的OPcache加速PHP代码执行</li>
                                                <li class="list-group-item">对高并发部分进行优化，如使用队列处理</li>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <h4>7. 常见问题与解决方案</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>问题描述</th>
                                                            <th>可能原因</th>
                                                            <th>解决方案</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>数据库连接失败</td>
                                                            <td>配置错误或MySQL服务未启动</td>
                                                            <td>检查config.php中的数据库配置，确保MySQL服务正常运行</td>
                                                        </tr>
                                                        <tr>
                                                            <td>页面空白或500错误</td>
                                                            <td>PHP代码错误或权限问题</td>
                                                            <td>开启PHP错误显示，检查错误日志，确保文件权限正确</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API调用返回错误</td>
                                                            <td>参数错误或令牌失效</td>
                                                            <td>检查请求参数格式，确保令牌有效</td>
                                                        </tr>
                                                        <tr>
                                                            <td>图片无法上传</td>
                                                            <td>上传目录权限不足或PHP配置限制</td>
                                                            <td>设置正确的目录权限，调整PHP的upload_max_filesize等参数</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
<script src="<?php echo $cdnpublic?>layer/3.1.1/layer.js"></script>