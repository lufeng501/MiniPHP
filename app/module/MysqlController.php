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

    public function index()
    {
//        $sql = "select * from users";
//        $sql = 'update users set user = "37wan123" where id = 4 limit 1';

//        $user = 'root';
//        $user = "root ' or '1'#";
//        $pwd = 'e10adc3949ba59abbe56e057f20f883e';
//
//
//
//
//        $data = [
//            'user' => $user,
//            'pwd' => $pwd
//        ];
//
//        $sql = "select * from users where `user` = '" . $user . "' and `pwd`= '" . $pwd ."'";
//        $link = new PdoLink();
//
//        $res = $link->preSql();
//
//        var_dump($res);


//        $link = new MysqlLink();
//        $link = new MysqliLink();
//        $res = $link->query($sql);
//        $res = $link->table('users')->where($data)->get();
//        $res = $link->
//        var_dump($res);
    }

    public function notorm()
    {
        $lists = $this->db->users()
            ->select("*");

        foreach ($lists as $id => $list) {
            echo "$list[title]\n";
        }

        var_dump($lists);
    }
}