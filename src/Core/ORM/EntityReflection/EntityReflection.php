<?php

namespace App\Core\ORM\EntityReflection;

use ReflectionClass;

class EntityReflection
{
    private object $instance;

    private string $uniqueColumn;

    private string $autoIncrement;

    private array $columnsWithValues;

    public function __construct($instance)
    {
        $this->reflection = new ReflectionClass($instance);
        $this->instance = $instance;
    }

    public function persistEntity(): void
    {
        foreach ($this->reflection->getProperties() as $propertie) {
            /** @var ReflectionAttribute $attributes */
            $attributes = $propertie->getAttributes(EntityAttribute::class);

            if (!empty($attributes)) {
                foreach ($attributes as $attribute) {
                    /** @var EntityAttribute $entityAttribute */
                    $entityAttribute = $attribute->newInstance();

                    if ($entityAttribute->ignoreEntity()) {
                        continue;
                    }

                    if ($entityAttribute->isAutoIncrement()) {
                        $this->setAutoIncrementKey($this->formatKeyName($propertie->getName()));
                    } else {
                        $this->setColumnsWithValues($this->formatKeyName($propertie->getName()), $this->instance->{'get'.ucfirst($propertie->getName())}());
                    }

                    if ($entityAttribute->isId()) {
                        $this->setIdColumn($propertie->getName());
                    }
                }
            } else {
                $this->setColumnsWithValues($this->formatKeyName($propertie->getName()), $this->instance->{'get'.ucfirst($propertie->getName())}());
            }
        }
    }

    public function getEntityName()
    {
        return $this->reflection->getName();
    }

    private function setIdColumn(string $column)
    {
        $this->uniqueColumn = $column;
    }

    public function getIdColumn()
    {
        return $this->uniqueColumn;
    }

    private function setAutoIncrementKey(string $column)
    {
        $this->autoIncrement = $column;
    }

    public function getAutoIncrementKey()
    {
        return $this->autoIncrement;
    }

    private function formatKeyName($columnsName)
    {
        $parts = preg_split('/(?=[A-Z])/', $columnsName);

        if (count($parts) > 1) {
            $columnsName = strtolower(implode('_', $parts));
        }

        return ':'.$columnsName;
    }

    private function setColumnsWithValues(string $column, mixed $value)
    {
        $this->columnsWithValues[$column] = $value;
    }

    public function getColumnsWithValues()
    {
        return $this->columnsWithValues;
    }

    public function formatFunctionName(string $columnName)
    {
        $functionName = '';

        $columns = explode('_', $columnName);

        if (count($columns) > 1) {
            for ($i = 0; $i < count($columns); ++$i) {
                $functionName .= ucfirst($columns[$i]);
            }

            return lcfirst($functionName);
        }

        return ucfirst($columns[0]);
    }
}
