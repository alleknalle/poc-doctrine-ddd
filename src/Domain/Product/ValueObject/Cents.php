<?php

declare(strict_types=1);

namespace App\Domain\Product\ValueObject;

final readonly class Cents
{
    private function __construct(private int $cents)
    {
    }

    public static function fromInt(int $cents): self
    {
        return new self($cents);
    }

    public function toInt(): int
    {
        return $this->cents;
    }
}
