<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final readonly class Username
{
    private function __construct(private string $username)
    {
    }

    public static function fromString(string $username): self
    {
        return new self($username);
    }

    public function toString(): string
    {
        return $this->username;
    }
}
