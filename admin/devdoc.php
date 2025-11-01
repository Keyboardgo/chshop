<?php
// +----------------------------------------------------------------------
// | 开发文档页面
// | 博客地址：zhonguo.ren
// | QQ群：915043052
// | 开发者：教主
// +----------------------------------------------------------------------
include("../includes/common.php");
$title='开发文档';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>    
<div class="col-md-12">
    <div class="block block-rounded block-themed">
        <div class="block-header">
            <h3 class="block-title">📚 开发文档</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-book-open"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            
            <!-- 导航标签 -->
            <div class="nav-tabs-horizontal nav-tabs-inverse" data-toggle="tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-tables" data-toggle="tab">数据表结构</a>
                    </li>
                    <li>
                        <a href="#tab-fields" data-toggle="tab">字段说明</a>
                    </li>
                    <li>
                        <a href="#tab-notes" data-toggle="tab">开发注意事项</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- 数据表结构 -->
                    <div class="tab-pane active" id="tab-tables">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>表名</th>
                                        <th>用途</th>
                                        <th>备注</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>shua_account</code></td>
                                        <td>管理员表</td>
                                        <td>存储系统管理员账号信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_apps</code></td>
                                        <td>应用程序表</td>
                                        <td>存储应用程序信息及下载链接</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_article</code></td>
                                        <td>文章表</td>
                                        <td>存储系统文章内容</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_cache</code></td>
                                        <td>缓存表</td>
                                        <td>存储系统缓存数据</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_cart</code></td>
                                        <td>购物车表</td>
                                        <td>存储用户购物车信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_chat_session</code></td>
                                        <td>客服会话表</td>
                                        <td>存储客服会话信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_chat_message</code></td>
                                        <td>客服消息表</td>
                                        <td>存储客服消息记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_class</code></td>
                                        <td>商品分类表</td>
                                        <td>存储商品分类信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_config</code></td>
                                        <td>系统配置表</td>
                                        <td>存储系统各项配置参数</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_faka</code></td>
                                        <td>卡密表</td>
                                        <td>存储各类卡密信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_gift</code></td>
                                        <td>礼物表</td>
                                        <td>存储系统礼物设置</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_giftlog</code></td>
                                        <td>礼物日志表</td>
                                        <td>存储礼物发放记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_invite</code></td>
                                        <td>邀请表</td>
                                        <td>存储邀请链接信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_invitelog</code></td>
                                        <td>邀请日志表</td>
                                        <td>存储邀请记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_inviteshop</code></td>
                                        <td>邀请商品表</td>
                                        <td>存储邀请商品配置</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_kms</code></td>
                                        <td>卡密存储表</td>
                                        <td>存储卡密信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_logs</code></td>
                                        <td>系统日志表</td>
                                        <td>存储系统操作日志</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_message</code></td>
                                        <td>站内消息表</td>
                                        <td>存储站内通知信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_orders</code></td>
                                        <td>订单表</td>
                                        <td>存储用户购买订单信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_pay</code></td>
                                        <td>支付表</td>
                                        <td>存储支付交易记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_points</code></td>
                                        <td>积分表</td>
                                        <td>存储用户积分记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_price</code></td>
                                        <td>价格表</td>
                                        <td>存储价格配置信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_qiandao</code></td>
                                        <td>签到表</td>
                                        <td>存储用户签到记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_sendcode</code></td>
                                        <td>验证码发送表</td>
                                        <td>存储验证码发送记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_shequ</code></td>
                                        <td>社区表</td>
                                        <td>存储社区平台配置</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_site</code></td>
                                        <td>站点/用户表</td>
                                        <td>存储用户及分站信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_supplier</code></td>
                                        <td>供应商表</td>
                                        <td>存储供应商账号信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_suppoints</code></td>
                                        <td>供应商积分表</td>
                                        <td>存储供应商积分记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_suptixian</code></td>
                                        <td>供应商提现表</td>
                                        <td>存储供应商提现记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_tixian</code></td>
                                        <td>提现表</td>
                                        <td>存储用户提现记录</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_toollogs</code></td>
                                        <td>工具日志表</td>
                                        <td>存储工具操作日志</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_tools</code></td>
                                        <td>工具/商品表</td>
                                        <td>存储系统所有商品信息</td>
                                    </tr>
                                    <tr>
                                        <td><code>shua_workorder</code></td>
                                        <td>工单表</td>
                                        <td>存储用户工单信息</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- 字段说明 -->
                    <div class="tab-pane" id="tab-fields">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <!-- 管理员表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-admin">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-admin" aria-expanded="false" aria-controls="collapse-admin">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_account 管理员表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-admin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-admin">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>id</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>自增ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>username</td>
                                                        <td>varchar(32)</td>
                                                        <td>是</td>
                                                        <td>管理员用户名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>password</td>
                                                        <td>varchar(32)</td>
                                                        <td>是</td>
                                                        <td>管理员密码（加密存储）</td>
                                                    </tr>
                                                    <tr>
                                                        <td>permission</td>
                                                        <td>text</td>
                                                        <td>否</td>
                                                        <td>管理员权限设置</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>创建时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>lasttime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>最后登录时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>active</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>是否启用，0=禁用，1=启用</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 商品表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-shop">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-shop" aria-expanded="false" aria-controls="collapse-shop">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_tools 商品表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-shop" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-shop">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>tid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>商品ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，关联shua_site表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>cid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>分类ID，关联shua_class表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>sort</td>
                                                        <td>int(11)</td>
                                                        <td>是</td>
                                                        <td>排序值</td>
                                                    </tr>
                                                    <tr>
                                                        <td>name</td>
                                                        <td>varchar(255)</td>
                                                        <td>是</td>
                                                        <td>商品名称</td>
                                                    </tr>
                                                    <tr>
                                                        <td>price</td>
                                                        <td>decimal(10,2)</td>
                                                        <td>是</td>
                                                        <td>商品价格</td>
                                                    </tr>
                                                    <tr>
                                                        <td>desc</td>
                                                        <td>text</td>
                                                        <td>否</td>
                                                        <td>商品描述</td>
                                                    </tr>
                                                    <tr>
                                                        <td>alert</td>
                                                        <td>text</td>
                                                        <td>否</td>
                                                        <td>商品注意事项</td>
                                                    </tr>
                                                    <tr>
                                                        <td>close</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>是否售罄，0=可售，1=售罄</td>
                                                    </tr>
                                                    <tr>
                                                        <td>active</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>是否启用，0=禁用，1=启用</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 订单表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-order">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-order" aria-expanded="false" aria-controls="collapse-order">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_orders 订单表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-order" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-order">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>id</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>自增ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>tid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>商品ID，关联shua_tools表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，关联shua_site表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>input</td>
                                                        <td>varchar(256)</td>
                                                        <td>是</td>
                                                        <td>用户输入内容（如QQ号、网址等）</td>
                                                    </tr>
                                                    <tr>
                                                        <td>value</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>数量值</td>
                                                    </tr>
                                                    <tr>
                                                        <td>money</td>
                                                        <td>decimal(10,2)</td>
                                                        <td>是</td>
                                                        <td>订单金额</td>
                                                    </tr>
                                                    <tr>
                                                        <td>cost</td>
                                                        <td>decimal(10,2)</td>
                                                        <td>是</td>
                                                        <td>成本价</td>
                                                    </tr>
                                                    <tr>
                                                        <td>status</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>订单状态，0=未完成，1=已完成</td>
                                                    </tr>
                                                    <tr>
                                                        <td>userid</td>
                                                        <td>varchar(32)</td>
                                                        <td>否</td>
                                                        <td>用户ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>tradeno</td>
                                                        <td>varchar(32)</td>
                                                        <td>否</td>
                                                        <td>交易订单号</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>下单时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>endtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>完成时间</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 用户/站点表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-site">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-site" aria-expanded="false" aria-controls="collapse-site">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_site 用户/站点表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-site" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-site">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>upzid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>上级站点ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>domain</td>
                                                        <td>varchar(50)</td>
                                                        <td>否</td>
                                                        <td>网站域名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>user</td>
                                                        <td>varchar(20)</td>
                                                        <td>是</td>
                                                        <td>用户名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>pwd</td>
                                                        <td>varchar(32)</td>
                                                        <td>是</td>
                                                        <td>用户密码</td>
                                                    </tr>
                                                    <tr>
                                                        <td>rmb</td>
                                                        <td>decimal(10,2)</td>
                                                        <td>是</td>
                                                        <td>账户余额</td>
                                                    </tr>
                                                    <tr>
                                                        <td>qq</td>
                                                        <td>varchar(12)</td>
                                                        <td>否</td>
                                                        <td>QQ号码</td>
                                                    </tr>
                                                    <tr>
                                                        <td>sitename</td>
                                                        <td>varchar(80)</td>
                                                        <td>否</td>
                                                        <td>站点名称</td>
                                                    </tr>
                                                    <tr>
                                                        <td>status</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>账户状态，0=禁用，1=启用</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>注册时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>endtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>到期时间</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 卡密表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-faka">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-faka" aria-expanded="false" aria-controls="collapse-faka">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_faka 卡密表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-faka" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-faka">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>kid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>卡密ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>tid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>商品ID，关联shua_tools表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>km</td>
                                                        <td>varchar(255)</td>
                                                        <td>否</td>
                                                        <td>卡密内容</td>
                                                    </tr>
                                                    <tr>
                                                        <td>pw</td>
                                                        <td>varchar(255)</td>
                                                        <td>否</td>
                                                        <td>卡密密码</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>添加时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>usetime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>使用时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>orderid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>订单ID，关联shua_orders表</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 系统配置表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-config">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-config" aria-expanded="false" aria-controls="collapse-config">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_config 系统配置表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-config" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-config">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>id</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>自增ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>k</td>
                                                        <td>varchar(50)</td>
                                                        <td>是</td>
                                                        <td>配置项键名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>v</td>
                                                        <td>text</td>
                                                        <td>否</td>
                                                        <td>配置项值</td>
                                                    </tr>
                                                    <tr>
                                                        <td>desc</td>
                                                        <td>varchar(255)</td>
                                                        <td>否</td>
                                                        <td>配置项描述</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 支付表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-pay">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-pay" aria-expanded="false" aria-controls="collapse-pay">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_pay 支付表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-pay" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-pay">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>id</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>自增ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，关联shua_site表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>trade_no</td>
                                                        <td>varchar(32)</td>
                                                        <td>是</td>
                                                        <td>交易单号</td>
                                                    </tr>
                                                    <tr>
                                                        <td>type</td>
                                                        <td>varchar(10)</td>
                                                        <td>是</td>
                                                        <td>支付方式（wxpay/alipay）</td>
                                                    </tr>
                                                    <tr>
                                                        <td>money</td>
                                                        <td>decimal(10,2)</td>
                                                        <td>是</td>
                                                        <td>支付金额</td>
                                                    </tr>
                                                    <tr>
                                                        <td>status</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>支付状态，0=未支付，1=已支付</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>创建时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>endtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>完成时间</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 日志表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-logs">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-logs" aria-expanded="false" aria-controls="collapse-logs">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_logs 日志表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-logs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-logs">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>id</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>自增ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，关联shua_site表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>user</td>
                                                        <td>varchar(32)</td>
                                                        <td>否</td>
                                                        <td>操作用户名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>text</td>
                                                        <td>否</td>
                                                        <td>操作内容描述</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ip</td>
                                                        <td>varchar(15)</td>
                                                        <td>否</td>
                                                        <td>操作IP地址</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>操作时间</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 分类表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-class">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-class" aria-expanded="false" aria-controls="collapse-class">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_class 分类表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-class" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-class">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>cid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>分类ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，关联shua_site表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>name</td>
                                                        <td>varchar(255)</td>
                                                        <td>是</td>
                                                        <td>分类名称</td>
                                                    </tr>
                                                    <tr>
                                                        <td>sort</td>
                                                        <td>int(11)</td>
                                                        <td>是</td>
                                                        <td>排序值</td>
                                                    </tr>
                                                    <tr>
                                                        <td>active</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>是否启用，0=禁用，1=启用</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ishead</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>是否显示在头部导航，0=不显示，1=显示</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 提现表字段 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-tixian">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-tixian" aria-expanded="false" aria-controls="collapse-tixian">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>shua_tixian 提现表字段说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-tixian" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-tixian">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>字段名</th>
                                                        <th>数据类型</th>
                                                        <th>是否必填</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>id</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>自增ID，主键</td>
                                                    </tr>
                                                    <tr>
                                                        <td>zid</td>
                                                        <td>int(11) unsigned</td>
                                                        <td>是</td>
                                                        <td>站点ID，关联shua_site表</td>
                                                    </tr>
                                                    <tr>
                                                        <td>money</td>
                                                        <td>decimal(10,2)</td>
                                                        <td>是</td>
                                                        <td>提现金额</td>
                                                    </tr>
                                                    <tr>
                                                        <td>account</td>
                                                        <td>varchar(255)</td>
                                                        <td>是</td>
                                                        <td>提现账号</td>
                                                    </tr>
                                                    <tr>
                                                        <td>name</td>
                                                        <td>varchar(50)</td>
                                                        <td>是</td>
                                                        <td>开户姓名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>type</td>
                                                        <td>varchar(20)</td>
                                                        <td>是</td>
                                                        <td>提现方式（alipay/wxpay/bank）</td>
                                                    </tr>
                                                    <tr>
                                                        <td>status</td>
                                                        <td>tinyint(1)</td>
                                                        <td>是</td>
                                                        <td>提现状态，0=待处理，1=已完成，2=已拒绝</td>
                                                    </tr>
                                                    <tr>
                                                        <td>addtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>申请时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>endtime</td>
                                                        <td>datetime</td>
                                                        <td>否</td>
                                                        <td>处理时间</td>
                                                    </tr>
                                                    <tr>
                                                        <td>admin</td>
                                                        <td>varchar(32)</td>
                                                        <td>否</td>
                                                        <td>处理管理员</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 系统配置项说明 -->
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-config-items">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-config-items" aria-expanded="false" aria-controls="collapse-config-items">
                                            <i class="fa fa-chevron-down text-muted mr-2"></i>系统配置项说明
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-config-items" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-config-items">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>配置项</th>
                                                        <th>默认值</th>
                                                        <th>数据类型</th>
                                                        <th>用途说明</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>web_name</td>
                                                        <td>测试站点</td>
                                                        <td>字符串</td>
                                                        <td>网站名称</td>
                                                    </tr>
                                                    <tr>
                                                        <td>web_logo</td>
                                                        <td>/assets/img/logo.png</td>
                                                        <td>字符串</td>
                                                        <td>网站Logo路径</td>
                                                    </tr>
                                                    <tr>
                                                        <td>web_url</td>
                                                        <td>http://127.0.0.1</td>
                                                        <td>字符串</td>
                                                        <td>网站URL</td>
                                                    </tr>
                                                    <tr>
                                                        <td>web_about</td>
                                                        <td>暂无</td>
                                                        <td>文本</td>
                                                        <td>关于网站信息</td>
                                                    </tr>
                                                    <tr>
                                                        <td>web_copyright</td>
                                                        <td>© 2023 版权所有</td>
                                                        <td>字符串</td>
                                                        <td>版权信息</td>
                                                    </tr>
                                                    <tr>
                                                        <td>web_beian</td>
                                                        <td>暂无</td>
                                                        <td>字符串</td>
                                                        <td>备案信息</td>
                                                    </tr>
                                                    <tr>
                                                        <td>min_money</td>
                                                        <td>1.00</td>
                                                        <td>数字</td>
                                                        <td>最小充值金额</td>
                                                    </tr>
                                                    <tr>
                                                        <td>min_tixian</td>
                                                        <td>10.00</td>
                                                        <td>数字</td>
                                                        <td>最小提现金额</td>
                                                    </tr>
                                                    <tr>
                                                        <td>api_shop</td>
                                                        <td>0</td>
                                                        <td>布尔值</td>
                                                        <td>是否开启API商城，0=关闭，1=开启</td>
                                                    </tr>
                                                    <tr>
                                                        <td>api_token</td>
                                                        <td>随机字符串</td>
                                                        <td>字符串</td>
                                                        <td>API接口密钥</td>
                                                    </tr>
                                                    <tr>
                                                        <td>auto_tixian</td>
                                                        <td>0</td>
                                                        <td>布尔值</td>
                                                        <td>是否自动处理提现，0=手动，1=自动</td>
                                                    </tr>
                                                    <tr>
                                                        <td>smtp_host</td>
                                                        <td></td>
                                                        <td>字符串</td>
                                                        <td>SMTP服务器地址</td>
                                                    </tr>
                                                    <tr>
                                                        <td>smtp_port</td>
                                                        <td>25</td>
                                                        <td>数字</td>
                                                        <td>SMTP服务器端口</td>
                                                    </tr>
                                                    <tr>
                                                        <td>smtp_user</td>
                                                        <td></td>
                                                        <td>字符串</td>
                                                        <td>SMTP用户名</td>
                                                    </tr>
                                                    <tr>
                                                        <td>smtp_pass</td>
                                                        <td></td>
                                                        <td>字符串</td>
                                                        <td>SMTP密码</td>
                                                    </tr>
                                                    <tr>
                                                        <td>wxpay_status</td>
                                                        <td>0</td>
                                                        <td>布尔值</td>
                                                        <td>微信支付状态，0=关闭，1=开启</td>
                                                    </tr>
                                                    <tr>
                                                        <td>alipay_status</td>
                                                        <td>0</td>
                                                        <td>布尔值</td>
                                                        <td>支付宝状态，0=关闭，1=开启</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 开发注意事项 -->
                    <div class="tab-pane" id="tab-notes">
                        <div class="alert alert-info">
                            <h4 class="alert-heading">开发前必读</h4>
                            <p class="mb-0">在进行系统二次开发前，请仔细阅读以下注意事项：</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="block block-rounded">
                                    <div class="block-header">
                                        <h3 class="block-title">安全注意事项</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="fa-ul">
                                            <li><i class="fa-li fa fa-shield text-primary"></i>请勿在代码中明文存储敏感信息</li>
                                            <li><i class="fa-li fa fa-shield text-primary"></i>所有用户输入必须进行过滤和转义</li>
                                            <li><i class="fa-li fa fa-shield text-primary"></i>使用预处理语句防止SQL注入</li>
                                            <li><i class="fa-li fa fa-shield text-primary"></i>定期备份数据库</li>
                                            <li><i class="fa-li fa fa-shield text-primary"></i>设置强密码策略</li>
                                            <li><i class="fa-li fa fa-shield text-primary"></i>添加操作日志记录</li>
                                            <li><i class="fa-li fa fa-shield text-primary"></i>对敏感操作添加二次确认</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="block block-rounded">
                                    <div class="block-header">
                                        <h3 class="block-title">开发规范</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="fa-ul">
                                            <li><i class="fa-li fa fa-code text-info"></i>遵循现有代码风格和命名规范</li>
                                            <li><i class="fa-li fa fa-code text-info"></i>所有文件添加版权和功能注释</li>
                                            <li><i class="fa-li fa fa-code text-info"></i>使用常量和配置项而非硬编码</li>
                                            <li><i class="fa-li fa fa-code text-info"></i>避免修改核心文件，优先使用插件机制</li>
                                            <li><i class="fa-li fa fa-code text-info"></i>代码缩进保持一致</li>
                                            <li><i class="fa-li fa fa-code text-info"></i>函数和变量命名清晰易懂</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="block block-rounded">
                                    <div class="block-header">
                                        <h3 class="block-title">数据库操作建议</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="fa-ul">
                                            <li><i class="fa-li fa fa-database text-warning"></i>使用事务保证数据一致性</li>
                                            <li><i class="fa-li fa fa-database text-warning"></i>为频繁查询的字段添加索引</li>
                                            <li><i class="fa-li fa fa-database text-warning"></i>避免在循环中执行SQL查询</li>
                                            <li><i class="fa-li fa fa-database text-warning"></i>定期清理无用数据</li>
                                            <li><i class="fa-li fa fa-database text-warning"></i>表名前缀统一为shua_</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="block block-rounded">
                                    <div class="block-header">
                                        <h3 class="block-title">系统架构说明</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="fa-ul">
                                            <li><i class="fa-li fa fa-sitemap text-success"></i>后台管理：admin目录</li>
                                            <li><i class="fa-li fa fa-sitemap text-success"></i>公共包含：includes目录</li>
                                            <li><i class="fa-li fa fa-sitemap text-success"></i>前端模板：templates目录</li>
                                            <li><i class="fa-li fa fa-sitemap text-success"></i>API接口：api目录</li>
                                            <li><i class="fa-li fa fa-sitemap text-success"></i>CDN资源：使用$cdnpublic变量引入</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="block block-rounded">
                                    <div class="block-header">
                                        <h3 class="block-title">常用功能模块</h3>
                                    </div>
                                    <div class="block-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>功能模块</th>
                                                        <th>相关文件</th>
                                                        <th>主要功能</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>用户管理</td>
                                                        <td>admin/site.php</td>
                                                        <td>管理系统用户和站点</td>
                                                    </tr>
                                                    <tr>
                                                        <td>商品管理</td>
                                                        <td>admin/tools.php</td>
                                                        <td>管理系统商品和分类</td>
                                                    </tr>
                                                    <tr>
                                                        <td>订单管理</td>
                                                        <td>admin/order.php</td>
                                                        <td>查看和处理用户订单</td>
                                                    </tr>
                                                    <tr>
                                                        <td>卡密管理</td>
                                                        <td>admin/faka.php</td>
                                                        <td>管理商品卡密信息</td>
                                                    </tr>
                                                    <tr>
                                                        <td>系统设置</td>
                                                        <td>admin/config.php</td>
                                                        <td>配置系统各项参数</td>
                                                    </tr>
                                                    <tr>
                                                        <td>日志管理</td>
                                                        <td>admin/logs.php</td>
                                                        <td>查看系统操作日志</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="block block-rounded">
                                    <div class="block-header">
                                        <h3 class="block-title">常用代码示例</h3>
                                    </div>
                                    <div class="block-content">
                                        <!-- 数据库查询示例 -->
                                        <div class="mb-4">
                                            <h4 class="font-w700 mb-2">数据库查询示例</h4>
                                            <div class="bg-gray-800 text-white p-3 rounded">
                                                <pre><code>// 获取商品列表示例
