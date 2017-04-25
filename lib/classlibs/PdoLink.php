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

    private $table;

    private $whereStr;

    public function __construct()
    {
        $dsn = "mysql:dbname=white_cap;host=localhost";
        $db_user = 'root';
        $db_pass = 'lusion';
        try {
            self::$_link = new \PDO($dsn, $db_user, $db_pass);
            self::$_link->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果
        } catch (\PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            die;
        }
    }

    public function preSql()
    {

        $user = "root ' or '1'#";
//        $user = "root";
        $pwd = 'e10adc3949ba59abbe56e057f20f883e';

        $st = self::$_link->prepare("select * from users where user = :username and pwd = :pwd limit 1");

        $st->bindParam(':username',$user);
        $st->bindParam(':pwd',$pwd);

        $st->execute();
        $bb = $st->fetchAll();

        return $bb;
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
        $aa = self::$_link->prepare($sql);
        $res = self::$_link->query($sql, \PDO::FETCH_ASSOC);
        foreach ($res as $k => $row) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * 设置表名字
     * @param $tableName
     * @return $this
     */
    public function table($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    public function where($value = [])
    {
        $whereStr = '';
        if (!empty($value)) {
            $tempWhere = [];
            foreach ($value as $k => $v) {
                $tempWhere[] = " `" . $k . "` = '" . $v . "'";
            }
            $whereStr = implode(' and ',$tempWhere);
        }
        $this->whereStr = $whereStr;
        return $this;
    }

    public function get()
    {
        $sql = "select * from " . $this->table . " where " . $this->whereStr;
        return $this->query($sql);
    }
}