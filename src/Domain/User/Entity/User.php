<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\ValueObject\Address;
use App\Domain\User\ValueObject\FullName;
use App\Domain\User\ValueObject\Username;

final class User
{
    public function __construct(
        private UserId $userId,
        private Username $username,
        private FullName $fullName,
        private Address $address,
        private bool $active,
        private UserGroup $userGroup,
    ) {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getUserGroup(): UserGroup
    {
        return $this->userGroup;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function update(
        Username $username,
        FullName $fullName,
    ): void {
        $this->username = $username;
        $this->fullName = $fullName;
    }

    public function updateAddress(Address $address): void
    {
        $this->address = $address;
    }

}
