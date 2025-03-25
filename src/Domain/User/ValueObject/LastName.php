<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class LastName
{
    private function __construct(private string $name)
    {
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function toString(): string
    {
        return $this->name;
    }
}
