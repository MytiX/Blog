<?php

namespace App\Core\ORM;

use App\Core\PDO\PDOConnection;
use App\Core\ORM\SQLBuilder\SQLBuilder;
use App\Core\ORM\EntityReflection\EntityReflection;

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

        // Si l'entity ne comporte pas de clé unique créer une erreur
        if (empty($this->entityReflection->getIdColumn())) {
            // throw Exception
            dd("Pas de clé unique sur l'entity");
        }

        // Si la valeur de la cle unique est vide c'est une insertion sinon une update

        if (empty($this->{"get" . ucfirst($this->entityReflection->getIdColumn())}())) {
            // INSERT
            $lastInsert = $this->insert();

            if ($lastInsert) {
                $this->{"setId"}($lastInsert);
            }

        } else {
            // UPDATE
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

    public function find($id)
    {
        $sql = $this->sqlBuilder->buildSQLSelect($id);

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getWhereParams());

        return $this->mappingResult($query->fetch());
    }

    public function findBy($key, $value = null)
    {
        $sql = $this->sqlBuilder->buildSQLSelect($key, $value);

        $query = $this->db->prepare($sql);

        $query->execute($this->sqlBuilder->getWhereParams());

        return $this->mapping($query->fetchAll());
    }

    private function insert()
    {
        $sql = $this->sqlBuilder->buildSQLInsert();

        $query = $this->db->prepare($sql);

        // dd($sql, $this->sqlBuilder->getParamsExecute($sql), $this->entityReflection->getColumnsWithValues());

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
        if (is_null($results)) {
            return null;
        }
        $array = [];

        foreach ($results as $result) {
            
            $array[] = $this->mappingResult($result);
        }
        return $array;
    }

    private function mappingResult($result): self
    {
        if (is_null($result)) {
            return null;
        }

        $class = $this;

        $instance = new $class();
            
            foreach ($result as $key => $value) {

                $method = "set" . $this->entityReflection->formatFunctionName($key);

                if (method_exists($instance, $method)) {
                    $instance->{$method}($value);
                } else {
                    dd("Pas de méthode pour " . $key);
                }
            }
        
        return $instance;
    }
}