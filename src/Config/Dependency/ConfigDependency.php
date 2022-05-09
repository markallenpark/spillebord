<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Map\Spillebord\Config\Config;

class ConfigDependency
{
    public function create() : Config
    {
        return new Config();
    }
}
