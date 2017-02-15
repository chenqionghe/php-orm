# php-orm
orm curd for the mysql

## cube-php/orm needs
* POD Ext.

## cube-group/php-orm.
* <a href='https://github.com/cube-group/php-orm'>click me , and go to check the php-orm</a>

## how to use the cube-orm?
```javascript
<?php
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
```

## Class Cube\Orm\DB
*  __construct($options);// init db config
*  table($name);//get the orm instance
*  query($sql,$task = false);
*  exec($sql,$task = false);
*  close();

## Class Cube\Orm\DBModel
*  __construct(\Cube\Orm\DB $db , string $tableName);
*  task(); // return the DBModel ,the sql will executed as the task when you use this
*  where($options);//return the DBModel
*  order($options);//return the DBModel
*  group($options);//return the DBModel
*  limit($start,$length);//return the DBModel
*  count();// return the result
*  sum($options);// return the result
*  select($options);// return the result
*  update($options);// return the result
*  delete($options);// return the result
*  insert($options);// return the result
*  insertMulti($columns,$values);//return the reslt

## More demos.
*  where
```javascript
$db = new DB($options);

$db->table('list')->where('a=1 and (b=2 or c=3)')->select();
SQL:select * from list where a=1 and (b=2 or c=3);
Attension:where you c='string' , you should use where('c="string"');
```
*  order
```javascript
$db->table('list')->order('userid ASC')->select();
SQL:select * from list order by userid asc;

$db->table('list')->order(array('userid ASC','username DESC'))->select();
SQL:select * from list order by userid asc,username desc;
```
*  group
```javascript
$db->table('list')->group('userid')->select();
SQL:select * from list group by userid;

$db->table('list')->group(array('userid','username'))->select();
SQL:select * from list group by userid,username;
```
* limit
```javascript
$db->table('list')->limit(0,10)->select();
SQL:select * from list limit 0,10;
```
* count
```javascript
$db->table('list')->count();
SQL:select count(*) from list;

$db->table('list')->where('a=1')->count();
SQL:select count(*) from list where a=1;
```
* sum
```javascript
$db->table('list')->sum('score');
SQL:select sum(score) from list;

$db->table('list')->where('a=1')->sum('score');
SQL:select sum(score) from list where a=1;
```
* select
```javascript
$db->table('list')->select();
SQL:select * FROM list;

$db->table('list')->select('username');
SQL:select username from list;

$db->table('list')->select(array('username','team'));
SQL:select username,team from list;
```
* update
```javascript
$db->table('list')->where('a=1 and b="world"')->update(array('c'=>2,'d'=>'"hello"'));
SQL:update list c=2,d="hello" where a=1 and b="world";
```
* delete
```javascript
$db->table('list')->where('a=1')->delete();
SQL:delete from list where a=1;
```
* insert
```javascript
$db->table('list')->insert(array('a'=>1,'b'=>2));
SQL:insert into list (a,b) values (1,2);

$db->table('list')->insert(['a','b'],[[1,2],[3,4],[5,6]]);
SQL:insert into list (a,b) values (1,2),(3,4),(5,6);
```
