<?php
/**
 * Created by PhpStorm.
 * User: luyingru
 * Date: 2016/6/12
 * Time: 17:21
 * 自动加载的引导程序
 */

include_once( __DIR__ . "/autoloader.php");
include_once( __DIR__ . "/../vendor/autoload.php");
include_once( __DIR__ . "/../config/define.php");

$loader = new \Example\Psr4AutoloaderClass;

$loader->register();

$loader->addNamespace('Lib', __DIR__ . "/../lib");
$loader->addNamespace('App', __DIR__ . "/../app");