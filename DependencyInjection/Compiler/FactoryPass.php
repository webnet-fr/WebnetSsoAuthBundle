<?php

namespace Webnet\SsoAuthBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class FactoryPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('webnet.sso_auth.factory')) {
            return;
        }

        $factoryBuilder = $container->getDefinition('webnet.sso_auth.factory');

        foreach ($container->findTaggedServiceIds('webnet.sso_auth.protocol') as $id => $attributes) {
            $factoryBuilder->addMethodCall('addProtocol', array($attributes[0]['id'], $id));
        }

        foreach ($container->findTaggedServiceIds('webnet.sso_auth.server') as $id => $attributes) {
            $factoryBuilder->addMethodCall('addServer', array($attributes[0]['id'], $id));
        }
    }
}
