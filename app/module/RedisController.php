<?php
/**
 * Descript:
 * User: luyingru@37.com
 * Date: 2017/2/23 14:39
 */

namespace App\module;


class RedisController
{

    public function index()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        echo "Connection to server sucessfully";
        echo "<br/>";
        //查看服务是否运行
        echo "Server is running: " . $redis->ping();
        echo "<br/>";
        //设置 redis 字符串数据
        $redis->set("foo", "hello world");
        // 获取存储的数据并输出
        echo "Stored string in redis:: " . $redis->get("foo");
    }

    /**
     * 队列生产者
     */
    public function producer()
    {
        //连接本地的 Redis 服务
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        try {
            $redis->lPush('task', "task-1");
            $redis->lPush('task', "task-2");
            $redis->lPush('task', "task-3");
            $redis->lPush('task', "task-4");
            $redis->lPush('task', "task-5");
            echo "队列生产者生成成功";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 队列消费者
     */
    public function consumer()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        try {
//            $value = $redis->LPOP('task');
            $value = $redis->rPop('task');
            echo "队列消费者消费成功";
            var_dump($value);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}