$rs = $DB->query("SELECT * FROM shua_tools WHERE active=1 ORDER BY sort ASC");
while($res = $DB->fetch($rs)){
    echo $res['name'].'&lt;br&gt;';
}

// 预处理语句防止SQL注入
$stmt = $DB->prepare("SELECT * FROM shua_site WHERE user=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();</code></pre>
                                            </div>
                                        </div>

                                        <!-- 用户验证示例 -->
                                        <div class="mb-4">
                                            <h4 class="font-w700 mb-2">用户登录验证示例</h4>
                                            <div class="bg-gray-800 text-white p-3 rounded">
                                                <pre><code>// 用户密码验证
$user = $DB->get_row("SELECT * FROM shua_site WHERE user='$username'");
if($user && md5($password.$user['pwd']) == $user['pwd']){
    // 登录成功，设置会话
    $_SESSION['user'] = $user['user'];
    $_SESSION['zid'] = $user['zid'];
    echo '登录成功！';
}else{
    echo '用户名或密码错误！';
}</code></pre>
                                            </div>
                                        </div>

                                        <!-- 订单创建示例 -->
                                        <div class="mb-4">
                                            <h4 class="font-w700 mb-2">订单创建示例</h4>
                                            <div class="bg-gray-800 text-white p-3 rounded">
                                                <pre><code>// 创建新订单
$trade_no = date("YmdHis").rand(1000,9999);
$DB->query("INSERT INTO shua_orders (tid, zid, input, value, money, cost, status, userid, tradeno, addtime) VALUES ('$tid', '$zid', '$input', '$value', '$money', '$cost', '0', '$userid', '$trade_no', NOW())");
$orderid = $DB->insert_id;

// 更新用户余额
$DB->query("UPDATE shua_site SET rmb=rmb-'$money' WHERE zid='$zid'");</code></pre>
                                            </div>
                                        </div>

                                        <!-- 错误处理示例 -->
                                        <div class="mb-4">
                                            <h4 class="font-w700 mb-2">错误处理示例</h4>
                                            <div class="bg-gray-800 text-white p-3 rounded">
                                                <pre><code>// 事务处理与错误捕获
$DB->query("BEGIN");
$update1 = $DB->query("UPDATE shua_site SET rmb=rmb-'$money' WHERE zid='$zid'");
$insert1 = $DB->query("INSERT INTO shua_orders (...) VALUES (...)");

if($update1 && $insert1){
    $DB->query("COMMIT");
    echo '操作成功！';
}else{
    $DB->query("ROLLBACK");
    // 记录错误日志
    $error_log = "操作失败：".date('Y-m-d H:i:s')." - 用户ID: ".$zid." - 错误: ".$DB->error()."\n";
    file_put_contents('../logs/error.log', $error_log, FILE_APPEND);
    echo '操作失败，请稍后重试！';
}</code></pre>
                                            </div>
                                        </div>

                                        <!-- 调试技巧 -->
                                        <div class="mb-4">
                                            <h4 class="font-w700 mb-2">调试技巧</h4>
                                            <div class="bg-gray-800 text-white p-3 rounded">
                                                <pre><code>// 输出变量调试信息
function debug($var, $title = 'Debug') {
    echo '&lt;div style="background:#000; color:#fff; padding:10px; margin:10px 0;"&gt;';
    echo '&lt;strong&gt;'.$title.'&lt;/strong&gt;&lt;pre&gt;';
    print_r($var);
    echo '&lt;/pre&gt;&lt;/div&gt;';
}

// 使用示例
$user_info = $DB->get_row("SELECT * FROM shua_site WHERE zid='$zid'");
debug($user_info, '用户信息');

// 记录详细操作日志
function write_log($action, $zid = 0, $user = ''){
    global $DB;
    $ip = getIP();
    $DB->query("INSERT INTO shua_logs (zid, user, action, ip, addtime) VALUES ('$zid', '$user', '$action', '$ip', NOW())");
}

// 使用示例
write_log('用户登录成功', $zid, $username);</code></pre>
                                            </div>
                                        </div>

                                        <!-- API接口调用示例 -->
                                        <div>
                                            <h4 class="font-w700 mb-2">API接口调用示例</h4>
                                            <div class="bg-gray-800 text-white p-3 rounded">
                                                <pre><code>// 发送HTTP请求函数
function curl_get($url, $timeout = 5) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// POST请求函数
function curl_post($url, $data, $timeout = 10) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// 调用第三方API示例
$api_url = 'https://api.example.com/v1/process';
$post_data = array(
    'key' => 'API_KEY',
    'data' => $order_data,
    'timestamp' => time()
);
$response = curl_post($api_url, $post_data);
$json_result = json_decode($response, true);

if($json_result['code'] == 200){
    // API调用成功
    echo '处理成功：'.$json_result['message'];
}else{
    // API调用失败
    echo '处理失败：'.$json_result['message'];
}</code></pre>
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

</div>

                            <!-- API接口说明 -->
                            <div class="panel panel-info mt-4">
                                <div class="panel-heading">
                                    <h3 class="panel-title">API接口说明</h3>
                                </div>
                                <div class="panel-body">
                                    <p class="text-muted">系统提供了丰富的API接口，方便开发者进行二次开发和对接。以下是主要的API接口说明：</p>
                                    
                                    <!-- 商品类API -->
                                    <div class="mb-4">
                                        <h4>1. 商品类API</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>接口名称</th>
                                                        <th>请求地址</th>
                                                        <th>请求方式</th>
                                                        <th>参数说明</th>
                                                        <th>返回格式</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>获取商品列表</td>
                                                        <td>/api/goods_list.php</td>
                                                        <td>GET</td>
                                                        <td>cid=分类ID（可选）</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>获取商品详情</td>
                                                        <td>/api/goods_detail.php</td>
                                                        <td>GET</td>
                                                        <td>tid=商品ID</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>获取商品库存</td>
                                                        <td>/api/goods_stock.php</td>
                                                        <td>GET</td>
                                                        <td>tid=商品ID</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 订单类API -->
                                    <div class="mb-4">
                                        <h4>2. 订单类API</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>接口名称</th>
                                                        <th>请求地址</th>
                                                        <th>请求方式</th>
                                                        <th>参数说明</th>
                                                        <th>返回格式</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>创建订单</td>
                                                        <td>/api/create_order.php</td>
                                                        <td>POST</td>
                                                        <td>tid=商品ID, num=数量, input=输入内容, token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>查询订单状态</td>
                                                        <td>/api/order_status.php</td>
                                                        <td>GET</td>
                                                        <td>order_no=订单号, token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>获取订单列表</td>
                                                        <td>/api/order_list.php</td>
                                                        <td>GET</td>
                                                        <td>page=页码, limit=每页数量, token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 支付类API -->
                                    <div class="mb-4">
                                        <h4>3. 支付类API</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>接口名称</th>
                                                        <th>请求地址</th>
                                                        <th>请求方式</th>
                                                        <th>参数说明</th>
                                                        <th>返回格式</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>创建支付</td>
                                                        <td>/api/create_pay.php</td>
                                                        <td>POST</td>
                                                        <td>money=金额, type=支付方式, token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>查询支付状态</td>
                                                        <td>/api/pay_status.php</td>
                                                        <td>GET</td>
                                                        <td>trade_no=交易单号, token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>获取支付配置</td>
                                                        <td>/api/pay_config.php</td>
                                                        <td>GET</td>
                                                        <td>token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 用户类API -->
                                    <div class="mb-4">
                                        <h4>4. 用户类API</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>接口名称</th>
                                                        <th>请求地址</th>
                                                        <th>请求方式</th>
                                                        <th>参数说明</th>
                                                        <th>返回格式</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>用户登录</td>
                                                        <td>/api/user_login.php</td>
                                                        <td>POST</td>
                                                        <td>username=用户名, password=密码</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>获取用户信息</td>
                                                        <td>/api/user_info.php</td>
                                                        <td>GET</td>
                                                        <td>token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>查询余额</td>
                                                        <td>/api/user_balance.php</td>
                                                        <td>GET</td>
                                                        <td>token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                    <tr>
                                                        <td>修改密码</td>
                                                        <td>/api/change_password.php</td>
                                                        <td>POST</td>
                                                        <td>old_pass=旧密码, new_pass=新密码, token=用户令牌</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- API返回示例 -->
                                    <div class="mt-4">
                                        <h4>API返回示例</h4>
                                        <div class="mt-2">
                                            <pre class="bg-dark text-green p-3 rounded">
<!-- 成功返回格式 -->
{
    "code": 200,
    "msg": "操作成功",
    "data": {
        // 返回的数据内容
    }
}

<!-- 失败返回格式 -->
{
    "code": 400,
    "msg": "操作失败",
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
        </div>
    </div>
</div>

</div>
</div>
<script src="<?php echo $cdnpublic?>layer/3.1.1/layer.js"></script>
</body>
</html>