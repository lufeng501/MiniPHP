<?php
/**
 * Descript:
 * User: luyingru@37.com11
 * Date: 2017/2/23 14:59
 */

namespace App\module;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class IndexController extends BaseController
{
    public function index()
    {
        echo "Hello MiniPHP-1.0.0";
    }

    public function log()
    {
        $log = new Logger('test');
        $log->pushHandler(new StreamHandler('/data/logs/monolog.log', Logger::WARNING));
        $log->warning('Foo');
        $log->error('Bar');
    }

    public function adminlte()
    {
        $this->render("Index/adminlte.html", ['name' => 'luyingru']);
    }
}