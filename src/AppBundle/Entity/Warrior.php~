<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Warrior
 *
 * @ORM\Table(name="warrior")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WarriorRepository")
 */
class Warrior {

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
     * @ORM\Column(name="power", type="string", length=255)
     */
    private $power;

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
     * @return Warrior
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
     * Set power
     *
     * @param string $power
     *
     * @return Warrior
     */
    public function setPower($power) {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return string
     */
    public function getPower() {
        return $this->power;
    }


    /**
     * Set personnage
     *
     * @param \AppBundle\Entity\Personnage $personnage
     *
     * @return Warrior
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
