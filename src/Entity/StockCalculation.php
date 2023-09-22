<?php

namespace App\Entity;

use App\Repository\StockCalculationRepository;
use App\Repository\WarehouseRepository;
use App\Service\CalculateStock;
use App\Entity\Warehouse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockCalculationRepository::class)]
class StockCalculation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $shop = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $minimumStock = 0;
    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $maximumStock = 0;

    #[ORM\ManyToMany(targetEntity: Warehouse::class, inversedBy: 'calculations')]
    private Collection $warehouses;

    public function __construct()
    {
        $this->warehouses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShop(): ?string
    {
        return $this->shop;
    }

    public function setShop(string $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    /** @return Warehouse[] */
    public function getWarehouses(): array
    {
        return $this->warehouses->toArray();
    }

    /** @param Warehouse[] $warehouses */
    public function setWarehouses(array $warehouses): self
    {
        $this->warehouses = new ArrayCollection($warehouses);

        return $this;
    }

    public function addWarehouse(Warehouse $warehouse): self
    {
        if (!$this->warehouses->contains($warehouse)) {
            $this->warehouses->add($warehouse);
            $warehouse->addStockCalculation($this);
        }

        return $this;
    }

    public function removeWarehouse(Warehouse $warehouse): self
    {
        $this->warehouses->removeElement($warehouse);

        return $this;
    }
    public function getMinimumStock(): int
    {
        return $this->minimumStock;
    }
    public function setMinimumStock(int $minimumStock): self
    {
        $this->minimumStock = $minimumStock;

        return $this;
    }
    public function getMaximumStock(): int
    {
        return $this->maximumStock;
    }
    public function setMaximumStock(int $maximumStock): self
    {
        $this->maximumStock = $maximumStock;

        return $this;
    }
}
