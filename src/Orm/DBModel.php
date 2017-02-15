<?php
/**
 * Created by PhpStorm.
 * User: linyang3
 * Date: 17/2/15
 * Time: 下午2:21
 */

namespace Cube\Orm;

/**
 * Class DBModel.
 * sql Orm model unit.
 * @package com\cube\Orm
 */
class DBModel
{
    /**
     * @var DB
     */
    private $_db = null;
    /**
     * the state of support task.
     * @var bool
     */
    private $_task = false;
    /**
     * the name of the table.
     * @var string
     */
    private $_table_name = '';
    /**
     * sql where string.
     * @var string
     */
    private $_where = '';
    /**
     * sql order string.
     * @var string
     */
    private $_order = '';
    /**
     * sql group string.
     * @var string
     */
    private $_group = '';
    /**
     * sql limit string.
     * @var string
     */
    private $_limit = '';

    /**
     * DB constructor.
     * @param $db DB
     * @param $table_name string
     */
    public function __construct($db, $table_name)
    {
        $this->_db = $db;
        $this->_table_name = $table_name;
    }

    /**
     * the Orm action as the task.
     *
     * DB::model('list')->task()->insert(array('a'=>1));
     * SQL:insert into list (a) values (1);
     * @return mixed
     */
    public function task()
    {
        $this->_task = true;
        return $this;
    }

    /**
     * where.
     *
     * DB::model('list')->where('a=1 and (b=2 or c=3)')->select();
     * SQL:select * from list where a=1 and (b=2 or c=3);
     *
     * @param $options
     * @return $this
     */
    public function where($options)
    {
        if (!empty($options)) {
            $this->_where = $options;
        }
        return $this;
    }

    /**
     * select by the order.
     *
     * DB::model('list')->order('userid ASC')->select();
     * SQL:select * from list order by userid asc;
     *
     * DB::model('list')->order(array('userid ASC','username DESC'))->select();
     * SQL:select * from list order by userid asc,username desc;
     *
     * @param $options
     * @return $this
     */
    public function order($options)
    {
        if (!empty($options)) {
            if (is_array($options) && count(options) > 0) {
                $this->_order = join(',', $options);
            } else {
                $this->_order = $options;
            }
        }
        return $this;
    }

    /**
     * select by the group.
     *
     * DB::model('list')->group('userid')->select();
     * SQL:select * from list group by userid;
     *
     * DB::model('list')->group(array('userid','username'))->select();
     * SQL:select * from list group by userid,username;
     *
     * @param $options
     * @return $this
     */
    public function group($options)
    {
        if (!empty($options)) {
            if (is_array($options) && count(options) > 0) {
                $this->_group = join(',', $options);
            } else {
                $this->_group = $options;
            }
        }
        return $this;
    }

    /**
     * limit pages.
     *
     * DB::model('list')->limit(0,10)->select();
     * SQL:select * from list limit 0,10;
     *
     * @param $start
     * @param $length
     * @return $this
     */
    public function limit($start, $length)
    {
        if ($start >= 0 && $length > 0) {
            $this->_limit = $start . ',' . $length;
        }
        return $this;
    }

    /**
     * get the count of the select.
     *
     * DB::model('list')->count();
     * SQL:select count(*) from list;
     *
     * DB::model('list')->where('a=1')->count();
     * SQL:select count(*) from list where a=1;
     *
     * @return array
     */
    public function count()
    {
        $sql = 'SELECT COUNT(*)';
        $sql .= ' FROM ' . $this->_table_name;
        if (!$this->_where) {
            $sql .= ' WHERE ' . $this->_where;
        }
        $sql .= ';';
        return $this->returnValue($this->_db->value($sql));
    }

    /**
     * 查询符合当前sql的和.
     *
     * DB::model('list')->sum('score');
     * SQL:select sum(score) from list;
     *
     * DB::model('list')->where('a=1')->sum('score');
     * SQL:select sum(score) from list where a=1;
     *
     * @param $value
     * @return array|int
     */
    public function sum($value)
    {
        if (empty($value)) {
            return -1;
        }
        $sql = 'SELECT SUM(' . $value . ')';
        $sql .= ' FROM ' . $this->_table_name;
        if (!$this->_where) {
            $sql .= ' WHERE ' . $this->_where;
        }
        $sql .= ';';
        return $this->returnValue($this->_db->value($sql));
    }

