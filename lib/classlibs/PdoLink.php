<?php
/**
 * Descript: pdo链接数据库
 * User: lufeng501206@gmail.com
 * Date: 2017/3/13 9:53
 */

namespace Lib\classlibs;


class PdoLink
{
    private static $_link;

    public function __construct()
    {
        $dsn = "mysql:dbname=white_cap;host=localhost";
        $db_user = 'root';
        $db_pass = 'lusion';
        try {
            self::$_link = new \PDO($dsn, $db_user, $db_pass);
        } catch (\PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            die;
        }
    }

    /**
     * 执行sql语句
     * @param $sql
     * @return int
     */
    public function exec($sql)
    {
        $nums = self::$_link->exec($sql);
        return $nums;
    }

    /**
     * 执行sql查询语句
     * @param $sql
     * @return \PDOStatement
     */
    public function query($sql)
    {
        $result = array();
        $res = self::$_link->query($sql,\PDO::FETCH_ASSOC);
        foreach ($res as $k => $row) {
            $result[] = $row;
        }
        return $result;
    }
}