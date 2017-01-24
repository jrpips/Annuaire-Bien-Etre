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


    /**************
     *
     * ATTRIBUTS
     *
     **************/

    /**
     * Catégorie de service : id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     *
     * @ORM\Column(name="enAvant", type="boolean")
     */
    private $enAvant;

    /**
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;



    /**************
     *
     * FOREIGN KEYS
     *
     **************/

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


    /**************
     *
     * METHODES
     *
     **************/

    //getter id
    public function getId() {
        return $this->id;
    }

   //setter nom
    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    //getter nom
    public function getNom() {
        return $this->nom;
    }

    //to display nom du service
    public function __toString() {
        return $this->nom . '';
    }

    //setter description
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    //getter description
    public function getDescription() {
        return $this->description;
    }

    //setter en avant
    public function setEnAvant($enAvant) {
        $this->enAvant = $enAvant;
        return $this;
    }

    //getter en avant
    public function getEnAvant() {
        return $this->enAvant;
    }

    //setter valide
    public function setValide($valide) {
        $this->valide = $valide;
        return $this;
    }

   //getter valide
    public function getValide() {
        return $this->valide;
    }

   //setter image
    public function setImage(\AppBundle\Entity\Image $image) {
        $this->image = $image;

        return $this;
    }

    //getter image
    public function getImage() {
        return $this->image;
    }

    //constructeur
    public function __construct() {
        $this->prestataires = new \Doctrine\Common\Collections\ArrayCollection();
    }

   //add fk prestataire
    public function addPrestataire(\AppBundle\Entity\Prestataire $prestataire) {
        $this->prestataires[] = $prestataire;
        return $this;
    }

   //remove fk prestataire
    public function removePrestataire(\AppBundle\Entity\Prestataire $prestataire) {
        $this->prestataires->removeElement($prestataire);
    }

   //getter fk prestataires
    public function getPrestataires() {
        return $this->prestataires;
    }

    //add fk promotion
    public function addPromotion(\AppBundle\Entity\Promotion $promotion)
    {
        $this->promotions[] = $promotion;
        return $this;
    }

    //remove fk promotion
    public function removePromotion(\AppBundle\Entity\Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    //getter fk promotions
    public function getPromotions()
    {
        return $this->promotions;
    }
}
