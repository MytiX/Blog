<?php

namespace App\Core\ORM;

use ReflectionClass;

class ORMReflection
{
    private object $instance;

    private array $properties;

    private string $table;
    
    private array $columns;
    
    private array $values;

    private ReflectionClass $reflection;

    public function __construct($instance)
    {
        $this->instance = $instance;
        $this->reflection = new ReflectionClass($instance);
    }

    private function getProperties(): array
    {
        if (empty($this->properties)) {
            foreach ($this->reflection->getProperties() as $propertie) {
            
                $this->properties[] = $propertie->getName();
            }
        }
        return $this->properties;
    }

    public function getTable(): string
    {
        if (empty($this->table)) {
            
            $class = explode("\\", get_class($this->instance));
    
            $parts = preg_split('/(?=[A-Z])/', $class[2]);
    
            $this->table = substr(strtolower(implode('_', $parts)), 1);
        }

        return $this->table;
    }

    public function getColumns(): array
    {
        if (empty($this->columns)) {
            foreach ($this->reflection->getProperties() as $propertie) {

                $parts = preg_split('/(?=[A-Z])/', $propertie->getName());

                if (count($parts) > 1) {
                    $this->columns[] = strtolower(implode('_', $parts));
                } else {
                    $this->columns[] = $propertie->getName();
                }
            }
        }
        return $this->columns;
    }

    public function getValues(): array
    {
        foreach ($this->getProperties() as $propertie) {
            $this->values[] = $this->instance->{"get" . ucfirst($propertie)}();
        }
        return $this->values;
    }
}