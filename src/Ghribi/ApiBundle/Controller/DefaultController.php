<?php

namespace Ghribi\ApiBundle\Controller;

use Ghribi\ApiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @Route("/me")
     */
    public function whoAmIAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @TODO: Use serializer */
        return new JsonResponse(array(
            'id'        => $user->getId(),
            'email'     => $user->getEmail(),
            'username'  => $user->getUsername(),
        ));
    }
}
