<?php

namespace Ghribi\Features;

/**
 * Class Credentials
 *
 * Provide test authentication credentials
 */
class Credentials
{
    /**
     * @return array
     */
    public static function getUserCredentials()
    {
        return array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'password'
        );
    }
}
