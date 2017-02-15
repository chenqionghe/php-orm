<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/8/26
 * Time: 下午10:54
 */

namespace Cube\Orm;

//extension check.
if (!extension_loaded('pdo_mysql')) {
    throw new \Exception('Ext pdo_mysql is not exist!');
}

/**
 * Class DB For the sql database :).
 * For sql.
 * You must setup the pdo extension before you use the DB.
 *
 * @package cube\Orm
 */
class DB
{
    /**
     * database config.
     * array(
     *  'type'=>'mysql',
     *  'host'=>'127.0.0.1',
     *  'port'=>3306,
     *  'username'=>'root',
     *  'password'=>'',
     *  'database'=>'sys',
     *  'prefix'=>'Orm prefix such as google_x_'
     * )
     * @var
     */
    private $options;

    /**
     * pdo connection instance.
     * @var
     */
    private $pdo;

    /**
     * DB constructor.
     */
    public function __construct($options)
    {
        //__construct access denied
        if (empty($options['type'])) {
            $options['type'] = 'mysql';
        }
        $this->options = $options;

        $this->pdo = new \PDO(
            $options['type'] . ':host=' . $options['host'] . ';port=' . $options['port'] . ';dbname=' . $options['database'],
            $options['username'],
            $options['password']
        );
    }

    /**
     * create Orm Orm instance.
     *
     * $db = new DB($options);
     * $db->table('list');
     *
     * @param $name string table name(not contains table prefix)
     * @return DBModel
     */
    public function table($name)
    {
        return new DBModel($this->pdo, !$this->options['prefix'] ? $name : ($this->options['prefix']['prefix'] . $name));
    }

    /**
     * execute sql.
     * (no collection returned)
     * for update/delete/insert.
     *
     * @param $sql string
     * @param $task bool run as the task mode(default value : false)
     * @return int (-1:error,0:no effect,>=1:number of affected rows);
     */
    public function exec($sql, $task = false)
    {
        if (!$this->pdo) {
            try {
                if ($task) $this->pdo->beginTransaction();
                $result = $this->pdo->exec($sql);
                if ($result !== false) {
                    if ($task) $this->pdo->commit();
                } else {
                    if ($task) $this->pdo->rollBack();
                    return -1;
                }
                return $result;
            } catch (\PDOException $e) {
                return -1;
            }
        }
        return -1;
    }

    /**
     * execute sql.
     * (collection returned)
     *
     * @param $sql string
     * @param $task bool run as the task mode(default value : false)
     * @return mixed
     */
    public function query($sql, $task = false)
    {
        if (!$this->pdo) {
            try {
                if ($task) $this->pdo->beginTransaction();
                $result = null;
                if ($stat = $this->pdo->query($sql)) {
                    $result = $stat->fetchAll(\PDO::FETCH_ASSOC);
                    if ($task) $this->pdo->commit();
                } else {
                    if ($task) $this->pdo->rollBack();
                }
                return $result;
            } catch (\PDOException $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Get PDO Statement.
     * @param $sql
     * @param $task
     * @return null
     */
    public function value($sql, $task = false)
    {
        if (!$this->pdo) {
            try {
                if ($task) $this->pdo->beginTransaction();
                $result = null;
                if ($stat = $this->pdo->query($sql)) {
                    $result = $stat->fetchColumn();
                    if ($task) $this->pdo->commit();
                } else {
                    if ($task) $this->pdo->rollBack();
                }
                return $result;
            } catch (\PDOException $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Close the Orm instance.
     * @return bool
     */
    public function close()
    {
        $this->pdo = null;
        return true;
    }
}