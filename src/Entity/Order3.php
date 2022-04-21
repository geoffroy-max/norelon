<?php

namespace App\Entity;

use App\Repository\Order3Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Order3Repository::class)
 */
class Order3
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="order3s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carrierName;

    /**
     * @ORM\Column(type="float")
     */
    private $carrierPrice;

    /**
     * @ORM\Column(type="text")
     */
    private $delivery;

    /**
     * @ORM\Column(type="boolean")
     */
   // private $isPaid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail3::class, mappedBy="order3")
     */
    private $orderDetail3s;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeSessionId;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\Column(type="boolean")
     */
    //private $isBest;

    public function __construct()
    {
        $this->orderDetail3s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * cette fonction permet de calculer le total des cmd dans easyAdmin
     */
    public function getTotal()
    {
        $total = null;
        foreach ($this->getOrderDetail3s()->getValues() as $product) {
            $total = $total + ($product->getPrice() * $product->getQuantity());
            return $total;
        }
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?float
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(float $carrierPrice): self
    {
        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    // on remplace ispaid par state
    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection|OrderDetail3[]
     */
    public function getOrderDetail3s(): Collection
    {
        return $this->orderDetail3s;
    }

    public function addOrderDetail3(OrderDetail3 $orderDetail3): self
    {
        if (!$this->orderDetail3s->contains($orderDetail3)) {
            $this->orderDetail3s[] = $orderDetail3;
            $orderDetail3->setOrder3($this);
        }

        return $this;
    }

    public function removeOrderDetail3(OrderDetail3 $orderDetail3): self
    {
        if ($this->orderDetail3s->removeElement($orderDetail3)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail3->getOrder3() === $this) {
                $orderDetail3->setOrder3(null);
            }
        }

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

   //public function getIsBest(): ?bool
    //{
        //return $this->isBest;
   // }

    //public function setIsBest(bool $isBest): self
    //{
        //$this->isBest = $isBest;

        //return $this;
  // }
}
