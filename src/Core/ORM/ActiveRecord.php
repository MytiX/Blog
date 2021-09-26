<?php

namespace App\Core\ORM;

use PDO;
use App\Core\PDO\PDOConnection;

abstract class ActiveRecord
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getConnection();
    }

    public function findById(int $id)
    {
        $query = $this->db->prepare(sprintf('SELECT * FROM %s WHERE `id` = :id', $this->getTable($this)));
        
        $query->execute([
            ':id' => $id
        ]);
        return $this->mappingResult($query->fetch(), get_class($this));
    }

    public function findAll()
    {
        $query = $this->db->prepare(sprintf('SELECT * FROM %s', $this->getTable($this)));
        
        $query->execute();
        dd($query->fetchAll());
        return $this->mapping($query->fetchAll(), $this);
    }

    private function getTable($entity): string
    {
        $class = explode("\\", get_class($entity));

        $parts = preg_split('/(?=[A-Z])/', $class[2]);

        return substr(strtolower(implode('_', $parts)), 1);
    }

    private function mapping($results)
    {
        $array = [];
        $class = get_class($this);

        foreach ($results as $result) {
            
            $array[] = $this->mappingResult($result, $class);
        }
        return $array;
    }

    private function mappingResult($result, $class): self
    {
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