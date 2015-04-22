<?php
header('Content-Type:text/html;charset=utf-8');
session_start();
set_time_limit(10);
/**
 * 基本配置
 */
define('APP_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
define('APP_DEBUG',true);
define('THINK_PATH','G:/www/CCThink/Core/');
/**
 * 定义基本错误消息号
 */
define('LOGIN_TYPE',1);   //登陆模式
define('CODE_VALID_TIME',0);    //验证码有效时间 0=>表示永久有效 非零表示指定时间有效
define('CODE_RROR',100);  //校验码错误
define('CODE_EXPIRE',101);  //校验码已过期
define('DOMAIN','http://'.$_SERVER['HTTP_HOST'].'/choucheng/');
define('PHONE_CODE_INTERVAL',60000);  //拉取验证码间隔时间 毫秒
define('PHONE_CODE_EXPIRE_TIME',20*60*1000);  //验证码过期时间 毫秒 默认 20M

require THINK_PATH.(APP_DEBUG?'debug.php':'index.php');
?>
