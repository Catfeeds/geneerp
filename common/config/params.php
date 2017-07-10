<?php

//网站全局配置
$config = require(__DIR__ . '/config.php');
//允许上传图片后缀
$config['image_extensions'] = ['jpg', 'jpeg', 'png', 'gif'];
//允许上传文件后缀
$config['file_extensions'] = ['jpg', 'jpeg', 'png', 'gif', 'rar', 'zip', 'txt', 'doc', 'swf', 'xls', 'ppt', 'docx', 'xlsx', 'pptx', 'chm', 'pdf', 'css', 'js', 'html'];
//编辑器上传允许的目录
$config['editor_dir'] = ['image', 'flash', 'media', 'file'];
//前台登录失败次数超过多少会显示验证码
$config['user_login_max_count'] = 6;
//后台登录失败次数超过多少会显示验证码
$config['admin_login_max_count'] = 3;
//管理员UID 可以设置多个
$config['admin_id'] = [10];
//API token 过期时间 1天
$config['api_token_expire'] = 7 * 24 * 3600;
//user.apiTokenExpire
return $config;
