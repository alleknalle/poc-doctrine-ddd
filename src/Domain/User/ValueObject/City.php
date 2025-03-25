<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class City
{
    private function __construct(
        private string $city
    ) {
    }

    public static function fromString(string $city): self
    {
        return new self($city);
    }

    public function toString(): string
    {
        return $this->city;
    }
}
