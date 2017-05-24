<?php
/**
 * Descript:
 * User: luyingru@37.com
 * Date: 2017/2/23 14:59
 */

namespace App\controllers\index;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "Hello MiniPHP-1.0.0";
    }

    public function adminlte()
    {
        $this->render("Index/adminlte.html", ['name' => 'luyingru']);
    }
}