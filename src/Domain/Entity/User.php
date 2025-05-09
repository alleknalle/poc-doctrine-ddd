<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Ids\GroupId;
use App\Domain\Entity\Ids\UserId;
use App\Domain\ValueObject\Address;

final class User
{
    public function __construct(
        private UserId $userId,
        private string $username,
        private string $fullName,
        private Address $address,
        private bool $active,
		private GroupId $groupId
    ) {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

	public function getGroupId(): GroupId
	{
		return $this->groupId;
	}

    public function isActive(): bool
    {
        return $this->active;
    }

}
