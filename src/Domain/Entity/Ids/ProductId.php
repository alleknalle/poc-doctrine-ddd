<?php

declare(strict_types=1);

namespace App\Domain\Entity\Ids;

final readonly class ProductId
{
    private function __construct(private string $productId)
    {
    }

    public static function fromString(string $productId): self
    {
        return new self($productId);
    }

    public function toString(): string
    {
        return $this->productId;
    }
}
