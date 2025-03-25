<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

final readonly class UserId
{
    private function __construct(private string $userId)
    {
    }

    public static function fromString(string $userId): self
    {
        return new self($userId);
    }

    public function toString(): string
    {
        return $this->userId;
    }
}
