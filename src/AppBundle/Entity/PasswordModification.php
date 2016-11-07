<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * Password_Modification
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PasswordModificationRepository")
 */
class PasswordModification {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO") 
     */
    private $id;

    /**
     * @ORM\Column(name="password", type="string", length=150)
     * 
     * @SecurityAssert\UserPassword(
     *     message = "Mot de passe courant erroné"
     * )
     */
    private $password;

    /**
     * @ORM\Column(name="newPassword", type="string", length=150)
     * @Assert\NotBlank(message="Veuillez choisir un nouveau mot de passe")
     */
    private $newPassword;

    /**
     * @Assert\NotBlank(message="Veuillez confirmer votre nouveau mot de passe")
     */
    private $confNewPassword;

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function getNewPassword() {
        return $this->newPassword;
    }

    public function setConfNewPassword($confNewPassword) {
        $this->confNewPassword = $confNewPassword;
        return $this;
    }

    public function getConfNewPassword() {
        return $this->confNewPassword;
    }

//    /**
//     * @Assert\Istrue(message="confirmation erronéé")
//     */
//    public function isConfNewPassword() {
//        return $this->newPassword === $this->confNewPassword;
//    }

    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getId() {
        return $this->id;
    }

}
