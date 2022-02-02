<?php

namespace App\Core\ORM;

use App\Core\ORM\EntityReflection\EntityReflection;
use App\Core\ORM\ORMException\ORMException;
use App\Core\ORM\SQLBuilder\SQLBuilder;
use App\Core\PDO\PDOConnection;

abstract class ActiveRecord
{
    private PDOConnection $db;

    private SQLBuilder $sqlBuilder;

    private EntityReflection $entityReflection;

    public function __construct()
    {
        $this->db = PDOConnection::getConnection();
        $this->entityReflection = new EntityReflection($this);
        $this->sqlBuilder = new SQLBuilder($this, $this->entityReflection);
    }

    public function save()
    {
        $this->entityReflection->persistEntity();

        if (empty($this->entityReflection->getIdColumn())) {
            throw new ORMException('No unique key on the entity', 500);
        }

        if (empty($this->{'get'.ucfirst($this->entityReflection->getIdColumn())}())) {
            $lastInsert = $this->insert();

            if ($lastInsert) {
                $this->{'setId'}($lastInsert);
            }
        } else {
            $this->update();
        }
    }

    public function findAll()
    {
        $sql = $this->sqlBuilder->buildSQLSelect();

        $query = $this->db->prepare($sql);

        $query->execute();

        return $this->mapping($query->fetchAll());
    }

    public function find(int $id)
    {
        $sql = $this->sqlBuilder->buildSQLSelect($id);

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getWhereParams());

        $result = $query->fetch();

        if (false === $result) {
            return null;
        }

        return $this->mappingResult($result);
    }

    /**
     * findBy.
     *
     * @param array $idOrParams takes as parameter an array accepting the keys params, orderBy, limit, offset
     *
     * @return array|null
     */
    public function findBy(array $idOrParams)
    {
        $sql = $this->sqlBuilder->buildSQLSelect($idOrParams);

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getWhereParams());

        return $this->mapping($query->fetchAll());
    }

    public function findOneBy(array $idOrParams)
    {
        $sql = $this->sqlBuilder->buildSQLSelect($idOrParams);

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getWhereParams());

        return $this->mappingResult($query->fetch());
    }

    private function insert()
    {
        $sql = $this->sqlBuilder->buildSQLInsert();

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getParamsExecute($sql));

        return $this->db->lastInsertId();
    }

    private function update()
    {
        $sql = $this->sqlBuilder->buildSQLUpdate();

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getParamsExecute($sql));

        return $this;
    }

    public function delete()
    {
        $sql = $this->sqlBuilder->buildSQLDelete();

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getParamsExecute($sql));
    }

    private function mapping($results)
    {
        if (empty($results)) {
            return null;
        }

        $array = [];

        foreach ($results as $result) {
            $array[] = $this->mappingResult($result);
        }

        return $array;
    }

    private function mappingResult($result)
    {
        if (empty($result)) {
            return null;
        }

        $class = $this;

        $instance = new $class();

        foreach ($result as $key => $value) {
            $method = 'set'.$this->entityReflection->formatFunctionName($key);

            if (method_exists($instance, $method)) {
                $instance->{$method}($value);
            } else {
                throw new ORMException("Undefine method $key", 500);
            }
        }

        return $instance;
    }
}
