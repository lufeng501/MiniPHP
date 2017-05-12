<?php
/**
 * Des : 全局helpers文件
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/12
 * Time: 11:01
 */

/**
 * 获取配置
 * @param $key
 * @return mixed
 */
function config($key) {
    global $app;
    $configInstance = $app->getSingleInstance(\Framework\handles\ConfigHandle::class);
    $value = $configInstance->loadConfig($key);
    return $value;
}