<?php

namespace Webnet\SsoAuthBundle\Sso;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Buzz\Client\ClientInterface;
use Webnet\SsoAuthBundle\Exception\ConfigNotFoundException;
use Webnet\SsoAuthBundle\Exception\ServerNotFoundException;
use Webnet\SsoAuthBundle\Exception\ProtocolNotFoundException;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class Factory
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $servers;

    /**
     * @var array
     */
    private $protocols;

    /**
     * @var array
     */
    private $managers;

    /**
     * @var \Buzz\Client\ClientInterface
     */
    private $client;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Buzz\Client\ClientInterface $client
     */
    public function __construct(ContainerInterface $container, $client)
    {
        $this->container = $container;
        $this->servers   = array();
        $this->protocols = array();
        $this->managers  = array();
        $this->client    = $client;
    }

    /**
     * @param string $id
     * @param string $service
     */
    public function addServer($id, $service)
    {
        $this->servers[$id] = $service;
    }

    /**
     * @param string $id
     * @param string $service
     */
    public function addProtocol($id, $service)
    {
        $this->protocols[$id] = $service;
    }

    /**
     * @param string $id
     * @param string $checkUrl
     *
     * @return Manager
     */
    public function getManager($id, $checkUrl)
    {
        if (!isset($this->managers[$id])) {
            $this->managers[$id] = $this->createManager($id, $checkUrl);
        }

        return $this->managers[$id];
    }

    /**
     * @param string $id
     * @param string $checkUrl
     *
     * @return Manager
     *
     * @throws \Webnet\SsoAuthBundle\Exception\ConfigNotFoundException
     */
    private function createManager($id, $checkUrl)
    {
        $parameter = sprintf('webnet.sso_auth.manager.%s', $id);

        if (!$this->container->hasParameter($parameter)) {
            throw new ConfigNotFoundException($id);
        }

        $config = $this->container->getParameter($parameter);
        $config['server']['check_url'] = $checkUrl;

        return new Manager($this->getServer($config['server']), $this->getProtocol($config['protocol']), $this->client);
    }

    /**
     * @param array $config
     *
     * @return ServerInterface
     *
     * @throws \Webnet\SsoAuthBundle\Exception\ServerNotFoundException
     */
    private function getServer(array $config)
    {
        $id = $config['id'];

        if (!isset($this->servers[$id])) {
            throw new ServerNotFoundException($id);
        }

        return $this->container->get($this->servers[$id])->setConfig($config);
    }

    /**
     * @param array $config
     *
     * @return ProtocolInterface
     *
     * @throws \Webnet\SsoAuthBundle\Exception\ProtocolNotFoundException
     */
    private function getProtocol(array $config)
    {
        $id = $config['id'];

        if (!isset($this->protocols[$id])) {
            throw new ProtocolNotFoundException($id);
        }

        return $this->container->get($this->protocols[$id])->setConfig($config);
    }
}
