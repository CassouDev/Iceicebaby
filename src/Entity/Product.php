<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
    private $productName;

    /**
     * @ORM\Column(type="text")
     */
    private $productType;

    /**
     * @ORM\Column(type="text")
     */
    private $productDescription;

    /**
     * @ORM\Column(type="integer")
     */
    private $ProductQuantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $productPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productMainPicture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productPicture2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ProductPicture3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productPicture4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductQuantity(): ?int
    {
        return $this->ProductQuantity;
    }

    public function setProductQuantity(int $ProductQuantity): self
    {
        $this->ProductQuantity = $ProductQuantity;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductMainPicture(): ?string
    {
        return $this->productMainPicture;
    }

    public function setProductMainPicture(string $productMainPicture): self
    {
        $this->productMainPicture = $productMainPicture;

        return $this;
    }

    public function getProductPicture2(): ?string
    {
        return $this->productPicture2;
    }

    public function setProductPicture2(?string $productPicture2): self
    {
        $this->productPicture2 = $productPicture2;

        return $this;
    }

    public function getProductPicture3(): ?string
    {
        return $this->ProductPicture3;
    }

    public function setProductPicture3(?string $ProductPicture3): self
    {
        $this->ProductPicture3 = $ProductPicture3;

        return $this;
    }

    public function getProductPicture4(): ?string
    {
        return $this->productPicture4;
    }

    public function setProductPicture4(?string $productPicture4): self
    {
        $this->productPicture4 = $productPicture4;

        return $this;
    }
}
