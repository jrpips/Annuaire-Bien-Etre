<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire
{

    /**************
     *
     * ATTRIBUTS
     *
     **************/

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="cote", type="float", nullable=true)
     */
    private $cote;

    /**
     * @Assert\NotBlank(message="Un titre est requis")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Le titre du commentaire doit contenir 2 caractères minimun",
     *      maxMessage = "Le titre est trop long, 100 caractères maximun"
     * )
     * @ORM\Column(name="titre", type="string", length=100)
     */
    private $titre;

    /**
     * @Assert\NotBlank(message="Un commentaire est requis")
     * @Assert\Length(
     *      min = 15,
     *      max = 255,
     *      minMessage = "Le commentaire doit contenir 15 caractères minimun",
     *      maxMessage = "Le commentaire est trop long, doit contenir 255 caractères maximun"
     * )
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(name="encodage", type="date")
     */
    private $encodage;


    /**************
     *
     * FOREIGN KEYS
     *
     **************/

    /**
     * @ORM\ManyToOne(targetEntity="Internaute", cascade={"persist"},inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $internaute;

    /**
     * @ORM\ManyToOne(targetEntity="Prestataire", cascade={"persist"},inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $prestataire;

    /**
     * @ORM\OneToMany(targetEntity="Abus",mappedBy="commentDenonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $abus;


    /**************
     *
     * METHODES
     *
     **************/

    //getter id
    public function getId()
    {
        return $this->id;
    }

    //constructeur date soumission du commentaire
    public function __construct()
    {
        $this->setEncodage(new \DateTime());
    }

    //setter cote
    public function setCote($cote)
    {
        $this->cote = $cote;
        return $this;
    }

    //getter cote
    public function getCote()
    {
        return $this->cote;
    }

    //setter titre
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    //getter titre
    public function getTitre()
    {
        return $this->titre;
    }

    //setter contenu
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }

    //getter contenu
    public function getContenu()
    {
        return $this->contenu;
    }

    //setter encodage
    public function setEncodage($encodage)
    {
        $this->encodage = $encodage;
        return $this;
    }

    //getter encodage
    public function getEncodage()
    {
        return $this->encodage;
    }


    /**************
     *
     * METHODES FK
     *
     **************/

    //setter fk internaute (auteur du commentaire)
    public function setInternaute(\AppBundle\Entity\Internaute $internaute)
    {
        $this->internaute = $internaute;
        return $this;
    }

    //getter fk internaute (auteur du commentaire)
    public function getInternaute()
    {
        return $this->internaute;
    }

    //setter fk prestataire (sujet du commentaire)
    public function setPrestataire(\AppBundle\Entity\Prestataire $prestataire)
    {
        $this->prestataire = $prestataire;
        return $this;
    }

    //getter fk prestataire (sujet du commentaire)
    public function getPrestataire()
    {
        return $this->prestataire;
    }

    //add fk abus
    public function addAbus(\AppBundle\Entity\Abus $abus)
    {
        $this->abus[] = $abus;
        return $this;
    }

    //remove fk abus
    public function removeAbus(\AppBundle\Entity\Abus $abus)
    {
        $this->abus->removeElement($abus);
    }

    //getter fk abus
    public function getAbus()
    {
        return $this->abus;
    }
}
