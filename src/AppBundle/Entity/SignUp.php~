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
class SignUp
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir 2 caractères minimun",
     *      maxMessage = "Le nom ne peut contenir plus de 50 caractères"
     * )
     * * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut contenir de chiffre"
     * )
     * @Assert\NotBlank(message="Un nom est requis")
     * @ORM\Column(name="firstname", type="string", length=50)
     */
    private $firstname;

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
     * @ORM\Column(name="lastname", type="string", length=50)
     */
    private $lastname;

    /**
     * @Assert\Email(
     *     message = "L'email '{{ value }}' est invalde.",
     *     checkMX = true
     * )
     * @Assert\NotBlank(message="Une adresse email est requise")
     * @ORM\Column(name="email", type="string", length=80, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true,nullable=true)
     */
    private $token;
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="_token", type="string", length=255, unique=true,)
//     */
//    private $_token;

    /**
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set token
     *
     * @param string $token
     *
     * @return SignUp
     */
    public function setToken()
    {
        $this->token = sha1(uniqid(mt_rand(), true));

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
