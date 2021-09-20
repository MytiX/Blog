<?php

namespace App\Core\ORM;

use App\Core\PDO\PDOConnection;
use PDO;

class ActiveRecord
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getConnection();
    }

    public function findById(int $id, $entityClass)
    {
        $query = $this->db->prepare(sprintf('SELECT * FROM %s WHERE `id` = :id', $this->getTable($entityClass)));
        
        $query->execute([
            ':id' => $id
        ]);
        dd($query->fetch());
        return $this->mapping($query->fetch(), $entityClass);    
    }

    public function findAll($entityClass)
    {
        $query = $this->db->prepare(sprintf('SELECT * FROM %s', $this->getTable($entityClass)));
        
        $query->execute();
        
        return $this->mapping($query->fetchAll(), $entityClass);
    }

    private function getTable($entity): string
    {
        $class = explode("\\", get_class($entity));

        $parts = preg_split('/(?=[A-Z])/', $class[2]);

        return substr(strtolower(implode('_', $parts)), 1);
    }

    private function mapping($results, $entityClass)
    {
        $array = [];

        foreach ($results as $result) {
            
            $class = get_class($entityClass);

            $instance = new $class();
            
            foreach ($result as $key => $value) {
                if (method_exists($instance, "set" . ucfirst($key))) {
                    $value = !empty($value) ? $value : null;
                    $instance->{"set" . ucfirst($key)}($value);
                }
            }
            $array[] = $instance;
        }
        return $array;
    }
}