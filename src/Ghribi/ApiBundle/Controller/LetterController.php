<?php

namespace Ghribi\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 *
 * @Route("/letter")
 */
class LetterController extends Controller
{
    /**
     * @Route("/", defaults={"_format": "json"})
     * @Method({"GET"})
     * @Rest\View()
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Returns a collection of letters"
     * )
     */
    public function getLettersAction()
    {
        return $this->getDoctrine()->getRepository('GhribiApiBundle:Letter')->findAll();
    }
}
