<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/11/5
 * Time: 下午1:13
 */

require __DIR__ . '/../com/cube/db/DB.php';

use com\cube\db\DB;


$config = [
    'host' => 'localhost',
    'port' => 3306,
    'user' => 'root',
    'password' => '',
    'db' => 'system',
    'prefix' => 'cube_orm_'
];

//init orm config.
DB::init($config);

DB::model('list')->where('a=1')->group('userid')->select();