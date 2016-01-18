<?php

namespace Webnet\SsoAuthBundle\Sso\Cas;

use Webnet\SsoAuthBundle\Sso\AbstractValidation;
use Webnet\SsoAuthBundle\Sso\ValidationInterface;
use Buzz\Message\Response;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class ArrayValidation extends AbstractValidation implements ValidationInterface
{
    /**
     * {@inheritdoc}
     */
    protected function validateResponse(Response $response)
    {
        $content = $response->getContent();
        $values = unserialize($content);
        $success = true;
        if (!empty($values) && is_array($values)) {
            $this->username = $values['user'];
            foreach ($values['attributes'] as $key => $value) {
                $this->attributes[$key] = $value;
            }
        } else {
            $success = false;
        }
        return $success;
    }
}
