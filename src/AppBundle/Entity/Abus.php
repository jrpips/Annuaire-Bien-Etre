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

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="encodage", type="date")
     */
    private $encodage;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", cascade={"persist"},inversedBy="msgAbus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $denonceur;

    /**
     * @ORM\ManyToOne(targetEntity="Commentaire",inversedBy="abus", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentDenonce;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->setEncodage(new \DateTime());
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Abus
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set encodage
     *
     * @param \DateTime $encodage
     *
     * @return Abus
     */
    public function setEncodage($encodage)
    {
        $this->encodage = $encodage;

        return $this;
    }

    /**
     * Get encodage
     *
     * @return \DateTime
     */
    public function getEncodage()
    {
        return $this->encodage;
    }

    /**
     * Set internaute
     *
     * @param \AppBundle\Entity\Internaute $internaute
     *
     * @return Abus
     */
    public function setInternaute(\AppBundle\Entity\Internaute $internaute)
    {
        $this->internaute = $internaute;

        return $this;
    }

    /**
     * Get internaute
     *
     * @return \AppBundle\Entity\Internaute
     */
    public function getInternaute()
    {
        return $this->internaute;
    }

    /**
     * Set commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Abus
     */
    public function setCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return \AppBundle\Entity\Commentaire
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set auteur
     *
     * @param \AppBundle\Entity\Utilisateur $auteur
     *
     * @return Abus
     */
    public function setAuteur(\AppBundle\Entity\Utilisateur $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set denonceur
     *
     * @param \AppBundle\Entity\Utilisateur $denonceur
     *
     * @return Abus
     */
    public function setDenonceur(\AppBundle\Entity\Utilisateur $denonceur)
    {
        $this->denonceur = $denonceur;

        return $this;
    }

    /**
     * Get denonceur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getDenonceur()
    {
        return $this->denonceur;
    }

    /**
     * Set commentDenonce
     *
     * @param \AppBundle\Entity\Commentaire $commentDenonce
     *
     * @return Abus
     */
    public function setCommentDenonce(\AppBundle\Entity\Commentaire $commentDenonce)
    {
        $this->commentDenonce = $commentDenonce;

        return $this;
    }

    /**
     * Get commentDenonce
     *
     * @return \AppBundle\Entity\Commentaire
     */
    public function getCommentDenonce()
    {
        return $this->commentDenonce;
    }
}
