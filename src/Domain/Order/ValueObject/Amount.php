<?php

declare(strict_types=1);

namespace App\Domain\Order\ValueObject;

final readonly class Amount
{
    private function __construct(private int $amount)
    {
    }

    public static function fromInt(int $amount): self
    {
        return new self($amount);
    }

    public function toInt(): int
    {
        return $this->amount;
    }
}
