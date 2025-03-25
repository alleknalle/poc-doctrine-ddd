<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class HouseNumber
{
    private function __construct(
        private string $houseNumber
    ) {
    }

    public static function fromString(string $houseNumber): self
    {
        return new self($houseNumber);
    }

    public function toString(): string
    {
        return $this->houseNumber;
    }
}
