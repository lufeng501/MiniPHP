<?php
/**
 * Descript:
 * User: lufeng501206@gmail.com
 * Date: 2017/3/15 9:27
 */

namespace Lib\classlibs;


class MysqlLink
{
    private static $_link;

    public function __construct()
    {
        //新建持久化连接
        $link = mysql_connect('localhost:3306', 'root', 'lusion');
        if (!empty($link)) {
            self::$_link = $link;
            //选择数据库
            mysql_select_db('white_cap', self::$_link);
        } else {
            throw new \Exception('数据库连接失败,请检查配置文件。');
        }
    }

    /**
     * 执行sql语句
     * @param $sql
     * @return array
     */
    public function query($sql)
    {
        $result = mysql_query($sql, self::$_link);
        if (empty($result)) {
            throw new \Exception("Could not successfully run query ($sql) from DB: " . mysql_error());
        } else {
            if (mysql_num_rows($result) == 0) {
                return $data = [];
            } else {
                while ($row = mysql_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            return $data;
        }
    }
}