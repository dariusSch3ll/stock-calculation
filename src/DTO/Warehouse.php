<?php

namespace App\DTO;

use App\Entity\Warehouse as Entity;

class Warehouse
{
    public function __construct(
        public readonly string $code
    )
    {
    }

    public static function fromAny(mixed $data): self
    {
        if ($data instanceof self) {
            return $data;
        }

        if (is_string($data)) {
            return self::fromString($data);
        }

        throw new \InvalidArgumentException('Invalid data');
    }
    public static function fromString(string $code): self
    {
        return new self($code);
    }

    public function toDomain(): Entity
    {
        return new Entity($this->code);
    }
}