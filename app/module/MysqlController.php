<?php
/**
 * Descript:
 * User: lufeng501206@gmail.com
 * Date: 2017/3/13 9:54
 */

namespace App\module;


use Lib\classlibs\MysqlLink;
use Lib\classlibs\PdoLink;

class MysqlController extends BaseController
{
    public function index()
    {
        $sql = "select * from users";
//        $sql = 'update users set user = "37wan123" where id = 4 limit 1';
//        $link = new PdoLink();
        $link = new MysqlLink();
        $res = $link->query($sql);
        var_dump($res);
    }
}