<?php
/**
 * Created by PhpStorm.
 * User: amokeddem
 * Date: 14/01/2016
 * Time: 17:17
 */

namespace Webnet\SsoAuthBundle\Buzz;

use Buzz\Client\ClientInterface;
use Buzz\Exception\ClientException;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

/**
 * Class CasClient
 *
 * @package Webnet\SsoAuthBundle\Buzz
 */
class CasClient implements ClientInterface
{
    private $client;
    private $options;

    /**
     * CasClient constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
        \phpCAS::getVersion();

        // Désactivé car trop verbeux pour la production...
        // \phpCAS::setDebug('/tmp/cas-log.log');

        \phpCAS::setVerbose(true);
        $this->client = new \CAS_Client(
            SAML_VERSION_1_1,
            false,
            $this->options['webnet.sso_auth.client.option.cas_host.value'],
            $this->options['webnet.sso_auth.client.option.cas_port.value'],
            $this->options['webnet.sso_auth.client.option.cas_context.value']
        );
        $this->client->setNoCasServerValidation();
        $this->client->handleLogoutRequests(false, false);
    }

    /**
     * @param RequestInterface $request
     * @param MessageInterface $response
     */
    public function send(RequestInterface $request, MessageInterface $response)
    {
        try {
            $this->client->forceAuthentication();
            $response->setContent(serialize($_SESSION['phpCAS']));
        } catch (\CAS_AuthenticationException $e) {

        }
    }
}
