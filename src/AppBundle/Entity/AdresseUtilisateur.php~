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

    /**************
     *
     * ATTRIBUTS
     *
     **************/

    /**
     * AdresseUtilisateur : id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * AdresseUtilisateur : code postal
     *
     * @Assert\NotBlank(message="Un code postal est requis")
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;

    /**
     * AdresseUtilisateur : localité
     *
     * @Assert\NotBlank(message="Une localité est requise")
     * @ORM\Column(name="localite", type="string", length=100)
     */
    private $localite;

    /**
     * AdresseUtilisateur : commune
     *
     * @Assert\NotBlank(message="Une commune est requise")
     * @ORM\Column(name="commune", type="string", length=100)
     */
    private $commune;


    /**************
     *
     * METHODES
     *
     **************/

    //getter id
    public function getId() {
        return $this->id;
    }

    //setter code postal
    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
        return $this;
    }

   //getter code postal
    public function getCodePostal() {
        return $this->codePostal;
    }

    //setter localité
    public function setLocalite($localite) {
        $this->localite = $localite;
        return $this;
    }

    //getter localité
    public function getLocalite() {
        return $this->localite;
    }

    //setter commune
    public function setCommune($commune) {
        $this->commune = $commune;
        return $this;
    }

   //getter commune
    public function getCommune() {
        return $this->commune;
    }

}
