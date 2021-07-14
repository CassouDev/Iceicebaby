<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $oderDate;

    /**
     * @ORM\Column(type="decimal")
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderStatus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOderDate(): ?\DateTimeInterface
    {
        return $this->oderDate;
    }

    public function setOderDate(\DateTimeInterface $oderDate): self
    {
        $this->oderDate = $oderDate;

        return $this;
    }

    public function getOrderPrice(): ?int
    {
        return $this->orderPrice;
    }

    public function setOrderPrice(int $orderPrice): self
    {
        $this->orderPrice = $orderPrice;

        return $this;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
