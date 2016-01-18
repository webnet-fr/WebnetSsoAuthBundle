<?php

namespace Webnet\SsoAuthBundle\Controller;

use Webnet\SsoAuthBundle\Sso\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TrustedSsoController extends Controller
{
    public function loginAction(Manager $manager, Request $request, AuthenticationException $exception = null)
    {
        return $this->render(
            'WebnetSsoAuthBundle:TrustedSso:login.html.twig',
            array(
                'manager'   => $manager,
                'request'   => $request,
                'exception' => $exception
            )
        );
    }

    public function logoutAction(Manager $manager, Request $request)
    {
        return $this->render(
            'WebnetSsoAuthBundle:TrustedSso:logout.html.twig',
            array(
                'manager' => $manager,
                'request' => $request
            )
        );
    }
}
