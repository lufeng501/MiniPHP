<?php
/**
 * Des : pdo操作类
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/24
 * Time: 11:46
 */

namespace Framework\orm\db;


use Framework\orm\DB;

class Pdo
{
    public $link;

    private $pdoStatement;

    public function __construct()
    {
        $dbConfig = config('databases.pdo');
        $dsn = "mysql:dbname={$dbConfig['database']};host={$dbConfig['host']}";
        $db_user = $dbConfig['user'];
        $db_pass = $dbConfig['password'];
        try {
            $this->link = new \PDO($dsn, $db_user, $db_pass);
            $this->link->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果
        } catch (\PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            die;
        }
    }

    /**
     * 执行sql语句
     * @param $sql
     * @return array
     */
    public function query($sql)
    {
        $result = array();
        $res = $this->link->query($sql, \PDO::FETCH_ASSOC);
        foreach ($res as $k => $row) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * bind value
     *
     * @param  DB     $db DB instance
     * @return void
     */
    public function bindValue(DB $db)
    {
        if (empty($db->params)) {
            return;
        }
        foreach ($db->params as $k => $v) {
            $this->pdoStatement->bindValue(":{$k}", $v);
        }
    }

    /**
     * select all data
     *
     * @param  DB     $db DB instance
     * @return array
     */
    public function findAll(DB $db)
    {
        $this->pdoStatement = $this->link->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
    }
}