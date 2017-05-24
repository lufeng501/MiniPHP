<?php
/**
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/11
 * Time: 17:43
 */

namespace Framework;


class App
{

    // 项目根路径
    public $rootPath;

    // 应用实例
    public static $app;

    // 容器实例
    public static $container;

    /**
     * App constructor.
     * @param $rootPath
     */
    public function __construct($rootPath)
    {
        // 根目录
        $this->rootPath = realpath($rootPath);
        //实例
        self::$app = $this;
        //容器
        self::$container = new Container();
    }

    /**
     * 运行
     */
    public function run($className)
    {
        $requestInstance = self::$container->getSingleInstance($className);
        // 开始执行路由分发
        $requestInstance->routeDispatch();
    }

    /**
     * 获取单例对象
     * @param $className
     * @return mixed
     */
    public function getSingleInstance($className) {
        return self::$container->getSingleInstance($className);
    }

    /**
     * 加载实例化
     * @param $className
     * @param bool $single
     */
    public function load($className,$single=false)
    {
        if ($single == true) { // 单例
            self::$container->singleton($className,self::$app);
        }
    }

}