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

    public function findById(int $id, $entity)
    {
        
        $query = $this->db->prepare(sprintf('SELECT * FROM %s WHERE `id` = :id', $this->getTable($entity)));
        
        $query->execute([
            ':id' => $id
        ]);
        
        $result = $query->fetch();
        
        dd($result);
        
    }

    public function getTable($entity): string
    {
        $class = explode("\\", get_class($entity));

        $parts = preg_split('/(?=[A-Z])/', $class[2]);

        return substr(strtolower(implode('_', $parts)), 1);
    }
}