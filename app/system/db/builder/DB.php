<?php

namespace App\system\db\builder;

class DB
{
    private static $instance;
    private $table_prefix;
    private $connection;
    private $table;
    private $whereClause = '';
    private $orderQuery = '';
    private $selectQuery = '*';
    private $groupQuery = '';
    private $closerSession = false;

    public function __construct()
    {
        global $table_prefix, $wpdb;
        $this->table_prefix = $table_prefix;
        $this->connection = $wpdb;
    }

    public static function table($name)
    {
        $self = self::getInstance();
        $self->table = $self->table_prefix . $name;
        return $self;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function where($column, $value = null)
    {

        if ($column instanceof \Closure) {
            $this->closerSession = true;
            $this->whereClause .= ($this->whereClause ? ' AND (' : ' where (');
            call_user_func($column, self::getInstance());
            $this->whereClause .= ')';
            $this->closerSession = false;
        } else {
            $this->whereClause .= $this->closerSession ? '' : ($this->whereClause ? ' AND ' : ' where ');
            $this->whereClause .= $this->connection->prepare($column . ' = %s ', $value);

        }
        return self::getInstance();
    }

    public function orWhere($column, $value)
    {
        $this->whereClause .= $this->connection->prepare(($this->whereClause ? ' OR ' : '') . $column . ' = %s ', $value);
        return self::getInstance();
    }

    public function orderBy($columns, $direction)
    {
        $this->orderQuery = " ORDER BY " . $columns . " " . $direction;
        return self::getInstance();
    }

    public function groupBy($columns)
    {
        $this->groupQuery = " GROUP BY " . $columns . " ";
        return self::getInstance();
    }


    public function select($fields)
    {
        $this->selectQuery = " " . $fields . " ";
        return self::getInstance();
    }

    public function whereRaw($query)
    {

        $this->whereClause .= $this->closerSession ? '' : ($this->whereClause ? ' AND ' : ' where ');
        $this->whereClause .= " " . $query . " ";
        return self::getInstance();
    }


    public function insert($data)
    {
        return $this->connection->insert($this->table, $data);
    }

    public function update( $data, $where)
    {
        return $this->connection->update($this->table, $data, $where);
    }

    public function delete( $where)
    {
        return $this->connection->delete($this->table, $where);
    }


    public function first()
    {
        return $this->connection->get_row("SELECT " . $this->selectQuery . " FROM $this->table " . $this->whereClause . $this->groupQuery . $this->orderQuery, OBJECT);
    }

    public function get()
    {
        return $this->connection->get_results("SELECT " . $this->selectQuery . " FROM $this->table " . $this->whereClause . $this->groupQuery . $this->orderQuery);
    }

}
