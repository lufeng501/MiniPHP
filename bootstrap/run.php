<?php
/**
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/11
 * Time: 17:44
 */

// 自动加载composer类
require(__DIR__. "/../vendor/autoload.php");

// 自动加载核心文件
require (__DIR__.'/../framework/Psr4Autoloader.php');

$loader =  new \Framework\Psr4Autoloader();

// 自动加载类注册
$loader->register();

// 添加自动加载的目录
// @todo 支持可配置
$loader->addNamespace('Lib', __DIR__ . "/../lib");
$loader->addNamespace('App', __DIR__ . "/../app");
$loader->addNamespace('Framework', __DIR__ . "/../framework");

global $app;
// 实例化应用
// 自动加载Helpers文件


$app = new \Framework\App(__DIR__.'/..');

$app->load(\Framework\handles\ConfigHandle::class,true);

require (__DIR__."/../framework/Helpers.php");

$app->load(\Framework\handles\RouterHandle::class,true);

$app->run(\Framework\handles\RouterHandle::class);

