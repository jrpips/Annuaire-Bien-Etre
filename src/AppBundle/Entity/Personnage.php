<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnage
 *
 * @ORM\Table(name="personnage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonnageRepository")
 */
class Personnage {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     *
     * @ORM\OneToOne(targetEntity="Warrior", cascade={"persist"},inversedBy="warrior")
     */
    private $warrior;
    /**
     *
     * @ORM\OneToOne(targetEntity="Magicien", cascade={"persist"},inversedBy="magicien")
     */
    private $magicien;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Personnage
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }


    /**
     * Set warrior
     *
     * @param \AppBundle\Entity\Warrior $warrior
     *
     * @return Personnage
     */
    public function setWarrior(\AppBundle\Entity\Warrior $warrior = null)
    {
        $this->warrior = $warrior;

        return $this;
    }

    /**
     * Get warrior
     *
     * @return \AppBundle\Entity\Warrior
     */
    public function getWarrior()
    {
        return $this->warrior;
    }

    /**
     * Set magicien
     *
     * @param \AppBundle\Entity\Magicien $magicien
     *
     * @return Personnage
     */
    public function setMagicien(\AppBundle\Entity\Magicien $magicien = null)
    {
        $this->magicien = $magicien;

        return $this;
    }

    /**
     * Get magicien
     *
     * @return \AppBundle\Entity\Magicien
     */
    public function getMagicien()
    {
        return $this->magicien;
    }
}
