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

    private function setAttribute($attributes)
    {
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if (array_key_exists($key, $this->attributes)) {
                    $this->attributes[$key] = $value;
                }
            }
        }
    }

    public function ignoreEntity(): bool
    {
        if (in_array('Ignore', $this->attributes)) {
            return $this->attributes['Ignore'];
        }
    }

    public function isAutoIncrement(): bool
    {
        if (in_array('AutoIncrement', $this->attributes)) {
            return $this->attributes['AutoIncrement'];
        }
    }

    public function isId(): bool
    {
        if (in_array('Id', $this->attributes)) {
            return $this->attributes['Id'];
        }
    }
}