    /**
     * select.
     *
     * DB::model('list')->select();
     * SQL:select * FROM list;
     *
     * DB::model('list')->select('username');
     * SQL:select username from list;
     *
     * DB::model('list')->select(array('username','team'));
     * SQL:select username,team from list;
     *
     * @param null $options
     * @return array
     */
    public function select($options = null)
    {
        $sql = 'SELECT ';
        if (!$options) {
            if (is_array($options) && count($options) > 0) {
                $sql .= join(',', $options);
            } else {
                $sql .= $options;
            }
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->_table_name;
        if (!empty($this->_where)) {
            $sql .= ' WHERE ' . $this->_where;
        }
        if (!empty($this->_group)) {
            $sql .= ' GROUP BY ' . $this->_group;
        }
        if (!empty($this->_order)) {
            $sql .= ' ORDER BY ' . $this->_group;
        }
        if (!empty($this->_limit)) {
            $sql .= ' LIMIT ' . $this->_limit;
        }
        $sql .= ';';
        return $this->returnValue($this->_db->query($sql, $this->_task));
    }

    /**
     * update.
     *
     * DB::model('list')->where('a=1 and b="world"')->update(array('c'=>2,'d'=>'"hello"'));
     * SQL:update list c=2,d="hello" where a=1 and b="world";
     *
     * @param $options
     * @return int
     */
    public function update($options)
    {
        $sql = 'UPDATE ' . $this->_table_name . ' SET ';
        if (!$options && is_array($options) && count($options) > 0) {
            $sets = array();
            foreach ($options as $key => $value) {
                array_push($sets, $key . '=' . $value);
            }
            $sql .= join(',', $sets);
        } else {
            return false;
        }
        if (!$this->_where) {
            $sql .= ' WHERE ' . $this->_where;
        }
        $sql .= ';';
        return $this->returnValue($this->_db->exec($sql, $this->_task));
    }

    /**
     * delete.
     *
     * DB::model('list')->where('a=1')->delete();
     * SQL:delete from list where a=1;
     *
     * @return int
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . $this->_table_name;
        if (!$this->_where) {
            $sql .= ' WHERE ' . $this->_where;
            $sql .= ';';
        }
        return $this->returnValue($this->_db->exec($sql, $this->_task));
    }

    /**
     * insert action.
     *
     * $db->table('list')->where('a=1')->insert(array('a'=>1,'c'='2'));
     * SQL:insert into list (a,c) values (1,2);
     * RESULT: index(if index==false error)
     *
     * @param $options array
     * @return int
     */
    public function insert($options)
    {
        $sql = 'INSERT INTO ' . $this->_table_name;
        if (!$options && is_array($options) && count($options) > 0) {
            $columns = array();
            $values = array();
            foreach ($options as $key => $value) {
                array_push($columns, $key);
                array_push($values, $value);
            }
            $sql .= ' (' . join(',', $columns) . ')';
            $sql .= ' VALUES (' . join(',', $values) . ')';
            $sql .= ';';
        } else {
            return false;
        }

        return $this->returnValue($this->_db->exec($sql, $this->_task));
    }

    /**
     *
     * @param $columns array
     * @param $values array
     */
    public function insertMulti($columns, $values)
    {
        $sql = 'INSERT INTO ' . $this->_table_name;
        if (!$columns && !$values && is_array($columns) && count($columns) > 0) {
            $sql .= ' (' . join(',', $columns) . ')';

            $insertSqlString = '';
            foreach ($values as $item) {
                $insertSqlString .= '(' . join(',', $item) . '),';
            }
            if ($insertSqlString) {
                $insertSqlString = substr($insertSqlString, 0, -1);
                $insertSqlString = ' VALUES ' . $insertSqlString;
            }
            $sql .= $insertSqlString . ';';
        } else {
            return false;
        }

        return $this->returnValue($this->_db->exec($sql, $this->_task));
    }

    private function returnValue($value)
    {
        $this->_db = null;
        return $value;
    }
}