<?php
/**
 * Descript:
 * User: luyingru@37.com
 * Date: 2017/2/23 14:24
 */

namespace Lib\classlibs;


class Dispatch
{
    public function run()
    {
        $m = !empty($_GET['m']) ? $_GET['m'] : "index";
        $act = !empty($_GET['act']) ? $_GET['act'] : "index";
        $className = '\\App\\module\\'. ucfirst($m) .'Controller';
        $obj = new $className();
        call_user_func(array($obj, $act));
    }
}