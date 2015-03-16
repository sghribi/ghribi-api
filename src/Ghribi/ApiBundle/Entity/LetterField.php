<?php

namespace Ghribi\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * LetterField
 *
 * @ORM\Table(name="letter_field")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class LetterField
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Letter", mappedBy="fields", cascade={"persist"})
     */
    private $letters;

    /**
     * Constructor
     *
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $this->letters = new ArrayCollection();
        $this->name = $name;
    }

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
     * Set label
     *
     * @param string $label
     * @return LetterField
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add letter
     *
     * @param Letter $letter
     *
     * @return LetterField
     */
    public function addLetter(Letter $letter)
    {
        $this->letters[] = $letter;

        return $this;
    }

    /**
     * Remove letters
     *
     * @param Letter $letter
     */
    public function removeLetter(Letter $letter)
    {
        $this->letters->removeElement($letter);
    }

    /**
     * Get letters
     *
     * @return Collection
     */
    public function getLetters()
    {
        return $this->letters;
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpInitialLabel()
    {
        $this->label = $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return LetterField
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
}
