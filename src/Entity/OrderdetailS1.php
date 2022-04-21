<?php

namespace App\Entity;

use App\Repository\OrderdetailS1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderdetailS1Repository::class)
 */
class OrderdetailS1
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
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\OneToMany(targetEntity=Order1::class, mappedBy="orderdetailS1")
     */
    private $orderdetail1S;

    public function __construct()
    {
        $this->orderdetail1S = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection<int, Order1>
     */
    public function getOrderdetail1S(): Collection
    {
        return $this->orderdetail1S;
    }

    public function addOrderdetail1(Order1 $orderdetail1): self
    {
        if (!$this->orderdetail1S->contains($orderdetail1)) {
            $this->orderdetail1S[] = $orderdetail1;
            $orderdetail1->setOrderdetailS1($this);
        }

        return $this;
    }

    public function removeOrderdetail1(Order1 $orderdetail1): self
    {
        if ($this->orderdetail1S->removeElement($orderdetail1)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail1->getOrderdetailS1() === $this) {
                $orderdetail1->setOrderdetailS1(null);
            }
        }

        return $this;
    }
}
