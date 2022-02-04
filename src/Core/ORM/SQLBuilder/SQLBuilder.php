<?php

namespace App\Core\ORM\SQLBuilder;

use App\Core\ORM\EntityReflection\EntityReflection;
use App\Core\ORM\SQLBuilder\SQLBuilderException\SQLBuilderException;
use DateTime;

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

    /**
     * getTable
     * Get table name
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * setTable
     * Formate table name
     * @return void
     */
    private function setTable(): void
    {
        if (empty($this->table)) {
            $class = explode('\\', $this->entityReflection->getEntityName());

            $parts = preg_split('/(?=[A-Z])/', $class[2]);

            $this->table = substr(strtolower(implode('_', $parts)), 1);
        }
    }

    /**
     * buildSQLSelect
     * Create SELECT SQL request
     * @param  mixed $idOrParams
     * @return string
     */
    public function buildSQLSelect(mixed $idOrParams = null): string
    {
        $sql = "SELECT * FROM {$this->getTable()}";

        // findAll
        if (empty($idOrParams)) {
            return $sql;
        }

        if (!empty($idOrParams['params']) or is_integer($idOrParams)) {
            $sql .= $this->buildSQLWhere($idOrParams);

            if (!empty($idOrParams['extraSQL'])) {
                $sql .= ' '.$idOrParams['extraSQL'];
            }
        }

        if (!empty($idOrParams['orderBy'])) {
            $sql .= $this->buildSQLOrderBy($idOrParams['orderBy']);
        }

        if (!empty($idOrParams['limit']) and empty($idOrParams['offset'])) {
            $sql .= $this->buildSQLLimit($idOrParams['limit']);
        } elseif (!empty($idOrParams['limit']) and !empty($idOrParams['offset'])) {
            $sql .= $this->buildSQLLimit($idOrParams['limit'], $idOrParams['offset']);
        }

        return $sql;
    }

    /**
     * buildSQLInsert
     * Create INSERT SQL request
     * @return string
     */
    public function buildSQLInsert(): string
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

    /**
     * buildSQLUpdate
     * Create UPDATE SQL request
     * @return string
     */
    public function buildSQLUpdate(): string
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

    /**
     * buildSQLDelete
     * Create DELETE SQL request
     * @return string
     */
    public function buildSQLDelete(): string
    {
        $this->entityReflection->persistEntity();

        $sql = "DELETE FROM {$this->getTable()}";

        $where = ' WHERE ';

        $where .= $this->entityReflection->getIdColumn().' = :'.$this->entityReflection->getIdColumn().'';

        $sql .= $where;

        return $sql;
    }

    /**
     * buildSQLWhere
     * Create WHERE SQL request
     * @param  mixed $idOrParams
     * @return string
     */
    public function buildSQLWhere($idOrParams): string
    {
        $where = ' WHERE ';

        // find
        if (is_integer($idOrParams)) {
            // @TODO faire que l'id soit récuperer depuis l'attribute de la class
            $where .= 'id = :id';
            $this->setWhereParams(':id', $idOrParams);

            return $where;
        }

        // findBy array multiple condition
        if (is_array($idOrParams['params'])) {
            foreach ($idOrParams['params'] as $key => $value) {
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

    /**
     * buildSQLOrderBy
     * Create ORDER BY SQL request
     * @param  array $paramsOrder
     * @return string
     */
    private function buildSQLOrderBy(array $paramsOrder): string
    {
        $orderBy = ' ORDER BY ';

        foreach ($paramsOrder as $param) {
            $orderBy .= $param.', ';
        }

        return substr($orderBy, 0, -2);
    }

    /**
     * buildSQLLimit
     * Create LIMIT SQL request
     * @param  int $limit
     * @param  int $offset
     * @return string
     */
    private function buildSQLLimit(int $limit, int $offset = null): string
    {
        $sql = ' LIMIT '.$limit;

        if (!empty($offset)) {
            $sql .= ' OFFSET '.$offset;
        }

        return $sql;
    }

    /**
     * setWhereParams
     * Insert in array the value of WHERE SQL
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    private function setWhereParams($key, $value): void
    {
        $this->whereParams[$key] = $value;
    }

    /**
     * getWhereParams
     * Return a array of WHERE value
     * @return array
     */
    public function getWhereParams(): array
    {
        $whereParams = $this->whereParams;
        $this->whereParams = [];

        return $whereParams;
    }

    /**
     * getParamsExecute
     * Get All value present on SQL request to set array for prepare request
     * @param  string $sql
     * @return array
     */
    public function getParamsExecute(string $sql): array
    {
        $params = [];

        preg_match_all('/:[a-z_]+/', $sql, $matches);

        foreach ($matches[0] as $column) {
            $paramsEntity = preg_replace('/:/', '', $column);

            $method = 'get'.$this->entityReflection->formatFunctionName($paramsEntity);

            if (method_exists($this->instance, $method)) {
                $value = $this->instance->{$method}();
                if ($value instanceof DateTime) {
                    $value = $value->format('Y-m-d H:i:s');
                }
                $params[$column] = $value;
            }
        }

        if (!empty($this->getWhereParams())) {
            $params = array_merge($params, $this->getWhereParams());
        }

        return $params;
    }
}
