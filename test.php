<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/11/5
 * Time: 下午1:13
 */

//Dependency Library
require __DIR__ . '/utils/Utils.php';
require __DIR__ . '/fs/FS.php';
require __DIR__ . '/log/Log.php';
//Core Library
require __DIR__ . '/orm/DB.php';

use orm\DB;

//init orm config.
DB::init([
    'host' => 'weixin001.mysql.rds.aliyuncs.com',
    'port' => 3306,
    'db' => 'ceshi',
    'username' => 'linyang',
    'password' => 'xyq2525307',
    'prefix' => 'ceshi_'
]);

print_r(DB::model('list')->select());