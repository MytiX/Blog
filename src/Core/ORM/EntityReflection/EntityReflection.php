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

    /**
     * persistEntity
     * Persist Data of entity in array
     * @return void
     */
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

    /**
     * getEntityName
     * Get name class of the entity
     * @return string
     */
    public function getEntityName(): string
    {
        return $this->reflection->getName();
    }

    /**
     * setIdColumn
     * Set name of the unique column
     * @param  string $column
     * @return void
     */
    private function setIdColumn(string $column): void
    {
        $this->uniqueColumn = $column;
    }

    /**
     * getIdColumn
     * Return value of index column
     * @return string
     */
    public function getIdColumn(): string
    {
        return $this->uniqueColumn;
    }

    /**
     * setAutoIncrementKey
     * Set name of the autoIncrement column
     * @param  string $column
     * @return void
     */
    private function setAutoIncrementKey(string $column): void
    {
        $this->autoIncrement = $column;
    }

    /**
     * getAutoIncrementKey
     * Return name of AutoIncrementKey column
     * @return string
     */
    public function getAutoIncrementKey(): string
    {
        return $this->autoIncrement;
    }

    /**
     * formatKeyName
     * Formate key name ex : createdAt = [':created_at']
     * @param  string $columnsName
     * @return string
     */
    private function formatKeyName($columnsName): string
    {
        $parts = preg_split('/(?=[A-Z])/', $columnsName);

        if (count($parts) > 1) {
            $columnsName = strtolower(implode('_', $parts));
        }

        return ':'.$columnsName;
    }

    /**
     * setColumnsWithValues
     * Set value and key in array [':created_at'] => '29/06/1995'
     * @param  string $column
     * @param  mixed $value
     * @return void
     */
    private function setColumnsWithValues(string $column, mixed $value): void
    {
        $this->columnsWithValues[$column] = $value;
    }

    /**
     * getColumnsWithValues
     *
     * @return array
     */
    public function getColumnsWithValues(): array
    {
        return $this->columnsWithValues;
    }

    /**
     * formatFunctionName
     * Convert name of column to name of function
     * @param  mixed $columnName
     * @return string
     */
    public function formatFunctionName(string $columnName): string
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
