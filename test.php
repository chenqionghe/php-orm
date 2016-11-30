<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/11/5
 * Time: 下午1:13
 */

//Dependency Library
require __DIR__ . '/utils/autoload.php';
require __DIR__ . '/fs/autoload.php';
require __DIR__ . '/log/autoload.php';
//Core Library
require __DIR__ . '/orm/autoload.php';

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