<?php

namespace Webnet\SsoAuthBundle\Sso;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Webnet\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;
use Buzz\Client\ClientInterface;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class Manager
{
    /**
     * @var \Webnet\SsoAuthBundle\Sso\ServerInterface
     */
    private $server;

    /**
     * @var \Webnet\SsoAuthBundle\Sso\ProtocolInterface
     */
    private $protocol;

    /**
     * @var \Buzz\Client\ClientInterface
     */
    private $client;

    /**
     * Constructor.
     *
     * @param ServerInterface              $server
     * @param ProtocolInterface            $protocol
     * @param \Buzz\Client\ClientInterface $client
     */
    public function __construct(ServerInterface $server, ProtocolInterface $protocol, $client)
    {
        $this->server   = $server;
        $this->protocol = $protocol;
        $this->client   = $client;
    }

    /**
     * Validates given credentials.
     *
     * @param string $credentials
     *
     * @return ValidationInterface
     */
    public function validateCredentials($credentials)
    {
        if ($this->client  instanceof \Webnet\SsoAuthBundle\Buzz\AdapatativeClient) {
            $request    = $this->server->buildValidationRequest($credentials);
        } else {
            $request = new \Buzz\Message\Request();
        }
        $validation = $this->protocol->executeValidation($this->client, $request, $credentials);

        return $validation;
    }

    /**
     * Creates a token from the request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Webnet\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken
     */
    public function createToken(Request $request)
    {
        return new SsoToken($this, $this->protocol->extractCredentials($request));
    }

    /**
     * @return \Webnet\SsoAuthBundle\Sso\ServerInterface
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return \Webnet\SsoAuthBundle\Sso\ProtocolInterface
     */
    public function getProtocol()
    {
        return $this->protocol;
    }
}
