<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

final class UserGroupId
{
    public function __construct(private string $userGroupId)
    {
    }

    public function getUserGroupId(): string
    {
        return $this->userGroupId;
    }
}
