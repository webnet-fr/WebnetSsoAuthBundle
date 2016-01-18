<?php

namespace Webnet\SsoAuthBundle;

use Webnet\SsoAuthBundle\DependencyInjection\Security\Factory\TrustedSsoFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Webnet\SsoAuthBundle\DependencyInjection\Compiler\FactoryPass;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class WebnetSsoAuthBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $ext = $container->getExtension('security');
        $ext->addSecurityListenerFactory(new TrustedSsoFactory());

        $container->addCompilerPass(new FactoryPass());
    }
}
