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
     * @var string Paths to configuration files.
     */
    private string $path;

    /**
     * The constructor
     *
     * @param string|null $config_path
     */
    public function __construct(string $config_path = null)
    {
        $this->data['root'] = PROJECT_ROOT;
        $this->data['local'] = [
            'environment' => LOCAL_ENV
        ];

        if ($config_path !== null) {

            if (mb_substr(string: $config_path, start: -1) != DIRECTORY_SEPARATOR) {
                $config_path = $config_path . DIRECTORY_SEPARATOR;
            }

            $this->path = $config_path;
        } else {
            $this->path = PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * Load configuration data from config file.
     *
     * @param string $name      Configuration name. ( Will be used as the base key for related config items. )
     * @param bool   $overwrite Overwrite default values with local configuration if true.
     * @return void
     */
    public function loadConfigFile(string $name, bool $overwrite = false) : void
    {
        $defaultConfigFile = $this->path . $name . '.php';
        $localConfigFile   = $this->path . $name . '.' . LOCAL_ENV . '.php';

        $data = $this->data[$name] ?? [];

        // Load default values
        if (file_exists($defaultConfigFile)) {
            $data = array_merge(require $defaultConfigFile, $data);
        }

        // Load local overrides
        if (file_exists($localConfigFile)) {
            $data = (! $overwrite) ? array_merge(require $localConfigFile, $data) : require $localConfigFile;
        }

        $this->data[$name] = $data;
    }

    /**
     * Retrieve a configuration value from configuration data.
     *
     * Uses dot-notation.
     *
     * @param string|null $key      Key of data to retrieve.
     * @param mixed|null  $default  Default value if value does not exist.
     * @return mixed                Value set to $key, or $default if $key is not set.
     */
    public function get(string $key = null, mixed $default = null) : mixed
    {
        $data = new Data(data: $this->data);

        // If no key is specified, return entire array
        if ($key === null) {
            return $this->data;
        }

        return $data->get(key: $key, default: $default);
    }
}
