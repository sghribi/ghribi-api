<?php

namespace Ghribi\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Letter
 *
 * @ORM\Table(name="letter")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Letter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     * @Serializer\Expose
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="LetterField", cascade={"all"}, inversedBy="letters", orphanRemoval=true)
     * @ORM\JoinTable(name="letter_letter_field")
     * @Serializer\Expose
     */
    private $fields;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Letter
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Letter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * Add fields
     *
     * @param LetterField $field
     *
     * @return Letter
     */
    public function addField(LetterField $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove fields
     *
     * @param LetterField $field
     */
    public function removeField(LetterField $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return Collection
     */
    public function getFields()
    {
        return $this->fields;
    }
}
