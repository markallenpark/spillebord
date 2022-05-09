<?php declare(strict_types=1);

namespace Map\Spillebord;

use DI\ContainerBuilder;
use Exception;
use Map\Spillebord\Config\DependencyManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;

class Spillebord
{
    /**
     * @var ContainerInterface The container.
     */
    private ContainerInterface $container;

    /**
     * @var App|mixed Slim application.
     */
    private App $app;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __construct()
    {
        $this->container = $this->createContainer();
        $this->app = $this->container->get(App::class);
        Routes::create($this->app);
        Middleware::load($this->app);
    }

    /**
     * @throws Exception
     */
    private function createContainer() : ContainerInterface
    {
        $builder = new ContainerBuilder();
        $dependencyManager = new DependencyManager();
        $dependencyManager->loadDependencies(dependencyConfig: 'dependency');
        $builder->addDefinitions($dependencyManager->getDependencies());
        return $builder->build();
    }

    /**
     * Start the application.
     *
     * @return void
     */
    public function run() : void
    {
        $this->app->run();
    }
}
