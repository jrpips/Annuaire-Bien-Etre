<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Prestataire",inversedBy="images")
     */
    private $prestataire;

    /**
     * @ORM\Column(name="ordre", type="float", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="requis")
     * 
     */
    private $name;

    /** 
     * @ORM\Column(type="string",length=255,nullable=true)
     * 
     */
    protected $path;
    
    protected $file;

    public function getUploadRootDir() {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__ . '/../../../web/image/userUploads';
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * 
     */
    public function preUpload() {
        $this->tempFile = $this->getAbsolutePath();
        $this->oldFile = $this->getPath();

        if (null !== $this->file) {
            $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * 
     */
    public function upload() {
        if (null !== $this->file) {
            $this->file->move($this->getUploadRootDir(), $this->path);
            unset($this->file);

            if ($this->oldFile != null) {
                unlink($this->tempFile);
            }
        }
    }

    /**
     * @ORM\PreRemove()
     * 
     */
    public function preRemoveUpload() {
        $this->tempFile = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     * 
     */
    public function removeUpload() {
        if (file_exists($this->tempFile)) {
            unlink($this->tempFile);
        }
    }

    //    public function __toString() {
    //        return $this->url . '';
    //    }

    public function getId() {
        return $this->id;
    }

    public function setOrdre($ordre) {
        $this->ordre = $ordre;
        return $this;
    }

    public function getOrdre() {
        return $this->ordre;
    }
 
    public function setPrestataire(\AppBundle\Entity\Prestataire $prestataire = null) {
        $this->prestataire = $prestataire;
        return $this;
    }

    public function getPrestataire() {
        return $this->prestataire;
    }

    public function getPath() {
        return $this->path;
    }

    public function getName() {
        return $this->name;
    }

    public function getFile() {
        return $this->file;
    }

    public function setFile($file) {
        $this->file = $file;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

}
