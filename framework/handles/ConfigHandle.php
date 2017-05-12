<?php
/**
 * Des : 配置类
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/12
 * Time: 11:56
 */

namespace Framework\handles;


use Framework\App;

class ConfigHandle implements Handle
{

    private $app;

    private $configs = [];

    public function __construct(App $app)
    {
        $this->register($app);
    }

    public function register(App $app)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name 属性名称
     * @param mixed $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    public function loadConfig($key = false)
    {
        $rootPath = $this->app->rootPath;
        $configArr = explode('.', $key);
        // 默认获取app.php文件中配置文件
        if (count($configArr) == 1) {
            $configKey = $key;
            $configs = require_once($rootPath . "/config/app.php");
            if (!is_bool($configs)) {
                $this->configs['app'] = $configs;
            }
            return $this->configs['app'][$configKey];
        } else {
            $configKey = end($configArr);
            array_pop($configArr);
            $configPath = implode('/', $configArr);
            $configs = require_once($rootPath . "/config/" . $configPath . '.php');
            if (!is_bool($configs)) {
                $this->configs[$configPath] = $configs;
            }
            return $this->configs[$configPath][$configKey];
        }
    }
}