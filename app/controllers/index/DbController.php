<?php
/**
 * Des :
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/24
 * Time: 11:52
 */

namespace App\controllers\index;


use Framework\orm\DB;

class DbController
{
    public function index()
    {
        $res = DB::query(' select * from users limit 3')->get();
//        $where = [
//            'id'   => ['>=', 2],
//        ];
//        $res = DB::table('users')->where($where)
//                                 ->limit(5)
//                                 ->findAll();
        print_r($res);
    }
}