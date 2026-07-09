<?php

namespace App\Entity;

use App\Repository\MetalPriceSnapshotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetalPriceSnapshotRepository::class)]
#[ORM\UniqueConstraint(name: 'uniq_metal_price_pair', columns: ['metal', 'currency'])]
class MetalPriceSnapshot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private string $metal;

    #[ORM\Column(length: 10)]
    private string $currency;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(type: 'json')]
    private array $payload = [];

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct(string $metal, string $currency, array $payload)
    {
        $this->metal = $metal;
        $this->currency = $currency;
        $this->payload = $payload;
        $this->createdAt = new \DateTimeImmutable();

        $this->price = isset($payload['price']) ? (float) $payload['price'] : null;
    }

    public function updateFromPayload(array $payload): void
    {
        $this->payload = $payload;
        $this->price = isset($payload['price']) ? (float) $payload['price'] : null;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetal(): string
    {
        return $this->metal;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}