<?php

namespace Ghribi\ApiBundle\Tests\Services;

use Ghribi\Features\Services\AbstractServiceTest;

/**
 * Class ServiceTest
 */
class ServiceTest extends AbstractServiceTest
{
    /**
     * @return array
     */
    public function provideServices()
    {
        return array(
            array('access_control_allow_listener',  'Ghribi\ApiBundle\Listener\AccessControlAllowListener'),
            array('http_options_listener',          'Ghribi\ApiBundle\Listener\HttpOptionsListener'),
        );
    }
}
