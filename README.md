# 彩虹商城重构版
1、框架全部更新
2、内置供货商
3、内置客服系统
4、代码进行优化
5、直客接口更新
6、仿易客手机端模板等多款模板
## 一、环境要求
- 操作系统：推荐 Linux（CentOS 7+/Ubuntu 18+），Windows 也可
- Web服务器：Nginx 或 Apache
- PHP 版本：7.4 及以上
- 数据库：MySQL 5.6 及以上
- 依赖扩展：pdo、pdo_mysql、openssl、fileinfo、mbstring、curl、gd、zip

## 二、准备工作
1. 获取完整源码包，上传至服务器网站根目录
2. 配置好域名解析，确保域名已指向服务器
3. 设置好网站目录权限，确保 PHP 有读写权限
4. 导入源码内的数据库

## 三、安装步骤
1. 浏览器访问 `http://你的域名/install/` 进入安装界面
2. 按提示填写数据库信息、管理员账号等
3. 安装完成后，删除 `/install` 目录或创建 `install/install.lock` 文件
4. 进入后台管理：`http://你的域名/admin/`
