<?php
/**
 * Descript:
 * User: luyingru@37.com
 * Date: 2017/2/23 14:59
 */

namespace App\module;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class IndexController
{
    public function index()
    {
        echo "hello MiniPHP-1.0";
    }

    public function log()
    {
        $log = new Logger('test');
        $log->pushHandler(new StreamHandler('/data/logs/monolog.log', Logger::WARNING));

        // add records to the log
        $log->warning('Foo');
        $log->error('Bar');
    }
}