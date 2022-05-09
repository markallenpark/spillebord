<?php declare(strict_types=1);

namespace Map\Spillebord\Config;
use UnexpectedValueException;

class DependencyManager
{
    /**
     * @var array Array of dependencies to inject into the container
     */
    private array $dependencies = [];

    /**
     * Load dependencies from a config file.
     *
     * @param string $dependencyConfig
     * @return void
     * @throws UnexpectedValueException
     */
    public function loadDependencies(string $dependencyConfig) : void
    {
        $config = new Config();
        $config->loadConfigFile($dependencyConfig);

        $dependencies = $config->get(key: $dependencyConfig . '.dependencies');
        $loaderNamespace = $config->get(key: $dependencyConfig . '.namespace', default: '\\' . __NAMESPACE__ . '\\Dependency');

        if (is_array($dependencies)) {
            foreach ($dependencies as $dependency) $this->addDependency($dependency, $loaderNamespace);
        } else {
            $errorMessage = 'Expected an array of values representing dependencies to load. Received ' .
                gettype($dependencies) . ' instead. Please check the formatting of the ' . $dependencyConfig . ' configuration.';
            throw new UnexpectedValueException($errorMessage);
        }
    }

    /**
     * Add a dependency to the dependency injection array
     *
     * @param string $dependency
     * @param string $loaderNamespace
     * @return void
     */
    public function addDependency(string $dependency, string $loaderNamespace) : void
    {
        $parts = explode(separator: '\\', string: $dependency);
        $name = end(array: $parts);
        $wrapperClassName = $loaderNamespace . '\\' . ucfirst($name) . 'Dependency';
        $dependencyWrapper = new $wrapperClassName();

        $this->dependencies[$dependency] = $dependencyWrapper->create();
    }

    public function getDependencies() : array
    {
        return $this->dependencies;
    }
}
