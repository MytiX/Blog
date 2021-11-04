<?php

namespace App\Core\ORM\SQLBuilder;

use App\Core\ORM\EntityReflection\EntityReflection;
use App\Core\ORM\SQLBuilder\SQLBuilderException\SQLBuilderException;

class SQLBuilder
{
    private object $instance;

    private EntityReflection $entityReflection;

    private string $table;

    private array $whereParams = [];

    public function __construct($instance, $entityReflection)
    {
        $this->entityReflection = $entityReflection;
        $this->setTable();
        $this->instance = $instance;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    private function setTable(): void
    {
        if (empty($this->table)) {
            $class = explode('\\', $this->entityReflection->getEntityName());

            $parts = preg_split('/(?=[A-Z])/', $class[2]);

            $this->table = substr(strtolower(implode('_', $parts)), 1);
        }
    }

    public function buildSQLSelect($key = null, $value = null)
    {
        $sql = "SELECT * FROM {$this->getTable()}";

        // findAll
        if (empty($key)) {
            return $sql;
        }

        $sql .= $this->buildSQLWhere($key, $value);

        return $sql;
    }

    public function buildSQLInsert()
    {
        $columnsString = '';
        $valuesString = '';

        $this->entityReflection->persistEntity();

        $sql = "INSERT INTO {$this->getTable()} ";

        foreach ($this->entityReflection->getColumnsWithValues() as $column => $value) {
            if ($column != $this->entityReflection->getAutoIncrementKey()) {
                $columnsString .= str_replace(':', '', $column).', ';
                $valuesString .= $column.', ';
            }
        }

        $columnsString = '('.substr($columnsString, 0, -2).')';
        $valuesString = ' VALUES ('.substr($valuesString, 0, -2).')';

        $sql .= $columnsString.$valuesString;

        return $sql;
    }

    public function buildSQLUpdate()
    {
        $this->entityReflection->persistEntity();

        $sql = "UPDATE {$this->getTable()} SET ";

        foreach ($this->entityReflection->getColumnsWithValues() as $column => $value) {
            if ($column != $this->entityReflection->getAutoIncrementKey()) {
                $sql .= str_replace(':', '', $column).' = '.$column.', ';
            }
        }

        $sql = substr($sql, 0, -2);

        $where = ' WHERE ';

        $where .= $this->entityReflection->getIdColumn().' = :'.$this->entityReflection->getIdColumn().'';

        $sql .= $where;

        return $sql;
    }

    public function buildSQLDelete()
    {
        $this->entityReflection->persistEntity();

        $sql = "DELETE FROM {$this->getTable()}";

        $where = ' WHERE ';

        $where .= $this->entityReflection->getIdColumn().' = :'.$this->entityReflection->getIdColumn().'';

        $sql .= $where;

        return $sql;
    }

    public function buildSQLWhere($keyOrArray, $value)
    {
        $where = ' WHERE ';

        // find
        if (is_integer($keyOrArray)) {
            // @TODO faire que l'id soit récuperer depuis l'attribute de la class
            $where .= 'id = :id';
            $this->setWhereParams(':id', $keyOrArray);

            return $where;
        }

        // findBy key and value
        if (is_string($keyOrArray) && !empty($value)) {
            $keyPrepare = ':w_'.$keyOrArray;
            $where .= $keyOrArray.' = '.$keyPrepare;
            $this->setWhereParams($keyPrepare, $value);

            return $where;
        }

        // findBy array multiple condition
        if (is_array($keyOrArray)) {
            foreach ($keyOrArray as $key => $value) {
                if (is_array($value)) {
                    $where .= '(';
                    for ($i = 0; $i < count($value); ++$i) {
                        $keyPrepare = ':w_'.$key.$i;
                        $where .= $key.' = '.$keyPrepare.' OR ';
                        $this->setWhereParams($keyPrepare, $value[$i]);
                    }
                    $where = substr($where, 0, -4).')';
                } else {
                    $keyPrepare = ':w_'.$key;
                    $where .= $key.' = '.$keyPrepare;
                    $this->setWhereParams($keyPrepare, $value);
                }
                $where .= ' AND ';
            }
            $where = substr($where, 0, -4);

            return $where;
        }

        throw new SQLBuilderException('An error occurred while generating the where condition, with the values. </br>'.__FILE__, 500);
    }

    private function setWhereParams($key, $value)
    {
        $this->whereParams[$key] = $value;
    }

    public function getWhereParams(): array
    {
        return $this->whereParams;
    }

    public function getParamsExecute(string $sql): array
    {
        $params = [];

        preg_match_all('/:[a-z_]+/', $sql, $matches);

        foreach ($matches[0] as $column) {
            $paramsEntity = preg_replace('/:/', '', $column);

            $method = 'get'.$this->entityReflection->formatFunctionName($paramsEntity);

            if (method_exists($this->instance, $method)) {
                $params[$column] = $this->instance->{$method}();
            }
        }

        if (!empty($this->getWhereParams())) {
            $params = array_merge($params, $this->getWhereParams());
        }

        return $params;
    }
}
