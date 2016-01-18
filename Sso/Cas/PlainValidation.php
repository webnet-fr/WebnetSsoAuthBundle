<?php

namespace Webnet\SsoAuthBundle\Sso\Cas;

use Webnet\SsoAuthBundle\Sso\AbstractValidation;
use Webnet\SsoAuthBundle\Sso\ValidationInterface;
use Buzz\Message\Response;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class PlainValidation extends AbstractValidation implements ValidationInterface
{
    /**
     * {@inheritdoc}
     */
    protected function validateResponse(Response $response)
    {
        $content = $response->getContent();
        $data    = explode("\n", str_replace("\n\n", "\n", str_replace("\r", "\n", $content)));
        $success = strtolower($data[0]) === 'yes';
        $message = (count($data) > 1 && $data[1]) ? $data[1] : null;

        if ($success) {
            $this->username = $message;
        } else {
            $this->error = $message;
        }

        return $success;
    }
}
