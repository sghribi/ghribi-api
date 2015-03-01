<?php

namespace Ghribi\ApiBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadData
 */
class LoadData extends DataFixtureLoader implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getFixtures()
    {
        if ($this->container->get('kernel')->getEnvironment() == 'test') {
            return  array(
                __DIR__ . '/fixtures.yml',
            );
        } else {
            return array();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}