<?php
/**
 * Des :
 * Created by PhpStorm.
 * User: lufeng501206@gmail.com
 * Date: 2017/5/12
 * Time: 11:50
 */

namespace Framework\handles;


use Framework\App;

Interface Handle
{
    public function register(App $app);
}