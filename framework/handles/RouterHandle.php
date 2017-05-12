<?php
/**
 * Des : 路由处理类
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/11
 * Time: 19:50
 */

namespace Framework\handles;


class RouterHandle
{
    // 获取参数
    private $serverParams;
    // 获取请求方法
    private $method;
    // 模块
    private $moduleName;
    // 控制器
    private $controllerName;
    // 方法
    private $actionName;

    public function __construct()
    {
        // 获取参数
        $this->serverParams = $_SERVER;
        // 获取方法
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
        // 获取url
        $this->requestUri = $this->server('REQUEST_URI');
    }

    /**
     * 路由分发(路由策略)
     */
    public function routeDispatch()
    {
        $this->pathinfo();

        // 判断默认模块、控制器、方法
        if (empty($this->moduleName)) {
            $this->moduleName = config('router.defaultModule');
        }
        if (empty($this->controllerName)) {
            $this->controllerName = config('router.defaultController');
        }
        if (empty($this->actionName)) {
            $this->actionName = config('router.defaultAction');
        }

        // 获取控制器类
        $controllerName = ucfirst($this->controllerName);
        $controllerPath = "App\\controllers\\{$this->moduleName}\\{$controllerName}Controller";

        // 判断控制器存不存在
        if (!class_exists($controllerPath)) {
            throw new \Exception('404 Controller:' . $controllerPath);
        }
        // 实例化当前控制器
        $controller = new $controllerPath();
        // 调用操作
        $actionName = $this->actionName;
        // 获取返回值
        $controller->$actionName();
    }

    private function pathinfo()
    {
        /* 匹配出uri */
        if (strpos($this->requestUri, '?')) {
            preg_match('/^\/(.*)\?/', $this->requestUri, $uri);
        } else {
            preg_match('/^\/(.*)/', $this->requestUri, $uri);
        }
        $uri = $uri[1];
        $uri = explode('/', $uri);
        switch (count($uri)) {
            case 3:
                $this->moduleName = $uri['0'];
                $this->controllerName = $uri['1'];
                $this->actionName = $uri['2'];
                break;

            case 2:
                /*
                * 使用默认方法
                */
                $this->moduleName = $uri['0'];
                $this->controllerName = $uri['1'];
                break;
            case 1:
                /*
                * 使用默认方法/控制器
                */
                $this->moduleName = $uri['0'];
                break;

            default:
                /*
                * 使用默认模块/控制器/操作逻辑
                */
                break;
        }

    }

    /**
     * 获取SERVER参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    private function server($value = '')
    {
        if (isset($this->serverParams[$value])) {
            return $this->serverParams[$value];
        }
        return '';
    }
}