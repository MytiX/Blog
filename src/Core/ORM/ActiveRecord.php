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
    }

    public function save()
    {
        $this->orm = new ORMReflection($this);
    }

    // Créer la findById, findBy, findAll

    public function insert(): void
    {
        $sql = "INSERT INTO {$this->orm->getTable()} {$this->orm->getStringColumnsInsert()} VALUES {$this->orm->getStringValueInsert()}";

        $this->db->query($sql);
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