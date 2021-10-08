<?php

namespace App\Core\ORM;

use ReflectionClass;

class ORMReflection
{
    private object $instance;

    private string $table;
    
    private array $columns;
    
    private array $values;

    private ReflectionClass $reflection;

    public function __construct($instance)
    {
        $this->instance = $instance;
        $this->initializeORM();
    }

    public function initializeORM(): void
    {
        $this->reflection = new ReflectionClass($this->instance);
        
        $this->setTable($this->instance);
        
        foreach ($this->reflection->getProperties() as $propertie) {
            
            /** @var ReflectionAttribute $attributes */
            $attributes = $propertie->getAttributes(ORMColumn::class);
            
            if (!empty($attributes)) {
                foreach ($attributes as $attribute) {
                    /** @var ORMColumn $ormColumn */
                    $ormColumn = $attribute->newInstance();
                    
                    if (!$ormColumn->isGenerateValue()) {
                        $this->setColumns($this->formatColumnName($propertie->getName()));
                        $this->setValues($this->instance->{"get" . ucfirst($propertie->getName())}());
                    }
                }
            } else {
                $this->setColumns($this->formatColumnName($propertie->getName()));
                $this->setValues($this->instance->{"get" . ucfirst($propertie->getName())}());
            }
        }
    }
    
    private function formatColumnName($columnsName)
    {
        $parts = preg_split('/(?=[A-Z])/', $columnsName);
        
        if (count($parts) > 1) {
            return strtolower(implode('_', $parts));
        } else {
            return $columnsName;
        }
    }
    
    public function getTable(): string
    {
        return $this->table;
    }

    private function setTable($instance): void
    {
        if (empty($this->table)) {
            
            $class = explode("\\", get_class($instance));
    
            $parts = preg_split('/(?=[A-Z])/', $class[2]);
    
            $this->table = substr(strtolower(implode('_', $parts)), 1);
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    private function setColumns($columns): void
    {
        $this->columns[] = $columns;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    private function setValues($value): void
    {
        $this->values[] = $value;
    }

    public function getStringColumnsInsert()
    {
        $sqlColumns = "(";

        foreach ($this->columns as $column) {
            
            $sqlColumns .= $column . ", ";
        }

        $sqlColumns = substr($sqlColumns, 0, -2);

        $sqlColumns .= ")";

        return $sqlColumns;
    }

    public function getStringValueInsert()
    {
        $sqlValues = "(";

        foreach ($this->values as $value) {
            
            $sqlValues .= "'" . $value . "', ";
        }

        $sqlValues = substr($sqlValues, 0, -2);

        $sqlValues .= ")";

        return $sqlValues;
    }
}