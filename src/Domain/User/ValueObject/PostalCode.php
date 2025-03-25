<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class PostalCode
{
    private function __construct(
        private string $postalCode
    ) {
    }

    public static function fromString(string $postalCode): self
    {
        return new self($postalCode);
    }

    public function toString(): string
    {
        return $this->postalCode;
    }
}
