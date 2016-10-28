<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AdresseUtilisateur
 *
 * @ORM\Table(name="adresse_utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdresseUtilisateurRepository")
 */
class AdresseUtilisateur {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="localite", type="string", length=100)
     */
    private $localite;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="commune", type="string", length=100)
     */
    private $commune;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return AdresseUtilisateur
     */
    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return int
     */
    public function getCodePostal() {
        return $this->codePostal;
    }

    /**
     * Set localite
     *
     * @param string $localite
     *
     * @return AdresseUtilisateur
     */
    public function setLocalite($localite) {
        $this->localite = $localite;

        return $this;
    }

    /**
     * Get localite
     *
     * @return string
     */
    public function getLocalite() {
        return $this->localite;
    }

    /**
     * Set commune
     *
     * @param string $commune
     *
     * @return AdresseUtilisateur
     */
    public function setCommune($commune) {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string
     */
    public function getCommune() {
        return $this->commune;
    }

}
