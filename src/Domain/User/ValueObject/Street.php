<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class Street
{
    private function __construct(private string $street)
    {
    }

    public static function fromString(string $street): self
    {
        return new self($street);
    }

    public function toString(): string
    {
        return $this->street;
    }
}
