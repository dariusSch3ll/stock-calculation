<?php

namespace App\Entity;

use App\Repository\WarehouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\StockCalculation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WarehouseRepository::class)]
class Warehouse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToMany(targetEntity: StockCalculation::class, mappedBy: 'warehouses')]
    private Collection $calculations;

    public function __construct(string $code)
    {
        $this->code = $code;
        $this->calculations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
    /**
     * @return Collection<int, StockCalculation>
     */
    public function getCalculations(): Collection
    {
        return $this->calculations;
    }

    public function addStockCalculation(StockCalculation $calculation): self
    {
        if (!$this->calculations->contains($calculation)) {
            $this->calculations->add($calculation);
            $calculation->addWarehouse($this);
        }

        return $this;
    }

    public function removeStockCalculation(StockCalculation $calculation): self
    {
        if ($this->calculations->removeElement($calculation)) {
            $calculation->removeWarehouse($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
