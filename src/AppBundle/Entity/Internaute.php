<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Internaute
 *
 * @ORM\Table(name="internaute")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InternauteRepository")
 * 
 */
class Internaute {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Utilisateur", cascade={"persist"},mappedBy="internaute")
     * @Assert\Valid
     */
    private $utilisateur;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Prestataire", inversedBy="abonnes")
     * @ORM\JoinTable(name="prestataire_for_internaute")
     */
    private $favoris; //ancien nom : $prestataires

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir 2 caractères minimun",
     *      maxMessage = "Le nom ne peut contenir plus de 50 caractères"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut contenir de chiffre"
     * )
     * @Assert\NotBlank(message="Un nom est requis")
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit contenir 2 caractères minimun",
     *      maxMessage = "Le prénom ne peut contenir plus de 50 caractères"
     * )
     * * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne peut contenir de chiffre"
     * )
     * @Assert\NotBlank(message="Un prénom est requis")
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\OneToMany(targetEntity="Commentaire", cascade={"persist"},mappedBy="internaute")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaires;

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
     * Add favori
     *
     * @param \AppBundle\Entity\Prestataire $favori
     *
     * @return Internaute
     */
    public function addFavori(\AppBundle\Entity\Prestataire $favori) {
        $this->favoris[] = $favori;

        return $this;
    }

    /**
     * Remove favori
     *
     * @param \AppBundle\Entity\Prestataire $favori
     */
    public function removeFavori(\AppBundle\Entity\Prestataire $favori) {
        $this->favoris->removeElement($favori);
    }

    /**
     * Get favoris
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoris() {
        return $this->favoris;
    }


    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Internaute
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}
