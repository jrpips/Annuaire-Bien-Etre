<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magicien
 *
 * @ORM\Table(name="magicien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MagicienRepository")
 */
class Magicien {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     *
     * @ORM\OneToOne(targetEntity="Personnage", cascade={"persist"},mappedBy="personnage")
     */
    private $personnage;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="magic", type="string", length=255)
     */
    private $magic;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Magicien
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set magic
     *
     * @param string $magic
     *
     * @return Magicien
     */
    public function setMagic($magic) {
        $this->magic = $magic;

        return $this;
    }

    /**
     * Get magic
     *
     * @return string
     */
    public function getMagic() {
        return $this->magic;
    }


    /**
     * Set personnage
     *
     * @param \AppBundle\Entity\Personnage $personnage
     *
     * @return Magicien
     */
    public function setPersonnage(\AppBundle\Entity\Personnage $personnage = null)
    {
        $this->personnage = $personnage;

        return $this;
    }

    /**
     * Get personnage
     *
     * @return \AppBundle\Entity\Personnage
     */
    public function getPersonnage()
    {
        return $this->personnage;
    }
}
