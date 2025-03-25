<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

final readonly class UserGroupId
{
    private function __construct(private string $userGroupId)
    {
    }

    public static function fromString(string $userGroupId): self
    {
        return new self($userGroupId);
    }

    public function toString(): string
    {
        return $this->userGroupId;
    }
}
