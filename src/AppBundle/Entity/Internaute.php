<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Internaute
 *
 * @ORM\Table(name="internaute")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InternauteRepository")
 */
class Internaute {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @ORM\OneToOne(targetEntity="Utilisateur", cascade={"persist"},mappedBy="internaute")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Prestataire", inversedBy="internautes")
     * @ORM\JoinTable(name="prestataire_for_internaute")
     */
    private $prestataires;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Internaute
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Internaute
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Internaute
     */
    public function setNewsletter($newsletter) {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter() {
        return $this->newsletter;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Internaute
     */
    public function setImage(\AppBundle\Entity\Image $image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set prestataires
     *
     * @param \AppBundle\Entity\Prestataire $prestataires
     *
     * @return Internaute
     */
    public function setPrestataires(\AppBundle\Entity\Prestataire $prestataires) {
        $this->prestataires = $prestataires;

        return $this;
    }

    /**
     * Get prestataires
     *
     * @return \AppBundle\Entity\Prestataire
     */
    public function getPrestataires() {
        return $this->prestataires;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->prestataires = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add prestataire
     *
     * @param \AppBundle\Entity\Prestataire $prestataire
     *
     * @return Internaute
     */
    public function addPrestataire(\AppBundle\Entity\Prestataire $prestataire) {
        $this->prestataires[] = $prestataire;

        return $this;
    }

    /**
     * Remove prestataire
     *
     * @param \AppBundle\Entity\Prestataire $prestataire
     */
    public function removePrestataire(\AppBundle\Entity\Prestataire $prestataire) {
        $this->prestataires->removeElement($prestataire);
    }


    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Internaute
     */
    public function setUtilisateur(\AppBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
