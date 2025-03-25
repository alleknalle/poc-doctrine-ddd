<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Shared\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Username;

final class User
{
    // private string $userGroupId;

    public function __construct(
        private UserId $userId,
        private Username $username,
        private Name $name,
        private UserGroup $userGroup,
        // UserGroup $userGroup
    )
    {
        // $this->userGroupId = $userGroup->getId();
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getUserGroup(): UserGroup
    {
        return $this->userGroup;
    }

    public function update(
        Username $username,
        Name $name,
    ): void {
        $this->username = $username;
        $this->name = $name;
    }

    // public function getUserGroupId(): string
    // {
    //     return $this->userGroupId;
    // }

}
