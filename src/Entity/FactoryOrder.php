<?php

namespace App\Entity;

use App\Repository\FactoryOrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FactoryOrderRepository::class)
 */
class FactoryOrder
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
    private $factoryFirstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $factoryLastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $factoryMail;

    /**
     * @ORM\Column(type="datetime")
     */
    private $factoryDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $factoryDeadline;

    /**
     * @ORM\Column(type="text")
     */
    private $factoryRequest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $factoryStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactoryFirstname(): ?string
    {
        return $this->factoryFirstname;
    }

    public function setFactoryFirstname(string $factoryFirstname): self
    {
        $this->factoryFirstname = $factoryFirstname;

        return $this;
    }

    public function getFactoryLastname(): ?string
    {
        return $this->factoryLastname;
    }

    public function setFactoryLastname(string $factoryLastname): self
    {
        $this->factoryLastname = $factoryLastname;

        return $this;
    }

    public function getFactoryMail(): ?string
    {
        return $this->factoryMail;
    }

    public function setFactoryMail(string $factoryMail): self
    {
        $this->factoryMail = $factoryMail;

        return $this;
    }

    public function getFactoryDate(): ?\DateTimeInterface
    {
        return $this->factoryDate;
    }

    public function setFactoryDate(\DateTimeInterface $factoryDate): self
    {
        $this->factoryDate = $factoryDate;

        return $this;
    }

    public function getFactoryDeadline(): ?\DateTimeInterface
    {
        return $this->factoryDeadline;
    }

    public function setFactoryDeadline(\DateTimeInterface $factoryDeadline): self
    {
        $this->factoryDeadline = $factoryDeadline;

        return $this;
    }

    public function getFactoryRequest(): ?string
    {
        return $this->factoryRequest;
    }

    public function setFactoryRequest(string $factoryRequest): self
    {
        $this->factoryRequest = $factoryRequest;

        return $this;
    }

    public function getFactoryStatus(): ?string
    {
        return $this->factoryStatus;
    }

    public function setFactoryStatus(string $factoryStatus): self
    {
        $this->factoryStatus = $factoryStatus;

        return $this;
    }
}
