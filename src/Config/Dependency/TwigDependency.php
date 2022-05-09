<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Map\Spillebord\Config\Config;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class TwigDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            $config = $container->get(Config::class);
            $config->loadConfigFile('twig');
            $paths = $config->get('twig.paths');
            $options = $config->get('twig.options');

            // Kept as a local variable, so that we can add extensions later.
            $twig = Twig::create($paths, $options);

            return $twig;
        };
    }
}
