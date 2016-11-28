<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Internaute",cascade={"persist"},inversedBy="utilisateur")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $internaute;

    /**
     * @ORM\OneToOne(targetEntity="Prestataire",cascade={"persist"},inversedBy="utilisateur")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $prestataire;

    /**
     * @ORM\OneToOne(targetEntity="AdresseUtilisateur", cascade={"persist"})
     * @Assert\Valid
     */
    private $adresseUtilisateur;
    
    /**
     * @ORM\OneToMany(targetEntity="Abus", cascade={"persist"},mappedBy="denonceur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $msgAbus;

    /**
     * @Assert\Email(
     *     message = "L'email '{{ value }}' est invalde.",
     *     checkMX = true
     * )
     * @Assert\NotBlank(message="Une adresse email est requise.")
     *
     * @ORM\Column(name="email", type="string", length=150, unique=true)
     */
    private $email;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le pseudo doit contenir 2 caractères minimun.",
     *      maxMessage = "Le pseudo ne peut contenir plus de 50 caractères."
     * )
     * @Assert\NotBlank(message="Un pseudo est requis")
     * 
     * @ORM\Column(name="username", type="string", length=50)
     */
    private $username;

    /**
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le mot de passe doit contenir 3 caractères minimun.",
     *      maxMessage = "Le nom ne peut contenir plus de 50 caractères"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]+$/",
     *     match=true,
     *     message="Le mot de passe ne peut contenir des caractères spéciaux." 
     * )
     * @Assert\NotBlank(message="Minimun 3 caractères alphanumériques.")
     * 
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    //private $confPwd;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\Column(name="salt", type="string", length=255,nullable=true)
     */
    private $salt;

    /**
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="Le numéro est invalide." 
     * )
     * @Assert\NotBlank(message="Un numéro est requis.")
     * 
     * @ORM\Column(name="adresseNumero", type="float")
     */
    private $adresseNumero;

    /**
     * @Assert\NotBlank(message="Un nom de rue est requis.")
     *
     * @ORM\Column(name="adresseRue", type="string", length=150)    
     */
    private $adresseRue;

    /**
     * @ORM\Column(name="inscription", type="date")
     */
    private $inscription;

    /**
     * @ORM\Column(name="essaiPwd", type="float")
     */
    private $essaiPwd;

    /**
     * @ORM\Column(name="banni", type="boolean")
     */
    private $banni;

    /**
     * @ORM\Column(name="inscriptionConf", type="boolean")
     */
    private $inscriptionConf;

    public function eraseCredentials() {
        
    }

    public function __construct() {
        $this->setInscription(new \DateTime());
        $this->setBanni(false);
        $this->setInscriptionConf(true);
        $this->setEssaiPwd(0);
//        $this->setSalt('');
//        $this->setRoles('ROLE_INTERNAUTE');
    }

//    /**
//     * @Assert\IsTrue(message="confirmation erronée")
//     */
//    public function isConfPwd() {
//        return $this->password === $this->confPwd;
//    }

    /**
     * Get id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set email
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set pwd
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get pwd
     */
    public function getPassword() {
        return $this->password;
    }

//    public function setConfPwd($confPwd) {
//        $this->email = $confPwd;
//
//        return $this;
//    }
//
//    /**
//     * Get confPwd
//     *
//     * @return string
//     */
//    public function getConfPwd() {
//        return $this->confPwd;
//    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles) {
        $this->roles = array($roles);

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
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
    public function setPrestataire(\AppBundle\Entity\Prestataire $prestataire = null) {
        $this->prestataire = $prestataire;

        return $this;
    }

    /**
     * Get prestataire
     *
     * @return \AppBundle\Entity\Prestataire
     */
    public function getPrestataire() {
        return $this->prestataire;
    }


    /**
     * Add denonceur
     *
     * @param \AppBundle\Entity\Abus $denonceur
     *
     * @return Utilisateur
     */
    public function addDenonceur(\AppBundle\Entity\Abus $denonceur)
    {
        $this->denonceur[] = $denonceur;

        return $this;
    }

    /**
     * Remove denonceur
     *
     * @param \AppBundle\Entity\Abus $denonceur
     */
    public function removeDenonceur(\AppBundle\Entity\Abus $denonceur)
    {
        $this->denonceur->removeElement($denonceur);
    }

    /**
     * Get denonceur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDenonceur()
    {
        return $this->denonceur;
    }

    /**
     * Add msgAbus
     *
     * @param \AppBundle\Entity\Abus $msgAbus
     *
     * @return Utilisateur
     */
    public function addMsgAbus(\AppBundle\Entity\Abus $msgAbus)
    {
        $this->msgAbus[] = $msgAbus;

        return $this;
    }

    /**
     * Remove msgAbus
     *
     * @param \AppBundle\Entity\Abus $msgAbus
     */
    public function removeMsgAbus(\AppBundle\Entity\Abus $msgAbus)
    {
        $this->msgAbus->removeElement($msgAbus);
    }

    /**
     * Get msgAbus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMsgAbus()
    {
        return $this->msgAbus;
    }
}
