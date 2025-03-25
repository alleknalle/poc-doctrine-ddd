<?php

declare(strict_types=1);

namespace App\Domain\Order\ValueObject;

final readonly class OrderLineId
{
    private function __construct(private string $orderLineId)
    {
    }

    public static function fromString(string $orderLineId): self
    {
        return new self($orderLineId);
    }

    public function toString(): string
    {
        return $this->orderLineId;
    }
}
