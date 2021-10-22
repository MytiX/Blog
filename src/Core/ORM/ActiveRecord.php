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
        // $id = $this->insert();
        
        // dd($id);
        
        dd($this->orm->buildSQLUpdate(), $this->orm->buildSQLInsert());
        // dd($this->orm->buildSQLInsert());


        // Si l'entity ne comporte pas de clé unique créer une erreur
        // if (empty($this->orm->getUniqueColumn())) {
        //     // throw Exception
        //     dd("Pas de clé unique sur l'entity");
        // }

        // // Si la valeur de la cle unique est vide c'est une insertion sinon une update
        // if (!empty($this->{"get" . ucfirst($this->orm->getUniqueColumn())}())) {
        //     // UPDATE
        //     $this->update();
        // } else {
        //     // INSERT
        //     $lastInsert = $this->insert();
        //     dd($lastInsert);
        // }

        
        


    }

    // Créer la find, findBy, findAll
    // public function findBy($key, $value = null)
    // {

    // }
    public function findBy($key, $value = null)
    {
        $sql = "SELECT * FROM {$this->orm->getTable()} WHERE ";

        $result = $this->db->query($sql);

        $this->mapping($result->fetchAll());
    }

    public function insert()
    {
        $this->orm->saveEntity();

        $query = $this->db->prepare($this->orm->buildSQLInsert());

        $query->execute($this->orm->getColumnsWithValues());

        return $this->db->lastInsertId();
    }

    public function update()
    {
        $this->orm->saveEntity();

        $query = $this->db->prepare($this->orm->buildSQLUpdate());

        $query->execute($this->orm->getColumnsWithValues());

        return $this;
        
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