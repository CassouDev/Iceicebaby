<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $oderDate;

    /**
     * @ORM\Column(type="decimal")
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private $oderDeliveryDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
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

    public function getOderDeliveryDate(): ?\DateTimeInterface
    {
        return $this->oderDeliveryDate;
    }

    public function setOderDeliveryDate(\DateTimeInterface $oderDeliveryDate): self
    {
        $this->oderDeliveryDate = $oderDeliveryDate;

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
}
