<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"userMail"},
 *  message="L'email que vous avez indiqué est déjà utilisé !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userLastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $userMail;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userPhoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 8, minMessage = "Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
    * @Assert\EqualTo(propertyPath="password", message="Ceci ne correspond pas au mot de passe")
     */
    public $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userAdress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userComplement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userCity;

    /**
     * @ORM\Column(type="integer")
     */
    private $userPostcode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserLastname(): ?string
    {
        return $this->userLastname;
    }

    public function setUserLastname(string $userLastname): self
    {
        $this->userLastname = $userLastname;

        return $this;
    }

    public function getUserMail(): ?string
    {
        return $this->userMail;
    }

    public function setUserMail(string $userMail): self
    {
        $this->userMail = $userMail;

        return $this;
    }

    public function getUserPhoneNumber(): ?int
    {
        return $this->userPhoneNumber;
    }

    public function setUserPhoneNumber(?int $userPhoneNumber): self
    {
        $this->userPhoneNumber = $userPhoneNumber;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserAdress(): ?string
    {
        return $this->userAdress;
    }

    public function setUserAdress(string $userAdress): self
    {
        $this->userAdress = $userAdress;

        return $this;
    }

    public function getUserComplement(): ?string
    {
        return $this->userComplement;
    }

    public function setUserComplement(?string $userComplement): self
    {
        $this->userComplement = $userComplement;

        return $this;
    }

    public function getUserCity(): ?string
    {
        return $this->userCity;
    }

    public function setUserCity(string $userCity): self
    {
        $this->userCity = $userCity;

        return $this;
    }

    public function getUserPostcode(): ?int
    {
        return $this->userPostcode;
    }

    public function setUserPostcode(int $userPostcode): self
    {
        $this->userPostcode = $userPostcode;

        return $this;
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getRoles() 
    {
        return ['ROLE_USER'];
    }
}
