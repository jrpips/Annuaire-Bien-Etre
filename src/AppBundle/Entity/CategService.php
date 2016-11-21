<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategService
 *
 * @ORM\Table(name="categ_service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategServiceRepository")
 */
class CategService {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Prestataire", inversedBy="categServices")
     * @ORM\JoinTable(name="prestataire_for_categorie")
     */
    private $prestataires;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Promotion",cascade={"persist"},mappedBy="categService")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotions;

    /**
     * @var string
     * @Assert\NotBlank(message="Un nom de service est requis")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom du service doit contenir 2 caractères minimun",
     *      maxMessage = "Le nom du service doit contenir 50 caractères maximun"
     * )
     *
     * @ORM\Column(name="nom", type="string", length=50, unique=true)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Une description du service est requise")
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "La description du service doit contenir 10 caractères minimun",
     *      maxMessage = "La description du service doit contenir 255 caractères maximun"
     * )
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="enAvant", type="boolean")
     */
    private $enAvant;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

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
     * @return CategService
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

    public function __toString() {
        return $this->nom . '';
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CategService
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set enAvant
     *
     * @param boolean $enAvant
     *
     * @return CategService
     */
    public function setEnAvant($enAvant) {
        $this->enAvant = $enAvant;

        return $this;
    }

    /**
     * Get enAvant
     *
     * @return bool
     */
    public function getEnAvant() {
        return $this->enAvant;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return CategService
     */
    public function setValide($valide) {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return bool
     */
    public function getValide() {
        return $this->valide;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return CategService
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
     * @return CategService
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
     * Get prestataires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrestataires() {
        return $this->prestataires;
    }


    /**
     * Add promotion
     *
     * @param \AppBundle\Entity\Promotion $promotion
     *
     * @return CategService
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
