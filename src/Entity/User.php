<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $userGender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userFirstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userLastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userMail;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userPhoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userPassword;

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

    public function getUserGender(): ?string
    {
        return $this->userGender;
    }

    public function setUserGender(string $userGender): self
    {
        $this->userGender = $userGender;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->userFirstname;
    }

    public function setUserFirstname(string $userFirstname): self
    {
        $this->userFirstname = $userFirstname;

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

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(string $userPassword): self
    {
        $this->userPassword = $userPassword;

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
}
