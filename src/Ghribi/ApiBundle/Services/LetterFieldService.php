<?php

namespace Ghribi\ApiBundle\Services;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Ghribi\ApiBundle\Entity\Letter;
use Ghribi\ApiBundle\Entity\LetterField;

/**
 * Class LetterFieldService
 */
class LetterFieldService
{
    /** @var EntityManager */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Letter $letter
     */
    public function updateLetterFields(Letter $letter)
    {
        if (is_null($this->em)) {
            throw new \LogicException('EntityManager must be set before.');
        }

        $fields = $this->getFieldsByLetter($letter);
        $letterFieldRepository = $this->em->getRepository('GhribiApiBundle:LetterField');

        foreach ($fields as $field) {
            $letterField = $letterFieldRepository->findOneBy(array('name' => $field));

            if (!$letterField) {
                $letterField = new LetterField($field);
                $this->em->persist($letterField);
            }

            $letter->addField($letterField);
            $letterField->addLetter($letter);
        }
    }

    /**
     * @TODO: unit test it
     *
     * @param Letter $letter
     *
     * @return array
     */
    private function getFieldsByLetter(Letter $letter)
    {
        preg_match_all('/\{\{(?!%)\s*((?:(?!\.)[^\s])*)\s*(?<!%)\}\}|\{%\s*(?:\s(?!endfor)(\w+))+\s*%\}/i', $letter->getText(), $m);
        $m = array_map('array_filter', $m);
        array_shift($m);
        return array_unique($m[0]);
    }
}
