<?php declare(strict_types=1);

namespace Map\Spillebord\Config;

use Dflydev\DotAccessData\Data;

class Config
{
    /**
     * @var array Array of configuration values.
     */
    private array $data = [];

    /**
     * @var array|string[] Paths to configuration files.
     */
    private array $paths = [
        'default' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR,
        'local' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . LOCAL_ENV . DIRECTORY_SEPARATOR
    ];

    /**
     * Load configuration data from config file.
     *
     * @param string $name  Configuration name. ( Will be used as the base key for related config items. )
     * @return void
     */
    public function loadConfigFile(string $name) : void
    {
        $defaultConfigFile = $this->paths['default'] . $name . '.php';
        $localConfigFile   = $this->paths['local'] . $name . '.php';

        $data = $this->data[$name] ?? [];

        if (file_exists($defaultConfigFile)) {
            $data = array_merge(require $defaultConfigFile, $data);
        }

        if (file_exists($localConfigFile)) {
            $data = array_merge(require $localConfigFile, $data);
        }

        $this->data[$name] = $data;
    }

    /**
     * Retrieve a configuration value from configuration data.
     *
     * @param string $key           Key of data to retrieve.
     * @param mixed|null $default   Default value if value does not exist.
     * @return mixed                Value set to $key, or $default if $key is not set.
     */
    public function get(string $key, mixed $default = null) : mixed
    {
        $data = new Data(data: $this->data);

        return $data->get(key: $key, default: $default);
    }
}
