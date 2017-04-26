<?php
/**
 * Descript:
 * User: lufeng501206@gmail.com
 * Date: 2017/3/13 9:54
 */

namespace App\module;


use Lib\classlibs\MysqliLink;
use Lib\classlibs\MysqlLink;
use Lib\classlibs\notorm\DB;
use Lib\classlibs\PdoLink;

class MysqlController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function mysql()
    {
        $sql = "select count(*) from users";
        $link = new MysqlLink();
        $res = $link->query($sql);
        var_dump($res);
    }

    public function mysqli()
    {
        $sql = "select count(*) from users";
        $link = new MysqliLink();
        $res = $link->query($sql);
        var_dump($res);
    }

    public function pdo()
    {
        $sql = "select users.id,users.name,login_logs.client_ip from users left join ( select * from login_logs where id < 10000 ) as login_logs on users.id = login_logs.userid where users.id < 15";

        $start = microtime(true);
        var_dump($start);
        $link = new PdoLink();
        $res = $link->query($sql);
        var_dump($res);
        $end = microtime(true);
        var_dump($end);
        $consume = $end - $start;
        var_dump($consume);
    }
}