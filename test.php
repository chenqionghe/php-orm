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
    'host' => 'localhost',
    'port' => 3306,
    'db' => 'system',
    'username' => 'root',
    'password' => '',
    'prefix' => ''
]);

print_r(DB::model('user')->select());