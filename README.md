# orm
orm curd for the mysql

# cube-php/orm needs <b>POD Ext.</b>

# cube-php/framework contains the orm.
## <a href='https://github.com/cube-php/framework'>cube-php/framework</a>

# how to use the cube-orm?
```javascript
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
```

# Class com\cube\db\DB
## static init($options);// init db config
## static model($tableName);//get the orm instance
## static query($sql,$task = false);
## static exec($sql,$task = true);

# Class com\cube\db\DBModel
## __construct($tableName);
## task(); // return the DBModel ,the sql will executed as the task when you use this
## where($options);//return the DBModel
## order($options);//return the DBModel
## group($options);//return the DBModel
## limit($start,$length);//return the DBModel
## count();// return the result
## sum($options);// return the result
## select($options);// return the result
## update($options);// return the result
## delete($options);// return the result
## insert($options);// return the result

# More demos.
## where
DB::model('list')->where('a=1 and (b=2 or c=3)')->select();
SQL:select * from list where a=1 and (b=2 or c=3);
Attension:where you c='string' , you should use where('c="string"');
## order
DB::model('list')->order('userid ASC')->select();
SQL:select * from list order by userid asc;
DB::model('list')->order(array('userid ASC','username DESC'))->select();
SQL:select * from list order by userid asc,username desc;
##

