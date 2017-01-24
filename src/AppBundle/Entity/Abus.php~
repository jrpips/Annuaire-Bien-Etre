<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abus
 *
 * @ORM\Table(name="abus")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbusRepository")
 */
class Abus
{

    /**************
     *
     * ATTRIBUTS
     *
     **************/

    /**
     * Abus : id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Abus : description de l'abus
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * Abus : date de l'encodage du signalement
     *
     * @ORM\Column(name="encodage", type="date")
     */
    private $encodage;

    /**
     * FK Internaute (signale un abus)
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", cascade={"persist"},inversedBy="msgAbus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $denonceur;

    /**
     * FK Commentaire (commentaire jugé abusif par l'internaute)
     *
     * @ORM\ManyToOne(targetEntity="Commentaire",inversedBy="abus", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentDenonce;


    /**************
     *
     * METHODES
     *
     **************/

    // getter id
    public function getId()
    {
        return $this->id;
    }

    /**
     * Abus : construction de la date du signalement.
     */
    public function __construct()
    {
        $this->setEncodage(new \DateTime());
    }
    // setter description
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    //getter description
    public function getDescription()
    {
        return $this->description;
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

    public function setInternaute(\AppBundle\Entity\Internaute $internaute)
    {
        $this->internaute = $internaute;
        return $this;
    }

    public function getInternaute()
    {
        return $this->internaute;
    }

    public function setCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setAuteur(\AppBundle\Entity\Utilisateur $auteur)
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getAuteur()
    {
        return $this->auteur;
    }

    public function setDenonceur(\AppBundle\Entity\Utilisateur $denonceur)
    {
        $this->denonceur = $denonceur;
        return $this;
    }

    public function getDenonceur()
    {
        return $this->denonceur;
    }

    public function setCommentDenonce(\AppBundle\Entity\Commentaire $commentDenonce)
    {
        $this->commentDenonce = $commentDenonce;
        return $this;
    }

    public function getCommentDenonce()
    {
        return $this->commentDenonce;
    }
}
