<?php

use libs\Orm\LDB;

require __DIR__ . '/../libs/autoload.php';

/**
 * Class TestLDBAll
 * 主从测试LDB
 */
class TestLDBAll
{
    private $config = [
        'master' => [
            'host' => 'host',
            'database' => 'base',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'charset',
            'prefix' => 'p_',
            'port' => 3306
        ],
        'slave' => [
            'host' => 'host',
            'database' => 'base',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
            'prefix' => 'p_',
            'port' => 3306
        ]
    ];

    private $db;

    public function __construct()
    {
        $this->db = new LDB($this->config['master'], $this->config['slave']);
    }

    public function t()
    {
        return $this->db->table('test');
    }

    public function write()
    {
        echo('Func: LDBKernel->table($name)->insert($params)<br>');
        $table = $this->t();
        $rt = $table->insert(['p1' => rand(0, 10), 'p2' => time()]);
        echo("Sql: {$table->getSql()}<br>");
        var_dump('insert: ' . $rt);

        echo('Func: LDBKernel->table($name)->insertMulti($keys,$params)<br>');
        $insertMultiData = [];
        for ($i = 0; $i < 3; $i++) {
            $insertMultiData[] = ['p1' => rand(0, 10), 'p2' => time()];
        }
        $table = $this->t();
        $rt = $table->insertMulti(['p1', 'p2'], $insertMultiData);
        echo("Sql: {$table->getSql()}<br>");
        var_dump('insertMulti: ' . $rt);

        echo('Func: LDBKernel->table($name)->where($params)->update($params)<br>');
        $table = $this->t();
        $rt = $table->where(['p1' => 2])->update(['p2' => -1]);
        echo("Sql: {$table->getSql()}<br>");
        var_dump('update: ' . $rt);

        echo('Func: LDBKernel->table($name)->where($params)->delete()<br>');
        $table = $this->t();
        $rt = $table->where(['p1' => 2])->delete();
        echo("Sql: {$table->getSql()}<br>");
        var_dump('delete: ' . $rt);

        echo('Func: LDB->query($sql, $params = null)<br>');
        $rt = $this->db->query('select * from p_test where p1=?', [5]);
        echo("Sql: {$this->db->lastSql()}<br>");
        var_dump($rt);

        #获取最近一次执行sql的方法:
        #1.$db->table('list')->getSql();
        #2.$db->lastSql();
    }

    public function read()
    {
//        echo('Func: LDBKernel->table($name)->count()<br>');
//        $table = $this->t();
//        $rt = $table->count();
//        echo("Sql: {$table->getSql()}<br>");
//        var_dump('count: ' . $rt);
//
//        echo('Func: LDBKernel->table($name)->limit($start,$pageSize)->select()<br>');
//        $table = $this->t();
//        $rt = $table->limit(0, 5)->select();
//        echo("Sql: {$table->getSql()}<br>");
//        var_dump($rt);
//
//        echo('Func: LDBKernel->table($name)->sum($key)<br>');
//        $table = $this->t();
//        $rt = $table->sum('p1');
//        echo("Sql: {$table->getSql()}<br>");
//        var_dump($rt);
//
        echo('Func: LDBKernel->table($name)->where($key)->one()<br>');
        $table = $this->t();
        $rt = $table->where(['id' => 126])->one(["p1", "p2"]);
        echo("Sql: {$table->getSql()}<br>");
        var_dump($rt);
    }
}

$t = new TestLDBAll();
//$t->write();
$t->read();