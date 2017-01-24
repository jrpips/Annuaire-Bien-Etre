<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $temp;

    /**
     * @ORM\ManyToOne(targetEntity="Prestataire",inversedBy="slider")
     */
    private $sliderItems;

    /**
     * @ORM\Column(name="ordre", type="float", nullable=true)
     */
    //private $ordre;

    /**
     * @ORM\Column(type="string",length=55,nullable=true)
     *
     * @Assert\Valid
     */
     private $name;

    /**
     * @ORM\OneToOne(targetEntity="Internaute",mappedBy="image")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\Column(type="string",length=255)
     *
     */
    //private $avatar;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     *
     */
    // private $url;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     *
     */
    public $path;

    private $file;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // crée un nom unique
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        if (isset($this->temp)) {
            if ($this->unlinkCheck($this->temp)) {
                unlink($this->getUploadRootDir() . '/' . $this->temp);
                $this->temp = null;
            }
        }
        $this->file = null;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'image/userUploads';
    }

    protected function unlinkCheck($element)
    {
        $patterns = ['/http/', '/user/', '/prestataire/', '/admin/'];
        $match = true;
        for ($i = 0; $i < count($patterns); $i++) {
            if (!preg_match($patterns[$i], $element)) {
                $match = false;
            }
        }
        return $match;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            if ($this->unlinkCheck($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * return string path
     */
    public function __toString()
    {
        return $this->path . '';
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Image
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sliderItems
     *
     * @param \AppBundle\Entity\Prestataire $sliderItems
     *
     * @return Image
     */
    public function setSliderItems(\AppBundle\Entity\Prestataire $sliderItems = null)
    {
        $this->sliderItems = $sliderItems;

        return $this;
    }

    /**
     * Get sliderItems
     *
     * @return \AppBundle\Entity\Prestataire
     */
    public function getSliderItems()
    {
        return $this->sliderItems;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Image
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
