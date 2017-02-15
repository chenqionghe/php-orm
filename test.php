<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/11/5
 * Time: 下午1:13
 */
//Core Library
require __DIR__ . '/src/Orm/DB.php';
require __DIR__ . '/src/Orm/DBModel.php';

use Cube\Orm\DB;

//init Orm config.
$db = new DB([
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'system',
    'username' => 'root',
    'password' => '',
    'prefix' => ''
]);

var_dump($db->table('user')->select());
var_dump($db->table('user')->insert(['username' => 'lin', 'password' => 'root']));
var_dump($db->table('user')->where('username="lin"')->update(['password' => 'admin']));
var_dump($db->table('user')->where('username="lin"')->delete());
var_dump($db->table('user')->where('username="lin"')->count());
var_dump($db->table('user')->where('type=2')->sum('score'));