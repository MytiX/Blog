<?php

namespace App\Core\ORM;

use App\Core\PDO\PDOConnection;

abstract class ActiveRecord
{
    private $db;

    private ORMReflection $orm;

    public function __construct()
    {
        $this->db = PDOConnection::getConnection();
        $this->orm = new ORMReflection($this);
    }

    public function save()
    {
        $this->orm->saveEntity();    
        
        // Si l'entity ne comporte pas de clé unique créer une erreur
        if (empty($this->orm->getIdColumn())) {
            // throw Exception
            dd("Pas de clé unique sur l'entity");
        }

        // dd($this->orm->getIdColumn());

        // Si la valeur de la cle unique est vide c'est une insertion sinon une update
        if (empty($this->{"get" . ucfirst($this->orm->getIdColumn())}())) {
            // INSERT
            $lastInsert = $this->insert();

            $result = $this->find($lastInsert); 

            // $instance = $this;

            foreach ($result as $key => $value) {
                if (method_exists($this, "set" . ucfirst($key))) {
                    $this->{"set" . ucfirst($key)}($value);
                }
            }
            dd("Insert");
        } else {
            // UPDATE
            $this->update();
            dd("Update");
        }

        
        


    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->orm->getTable()} ";

        $query = $this->db->prepare($sql);

        $query->execute();

        return $this->mapping($query->fetchAll());
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->orm->getTable()} {$this->orm->buildWhereSQL('id', $id)} ";

        $query = $this->db->prepare($sql);

        $query->execute($this->orm->getWhereParams());

        return $this->mappingResult($query->fetch());
    }

    public function findBy($key, $value = null)
    {
        $sql = "SELECT * FROM {$this->orm->getTable()} {$this->orm->buildWhereSQL($key, $value)} ";

        $query = $this->db->prepare($sql);

        $query->execute($this->orm->getWhereParams());

        return $this->mapping($query->fetchAll());
    }

    private function insert()
    {
        $query = $this->db->prepare($this->orm->buildSQLInsert());

        $query->execute($this->orm->getColumnsWithValues());

        return $this->db->lastInsertId();
    }

    private function update()
    {
        $query = $this->db->prepare($this->orm->buildSQLUpdate());

        $query->execute($this->orm->getColumnsWithValues());

        return $this;
        
    }

    public function delete($key, $value)
    {
        $sql = "DELETE FROM {$this->orm->getTable()} {$this->orm->buildWhereSQL($key, $value)} ";

        $query = $this->db->prepare($sql);

        $query->execute($this->orm->getWhereParams());
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
                if (method_exists($instance, "set" . ucfirst($key))) {
                    $instance->{"set" . ucfirst($key)}($value);
                }
            }
        
        return $instance;
    }
}