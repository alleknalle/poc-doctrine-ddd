<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

final class OrderId
{
    public function __construct(private string $userId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
