<?php

namespace Config;

class TemplatingConfig
{
    public static function getConfig(): array
    {
        return [
            "path" => "../template",
            "base" => "../template/base.php",
        ];
    }
}