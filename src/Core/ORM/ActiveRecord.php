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
        if (empty($this->orm->getUniqueColumn())) {
            // throw Exception
            dd("Pas de clé unique sur l'entity");
        }

        // Si la valeur de la cle unique est vide c'est une insertion sinon une update
        if (!empty($this->{"get" . ucfirst($this->orm->getUniqueColumn())}())) {
            // UPDATE
            $this->update();
        } else {
            // INSERT
            $lastInsert = $this->insert();
            dd($lastInsert);
        }

        
        


    }

    // Créer la findById, findBy, findAll
    public function findBy(array $where)
    {
        $sql = "SELECT * FROM {$this->orm->getTable()} WHERE ";

        $result = $this->db->query($sql);

        $this->mapping($result->fetchAll());
    }

    public function insert()
    {
        $sql = "INSERT INTO {$this->orm->getTable()} {$this->orm->getStringColumnsInsert()} VALUES {$this->orm->getStringValueInsert()}";

        $this->db->query($sql);

        return $this->db->lastInsertId();
    }

    public function update()
    {
        // 
    }

    public function delete()
    {
        // 
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

        $class = $this->class;

        $instance = new $class();
            
            foreach ($result as $key => $value) {
                if (method_exists($instance, "set" . ucfirst($key))) {
                    $value = !empty($value) ? $value : null;
                    $instance->{"set" . ucfirst($key)}($value);
                }
            }
        
        return $instance;
    }
}