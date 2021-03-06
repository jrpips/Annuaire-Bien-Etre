<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsletterRepository")
 */
class Newsletter {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "Le titre doit contenir 2 caractères minimun",
     *      maxMessage = "Le titre ne peut contenir plus de 50 caractères"
     * )
     * @Assert\NotBlank(message="Un titre est requis")
     * @ORM\Column(name="titre", type="string", length=80)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publication", type="date",nullable=true)
     */
    private $publication;

    /**
     * @var string
     * @ORM\Column(name="contenu",type="string",length=255, nullable=true)
     */
    private $contenu;

    /**
     * @var string
     * @ORM\Column(name="path",type="string",length=255, nullable=true)
     */
    private $path;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    public function __toString() {
        return $this->publication . '';
    }
    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Newsletter
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set publication
     *
     * @param \DateTime $publication
     *
     * @return Newsletter
     */
    public function setPublication($publication) {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \DateTime
     */
    public function getPublication() {
        return $this->publication;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     *
     * @return Newsletter
     */
    public function setPdf($pdf) {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return string
     */
    public function getPdf() {
        return $this->pdf;
    }


    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Newsletter
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Newsletter
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
