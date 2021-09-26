<?php

namespace App\Core\ORM;

use PDO;
use ReflectionClass;
use App\Core\PDO\PDOConnection;

abstract class ActiveRecord
{
    // TODO Voir pour créer une autre class qui regroupe les fonctions getTable, mapping, mappingResult, getInsertKey, getInsertValues
    private $db;

    private $class;

    public function __construct()
    {
        $this->db = PDOConnection::getConnection();
        $this->class = get_class($this);
    }

    public function findById(int $id)
    {
        $query = $this->db->prepare("SELECT * FROM {$this->getTable()} WHERE `id` = :id");
        
        $query->execute([
            ':id' => $id
        ]);

        return $this->mappingResult($query->fetch());
    }

    public function findAll()
    {
        $query = $this->db->prepare(sprintf('SELECT * FROM %s', $this->getTable()));
        
        $query->execute();

        return $this->mapping($query->fetchAll());
    }

    public function insert(): void
    {
        $sql = "INSERT INTO {$this->getTable()} ({$this->getInsertKey()}) VALUES ({$this->getInsertValues()})";

        $this->db->query($sql);
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    private function getTable(): string
    {
        $class = explode("\\", $this->class);

        $parts = preg_split('/(?=[A-Z])/', $class[2]);

        return substr(strtolower(implode('_', $parts)), 1);
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

    private function getInsertKey()
    {
        $reflection = new ReflectionClass($this);

        $keyInsert = "";

        foreach ($reflection->getProperties() as $propertie) {
            if ($propertie->name !== "id") {
                $keyInsert .= $propertie->name . ", ";
            }
        }

        return substr($keyInsert, 0, strlen($keyInsert) - 2);
    }

    private function getInsertValues()
    {
        $reflection = new ReflectionClass($this);

        $valuesInsert = "";

        foreach ($reflection->getProperties() as $propertie) {
            if ($propertie->name !== "id") {
                $valuesInsert .= '\'' . $this->{"get" . ucfirst($propertie->name)}() . "', ";
            }
        }

        return substr($valuesInsert, 0, strlen($valuesInsert) - 2);
    }
}