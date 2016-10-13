<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SignUp
 *
 * @ORM\Table(name="sign_up")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SignUpRepository")
 */
class SignUp {

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
     * @ORM\Column(name="firstname", type="string", length=50)
     * @Assert\Length(min=2,minMessage="2 caract. minimum")
     * @Assert\NotBlank(message="requis")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @Assert\Length(min=2,minMessage="2 caract. minimum")
     * @Assert\NotBlank(message="requis")
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, unique=true)
     * @Assert\Length(min=2,minMessage="2 caract. minimum")
     * @Assert\NotBlank(message="requis")
     */
    private $email;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="_token", type="string", length=255, unique=true)
//     */
//    private $_token;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return SignUp
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return SignUp
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return SignUp
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
}
