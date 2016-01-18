<?php

namespace Webnet\SsoAuthBundle\Sso\Cas;

use Webnet\SsoAuthBundle\Sso\AbstractProtocol;
use Webnet\SsoAuthBundle\Sso\ProtocolInterface;
use Webnet\SsoAuthBundle\Exception\InvalidConfigurationException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;
use Buzz\Client\ClientInterface;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class SamlProtocol extends AbstractProtocol
{
    /**
     * {@inheritdoc}
     */
    public function isValidationRequest(SymfonyRequest $request)
    {
        return !empty($_SESSION['phpCAS']) || $request->query->has('ticket');
    }

    /**
     * {@inheritdoc}
     */
    public function extractCredentials(SymfonyRequest $request)
    {
        if (!empty($_SESSION['phpCAS'])) {
            return $_SESSION['phpCAS'];
        } else {
            return $request->query->get('ticket');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function executeValidation(ClientInterface $client, BuzzRequest $request, $credentials)
    {
        $response = new BuzzResponse();
        $client->send($request, $response);
        switch ($this->getConfigValue('version')) {
            case 1: return new PlainValidation($response, $credentials);
            case 2: return new XmlValidation($response, $credentials);
            case 3: return new ArrayValidation($response, $credentials);
        }

        throw new InvalidConfigurationException('Version should either be 1, 2 or 3.');
    }
}
