<?php

namespace App\Core\ORM;

use ReflectionClass;

class ORMReflection
{
    private object $instance;

    private string $table;
    
    private array $whereParams;

    private string $autoIncrement;

    private array $columnsWithValues = [];

    private ?string $IdColumn = null;

    private ReflectionClass $reflection;

    public function __construct($instance)
    {
        $this->reflection = new ReflectionClass($instance);
        $this->setTable($instance);
        $this->instance = $instance;
    }

    public function saveEntity(): void
    {
        foreach ($this->reflection->getProperties() as $propertie) {
            /** @var ReflectionAttribute $attributes */
            $attributes = $propertie->getAttributes(ORMColumn::class);
            
            if (!empty($attributes)) {
                foreach ($attributes as $attribute) {
                    /** @var ORMColumn $ormColumn */
                    $ormColumn = $attribute->newInstance();
                    
                    if ($ormColumn->isAutoIncrement()) {
                        $this->setAutoIncrementKey($this->formatColumnName($propertie->getName()));
                    } else {
                        $this->setColumnsWithValues($this->formatColumnName($propertie->getName()), $this->instance->{"get" . ucfirst($propertie->getName())}());
                    }
                    
                    if ($ormColumn->isId()) {
                        $this->setIdColumn($propertie->getName());
                    }
                }
            } else {
                $this->setColumnsWithValues($this->formatColumnName($propertie->getName()), $this->instance->{"get" . ucfirst($propertie->getName())}());
            }
        }
    }

    private function setIdColumn(string $column)
    {
        $this->uniqueColumn = $column;
    }

    public function getIdColumn()
    {
        return $this->uniqueColumn;
    }

    private function setAutoIncrementKey(string $column)
    {
        $this->autoIncrement = $column;
    }
    public function getAutoIncrementKey()
    {
        return $this->autoIncrement;
    }
    
    private function formatColumnName($columnsName)
    {
        $parts = preg_split('/(?=[A-Z])/', $columnsName);
        
        if (count($parts) > 1) {
            $columnsName = strtolower(implode('_', $parts));
        } 
        return ":" . $columnsName;
    }
    
    public function getTable(): string
    {
        return $this->table;
    }

    private function setTable($instance): void
    {
        if (empty($this->table)) {
            
            $class = explode("\\", get_class($instance));
    
            $parts = preg_split('/(?=[A-Z])/', $class[2]);
    
            $this->table = substr(strtolower(implode('_', $parts)), 1);
        }
    }

    private function setColumnsWithValues(string $column, mixed $value)
    {
        $this->columnsWithValues[$column] = $value;
    }

    public function getColumnsWithValues()
    {
        return $this->columnsWithValues;
    }

    public function buildSQLInsert()
    {
        $columnsString = "";
        $valuesString = "";

        $sql = "INSERT INTO {$this->getTable()} ";

        foreach ($this->getColumnsWithValues() as $column => $value) {
            if ($column != $this->getAutoIncrementKey())
            {
                $columnsString .= str_replace(":", "", $column) . ", ";
                $valuesString .= $column . ", ";
            }
        }

        $columnsString = "(" . substr($columnsString, 0, -2) . ")";
        $valuesString = " VALUES (" . substr($valuesString, 0, -2) . ")";

        $sql .= $columnsString . $valuesString;

        return $sql;
    } 

    public function buildSQLUpdate(array $conditions = [])
    {
        $sql = "UPDATE {$this->getTable()} SET ";

        dd($this->getColumnsWithValues());

        foreach ($this->getColumnsWithValues() as $column => $value) {

            if ($column != $this->getAutoIncrementKey()) {
                $sql .= str_replace(":", "", $column) . " = " . $column . ", ";
            }
        }

        $sql = substr($sql, 0, -2);

        $where = " WHERE ";

        $where .= $this->getIdColumn() . " = :" . $this->getIdColumn() . "";

        $sql .= $where;

        return $sql;
    }

    public function buildWhereSQL($keyOrArray, $value = null)
    {
        $wherePrepare = [];

        $where = "WHERE ";

        if (is_array($keyOrArray)) {
            foreach ($keyOrArray as $key => $value) {
                if (is_array($value)) {
                    $where .= "(";
                    for ($i=0; $i < count($value); $i++) { 
                        $keyPrepare = ":w_" . $key . $i;
                        $where .= $key . " = " . $keyPrepare . " OR ";
                        $this->setWhereParams($keyPrepare, $value[$i]);
                    }
                    $where = substr($where, 0, -4) . ") AND ";
                } else {
                    $keyPrepare = ":w_" . $key;
                    $where .= $key . " = " . $keyPrepare;
                    $this->setWhereParams($keyPrepare, $value);
                }
            }
        } else {
            $keyPrepare = ":w_" . $keyOrArray;
            $where .= $keyOrArray . " = " . $keyPrepare;
            $this->setWhereParams($keyPrepare, $value);
        }

        return $where;
    }

    private function setWhereParams($key, $value)
    {
        $this->whereParams[$key] = $value;
    }

    public function getWhereParams(): array
    {
        return $this->whereParams;
    }
}