<?php

namespace Ghribi\ApiBundle\Tests\Services;

use Ghribi\ApiBundle\Listener\LetterFieldListener;
use Ghribi\Features\Services\AbstractServiceTest;
use Ghribi\ApiBundle\Listener\HttpOptionsListener;
use Ghribi\ApiBundle\Listener\AccessControlAllowListener;
use Ghribi\ApiBundle\Services\LetterFieldService;

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
            array('access_control_allow_listener',  AccessControlAllowListener::class),
            array('http_options_listener',          HttpOptionsListener::class),
            array('letter_field_updater.service',   LetterFieldService::class),
            array('letter_field_updater.listener',  LetterFieldListener::class),
        );
    }
}
