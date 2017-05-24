<?php
/**
 * Des : 类实例容器
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/11
 * Time: 18:13
 */

namespace Framework;


class Container
{
    private $instanceSingleLists = [];

    public function __construct()
    {

    }

    /**
     * 单例实例化
     */
    public function singleton($className, App $app)
    {
        // 判断是否已经存在单例实例
        if (empty($this->instanceSingleLists[$className])) {
            $this->instanceSingleLists[$className] = new $className($app);
        }
        $this->instanceSingleLists[$className];
        return true;
    }

    /**
     * 实例化
     * @param $className
     * @return bool
     */
    public function setSingleInstance($className)
    {
        $this->instanceSingleLists[$className] = new $className();
        return true;
    }

    /**
     * 获取单例对象实例
     */
    public function getSingleInstance($className)
    {
        if (!isset($this->instanceSingleLists[$className])) {
            // 实例化
            $this->setSingleInstance($className);
        }
        return $this->instanceSingleLists[$className];
    }
}