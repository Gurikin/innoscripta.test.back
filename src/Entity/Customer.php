<?php

namespace App\Entity;

use App\Helper\TokenHelper;
use App\Repository\CustomerRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $token;

    /**
     * @ORM\Column(type="datetime", name="token_expired_at")
     */
    private ?DateTimeInterface $tokenExpiredAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     */
    private ?User $user;

    /**
     * @ORM\OneToOne(targetEntity=Cart::class, cascade={"persist", "remove"})
     */
    private Cart $cart;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->cart = new Cart();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        $this->setTokenExpiredAt((new DateTime(TokenHelper::TOKEN_LIFE_TIME)));

        return $this;
    }

    public function getTokenExpiredAt(): ?DateTimeInterface
    {
        return $this->tokenExpiredAt;
    }

    public function setTokenExpiredAt(DateTimeInterface $tokenExpiredAt): self
    {
        $this->tokenExpiredAt = $tokenExpiredAt;

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

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }
}
