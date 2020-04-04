<?php
namespace  App\system\schema;



class Schema
{
    private static $instance;
    private $table = '';
    private $column = '';
    public $sql ;
    private $columns = [];
    private $nullable = false;
    private $unsigned = false;
    private $onUpdateTimeStamp = false;
    private $defaultValue = '';
    private $currentColumn = '';
    private $primaryKey = false;
    private $increment = false;
    private $foreignData = '';
    private $table_prefix ;


    public function __construct()
    {
        global $table_prefix;
        $this->table_prefix = $table_prefix;
    }

    public static function create($table, $closure)
    {
        $self = (new self);
        $self->sql = 'create table' ;
        $self->table = $self->table_prefix.$table;

        if ($closure instanceof \Closure) {
            call_user_func($closure, $self);
        }

        $self->sql .= " `".$self->table."`( ".implode(', ', $self->columns) .")";

        return $self;
    }


    public function decimal($column, $length = 20, $places = 2)
    {

        $this->currentColumn = "`" . $column . "` decimal(" . $length . "," . $places . ")";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    private function addColumn($columnData)
    {
        $this->nullable = false;
        $this->primaryKey = false;
        $this->increment = false;
        $this->unsigned = false;
        $this->onUpdateTimeStamp = false;
        $this->defaultValue = '';
        $this->foreignData = '';
        $this->column = $columnData . ($this->defaultValue ? ' DEFAULT "' . $this->defaultValue . '"' : '') . ($this->nullable ? ' NULL' : ' NOT NULL');
        array_push($this->columns, $this->column);
        return $this;
    }

    public function enum($column, $values)
    {
        $enumValues = '';
        foreach ($values as $k => $v) {
            $enumValues .= '"' . $v . '",';
        }

        $this->currentColumn = "`" . $column . "` enum(" . substr($enumValues, 0, -1) . ")";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function intIncrements($column)
    {
        $this->integer($column);
        $this->increment();
        $this->unsigned();
        $this->primaryKey();
        return $this;
    }

    public function integer($column, $length = 10)
    {

        $this->currentColumn = "`" . $column . "` int(" . $length . ")";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function increment()
    {
        $this->increment = true;
        $this->updateColumn($this->currentColumn);
        return $this;
    }

    public function updateColumn($columnData)
    {
        $defaultValue = ($this->defaultValue ? ' DEFAULT ' . (strtoupper($this->defaultValue) === 'CURRENT_TIMESTAMP' ? strtoupper($this->defaultValue) : '"' . $this->defaultValue . '"') : '');
        $unsigned = ($this->unsigned ? ' UNSIGNED ' : '');
        $nullable = ($this->nullable ? ' NULL' : ' NOT NULL ');
        $increment = ($this->increment ? ' auto_increment ' : '');
        $primaryKey = ($this->primaryKey ? ' PRIMARY KEY' : '');
        $onUpdateTimeStamp = ($this->onUpdateTimeStamp ? ' ON UPDATE CURRENT_TIMESTAMP' : '');
        $foreignData = ( $this->foreignData ? $this->foreignData : '');

        $this->column = $columnData . $unsigned . $nullable . $defaultValue . $increment . $primaryKey . $onUpdateTimeStamp.$foreignData;
        $lastIndex = count($this->columns) - 1;
        $this->columns[$lastIndex] = $this->column;
        return $this;
    }

    public function unsigned()
    {
        $this->unsigned = true;
        $this->updateColumn($this->currentColumn);
        return $this;
    }

    public function primaryKey()
    {
        $this->primaryKey = true;
        $this->updateColumn($this->currentColumn);
        return $this;
    }

    public function bigIntIncrements($column)
    {
        $this->bigInt($column);
        $this->increment();
        $this->unsigned();
        $this->primaryKey();
        return $this;
    }

    public function bigInt($column, $length = 20)
    {

        $this->currentColumn = "`" . $column . "` bigint(" . $length . ")";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function string($column, $length = 255)
    {

        $this->currentColumn = "`" . $column . "` varchar(" . $length . ")";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function text($column)
    {

        $this->currentColumn = "`" . $column . "` text";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function date($column)
    {

        $this->currentColumn = "`" . $column . "` date";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function timestamp($column)
    {
        $this->currentColumn = "`" . $column . "` timestamp";
        $this->addColumn($this->currentColumn);
        return $this;
    }

    public function nullable()
    {
        $this->nullable = true;
        $this->updateColumn($this->currentColumn);
        return $this;
    }

    public function default($value)
    {
        $this->defaultValue = $value;
        $this->updateColumn($this->currentColumn);
        return $this;
    }

    public function onUpdateTimeStamp()
    {
        $this->onUpdateTimeStamp = true;
        $this->updateColumn($this->currentColumn);
        return $this;
    }

    public function foreign($column)
    {
        $this->foreignData = ', CONSTRAINT ' . $this->table . '_' . $column . " FOREIGN KEY (`" . $column . "`) ";
        return $this;
    }

    public function on($reference)
    {
        $data = explode('.', $reference);
        $this->foreignData .= "REFERENCES `" .  $this->table_prefix.$data[0] . "` (`" . $data[1] . "`) ";
        $this->updateColumn($this->currentColumn);
        return $this;
    }

}


?>
