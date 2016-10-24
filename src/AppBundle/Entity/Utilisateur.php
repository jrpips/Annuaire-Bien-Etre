<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 */
class Utilisateur {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Internaute",mappedBy="utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $internaute;

    /**
     * @ORM\OneToOne(targetEntity="Prestataire",mappedBy="utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $prestataire;

    /**
     * 
     * @ORM\OneToOne(targetEntity="AdresseUtilisateur", cascade={"persist"})
     * @Assert\Valid
     */
    private $adresseUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, unique=true)
     * @Assert\Length(min=2,minMessage="2 caract. minimum")
     * @Assert\NotBlank(message="requis")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=50)
     * @Assert\NotBlank(message="Minimun 6 caractères alphanumériques")
     */
    private $pwd;

    /**
     * @var float
     *
     * @ORM\Column(name="adresseNumero", type="float")
     * @Assert\Length(min=2,minMessage="2 caract. minimum")
     * @Assert\NotBlank(message="requis")
     */
    private $adresseNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseRue", type="string", length=150)
     * @Assert\Length(min=2,minMessage="2 caract. minimum")
     * @Assert\NotBlank(message="requis")
     */
    private $adresseRue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inscription", type="date")
     */
    private $inscription;

    /**
     * @var string
     *
     * @ORM\Column(name="typeUtilisateur", type="string", length=50)
     */
    private $typeUtilisateur;

    /**
     * @var float
     *
     * @ORM\Column(name="essaiPwd", type="float")
     */
    private $essaiPwd;

    /**
     * @var bool
     *
     * @ORM\Column(name="banni", type="boolean")
     */
    private $banni;

    /**
     * @var bool
     *
     * @ORM\Column(name="inscriptionConf", type="boolean")
     */
    private $inscriptionConf;

    public function __construct() {
        $this->setInscription(new \DateTime());
        $this->setBanni(false);
        $this->setInscriptionConf(true);
        $this->setEssaiPwd(3);
        $this->setTypeUtilisateur('internaute');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set pwd
     *
     * @param string $pwd
     *
     * @return Utilisateur
     */
    public function setPwd($pwd) {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Get pwd
     *
     * @return string
     */
    public function getPwd() {
        return $this->pwd;
    }

    /**
     * Set adresseNumero
     *
     * @param float $adresseNumero
     *
     * @return Utilisateur
     */
    public function setAdresseNumero($adresseNumero) {
        $this->adresseNumero = $adresseNumero;

        return $this;
    }

    /**
     * Get adresseNumero
     *
     * @return float
     */
    public function getAdresseNumero() {
        return $this->adresseNumero;
    }

    /**
     * Set adresseRue
     *
     * @param string $adresseRue
     *
     * @return Utilisateur
     */
    public function setAdresseRue($adresseRue) {
        $this->adresseRue = $adresseRue;

        return $this;
    }

    /**
     * Get adresseRue
     *
     * @return string
     */
    public function getAdresseRue() {
        return $this->adresseRue;
    }

    /**
     * Set essaiPwd
     *
     * @param float $essaiPwd
     *
     * @return Utilisateur
     */
    public function setEssaiPwd($essaiPwd) {
        $this->essaiPwd = $essaiPwd;

        return $this;
    }

    /**
     * Get essaiPwd
     *
     * @return float
     */
    public function getEssaiPwd() {
        return $this->essaiPwd;
    }

    /**
     * Set banni
     *
     * @param boolean $banni
     *
     * @return Utilisateur
     */
    public function setBanni($banni) {
        $this->banni = $banni;

        return $this;
    }

    /**
     * Get banni
     *
     * @return bool
     */
    public function getBanni() {
        return $this->banni;
    }

    /**
     * Set inscriptionConf
     *
     * @param boolean $inscriptionConf
     *
     * @return Utilisateur
     */
    public function setInscriptionConf($inscriptionConf) {
        $this->inscriptionConf = $inscriptionConf;

        return $this;
    }

    /**
     * Get inscriptionConf
     *
     * @return bool
     */
    public function getInscriptionConf() {
        return $this->inscriptionConf;
    }

    /**
     * Set inscription
     *
     * @param \DateTime $inscription
     *
     * @return Utilisateur
     */
    public function setInscription($inscription) {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return \DateTime
     */
    public function getInscription() {
        return $this->inscription;
    }

    /**
     * Set typeUtilisateur
     *
     * @param string $typeUtilisateur
     *
     * @return Utilisateur
     */
    public function setTypeUtilisateur($typeUtilisateur) {
        $this->typeUtilisateur = $typeUtilisateur;

        return $this;
    }

    /**
     * Get typeUtilisateur
     *
     * @return string
     */
    public function getTypeUtilisateur() {
        return $this->typeUtilisateur;
    }

    /**
     * Set internaute
     *
     * @param \AppBundle\Entity\Internaute $internaute
     *
     * @return Utilisateur
     */
    public function setInternaute(\AppBundle\Entity\Internaute $internaute) {
        $this->internaute = $internaute;

        return $this;
    }

    /**
     * Get internaute
     *
     * @return \AppBundle\Entity\Internaute
     */
    public function getInternaute() {
        return $this->internaute;
    }

//    /**
//     * Set prestataire
//     *
//     * @param \AppBundle\Entity\Prestataire $prestataire
//     *
//     * @return Utilisateur
//     */
//    public function setPrestataire(\AppBundle\Entity\Prestataire $prestataire) {
//        $this->prestataire = $prestataire;
//
//        return $this;
//    }
//
//    /**
//     * Get prestataire
//     *
//     * @return \AppBundle\Entity\Prestataire
//     */
//    public function getPrestataire() {
//        return $this->prestataire;
//    }

    /**
     * Set adresseUtilisateur
     *
     * @param \AppBundle\Entity\AdresseUtilisateur $adresseUtilisateur
     *
     * @return Utilisateur
     */
    public function setAdresseUtilisateur(\AppBundle\Entity\AdresseUtilisateur $adresseUtilisateur = null) {
        $this->adresseUtilisateur = $adresseUtilisateur;

        return $this;
    }

    /**
     * Get adresseUtilisateur
     *
     * @return \AppBundle\Entity\AdresseUtilisateur
     */
    public function getAdresseUtilisateur() {
        return $this->adresseUtilisateur;
    }


    /**
     * Set prestataire
     *
     * @param \AppBundle\Entity\Prestataire $prestataire
     *
     * @return Utilisateur
     */
    public function setPrestataire(\AppBundle\Entity\Prestataire $prestataire = null)
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    /**
     * Get prestataire
     *
     * @return \AppBundle\Entity\Prestataire
     */
    public function getPrestataire()
    {
        return $this->prestataire;
    }
}
