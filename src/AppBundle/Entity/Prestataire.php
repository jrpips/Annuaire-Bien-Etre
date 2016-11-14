<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prestataire
 *
 * @ORM\Table(name="prestataire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestataireRepository")
 */
class Prestataire {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Utilisateur", cascade={"persist"},mappedBy="prestataire")
     * @Assert\Valid
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="Image",mappedBy="prestataire")
     */
    private $images;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Internaute",mappedBy="favoris",cascade={"persist"})
     */
    private $abonnes; //ancien nom : $internautes

    /**
     *
     * @ORM\ManyToMany(targetEntity="CategService",mappedBy="prestataires",cascade={"persist"})
     */
    private $categServices;

    /**
     * @ORM\OneToMany(targetEntity="Stage", cascade={"persist"},mappedBy="prestataire")
     * @Assert\Valid
     */
    private $stages;

    /**
     * @ORM\OneToMany(targetEntity="Promotion", cascade={"persist"},mappedBy="prestataire")
     * @Assert\Valid
     */
    private $promotions;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir 2 caractères minimun",
     *      maxMessage = "Le nom ne peut contenir plus de 50 caractères"
     * )
     * @Assert\NotBlank(message="Un nom est requis")
     * @ORM\Column(name="nom", type="string", length=50, unique=true)
     */
    private $nom;

    /**
     * @Assert\Url(
     *    protocols = {"http", "https"},
     *    checkDNS = true,
     *    dnsMessage = "L'adresse '{{ value }}' ne répond pas."
     * )
     * @ORM\Column(name="siteInternet", type="string", length=150, unique=true)
     */
    private $siteInternet;

    /**
     * @var string
     * @Assert\NotBlank(message="Un numéro de téléphone est requis")
     * @ORM\Column(name="telephone", type="string", length=50, unique=false)
     */
    private $telephone;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez renseigner votre numéro")
     * @ORM\Column(name="tva", type="string", length=50, unique=true)
     */
    private $tva;

    public function __toString() {
        return $this->nom . '';
        ;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Prestataire
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
     * Set siteInternet
     *
     * @param string $siteInternet
     *
     * @return Prestataire
     */
    public function setSiteInternet($siteInternet) {
        $this->siteInternet = $siteInternet;

        return $this;
    }

    /**
     * Get siteInternet
     *
     * @return string
     */
    public function getSiteInternet() {
        return $this->siteInternet;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Prestataire
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return Prestataire
     */
    public function setTva($tva) {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva() {
        return $this->tva;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Prestataire
     */
    public function addImage(\AppBundle\Entity\Image $image) {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image) {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Add categService
     *
     * @param \AppBundle\Entity\CategService $categService
     *
     * @return Prestataire
     */
    public function addCategService(\AppBundle\Entity\CategService $categService) {
        $this->categServices[] = $categService;

        return $this;
    }

    /**
     * Remove categService
     *
     * @param \AppBundle\Entity\CategService $categService
     */
    public function removeCategService(\AppBundle\Entity\CategService $categService) {
        $this->categServices->removeElement($categService);
    }

    /**
     * Get categServices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategServices() {
        return $this->categServices;
    }

    /**
     * Add internaute
     *
     * @param \AppBundle\Entity\Internaute $internaute
     *
     * @return Prestataire
     */
    public function addInternaute(\AppBundle\Entity\Internaute $internaute) {
        $this->internautes[] = $internaute;

        return $this;
    }

    /**
     * Remove internaute
     *
     * @param \AppBundle\Entity\Internaute $internaute
     */
    public function removeInternaute(\AppBundle\Entity\Internaute $internaute) {
        $this->internautes->removeElement($internaute);
    }

    /**
     * Get internautes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInternautes() {
        return $this->internautes;
    }

    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Prestataire
     */
    public function setUtilisateur(\AppBundle\Entity\Utilisateur $utilisateur = null) {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getUtilisateur() {
        return $this->utilisateur;
    }

    /**
     * Add abonne
     *
     * @param \AppBundle\Entity\Internaute $abonne
     *
     * @return Prestataire
     */
    public function addAbonne(\AppBundle\Entity\Internaute $abonne) {
        $this->abonnes[] = $abonne;

        return $this;
    }

    /**
     * Remove abonne
     *
     * @param \AppBundle\Entity\Internaute $abonne
     */
    public function removeAbonne(\AppBundle\Entity\Internaute $abonne) {
        $this->abonnes->removeElement($abonne);
    }

    /**
     * Get abonnes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbonnes() {
        return $this->abonnes;
    }


    /**
     * Add stage
     *
     * @param \AppBundle\Entity\Stage $stage
     *
     * @return Prestataire
     */
    public function addStage(\AppBundle\Entity\Stage $stage)
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * Remove stage
     *
     * @param \AppBundle\Entity\Stage $stage
     */
    public function removeStage(\AppBundle\Entity\Stage $stage)
    {
        $this->stages->removeElement($stage);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * Add promotion
     *
     * @param \AppBundle\Entity\Promotion $promotion
     *
     * @return Prestataire
     */
    public function addPromotion(\AppBundle\Entity\Promotion $promotion)
    {
        $this->promotions[] = $promotion;

        return $this;
    }

    /**
     * Remove promotion
     *
     * @param \AppBundle\Entity\Promotion $promotion
     */
    public function removePromotion(\AppBundle\Entity\Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    /**
     * Get promotions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }
}
