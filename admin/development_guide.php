<?php include '../common.php'; ?>
<?php include './admin_config.php'; ?>
<?php include './checklogin.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统开发规范文档 - 刷赞系统</title>
    <meta name="author" content="教主 - zhonguo.ren QQ群915043052">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .code-block {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.25rem;
            border-left: 4px solid #007bff;
            overflow-x: auto;
            margin-bottom: 1rem;
        }
        .card {
            margin-bottom: 1.5rem;
        }
        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }
        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        pre {
            background-color: #282c34;
            color: #abb2bf;
            padding: 1rem;
            border-radius: 0.25rem;
            overflow-x: auto;
        }
        code {
            color: #e06c75;
        }
        .tip-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .danger-box {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include './header.php'; ?>
        <div class="leftside">
            <?php include './menu.php'; ?>
        </div>
        <div class="rightside">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">系统开发规范文档</h3>
                        <p class="card-text">本文档旨在规范系统开发流程、代码风格和最佳实践，确保团队开发效率和代码质量。</p>
                        <p class="text-muted">作者：教主 - <a href="http://zhonguo.ren" target="_blank">zhonguo.ren</a> | QQ群：915043052</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="devGuideTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="coding-standards-tab" data-toggle="tab" href="#coding-standards" role="tab" aria-controls="coding-standards" aria-selected="true">1. 编码规范</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="naming-conventions-tab" data-toggle="tab" href="#naming-conventions" role="tab" aria-controls="naming-conventions" aria-selected="false">2. 命名规范</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="database-standards-tab" data-toggle="tab" href="#database-standards" role="tab" aria-controls="database-standards" aria-selected="false">3. 数据库规范</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="security-standards-tab" data-toggle="tab" href="#security-standards" role="tab" aria-controls="security-standards" aria-selected="false">4. 安全规范</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="development-process-tab" data-toggle="tab" href="#development-process" role="tab" aria-controls="development-process" aria-selected="false">5. 开发流程</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="file-structure-tab" data-toggle="tab" href="#file-structure" role="tab" aria-controls="file-structure" aria-selected="false">6. 文件结构</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-4" id="devGuideTabsContent">
                            <!-- 编码规范 -->
                            <div class="tab-pane fade show active" id="coding-standards" role="tabpanel" aria-labelledby="coding-standards-tab">
                                <h4 class="mb-3">PHP编码规范</h4>
                                
                                <div class="code-block">
                                    <pre><code>&lt;?php
// 使用PHP短标签
// 所有PHP文件开头必须包含此注释
// 作者：教主 - zhonguo.ren QQ群915043052

// 使用大括号风格（与控制结构在同一行）
if ($condition) {
    // 代码块
} else {
    // 代码块
}

// 函数定义
function functionName($param1, $param2 = null) {
    // 函数体
    return $result;
}

// 缩进使用4个空格，禁止使用Tab
$array = [
    'key1' => 'value1',
    'key2' => 'value2'
];

// 字符串连接使用点号
$message = 'Hello, ' . $name . '!';

// 变量赋值时等号两侧保留空格
$count = 10;

// 运算符两侧保留空格
$sum = $a + $b;

// 行尾不使用分号（可选，但推荐统一风格）
?&gt;</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">HTML/CSS编码规范</h4>
                                
                                <div class="code-block">
                                    <pre><code>&lt;!-- HTML5文档类型声明 --&gt;
&lt;!DOCTYPE html&gt;
&lt;html lang="zh-CN"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;页面标题&lt;/title&gt;
    &lt;!-- 使用Bootstrap框架 --&gt;
    &lt;link rel="stylesheet" href="../assets/css/bootstrap.min.css"&gt;
    &lt;link rel="stylesheet" href="../assets/css/admin.css"&gt;
    &lt;style&gt;
        /* 内联样式应尽量少用，主要放在CSS文件中 */
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;!-- 使用语义化HTML标签 --&gt;
    &lt;header&gt;&lt;/header&gt;
    &lt;main&gt;&lt;/main&gt;
    &lt;footer&gt;&lt;/footer&gt;
    
    &lt;!-- Bootstrap组件使用 --&gt;
    &lt;div class="container"&gt;
        &lt;div class="row"&gt;
            &lt;div class="col-md-6"&gt;
                &lt;div class="card"&gt;
                    &lt;div class="card-body"&gt;
                        &lt;h5 class="card-title"&gt;卡片标题&lt;/h5&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;!-- JavaScript脚本放在body底部 --&gt;
    &lt;script src="../assets/js/jquery.min.js"&gt;&lt;/script&gt;
    &lt;script src="../assets/js/bootstrap.bundle.min.js"&gt;&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">JavaScript编码规范</h4>
                                
                                <div class="code-block">
                                    <pre><code>// 使用let和const代替var
let counter = 0;
const MAX_COUNT = 100;

// 函数定义
function processData(data) {
    // 函数体
    return processedData;
}

// 箭头函数（适用于回调函数等场景）
const handleClick = () => {
    // 处理点击事件
};

// 对象字面量
const user = {
    id: 1,
    name: 'John',
    email: 'john@example.com'
};

// 字符串模板（ES6特性）
const message = `Hello, ${user.name}!`;

// 避免使用eval()
// 错误处理
try {
    // 可能抛出异常的代码
} catch (error) {
    console.error('发生错误:', error);
}</code></pre>
                                </div>

                                <div class="tip-box">
                                    <strong>提示：</strong>所有代码必须有适当的注释，特别是复杂的逻辑和业务流程。注释应清晰明了，不要过多冗余但也不要过于简略。
                                </div>
                            </div>

                            <!-- 命名规范 -->
                            <div class="tab-pane fade" id="naming-conventions" role="tabpanel" aria-labelledby="naming-conventions-tab">
                                <h4 class="mb-3">变量命名</h4>
                                <ul>
                                    <li>使用驼峰命名法（camelCase）</li>
                                    <li>变量名应具有描述性，避免使用单字母变量（循环变量除外）</li>
                                    <li>布尔变量应使用is/has/can等前缀，如：<code>isLogin</code>、<code>hasPermission</code></li>
                                    <li>常量使用全大写字母，单词间用下划线分隔，如：<code>MAX_RETRY_COUNT</code></li>
                                </ul>

                                <div class="code-block">
                                    <pre><code>// 好的变量命名示例
let userId = 123;
let isAdminUser = false;
const MAX_CONNECTIONS = 10;

// 避免使用的变量命名
let a = 123; // 过于简略
let user_id = 123; // 不符合驼峰命名
let maxConnections = 10; // 常量应全大写</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">函数命名</h4>
                                <ul>
                                    <li>使用驼峰命名法（camelCase）</li>
                                    <li>函数名应使用动词开头，清晰表达函数的功能</li>
                                    <li>避免使用模糊的函数名，如：<code>processData</code>、<code>handleEvent</code></li>
                                </ul>

                                <div class="code-block">
                                    <pre><code>// 好的函数命名示例
function getUserInfo(userId) {}
function calculateTotalPrice(items) {}
function validateEmail(email) {}

// 避免使用的函数命名
function doSomething() {} // 功能不明确
function process() {} // 功能太宽泛</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">类命名</h4>
                                <ul>
                                    <li>使用帕斯卡命名法（PascalCase），首字母大写</li>
                                    <li>类名应具有描述性，表示一个具体的实体</li>
                                </ul>

                                <div class="code-block">
                                    <pre><code>// 类命名示例
class UserManager {
    constructor() {}
    getUser() {}
}

class OrderProcessor {
    constructor() {}
    processOrder() {}
}</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">数据库表和字段命名</h4>
                                <ul>
                                    <li>表名使用小写字母，单词间用下划线分隔，前缀为<code>shua_</code></li>
                                    <li>字段名使用小写字母，单词间用下划线分隔</li>
                                    <li>主键统一命名为<code>id</code>，外键命名为<code>表名_id</code>，如：<code>user_id</code></li>
                                </ul>

                                <div class="code-block">
                                    <pre><code>-- 表和字段命名示例
CREATE TABLE `shua_users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `create_time` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `shua_orders` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `order_no` VARCHAR(50) NOT NULL,
    `total_price` DECIMAL(10,2) NOT NULL,
    `status` TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;</code></pre>
                                </div>
                            </div>

                            <!-- 数据库规范 -->
                            <div class="tab-pane fade" id="database-standards" role="tabpanel" aria-labelledby="database-standards-tab">
                                <h4 class="mb-3">数据库设计原则</h4>
                                <ul>
                                    <li>遵循第三范式（3NF），减少数据冗余</li>
                                    <li>合理设计字段类型和长度，避免浪费空间</li>
                                    <li>为常用查询字段创建索引，提高查询性能</li>
                                    <li>使用InnoDB引擎，支持事务和外键约束</li>
                                    <li>字符集使用utf8mb4，支持更广泛的字符集（包括emoji表情）</li>
                                </ul>

                                <h4 class="mb-3 mt-5">SQL语句规范</h4>
                                <div class="code-block">
                                    <pre><code>-- SELECT语句规范
SELECT u.id, u.username, o.order_no, o.total_price 
FROM shua_users u
INNER JOIN shua_orders o ON u.id = o.user_id
WHERE o.status = 1
ORDER BY o.create_time DESC
LIMIT 0, 20;

-- INSERT语句规范
INSERT INTO shua_orders (user_id, order_no, total_price, status, create_time) 
VALUES (1, '20210601123456', 100.00, 1, UNIX_TIMESTAMP());

-- UPDATE语句规范
UPDATE shua_users 
SET last_login_time = UNIX_TIMESTAMP(), last_login_ip = '192.168.1.1'
WHERE id = 1;

-- DELETE语句规范
DELETE FROM shua_cart_items WHERE user_id = 1 AND product_id = 10;</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">事务处理</h4>
                                <p>对于涉及多表操作的业务逻辑，必须使用事务保证数据一致性。</p>
                                <div class="code-block">
                                    <pre><code>// 事务处理示例
$pdo->beginTransaction();
try {
    // 执行多个SQL操作
    $pdo->exec("UPDATE shua_users SET balance = balance - 100 WHERE id = 1");
    $pdo->exec("INSERT INTO shua_orders (user_id, total_price) VALUES (1, 100)");
    $pdo->exec("INSERT INTO shua_order_logs (order_id, action) VALUES (LAST_INSERT_ID(), 'create')");
    
    // 提交事务
    $pdo->commit();
} catch (Exception $e) {
    // 发生异常时回滚事务
    $pdo->rollBack();
    // 记录错误日志
    write_log('Transaction failed: ' . $e->getMessage());
}</code></pre>
                                </div>

                                <div class="warning-box">
                                    <strong>警告：</strong>禁止在生产环境中使用<code>SELECT *</code>查询，应明确指定需要查询的字段，以提高查询性能和避免不必要的数据传输。
                                </div>
                            </div>

                            <!-- 安全规范 -->
                            <div class="tab-pane fade" id="security-standards" role="tabpanel" aria-labelledby="security-standards-tab">
                                <h4 class="mb-3">输入验证</h4>
                                <p>所有用户输入必须进行严格验证，包括但不限于：</p>
                                <ul>
                                    <li>数据类型验证（整数、浮点数、字符串等）</li>
                                    <li>数据长度验证（最小/最大长度）</li>
                                    <li>格式验证（邮箱、手机号、日期等）</li>
                                    <li>业务逻辑验证（是否存在、权限检查等）</li>
                                </ul>
                                <div class="code-block">
                                    <pre><code>// 输入验证示例
function validateUserData($data) {
    $errors = [];
    
    // 用户名验证
    if (empty($data['username'])) {
        $errors[] = '用户名不能为空';
    } elseif (strlen($data['username']) < 3 || strlen($data['username']) > 20) {
        $errors[] = '用户名长度应在3-20个字符之间';
    }
    
    // 邮箱验证
    if (empty($data['email'])) {
        $errors[] = '邮箱不能为空';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = '邮箱格式不正确';
    }
    
    return $errors;
}</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">输出转义</h4>
                                <p>所有用户可控数据在输出到页面前必须进行转义，防止XSS攻击。</p>
                                <div class="code-block">
                                    <pre><code>// 输出转义示例
// PHP输出转义
&lt;?php echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8'); ?&gt;

// JavaScript输出转义（在PHP中处理）
var username = '&lt;?php echo json_encode($userInput); ?&gt;';

// 在模板中使用
&lt;div&gt;&lt;?php echo safe_output($userInput); ?&gt;&lt;/div&gt;</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">密码安全</h4>
                                <ul>
                                    <li>用户密码必须使用bcrypt或password_hash进行加密存储</li>
                                    <li>禁止明文存储密码或使用简单的MD5/SHA1哈希</li>
                                    <li>强制用户设置强度较高的密码（长度、复杂度要求）</li>
                                    <li>实现密码定期过期和历史密码检查功能</li>
                                </ul>
                                <div class="code-block">
                                    <pre><code>// 密码加密示例
$password = 'UserPassword123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 密码验证示例
if (password_verify($userInputPassword, $storedHashedPassword)) {
    // 密码正确
} else {
    // 密码错误
}</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">防止SQL注入</h4>
                                <p>使用预处理语句和参数绑定，禁止直接拼接SQL语句。</p>
                                <div class="code-block">
                                    <pre><code>// 预处理语句示例（PDO）
$stmt = $pdo->prepare("SELECT * FROM shua_users WHERE username = :username AND status = :status");
$stmt->bindParam(':username', $username);
$stmt->bindParam(':status', $status);
$stmt->execute();
$user = $stmt->fetch();

// mysqli预处理语句示例
$stmt = $mysqli->prepare("SELECT * FROM shua_users WHERE username = ? AND status = ?");
$stmt->bind_param("si", $username, $status);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">会话安全</h4>
                                <ul>
                                    <li>设置合适的会话过期时间</li>
                                    <li>使用HTTPS保护会话Cookie</li>
                                    <li>禁止通过URL传递会话ID</li>
                                    <li>实现会话固定攻击防护</li>
                                    <li>用户登录成功后重新生成会话ID</li>
                                </ul>

                                <div class="danger-box">
                                    <strong>重要安全提示：</strong>开发过程中必须时刻注意安全问题，遵循最小权限原则，定期进行安全审计和漏洞扫描。任何安全漏洞都可能导致严重的后果。
                                </div>
                            </div>

                            <!-- 开发流程 -->
                            <div class="tab-pane fade" id="development-process" role="tabpanel" aria-labelledby="development-process-tab">
                                <h4 class="mb-3">开发环境配置</h4>
                                <p>本地开发环境应尽量与生产环境保持一致：</p>
                                <ul>
                                    <li>PHP版本：7.4+</li>
                                    <li>MySQL版本：5.7+</li>
                                    <li>Web服务器：Nginx 1.22.0+</li>
                                    <li>开发工具：推荐使用VSCode、PHPStorm等</li>
                                    <li>版本控制：Git</li>
                                </ul>

                                <h4 class="mb-3 mt-5">开发工作流</h4>
                                <ol>
                                    <li><strong>需求分析</strong>：理解功能需求，编写需求文档</li>
                                    <li><strong>设计</strong>：进行系统设计、数据库设计和界面设计</li>
                                    <li><strong>编码</strong>：按照规范编写代码，进行单元测试</li>
                                    <li><strong>测试</strong>：进行功能测试、性能测试和安全测试</li>
                                    <li><strong>代码审查</strong>：团队成员互相审查代码</li>
                                    <li><strong>部署</strong>：将代码部署到测试环境和生产环境</li>
                                    <li><strong>监控与维护</strong>：监控系统运行状态，及时修复bug</li>
                                </ol>

                                <h4 class="mb-3 mt-5">代码提交规范</h4>
                                <p>Git提交信息应清晰明了，遵循以下格式：</p>
                                <div class="code-block">
                                    <pre><code>// Git提交信息示例
[类型]: 简洁描述

详细描述（可选）

相关issue（可选）</code></pre>
                                </div>
                                <p>常见的提交类型包括：</p>
                                <ul>
                                    <li>feat: 新功能</li>
                                    <li>fix: 修复bug</li>
                                    <li>docs: 文档修改</li>
                                    <li>style: 代码格式调整，不影响功能</li>
                                    <li>refactor: 代码重构，不新增功能</li>
                                    <li>test: 添加或修改测试代码</li>
                                    <li>chore: 构建过程或辅助工具变动</li>
                                </ul>

                                <h4 class="mb-3 mt-5">代码审查流程</h4>
                                <p>所有代码在合并到主分支前必须经过代码审查：</p>
                                <ol>
                                    <li>开发者提交代码到功能分支</li>
                                    <li>创建Pull Request/Merge Request</li>
                                    <li>至少一名团队成员进行代码审查</li>
                                    <li>审查通过后，代码合并到主分支</li>
                                    <li>自动或手动部署到测试环境进行测试</li>
                                </ol>

                                <div class="tip-box">
                                    <strong>提示：</strong>建议使用项目管理工具（如Jira、Trello）来跟踪任务进度和管理项目流程。
                                </div>
                            </div>

                            <!-- 文件结构 -->
                            <div class="tab-pane fade" id="file-structure" role="tabpanel" aria-labelledby="file-structure-tab">
                                <h4 class="mb-3">系统目录结构</h4>
                                <p>系统采用模块化设计，目录结构清晰，便于维护和扩展。</p>
                                <div class="code-block">
                                    <pre><code>d:/wwwroot/127.0.0.3/
├── admin/                 # 后台管理系统目录
│   ├── assets/            # 后台静态资源
│   ├── include/           # 后台包含文件
│   ├── pages/             # 后台页面
│   ├── api/               # 后台API接口
│   ├── devdoc.php         # 开发文档
│   ├── system_architecture.php  # 系统架构文档
│   ├── api_doc.php        # API接口文档
│   ├── database_design.php # 数据库设计文档
│   ├── development_guide.php # 开发规范文档
│   └── ...
├── api/                   # 前台API接口
├── assets/                # 前台静态资源
│   ├── css/
│   ├── js/
│   ├── img/
│   └── ...
├── common.php             # 公共函数和配置
├── index.php              # 网站首页
├── user/                  # 用户中心
├── orders/                # 订单相关
├── products/              # 商品相关
└── ...</code></pre>
                                </div>

                                <h4 class="mb-3 mt-5">文件命名规范</h4>
                                <ul>
                                    <li>文件名使用小写字母，单词间用下划线分隔</li>
                                    <li>功能相关的文件应放在同一目录下</li>
                                    <li>公共组件和工具类应放在特定的目录中</li>
                                    <li>避免创建过于复杂的目录层次结构</li>
                                </ul>

                                <h4 class="mb-3 mt-5">模块划分</h4>
                                <p>系统主要模块划分如下：</p>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>模块名称</th>
                                            <th>主要职责</th>
                                            <th>文件位置</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>用户管理</td>
                                            <td>用户注册、登录、信息管理</td>
                                            <td>user/</td>
                                        </tr>
                                        <tr>
                                            <td>订单管理</td>
                                            <td>订单创建、查询、状态更新</td>
                                            <td>orders/</td>
                                        </tr>
                                        <tr>
                                            <td>商品管理</td>
                                            <td>商品列表、详情、库存管理</td>
                                            <td>products/</td>
                                        </tr>
                                        <tr>
                                            <td>支付系统</td>
                                            <td>支付处理、回调、结算</td>
                                            <td>api/pay/</td>
                                        </tr>
                                        <tr>
                                            <td>后台管理</td>
                                            <td>系统配置、用户管理、订单审核</td>
                                            <td>admin/</td>
                                        </tr>
                                        <tr>
                                            <td>API接口</td>
                                            <td>对外提供的接口服务</td>
                                            <td>api/</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="tip-box">
                                    <strong>提示：</strong>在添加新功能或修改现有功能时，应遵循系统现有的文件结构和模块划分原则，保持代码的一致性和可维护性。
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // 初始化标签页
        $(document).ready(function() {
            $('#devGuideTabs a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        })
    </script>
</body>
</html>
<?php include '../foot.php'; ?>