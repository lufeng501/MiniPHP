<?php
/**
 * Descript:
 * User: lufeng501206@gmail.com
 * Date: 2017/3/15 9:26
 */

namespace Lib\classlibs;


class MysqliLink
{
    private static $_link;

    public function __construct()
    {
        $link = new \mysqli('localhost', 'root', 'lusion', 'white_cap');

        if ($link->connect_error) {
            throw new \Exception('Connect Error (' . $link->connect_errno . ') '. $link->connect_error);
        }else{
            self::$_link = $link;
        }
    }

    /**
     * 执行一条sql语句
     * @param $sql
     * @return array
     * @throws \Exception
     */
    public function query($sql)
    {
        $result = self::$_link->query($sql);
        if (empty($result)) {
            throw new \Exception("Could not successfully run query ($sql) from DB: " . self::$_link->error);
        } else {
            if ($result->num_rows == 0) {
                return $data = [];
            } else {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            return $data;
        }
    }
}