<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stage
 *
 * @ORM\Table(name="stage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StageRepository")
 */
class Stage
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prestataire", cascade={"persist"},inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prestataire;

    /**
     * @Assert\NotBlank(message="Un nom est requis")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir 2 caractères minimun",
     *      maxMessage = "Le nom ne peut contenir plus de 50 caractères"
     * )
     * @ORM\Column(name="nom", type="string", length=150)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Une description est requise")
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "La description doit contenir 10 caractères minimun",
     *      maxMessage = "La description ne peut contenir plus de 255 caractères"
     * )
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Un tarif est requis")
     *
     * @ORM\Column(name="tarif", type="string", length=50)
     */
    private $tarif;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "L'info doit contenir 2 caractères minimun",
     *      maxMessage = "L'info ne peut contenir plus de 50 caractères"
     * )
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @Assert\NotBlank(message="Une date  est requise")
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @Assert\NotBlank(message="Une date  est requise")
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

    /**
     * @Assert\NotBlank(message="Une date  est requise")
     *
     * @ORM\Column(name="affichageDebut", type="date")
     */
    private $affichageDebut;

    /**
     * @Assert\NotBlank(message="Une date  est requise")
     *
     * @ORM\Column(name="affichageFin", type="date")
     */
    private $affichageFin;

    /**
     * @Assert\IsTrue(message="La date du début est inférieure à celle d'aujourd'hui")
     */
    public function isDateDebutValid()
    {
        $today = new \DateTime();
        return $today <= $this->getDateDebut();
    }

    /**
     * @Assert\IsTrue(message="La date de fin est inférieure à celle du début.")
     */
    public function isDateFinValid()
    {
        return $this->getDateDebut() >= $this->getDateFin();
    }
    /**
     * @Assert\IsTrue(message="La date d'affichage du début est inférieure à celle d'aujourd'hui")
     */
    public function isDebutAffichageValid()
    {
        $today = new \DateTime();
        return $today <= $this->getAffichageDebut();
    }
    /**
     * @Assert\IsTrue(message="La date de fin d'affichage est inférieure à celle du début.")
     */
    public function isAffichageFinValid()
    {
        return $this->getAffichageDebut() <= $this->getAffichageFin();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Stage
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Stage
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
     * Set tarif
     *
     * @param string $tarif
     *
     * @return Stage
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Stage
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Stage
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Stage
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set affichageDebut
     *
     * @param \DateTime $affichageDebut
     *
     * @return Stage
     */
    public function setAffichageDebut($affichageDebut)
    {
        $this->affichageDebut = $affichageDebut;

        return $this;
    }

    /**
     * Get affichageDebut
     *
     * @return \DateTime
     */
    public function getAffichageDebut()
    {
        return $this->affichageDebut;
    }

    /**
     * Set affichageFin
     *
     * @param \DateTime $affichageFin
     *
     * @return Stage
     */
    public function setAffichageFin($affichageFin)
    {
        $this->affichageFin = $affichageFin;

        return $this;
    }

    /**
     * Get affichageFin
     *
     * @return \DateTime
     */
    public function getAffichageFin()
    {
        return $this->affichageFin;
    }


    /**
     * Set prestataire
     *
     * @param \AppBundle\Entity\Prestataire $prestataire
     *
     * @return Stage
     */
    public function setPrestataire(\AppBundle\Entity\Prestataire $prestataire)
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    /**
     * Get prestataire
     *
     * @return \AppBundle\Entity\Prestataire
     */
    public function getPrestataire()
    {
        return $this->prestataire;
    }
}
