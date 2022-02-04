<?php

namespace App\Core\ORM\EntityReflection;

use Attribute;

#[Attribute]
class EntityAttribute
{
    public array $attributes = [
        'AutoIncrement' => false,
        'Id' => false,
        'Ignore' => false,
    ];

    public function __construct(array $attributes)
    {
        $this->setAttribute($attributes);
    }

    /**
     * setAttribute
     * Override the value of attributes params
     * @param  array $attributes
     * @return void
     */
    private function setAttribute(array $attributes): void
    {
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if (array_key_exists($key, $this->attributes)) {
                    $this->attributes[$key] = $value;
                }
            }
        }
    }

    /**
     * ignoreEntity
     * Used to change the comportement in EntityReflection
     * @return bool
     */
    public function ignoreEntity(): bool
    {
        if (in_array('Ignore', $this->attributes)) {
            return $this->attributes['Ignore'];
        }
    }

    /**
     * isAutoIncrement
     * Used to change the comportement in EntityReflection
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        if (in_array('AutoIncrement', $this->attributes)) {
            return $this->attributes['AutoIncrement'];
        }
    }

    /**
     * isId
     * Used to change the comportement in EntityReflection
     * @return bool
     */
    public function isId(): bool
    {
        if (in_array('Id', $this->attributes)) {
            return $this->attributes['Id'];
        }
    }
}
