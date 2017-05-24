<?php
/**
 * Descript:
 * User: lufeng501206@gmail.com
 * Date: 2017/3/11 23:30
 */

namespace App\controllers\index;



class BaseController
{
    public function __construct()
    {
    }

    /**
     * 使用twig模板引擎渲染页面
     * @param $tpl
     * @param $data
     */
    public function render($tpl, $data)
    {
        $loader = new \Twig_Loader_Filesystem(ROOT . '/app/templates');
        $twig = new \Twig_Environment($loader);
        echo $twig->render($tpl, $data);
        die;
    }
}