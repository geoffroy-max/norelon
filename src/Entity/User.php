<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=10, minMessage="le prénom doit compoeté min 3 caractere", maxMessage="le prenom ne px comporté plus de 10 lettre")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="user")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     */
    private $orderrs;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user")
     */
   // private $commandes;

    /**
     * @ORM\OneToMany(targetEntity=Order1::class, mappedBy="user")
     */
    private $order1s;

    /**
     * @ORM\OneToMany(targetEntity=Order1::class, mappedBy="user")
     */
    private $order1ss;

    /**
     * @ORM\OneToMany(targetEntity=Order3::class, mappedBy="user")
     */
    private $order3s;

    /**
     * @ORM\OneToMany(targetEntity=Order1::class, mappedBy="user")
     */
    private $orderr1;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->orderrs = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->order1s = new ArrayCollection();
        $this->order1ss = new ArrayCollection();
        $this->order3s = new ArrayCollection();
        $this->orderr1 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getfullName(){

       return  $this->getFirstname().' '.$this->getLastname();

    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderrs(): Collection
    {
        return $this->orderrs;
    }

    public function addOrderr(Order $orderr): self
    {
        if (!$this->orderrs->contains($orderr)) {
            $this->orderrs[] = $orderr;
            $orderr->setUser($this);
        }

        return $this;
    }

    public function removeOrderr(Order $orderr): self
    {
        if ($this->orderrs->removeElement($orderr)) {
            // set the owning side to null (unless already changed)
            if ($orderr->getUser() === $this) {
                $orderr->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order1[]
     */
    public function getOrder1s(): Collection
    {
        return $this->order1s;
    }

    public function addOrder1(Order1 $order1): self
    {
        if (!$this->order1s->contains($order1)) {
            $this->order1s[] = $order1;
            $order1->setUser($this);
        }

        return $this;
    }

    public function removeOrder1(Order1 $order1): self
    {
        if ($this->order1s->removeElement($order1)) {
            // set the owning side to null (unless already changed)
            if ($order1->getUser() === $this) {
                $order1->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order1[]
     */
    public function getOrder1ss(): Collection
    {
        return $this->order1ss;
    }

    public function addOrder1ss(Order1 $order1ss): self
    {
        if (!$this->order1ss->contains($order1ss)) {
            $this->order1ss[] = $order1ss;
            $order1ss->setUser($this);
        }

        return $this;
    }

    public function removeOrder1ss(Order1 $order1ss): self
    {
        if ($this->order1ss->removeElement($order1ss)) {
            // set the owning side to null (unless already changed)
            if ($order1ss->getUser() === $this) {
                $order1ss->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order3[]
     */
    public function getOrder3s(): Collection
    {
        return $this->order3s;
    }

    public function addOrder3(Order3 $order3): self
    {
        if (!$this->order3s->contains($order3)) {
            $this->order3s[] = $order3;
            $order3->setUser($this);
        }

        return $this;
    }

    public function removeOrder3(Order3 $order3): self
    {
        if ($this->order3s->removeElement($order3)) {
            // set the owning side to null (unless already changed)
            if ($order3->getUser() === $this) {
                $order3->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order1>
     */
    public function getOrderr1(): Collection
    {
        return $this->orderr1;
    }

    public function addOrderr1(Order1 $orderr1): self
    {
        if (!$this->orderr1->contains($orderr1)) {
            $this->orderr1[] = $orderr1;
            $orderr1->setUser($this);
        }

        return $this;
    }

    public function removeOrderr1(Order1 $orderr1): self
    {
        if ($this->orderr1->removeElement($orderr1)) {
            // set the owning side to null (unless already changed)
            if ($orderr1->getUser() === $this) {
                $orderr1->setUser(null);
            }
        }

        return $this;
    }
}
