<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Map\Spillebord\Config\Config;
use Odan\Session\PhpSession;
use Psr\Container\ContainerInterface;

class SessionInterfaceDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            $config = $container->get(Config::class);
            $config->loadConfigFile('session');
            $session = new PhpSession();
            $session->setOptions($config->get('session'));
            return $session;
        };
    }
}
