<?php
/**
 * Created by PhpStorm.
 * User: samy
 * Date: 15/03/15
 * Time: 19:06
 */

namespace Ghribi\ApiBundle\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Ghribi\ApiBundle\Entity\Letter;
use Ghribi\ApiBundle\Services\LetterFieldService;

class LetterFieldListener
{
    /** @var LetterFieldService */
    private $letterFieldService;

    /**
     * @param LetterFieldService $letterFieldService
     */
    public function __construct(LetterFieldService $letterFieldService)
    {
        $this->letterFieldService = $letterFieldService;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Letter) {
            $this->letterFieldService->setEntityManager($args->getEntityManager());
            $this->letterFieldService->updateLetterFields($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Letter) {
            $this->letterFieldService->setEntityManager($args->getEntityManager());
            $this->letterFieldService->updateLetterFields($entity);
        }
    }
}
