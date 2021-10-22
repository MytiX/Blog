<?php

namespace App\Core\ORM;

use Attribute;

#[Attribute]
class ORMColumn
{
    public array $attributes = [
        "GeneratedValue" => false,
        "Unique" => false
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

    public function isGenerateValue(): bool
    {
        if (in_array("GeneratedValue", $this->attributes)) {
 
            return $this->attributes["GeneratedValue"];
        }
    }

    public function isUnique(): bool
    {
        if (in_array("Unique", $this->attributes)) {
 
            return $this->attributes["Unique"];
        }
    }
}