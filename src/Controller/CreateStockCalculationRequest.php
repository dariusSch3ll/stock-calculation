<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as WebmozartAssert;

final class CreateStockCalculationRequest
{
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private readonly mixed $shop;

    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Assert\Regex('/^[F|W]\d{12}$/', 'SKU need to start with a F or W and followed by 12 digits')]
    private readonly mixed $product;

    #[Assert\NotNull()]
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\NotBlank,
        new Assert\Type('string'),
        new Assert\Length(min: 2),
    ])]
    private readonly mixed $warehouses;

    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Type('int')]
    private readonly mixed $maxstock;
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Type('int')]
    private readonly mixed $stock;
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Type('int')]
    private readonly mixed $ironstock;

    public function __construct(mixed $shop, mixed $product, mixed $warehouses, mixed $stock, mixed $maxstock, mixed $ironstock)
    {
        $this->shop = $shop;
        $this->product = $product;
        $this->warehouses = $warehouses;
        $this->stock = $stock;
        $this->maxstock = $maxstock;
        $this->ironstock = $ironstock;

    }

    public function getShop(): string
    {
        $value = $this->shop;

        WebmozartAssert::string($value);
        WebmozartAssert::notEmpty($value);

        return $value;
    }

    public function getProduct(): string
    {
        $value = $this->product;

        WebmozartAssert::string($value);
        WebmozartAssert::notEmpty($value);

        return $value;
    }

    public function getWarehouses(): array
    {
        $value = $this->warehouses;

        WebmozartAssert::isArray($value);
        WebmozartAssert::allString($value);
        WebmozartAssert::allNotEmpty($value);

        return $value;
    }
    public function getStock(): int
    {
        $value = $this->stock;

        WebmozartAssert::integer($value);
        WebmozartAssert::notEmpty($value);

        return $value;
    }
    public function getIronStock(): int
    {
        $value = $this->ironstock;

        WebmozartAssert::integer($value);
        WebmozartAssert::notEmpty($value);

        return $value;
    }
    public function getMaxStock(): int
    {
        $value = $this->maxstock;

        WebmozartAssert::integer($value);
        WebmozartAssert::notEmpty($value);

        return $value;
    }
}
